<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    // Ambil pesan (broadcast & per user)
    public function getMessages() {
        $user_id = $this->session->userdata('user_id');
        $with_user = $this->input->get('with_user'); // null untuk broadcast
        $this->db->select('chat_messages.*, user.username as sender_name, staff.nama as sender_staff_name');
        $this->db->from('chat_messages');
        $this->db->join('user', 'user.id = chat_messages.sender_id', 'left');
        $this->db->join('staff', 'staff.id = user.staff_id', 'left');
        $this->db->order_by('chat_messages.created_at', 'asc');
        if ($with_user) {
            $this->db->where('(
                (chat_messages.sender_id = '.$user_id.' AND chat_messages.receiver_id = '.$with_user.') OR
                (chat_messages.sender_id = '.$with_user.' AND chat_messages.receiver_id = '.$user_id.')
            )');
        } else {
            $this->db->where('(chat_messages.receiver_id IS NULL OR chat_messages.receiver_id = '.$user_id.' OR chat_messages.sender_id = '.$user_id.')');
        }
        $messages = $this->db->get()->result();
        // Kirim sender_name (nama staff jika ada, jika tidak username)
        $result = [];
        foreach ($messages as $msg) {
            $result[] = [
                'id' => $msg->id,
                'sender_id' => $msg->sender_id,
                'receiver_id' => $msg->receiver_id,
                'message' => $msg->message,
                'created_at' => $msg->created_at,
                'is_read' => $msg->is_read,
                'sender_name' => $msg->sender_staff_name ? $msg->sender_staff_name : $msg->sender_name
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($result);
    }

    // Kirim pesan
    public function sendMessage() {
        $user_id = $this->session->userdata('user_id');
        $receiver_id = $this->input->post('receiver_id'); // null untuk broadcast
        $message = $this->input->post('message');
        if (!$user_id) {
            echo json_encode(['status'=>'error','msg'=>'Session user hilang, silakan login ulang.']);
            return;
        }
        if (!$message) {
            echo json_encode(['status'=>'error','msg'=>'Pesan tidak boleh kosong.']);
            return;
        }
        $this->db->insert('chat_messages', [
            'sender_id' => $user_id,
            'receiver_id' => $receiver_id ? $receiver_id : null,
            'message' => $message,
            'created_at' => date('Y-m-d H:i:s'),
            'is_read' => 0
        ]);
        echo json_encode(['status'=>'ok']);
    }

    // Tandai pesan sudah dibaca
    public function markAsRead() {
        $user_id = $this->session->userdata('user_id');
        $with_user = $this->input->post('with_user');
        if ($with_user) {
            $this->db->where('sender_id', $with_user);
            $this->db->where('receiver_id', $user_id);
        } else {
            $this->db->where('receiver_id', $user_id);
            $this->db->where('sender_id IS NOT NULL');
        }
        $this->db->update('chat_messages', ['is_read'=>1]);
        echo json_encode(['status'=>'ok']);
    }

    // Ambil semua user (untuk list chat per user)
    public function getAllUsers() {
        $user_id = $this->session->userdata('user_id');
        $this->load->model('User_model');
        // Ambil semua user tanpa filter divisi jika superadmin atau admin
        $is_admin = in_array($this->session->userdata('role'), ['superadmin','admin']);
        $users = $this->User_model->getAllUsers(null, $is_admin);
        $result = [];
        foreach ($users as $u) {
            if ($u->id == $user_id) continue;
            $result[] = [
                'id' => $u->id,
                'username' => $u->username,
                'role' => isset($u->role) ? $u->role : (isset($u->role_nama) ? $u->role_nama : '-')
            ];
        }
        echo json_encode($result);
    }
} 