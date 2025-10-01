<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JamKerja extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
    }

    public function index() {
        if ($this->session->userdata('role') !== 'superadmin') show_404();
        $msg = '';
        if ($this->input->post()) {
            $jam_masuk = $this->input->post('jam_masuk');
            $jam_pulang = $this->input->post('jam_pulang');
            if ($jam_masuk && $jam_pulang) {
                // Cek apakah sudah ada baris jam kerja default
                $cek = $this->db->get('jam_kerja')->row();
                if ($cek) {
                    $this->db->update('jam_kerja', [
                        'jam_masuk' => $jam_masuk,
                        'jam_pulang' => $jam_pulang
                    ], ['id' => $cek->id]);
                } else {
                    $this->db->insert('jam_kerja', [
                        'jam_masuk' => $jam_masuk,
                        'jam_pulang' => $jam_pulang
                    ]);
                }
                $msg = 'Jam kerja berhasil disimpan!';
            } else {
                $msg = 'Jam masuk dan jam pulang wajib diisi!';
            }
        }
        $data['jam_kerja'] = $this->db->get('jam_kerja')->row();
        $data['msg'] = $msg;
        $this->load->view('jam_kerja/index', $data);
    }
} 