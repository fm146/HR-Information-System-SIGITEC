<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity_model extends CI_Model {
    public function addActivity($user_id, $title, $desc) {
        $this->db->insert('activity_log', [
            'user_id' => $user_id,
            'title' => $title,
            'description' => $desc,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
    public function getRecent($user_id, $limit=10, $all=false) {
        $this->db->order_by('created_at', 'desc');
        if (!$all) $this->db->where('user_id', $user_id);
        return $this->db->get('activity_log', $limit)->result();
    }
} 