<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(['url', 'form']);
    }

    public function index() {
        if ($this->session->userdata('role') !== 'superadmin') show_404();
        $msg = '';
        $config_file = APPPATH.'config/config.php';
        $current_timezone = @date_default_timezone_get();
        if ($this->input->post('timezone')) {
            $timezone = $this->input->post('timezone');
            // Update config.php (replace or add date_default_timezone_set)
            $config = file_get_contents($config_file);
            $config = preg_replace('/date_default_timezone_set\([^)]+\);/','', $config); // hapus baris lama
            $config .= "\ndate_default_timezone_set('".$timezone."');\n";
            file_put_contents($config_file, $config);
            $msg = 'Timezone berhasil diupdate!';
            $current_timezone = $timezone;
        }
        $data['msg'] = $msg;
        $data['current_timezone'] = $current_timezone;
        $data['timezones'] = timezone_identifiers_list();
        $this->load->view('settings/index', $data);
    }
} 