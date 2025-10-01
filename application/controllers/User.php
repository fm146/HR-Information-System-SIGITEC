<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->database();
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
    }

    // Daftar user
    public function index() {
        if (!in_array($this->session->userdata('role'), ['superadmin','admin'])) show_404();
        $q = $this->input->get('q');
        $data['users'] = $this->User_model->getAllUsers($q);
        $data['q'] = $q;
        $this->load->view('user/index', $data);
    }

    // Detail user + rekap gaji
    public function detail($id) {
        if (!in_array($this->session->userdata('role'), ['superadmin','admin'])) show_404();
        $data['user'] = $this->User_model->getUserDetail($id);
        $data['rekap_gaji'] = $this->User_model->getRekapGajiUserByStaffId($data['user']->staff_id);
        $this->load->view('user/detail', $data);
    }

    // Form tambah user
    public function add() {
        if ($this->session->userdata('role') !== 'superadmin') show_404();
        $data['roles'] = $this->User_model->getAllRoles();
        $data['staffs'] = $this->User_model->getAllStaff();
        $data['divisi_list'] = [
            'marketing', 'finance', 'sales', 'branding', 'hr', 'it', 'operational', 'lainnya'
        ];
        $this->load->view('user/form', $data);
    }
    public function add_action() {
        if ($this->session->userdata('role') !== 'superadmin') show_404();
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $role_id = $this->input->post('role_id');
        $staff_id = $this->input->post('staff_id');
        $jam_masuk = $this->input->post('jam_masuk') ?: null;
        $jam_pulang = $this->input->post('jam_pulang') ?: null;
        // Jika staff_id kosong, input staff baru
        if (!$staff_id) {
            $staff_data = [
                'nama' => $this->input->post('nama_lengkap'),
                'divisi_id' => $this->input->post('divisi_id'),
                'jabatan' => $this->input->post('jabatan'),
                'telepon' => $this->input->post('telepon'),
                'rekening_atm' => $this->input->post('rekening_atm'),
                'no_ktp' => $this->input->post('no_ktp'),
                'pendidikan' => $this->input->post('pendidikan'),
                'gaji_bulanan' => $this->input->post('gaji_bulanan'),
                'email' => $this->input->post('email'),
            ];
            $staff_id = $this->User_model->insertStaffFull($staff_data);
        }
        if ($this->User_model->getByUsername($username)) {
            $this->session->set_flashdata('error', 'Username sudah terdaftar!');
            redirect('user/add');
        }
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $this->User_model->insertUserFull($username, $hash, $role_id, $staff_id, $jam_masuk, $jam_pulang);
        // Tambah log activity
        $this->load->model('Activity_model');
        $this->Activity_model->addActivity(
            $this->session->userdata('user_id'),
            'Staff baru ditambahkan',
            'Staff ' . $this->input->post('nama_lengkap') . ' berhasil didaftarkan.'
        );
        $this->session->set_flashdata('success', 'User berhasil ditambah!');
        redirect('user');
    }

    // Form edit user
    public function edit($id) {
        if ($this->session->userdata('role') !== 'superadmin') show_404();
        $data['user'] = $this->User_model->getUserDetail($id);
        $data['roles'] = $this->User_model->getAllRoles();
        $data['staffs'] = $this->User_model->getAllStaff();
        $data['divisi_list'] = [
            'marketing', 'finance', 'sales', 'branding', 'hr', 'it', 'operational', 'lainnya'
        ];
        $this->load->view('user/form', $data);
    }
    public function edit_action($id) {
        if ($this->session->userdata('role') !== 'superadmin') show_404();
        $username = $this->input->post('username');
        $role_id = $this->input->post('role_id');
        $staff_id = $this->input->post('staff_id');
        $jam_masuk = $this->input->post('jam_masuk') ?: null;
        $jam_pulang = $this->input->post('jam_pulang') ?: null;
        // Update data staff
        $staff_data = [
            'nama' => $this->input->post('nama_lengkap'),
            'email' => $this->input->post('email'),
            'divisi_id' => $this->input->post('divisi_id'),
            'jabatan' => $this->input->post('jabatan'),
            'telepon' => $this->input->post('telepon'),
            'rekening_atm' => $this->input->post('rekening_atm'),
            'no_ktp' => $this->input->post('no_ktp'),
            'pendidikan' => $this->input->post('pendidikan'),
            'gaji_bulanan' => $this->input->post('gaji_bulanan'),
        ];
        $this->User_model->updateStaff($staff_id, $staff_data);
        $this->User_model->updateUser($id, $username, $role_id, $staff_id, $jam_masuk, $jam_pulang);
        $this->session->set_flashdata('success', 'User berhasil diupdate!');
        redirect('user');
    }

    // Hapus user
    public function delete($id) {
        if ($this->session->userdata('role') !== 'superadmin') show_404();
        $this->User_model->deleteUser($id);
        $this->session->set_flashdata('success', 'User berhasil dihapus!');
        redirect('user');
    }
} 