<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
    }

    // Superadmin: lihat semua presensi
    public function index() {
        if ($this->session->userdata('role') !== 'superadmin') show_404();
        $tanggal = $this->input->get('tanggal') ?: date('Y-m-d');
        $this->db->select('presensi.*, staff.nama as staff_nama, staff.divisi_id, divisi.nama as divisi_nama, user.username, user.jam_masuk as user_jam_masuk, user.jam_pulang as user_jam_pulang');
        $this->db->from('presensi');
        $this->db->join('staff', 'staff.id = presensi.staff_id');
        $this->db->join('user', 'user.staff_id = staff.id', 'left');
        $this->db->join('divisi', 'divisi.id = staff.divisi_id', 'left');
        $this->db->where('presensi.tanggal', $tanggal);
        $this->db->order_by('presensi.jam_masuk', 'asc');
        $presensi = $this->db->get()->result();
        // Ambil jam kerja default
        $jam_kerja_default = $this->db->get('jam_kerja')->row();
        foreach ($presensi as &$p) {
            $jam_kerja = $p->user_jam_masuk ?: ($jam_kerja_default ? $jam_kerja_default->jam_masuk : '08:00:00');
            $jam_kerja_pulang = $p->user_jam_pulang ?: ($jam_kerja_default ? $jam_kerja_default->jam_pulang : '17:00:00');
            $p->jam_kerja = $jam_kerja;
            $p->jam_kerja_pulang = $jam_kerja_pulang;
            // Status masuk
            if ($p->jam_masuk && $p->jam_masuk > $jam_kerja) {
                $telat = (strtotime($p->jam_masuk) - strtotime($jam_kerja)) / 60;
                $p->status_final = 'Terlambat ('.round($telat).' menit)';
                $p->telat = round($telat);
            } else {
                $p->status_final = 'Sesuai Jadwal';
                $p->telat = 0;
            }
            // Status pulang
            if (!$p->jam_pulang) {
                $p->status_pulang = 'Belum Check Out';
            } else if ($p->jam_pulang < $jam_kerja_pulang) {
                $cepat = (strtotime($jam_kerja_pulang) - strtotime($p->jam_pulang)) / 60;
                $p->status_pulang = 'Pulang Cepat ('.round($cepat).' menit)';
            } else {
                $p->status_pulang = 'Sesuai Jadwal';
            }
        }
        $data['presensi'] = $presensi;
        $data['tanggal'] = $tanggal;
        $this->load->view('attendance/index', $data);
    }

    // Admin: lihat presensi anggota divisi sendiri
    public function divisi() {
        if ($this->session->userdata('role') !== 'admin') show_404();
        $user_id = $this->session->userdata('user_id');
        $user = $this->db->get_where('user', ['id' => $user_id])->row();
        if (!$user) show_404();
        $staff = $this->db->get_where('staff', ['id' => $user->staff_id])->row();
        if (!$staff) show_404();
        $divisi_id = $staff->divisi_id;
        $tanggal = $this->input->get('tanggal') ?: date('Y-m-d');
        $this->db->select('presensi.*, staff.nama as staff_nama, staff.divisi_id, divisi.nama as divisi_nama, user.username, user.jam_masuk as user_jam_masuk, user.jam_pulang as user_jam_pulang');
        $this->db->from('presensi');
        $this->db->join('staff', 'staff.id = presensi.staff_id');
        $this->db->join('user', 'user.staff_id = staff.id', 'left');
        $this->db->join('divisi', 'divisi.id = staff.divisi_id', 'left');
        $this->db->where('presensi.tanggal', $tanggal);
        $this->db->where('staff.divisi_id', $divisi_id);
        $this->db->order_by('presensi.jam_masuk', 'asc');
        $presensi = $this->db->get()->result();
        $jam_kerja_default = $this->db->get('jam_kerja')->row();
        foreach ($presensi as &$p) {
            $jam_kerja = $p->user_jam_masuk ?: ($jam_kerja_default ? $jam_kerja_default->jam_masuk : '08:00:00');
            $jam_kerja_pulang = $p->user_jam_pulang ?: ($jam_kerja_default ? $jam_kerja_default->jam_pulang : '17:00:00');
            $p->jam_kerja = $jam_kerja;
            $p->jam_kerja_pulang = $jam_kerja_pulang;
            // Status masuk
            if ($p->jam_masuk && $p->jam_masuk > $jam_kerja) {
                $telat = (strtotime($p->jam_masuk) - strtotime($jam_kerja)) / 60;
                $p->status_final = 'Terlambat ('.round($telat).' menit)';
                $p->telat = round($telat);
            } else {
                $p->status_final = 'Sesuai Jadwal';
                $p->telat = 0;
            }
            // Status pulang
            if (!$p->jam_pulang) {
                $p->status_pulang = 'Belum Check Out';
            } else if ($p->jam_pulang < $jam_kerja_pulang) {
                $cepat = (strtotime($jam_kerja_pulang) - strtotime($p->jam_pulang)) / 60;
                $p->status_pulang = 'Pulang Cepat ('.round($cepat).' menit)';
            } else {
                $p->status_pulang = 'Sesuai Jadwal';
            }
        }
        $data['presensi'] = $presensi;
        $data['tanggal'] = $tanggal;
        $this->load->view('attendance/divisi', $data);
    }
} 