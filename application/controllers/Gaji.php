<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gaji extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->database();
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
    }

    // Rekap gaji untuk superadmin (dengan filter)
    public function index() {
        if ($this->session->userdata('role') !== 'superadmin') show_404();
        $filter = [
            'nama' => $this->input->get('nama'),
            'divisi' => $this->input->get('divisi'),
            'min_gaji' => $this->input->get('min_gaji'),
            'max_gaji' => $this->input->get('max_gaji'),
            'min_jam' => $this->input->get('min_jam'),
            'max_jam' => $this->input->get('max_jam'),
            'bulan' => $this->input->get('bulan') ?: date('m'),
            'tahun' => $this->input->get('tahun') ?: date('Y'),
        ];
        $msg_hari_kerja = '';
        // Proses simpan hari kerja jika ada POST
        if ($this->input->post('jumlah_hari_kerja')) {
            $jumlah_hari = (int)$this->input->post('jumlah_hari_kerja');
            $bulan = (int)($this->input->post('bulan') ?: date('m'));
            $tahun = (int)($this->input->post('tahun') ?: date('Y'));
            // Cek sudah ada?
            $cek = $this->db->get_where('hari_kerja_bulanan', ['bulan'=>$bulan, 'tahun'=>$tahun])->row();
            if ($cek) {
                $this->db->where('id', $cek->id)->update('hari_kerja_bulanan', ['jumlah_hari'=>$jumlah_hari]);
                $msg_hari_kerja = 'Hari kerja berhasil diupdate!';
            } else {
                $this->db->insert('hari_kerja_bulanan', [
                    'bulan'=>$bulan,
                    'tahun'=>$tahun,
                    'jumlah_hari'=>$jumlah_hari
                ]);
                $msg_hari_kerja = 'Hari kerja berhasil disimpan!';
            }
        }
        // Ambil hari kerja bulan ini
        $cek = $this->db->get_where('hari_kerja_bulanan', ['bulan'=>(int)$filter['bulan'], 'tahun'=>(int)$filter['tahun']])->row();
        $data['jumlah_hari_kerja'] = $cek ? $cek->jumlah_hari : HARI_AKTIF_KERJA_DEFAULT;
        $data['msg_hari_kerja'] = $msg_hari_kerja;
        $data['rekap'] = $this->User_model->getRekapGaji($filter);
        $data['filter'] = $filter;
        $data['divisi_list'] = $this->User_model->getAllDivisi();
        $this->load->view('gaji/index', $data);
    }

    // Rekap gaji pribadi (admin/staff)
    public function my() {
        $user_id = $this->session->userdata('user_id');
        $data['rekap'] = $this->User_model->getRekapGajiUser($user_id);
        $this->load->view('gaji/my', $data);
    }
} 