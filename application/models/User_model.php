<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    public function getByUsername($username) {
        $this->db->select('user.*, role.nama as role');
        $this->db->from('user');
        $this->db->join('role', 'role.id = user.role_id', 'left');
        $this->db->where('user.username', $username);
        return $this->db->get()->row();
    }

    public function insertUser($username, $password, $role_id) {
        $data = [
            'username' => $username,
            'password' => $password,
            'role_id' => $role_id
        ];
        return $this->db->insert('user', $data);
    }

    public function getAllRoles() {
        return $this->db->get('role')->result();
    }

    public function updateThemeMode($user_id, $theme_mode) {
        $this->db->where('id', $user_id);
        return $this->db->update('user', ['theme_mode' => $theme_mode]);
    }

    // Gaji Setting
    public function getGajiPerJam() {
        $row = $this->db->order_by('id', 'desc')->get('gaji_setting')->row();
        return $row ? $row->nominal_per_jam : 0;
    }
    public function setGajiPerJam($nominal) {
        return $this->db->insert('gaji_setting', ['nominal_per_jam' => $nominal]);
    }

    // Rekap dan simpan gaji bulanan
    public function generateGajiBulanan($bulan, $tahun) {
        $staffs = $this->db->get('staff')->result();
        $CI =& get_instance();
        $cek_hari_kerja = $CI->db->get_where('hari_kerja_bulanan', [
            'bulan' => (int)$bulan,
            'tahun' => (int)$tahun
        ])->row();
        $jumlah_hari_kerja = $cek_hari_kerja ? $cek_hari_kerja->jumlah_hari : HARI_AKTIF_KERJA_DEFAULT;
        $jam_kerja_per_hari = JAM_KERJA_PER_HARI_DEFAULT;
        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        forEach($staffs as $staff) {
            $gaji_bulanan = $staff->gaji_bulanan;
            $gaji_harian = $gaji_bulanan / $jumlah_hari_kerja;
            $total_gaji = 0;
            $total_jam = 0;
            for ($day = 1; $day <= $days_in_month; $day++) {
                $tanggal = sprintf('%04d-%02d-%02d', $tahun, $bulan, $day);
                // Cek apakah hari ini termasuk hari kerja (asumsi: hari kerja = jumlah_hari_kerja pertama di bulan)
                if ($jumlah_hari_kerja < $day) continue;
                // Ambil presensi hari ini
                $presensi = $CI->db->get_where('presensi', [
                    'staff_id' => $staff->id,
                    'tanggal' => $tanggal
                ])->row();
                $jam_hadir = 0;
                if ($presensi && $presensi->jam_masuk && $presensi->jam_pulang) {
                    $masuk = strtotime($presensi->jam_masuk);
                    $pulang = strtotime($presensi->jam_pulang);
                    $jam_hadir = max(0, ($pulang - $masuk) / 3600);
                }
                $persen = min($jam_hadir / $jam_kerja_per_hari, 1.0);
                $total_jam += $jam_hadir;
                $total_gaji += $gaji_harian * $persen;
            }
            $jumlah_gaji = round($total_gaji);
            // Cek sudah ada gaji bulan ini?
            $CI->db->where('staff_id', $staff->id);
            $CI->db->where('MONTH(tanggal)', $bulan);
            $CI->db->where('YEAR(tanggal)', $tahun);
            $cek = $CI->db->get('gaji')->row();
            if ($cek) {
                $CI->db->where('id', $cek->id);
                $CI->db->update('gaji', [
                    'jumlah' => $jumlah_gaji,
                    'keterangan' => 'Otomatis by sistem',
                    'tanggal' => date('Y-m-d', strtotime("$tahun-$bulan-01"))
                ]);
            } else {
                $CI->db->insert('gaji', [
                    'staff_id' => $staff->id,
                    'tanggal' => date('Y-m-d', strtotime("$tahun-$bulan-01")),
                    'jumlah' => $jumlah_gaji,
                    'keterangan' => 'Otomatis by sistem'
                ]);
            }
        }
    }

    // Rekap gaji untuk superadmin (dengan filter)
    public function getRekapGaji($filter) {
        $this->db->select('gaji.*, staff.nama as staff_nama, staff.id as staff_id, staff.jabatan, staff.email, staff.divisi_id, divisi.nama as divisi_nama, user.role_id, role.nama as role_nama');
        $this->db->from('gaji');
        $this->db->join('staff', 'staff.id = gaji.staff_id');
        $this->db->join('user', 'user.staff_id = staff.id', 'left');
        $this->db->join('role', 'role.id = user.role_id', 'left');
        $this->db->join('divisi', 'divisi.id = staff.divisi_id', 'left');
        $this->db->where('MONTH(gaji.tanggal)', $filter['bulan']);
        $this->db->where('YEAR(gaji.tanggal)', $filter['tahun']);
        if ($filter['nama']) $this->db->like('staff.nama', $filter['nama']);
        if ($filter['divisi']) $this->db->where('divisi.id', $filter['divisi']);
        if ($filter['min_gaji']) $this->db->where('gaji.jumlah >=', $filter['min_gaji']);
        if ($filter['max_gaji']) $this->db->where('gaji.jumlah <=', $filter['max_gaji']);
        // Hitung total jam kerja dari presensi
        $result = $this->db->get()->result();
        // Ambil hari kerja bulan ini dari tabel, jika ada
        $CI =& get_instance();
        $cek_hari_kerja = $CI->db->get_where('hari_kerja_bulanan', [
            'bulan' => (int)$filter['bulan'],
            'tahun' => (int)$filter['tahun']
        ])->row();
        $jumlah_hari_kerja = $cek_hari_kerja ? $cek_hari_kerja->jumlah_hari : HARI_AKTIF_KERJA_DEFAULT;
        foreach ($result as &$row) {
            $row->total_jam = $this->getTotalJamKerja($row->staff_id, $filter['bulan'], $filter['tahun']);
            // Hitung jumlah hari hadir (ada presensi dengan jam masuk & pulang)
            $this->db->where('staff_id', $row->staff_id);
            $this->db->where('MONTH(tanggal)', $filter['bulan']);
            $this->db->where('YEAR(tanggal)', $filter['tahun']);
            $this->db->where('jam_masuk IS NOT NULL');
            $this->db->where('jam_pulang IS NOT NULL');
            $row->total_hari_kerja = $this->db->count_all_results('presensi');
        }
        if ($filter['min_jam']) $result = array_filter($result, fn($r) => $r->total_jam >= $filter['min_jam']);
        if ($filter['max_jam']) $result = array_filter($result, fn($r) => $r->total_jam <= $filter['max_jam']);
        return $result;
    }
    // Rekap gaji pribadi
    public function getRekapGajiUser($user_id) {
        $user = $this->db->get_where('user', ['id' => $user_id])->row();
        if (!$user) return [];
        $this->db->select('gaji.*, staff.nama as staff_nama, staff.id as staff_id, staff.jabatan, staff.email, staff.divisi_id, divisi.nama as divisi_nama');
        $this->db->from('gaji');
        $this->db->join('staff', 'staff.id = gaji.staff_id');
        $this->db->join('divisi', 'divisi.id = staff.divisi_id', 'left');
        $this->db->where('staff.id', $user->staff_id);
        $this->db->order_by('gaji.tanggal', 'desc');
        $result = $this->db->get()->result();
        foreach ($result as &$row) {
            $bulan = date('m', strtotime($row->tanggal));
            $tahun = date('Y', strtotime($row->tanggal));
            $row->total_jam = $this->getTotalJamKerja($row->staff_id, $bulan, $tahun);
        }
        return $result;
    }
    // Hitung total jam kerja per staff per bulan
    public function getTotalJamKerja($staff_id, $bulan, $tahun) {
        $this->db->where('staff_id', $staff_id);
        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        $presensis = $this->db->get('presensi')->result();
        $total_jam = 0;
        foreach ($presensis as $p) {
            if ($p->jam_masuk && $p->jam_pulang) {
                $masuk = strtotime($p->jam_masuk);
                $pulang = strtotime($p->jam_pulang);
                $selisih = max(0, ($pulang - $masuk) / 3600);
                $total_jam += $selisih;
            }
        }
        return round($total_jam, 2);
    }
    // List divisi
    public function getAllDivisi() {
        return $this->db->get('divisi')->result();
    }

    // List semua user
    public function getAllUsers($q = null, $all = false) {
        $CI =& get_instance();
        $divisi_id = null;
        if ($CI->session->userdata('role') === 'admin' && !$all) {
            $admin_id = $CI->session->userdata('user_id');
            $ci = &get_instance();
            $ci->load->database();
            $admin = $ci->db->get_where('user', ['id' => $admin_id])->row();
            if ($admin && $admin->staff_id) {
                $staff = $ci->db->get_where('staff', ['id' => $admin->staff_id])->row();
                if ($staff && $staff->divisi_id) {
                    $divisi_id = $staff->divisi_id;
                }
            }
        }
        $this->db->select('user.*, staff.nama as staff_nama, staff.email, staff.jabatan, staff.divisi_id, staff.pendidikan, staff.telepon, staff.rekening_atm, staff.no_ktp, staff.gaji_bulanan, divisi.nama as divisi_nama, role.nama as role_nama');
        $this->db->from('user');
        $this->db->join('staff', 'staff.id = user.staff_id', 'left');
        $this->db->join('divisi', 'divisi.id = staff.divisi_id', 'left');
        $this->db->join('role', 'role.id = user.role_id', 'left');
        if ($divisi_id) {
            $this->db->where('staff.divisi_id', $divisi_id);
        }
        if ($q) {
            $this->db->group_start();
            $this->db->like('user.username', $q);
            $this->db->or_like('staff.nama', $q);
            $this->db->or_like('staff.email', $q);
            $this->db->or_like('role.nama', $q);
            $this->db->or_like('divisi.nama', $q);
            $this->db->or_like('staff.jabatan', $q);
            $this->db->group_end();
        }
        return $this->db->get()->result();
    }
    // Detail user
    public function getUserDetail($id) {
        $this->db->select('user.*, staff.nama as staff_nama, staff.email, staff.jabatan, staff.divisi_id, staff.pendidikan, staff.telepon, staff.rekening_atm, staff.no_ktp, staff.gaji_bulanan, divisi.nama as divisi_nama, role.nama as role_nama');
        $this->db->from('user');
        $this->db->join('staff', 'staff.id = user.staff_id', 'left');
        $this->db->join('divisi', 'divisi.id = staff.divisi_id', 'left');
        $this->db->join('role', 'role.id = user.role_id', 'left');
        $this->db->where('user.id', $id);
        return $this->db->get()->row();
    }
    // Tambah user lengkap
    public function insertUserFull($username, $password, $role_id, $staff_id, $jam_masuk = null, $jam_pulang = null) {
        $data = [
            'username' => $username,
            'password' => $password,
            'role_id' => $role_id,
            'staff_id' => $staff_id,
            'jam_masuk' => $jam_masuk,
            'jam_pulang' => $jam_pulang
        ];
        return $this->db->insert('user', $data);
    }
    // Update user
    public function updateUser($id, $username, $role_id, $staff_id, $jam_masuk = null, $jam_pulang = null) {
        $data = [
            'username' => $username,
            'role_id' => $role_id,
            'staff_id' => $staff_id,
            'jam_masuk' => $jam_masuk,
            'jam_pulang' => $jam_pulang
        ];
        $this->db->where('id', $id);
        return $this->db->update('user', $data);
    }
    // Hapus user
    public function deleteUser($id) {
        $this->db->where('id', $id);
        return $this->db->delete('user');
    }
    // List staff
    public function getAllStaff() {
        return $this->db->get('staff')->result();
    }
    // Rekap gaji user by staff_id
    public function getRekapGajiUserByStaffId($staff_id) {
        $this->db->select('gaji.*, staff.nama as staff_nama, staff.id as staff_id, staff.jabatan, staff.email, staff.divisi_id, divisi.nama as divisi_nama');
        $this->db->from('gaji');
        $this->db->join('staff', 'staff.id = gaji.staff_id');
        $this->db->join('divisi', 'divisi.id = staff.divisi_id', 'left');
        $this->db->where('staff.id', $staff_id);
        $this->db->order_by('gaji.tanggal', 'desc');
        $result = $this->db->get()->result();
        foreach ($result as &$row) {
            $bulan = date('m', strtotime($row->tanggal));
            $tahun = date('Y', strtotime($row->tanggal));
            $row->total_jam = $this->getTotalJamKerja($row->staff_id, $bulan, $tahun);
        }
        return $result;
    }
    // Tambah staff lengkap
    public function insertStaffFull($data) {
        $this->db->insert('staff', $data);
        return $this->db->insert_id();
    }
    public function updateStaff($staff_id, $data) {
        $this->db->where('id', $staff_id);
        return $this->db->update('staff', $data);
    }
} 