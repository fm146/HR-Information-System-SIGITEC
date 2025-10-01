<?php
class Perizinan_model extends CI_Model {
    protected $table = 'perizinan';
    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }
    public function get_by_user($user_id) {
        return $this->db->where('user_id', $user_id)->order_by('created_at', 'DESC')->get($this->table)->result();
    }
} 