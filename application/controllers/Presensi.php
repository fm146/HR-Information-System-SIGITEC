<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Presensi extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
    }

    // Proses check in
    public function check_in() {
        if (!$this->session->userdata('logged_in')) redirect('auth');
        $user_id = $this->session->userdata('user_id');
        $user = $this->db->get_where('user', ['id' => $user_id])->row();
        if (!$user) show_404();
        $staff_id = $user->staff_id;
        $today = date('Y-m-d');
        // Cek sudah check in hari ini
        $cek = $this->db->get_where('presensi', ['staff_id' => $staff_id, 'tanggal' => $today])->row();
        if ($cek && $cek->jam_masuk) {
            $this->session->set_flashdata('error', 'Anda sudah check in hari ini!');
            redirect($_SERVER['HTTP_REFERER'] ?? 'dashboard/'.strtolower($user->role));
        }
        $now = date('H:i:s');
        $this->db->insert('presensi', [
            'staff_id' => $staff_id,
            'tanggal' => $today,
            'jam_masuk' => $now,
            'status' => 'Sesuai Jadwal'
        ]);
        $this->session->set_flashdata('success', 'Check in berhasil!');
        redirect($_SERVER['HTTP_REFERER'] ?? 'dashboard/'.strtolower($user->role));
    }

    // Proses check out
    public function check_out() {
        if (!$this->session->userdata('logged_in')) redirect('auth');
        $user_id = $this->session->userdata('user_id');
        $user = $this->db->get_where('user', ['id' => $user_id])->row();
        if (!$user) show_404();
        $staff_id = $user->staff_id;
        $today = date('Y-m-d');
        // Cek sudah check in hari ini
        $cek = $this->db->get_where('presensi', ['staff_id' => $staff_id, 'tanggal' => $today])->row();
        if (!$cek || !$cek->jam_masuk) {
            $this->session->set_flashdata('error', 'Anda belum check in hari ini!');
            redirect($_SERVER['HTTP_REFERER'] ?? 'dashboard/'.strtolower($user->role));
        }
        if ($cek->jam_pulang) {
            $this->session->set_flashdata('error', 'Anda sudah check out hari ini!');
            redirect($_SERVER['HTTP_REFERER'] ?? 'dashboard/'.strtolower($user->role));
        }
        $now = date('H:i:s');
        $this->db->where('id', $cek->id)->update('presensi', [
            'jam_pulang' => $now
        ]);
        $this->session->set_flashdata('success', 'Check out berhasil!');
        redirect($_SERVER['HTTP_REFERER'] ?? 'dashboard/'.strtolower($user->role));
    }
} 