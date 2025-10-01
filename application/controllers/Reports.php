<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    // Tampilkan form & list laporan user
    public function index() {
        $user_id = $this->session->userdata('user_id');
        $role = $this->session->userdata('role');
        $this->db->order_by('created_at', 'desc');
        if ($role == 'superadmin') {
            $reports = $this->db->select('reports.*, user.username')->from('reports')->join('user', 'user.id = reports.user_id', 'left')->order_by('created_at', 'desc')->get()->result();
            // Ambil semua pengajuan perizinan
            $izin = $this->db->select('perizinan.*, user.username')->from('perizinan')->join('user', 'user.id = perizinan.user_id', 'left')->order_by('created_at', 'desc')->get()->result();
        } else {
            $reports = $this->db->get_where('reports', ['user_id' => $user_id])->result();
            $izin = [];
        }
        $this->load->view('reports/index', ['reports' => $reports, 'izin' => $izin]);
    }

    // Proses simpan laporan
    public function submit() {
        $user_id = $this->session->userdata('user_id');
        $isi = $this->input->post('isi');
        $perihal = $this->input->post('perihal');
        if (!$isi || !$perihal) {
            $this->session->set_flashdata('error', 'Perihal dan isi laporan tidak boleh kosong.');
            redirect('reports');
            return;
        }
        $this->db->insert('reports', [
            'user_id' => $user_id,
            'isi' => $isi,
            'perihal' => $perihal,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        // Tambah log activity
        $this->load->model('Activity_model');
        $this->Activity_model->addActivity(
            $user_id,
            'Laporan/Masukan dikirim',
            'Anda mengirim laporan dengan perihal: ' . $perihal
        );
        $this->session->set_flashdata('success', 'Laporan/masukan berhasil dikirim.');
        redirect('reports');
    }
} 