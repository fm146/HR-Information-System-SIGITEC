<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    public function superadmin() {
        // Check if user has superadmin role
        if ($this->session->userdata('role') !== 'superadmin') {
            redirect('auth');
        }
        
        $data['title'] = 'Super Admin Dashboard';
        $data['username'] = $this->session->userdata('username');
        $data['role'] = $this->session->userdata('role');
        
        $user_id = $this->session->userdata('user_id');
        $this->load->model('User_model');
        $user = $this->User_model->getUserDetail($user_id);
        $staff_id = $user ? $user->staff_id : null;
        $jam_masuk_default = $user && $user->jam_masuk ? $user->jam_masuk : '08:00:00';
        $jam_pulang_default = $user && $user->jam_pulang ? $user->jam_pulang : '16:00:00';
        $today = date('Y-m-d');
        $presensi = null;
        if ($staff_id) {
            $presensi = $this->db->get_where('presensi', [
                'staff_id' => $staff_id,
                'tanggal' => $today
            ])->row();
        }
        $data['jam_masuk_default'] = $jam_masuk_default;
        $data['jam_pulang_default'] = $jam_pulang_default;
        $data['presensi_today'] = $presensi;
        
        $this->load->helper('date');
        $this->load->model('Activity_model');
        $activities = $this->Activity_model->getRecent(null, 3, true);
        $data['activities'] = $activities;
        
        $this->load->view('dashboard/superadmin', $data);
    }

    public function admin() {
        // Check if user has admin role
        if ($this->session->userdata('role') !== 'admin') {
            redirect('auth');
        }
        
        $data['title'] = 'Admin Dashboard';
        $data['username'] = $this->session->userdata('username');
        $data['role'] = $this->session->userdata('role');
        
        $user_id = $this->session->userdata('user_id');
        $this->load->model('User_model');
        $user = $this->User_model->getUserDetail($user_id);
        $staff_id = $user ? $user->staff_id : null;
        $jam_masuk_default = $user && $user->jam_masuk ? $user->jam_masuk : '08:00:00';
        $jam_pulang_default = $user && $user->jam_pulang ? $user->jam_pulang : '16:00:00';
        $today = date('Y-m-d');
        $presensi = null;
        if ($staff_id) {
            $presensi = $this->db->get_where('presensi', [
                'staff_id' => $staff_id,
                'tanggal' => $today
            ])->row();
        }
        $data['jam_masuk_default'] = $jam_masuk_default;
        $data['jam_pulang_default'] = $jam_pulang_default;
        $data['presensi_today'] = $presensi;
        
        $this->load->helper('date');
        $this->load->model('Activity_model');
        $activities = $this->Activity_model->getRecent($user_id, 3, false);
        $data['activities'] = $activities;
        
        $this->load->view('dashboard/admin', $data);
    }

    public function staff() {
        // Check if user has staff role
        if ($this->session->userdata('role') !== 'staff') {
            redirect('auth');
        }
        
        $data['title'] = 'Staff Dashboard';
        $data['username'] = $this->session->userdata('username');
        $data['role'] = $this->session->userdata('role');
        
        $user_id = $this->session->userdata('user_id');
        $this->load->model('User_model');
        $user = $this->User_model->getUserDetail($user_id);
        $staff_id = $user ? $user->staff_id : null;
        $jam_masuk_default = $user && $user->jam_masuk ? $user->jam_masuk : '08:00:00';
        $jam_pulang_default = $user && $user->jam_pulang ? $user->jam_pulang : '16:00:00';
        $today = date('Y-m-d');
        $presensi = null;
        if ($staff_id) {
            $presensi = $this->db->get_where('presensi', [
                'staff_id' => $staff_id,
                'tanggal' => $today
            ])->row();
        }
        $data['jam_masuk_default'] = $jam_masuk_default;
        $data['jam_pulang_default'] = $jam_pulang_default;
        $data['presensi_today'] = $presensi;
        
        $this->load->helper('date');
        $this->load->model('Activity_model');
        $activities = $this->Activity_model->getRecent($user_id, 3, false);
        $data['activities'] = $activities;
        
        $this->load->view('dashboard/staff', $data);
    }
} 