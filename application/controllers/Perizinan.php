<?php
class Perizinan extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Perizinan_model');
        if (!$this->session->userdata('user_id')) redirect('auth/login');
    }
    public function index() {
        $data['title'] = 'Perizinan';
        $data['perizinan'] = $this->Perizinan_model->get_by_user($this->session->userdata('user_id'));
        $this->load->view('perizinan/index', $data);
    }
    public function submit() {
        $user_id = $this->session->userdata('user_id');
        $perihal = $this->input->post('perihal');
        $alasan = $this->input->post('alasan');
        $alasan_detail = $this->input->post('alasan_detail');
        $data = [
            'user_id' => $user_id,
            'perihal' => $perihal,
            'alasan' => $perihal == 'Izin Tidak Masuk' ? $alasan : NULL,
            'alasan_detail' => $perihal == 'Pengunduran Diri' ? $alasan_detail : NULL,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->Perizinan_model->insert($data);
        $this->session->set_flashdata('success', 'Pengajuan perizinan berhasil dikirim.');
        redirect('perizinan');
    }
} 