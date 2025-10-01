<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
    }

    public function index() {
        if ($this->session->userdata('logged_in')) {
            $this->_redirect_by_role($this->session->userdata('role'));
        }
        $this->load->view('auth/login');
    }

    public function login() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $user = $this->User_model->getByUsername($username);
        if ($user && password_verify($password, $user->password)) {
            $this->session->set_userdata([
                'user_id' => $user->id,
                'username' => $user->username,
                'role' => $user->role,
                'logged_in' => true
            ]);
            $this->_redirect_by_role($user->role);
        } else {
            $this->session->set_flashdata('error', 'Username atau password salah!');
            redirect('auth');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth');
    }

    public function register() {
        $data['roles'] = $this->User_model->getAllRoles();
        $this->load->view('auth/register', $data);
    }

    public function register_action() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $role_id = $this->input->post('role_id');

        // Validasi sederhana
        if (empty($username) || empty($password) || empty($role_id)) {
            $this->session->set_flashdata('error', 'Semua field wajib diisi!');
            redirect('auth/register');
        }

        // Cek username sudah ada
        if ($this->User_model->getByUsername($username)) {
            $this->session->set_flashdata('error', 'Username sudah terdaftar!');
            redirect('auth/register');
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $this->User_model->insertUser($username, $hash, $role_id);
        $this->session->set_flashdata('success', 'Pendaftaran berhasil! Silakan login.');
        redirect('auth');
    }

    public function set_theme_mode() {
        if (!$this->session->userdata('logged_in')) {
            show_error('Unauthorized', 401);
        }
        $theme_mode = $this->input->post('theme_mode');
        $user_id = $this->session->userdata('user_id');
        if (in_array($theme_mode, ['light', 'dark'])) {
            $this->User_model->updateThemeMode($user_id, $theme_mode);
            $this->session->set_userdata('theme_mode', $theme_mode);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Invalid mode']);
        }
    }

    public function gaji_setting() {
        if ($this->session->userdata('role') !== 'superadmin') show_404();
        $data['gaji_per_jam'] = $this->User_model->getGajiPerJam();
        $this->load->view('gaji/setting', $data);
    }
    public function gaji_setting_action() {
        if ($this->session->userdata('role') !== 'superadmin') show_404();
        $nominal = (int)$this->input->post('nominal_per_jam');
        if ($nominal > 0) {
            $this->User_model->setGajiPerJam($nominal);
            $this->session->set_flashdata('success', 'Gaji per jam berhasil diupdate!');
        } else {
            $this->session->set_flashdata('error', 'Nominal tidak valid!');
        }
        redirect('auth/gaji_setting');
    }

    public function generate_gaji_bulanan() {
        if ($this->session->userdata('role') !== 'superadmin') show_404();
        $bulan = $this->input->post('bulan') ?: date('m');
        $tahun = $this->input->post('tahun') ?: date('Y');
        $this->User_model->generateGajiBulanan($bulan, $tahun);
        // Tambah log activity
        $this->load->model('Activity_model');
        $this->Activity_model->addActivity(
            $this->session->userdata('user_id'),
            'Gaji bulanan digenerate',
            'Gaji bulan ' . $bulan . '/' . $tahun . ' telah digenerate.'
        );
        $this->session->set_flashdata('success', 'Gaji bulanan berhasil digenerate!');
        redirect('gaji');
    }

    private function _redirect_by_role($role) {
        switch ($role) {
            case 'superadmin':
                redirect('dashboard/superadmin');
                break;
            case 'admin':
                redirect('dashboard/admin');
                break;
            case 'staff':
                redirect('dashboard/staff');
                break;
            default:
                redirect('auth');
        }
    }
} 