<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    public function index() {
        $role = $this->session->userdata('role');
        $this->db->order_by('tanggal_mulai', 'desc');
        $events = $this->db->get('event')->result();
        $this->load->view('event/index', ['events' => $events, 'role' => $role]);
    }

    public function add() {
        $role = $this->session->userdata('role');
        if ($role != 'superadmin') {
            show_404();
            return;
        }
        $judul = $this->input->post('judul');
        $deskripsi = $this->input->post('deskripsi');
        $tanggal_mulai = $this->input->post('tanggal_mulai');
        $tanggal_selesai = $this->input->post('tanggal_selesai');
        if (!$judul || !$tanggal_mulai || !$tanggal_selesai) {
            $this->session->set_flashdata('error', 'Judul dan tanggal wajib diisi.');
            redirect('event');
            return;
        }
        $this->db->insert('event', [
            'judul' => $judul,
            'deskripsi' => $deskripsi,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai
        ]);
        // Tambah log activity
        $this->load->model('Activity_model');
        $this->Activity_model->addActivity(
            $this->session->userdata('user_id'),
            'Event baru dibuat',
            'Event "' . $judul . '" telah ditambahkan.'
        );
        $this->session->set_flashdata('success', 'Acara berhasil ditambahkan.');
        redirect('event');
    }

    public function edit($id = null) {
        $role = $this->session->userdata('role');
        if ($role != 'superadmin' || !$id) { show_404(); return; }
        if ($this->input->method() === 'post') {
            $judul = $this->input->post('judul');
            $deskripsi = $this->input->post('deskripsi');
            $tanggal_mulai = $this->input->post('tanggal_mulai');
            $tanggal_selesai = $this->input->post('tanggal_selesai');
            if (!$judul || !$tanggal_mulai || !$tanggal_selesai) {
                $this->session->set_flashdata('error', 'Judul dan tanggal wajib diisi.');
                redirect('event');
                return;
            }
            $this->db->where('id', $id)->update('event', [
                'judul' => $judul,
                'deskripsi' => $deskripsi,
                'tanggal_mulai' => $tanggal_mulai,
                'tanggal_selesai' => $tanggal_selesai
            ]);
            $this->session->set_flashdata('success', 'Acara berhasil diupdate.');
            redirect('event');
        } else {
            $event = $this->db->get_where('event', ['id' => $id])->row();
            if (!$event) { show_404(); return; }
            $this->load->view('event/edit', ['event' => $event]);
        }
    }

    public function delete($id = null) {
        $role = $this->session->userdata('role');
        if ($role != 'superadmin' || !$id) { show_404(); return; }
        $this->db->delete('event', ['id' => $id]);
        $this->session->set_flashdata('success', 'Acara berhasil dihapus.');
        redirect('event');
    }
} 