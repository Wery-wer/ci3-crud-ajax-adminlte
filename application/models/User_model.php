<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    private $table = 'users';

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

    private function get_jakarta_time()
    {
        return date('Y-m-d H:i:s');
    }

    public function get_all_users()
    {
        $this->db->order_by('id', 'DESC');
        return $this->db->get($this->table)->result_array();
    }

    public function get_user_by_id($id)
    {
        return $this->db->get_where($this->table, array('id' => $id))->row_array();
    }

    public function create_user($data)
    {
        $data['created_at'] = $this->get_jakarta_time();
        return $this->db->insert($this->table, $data);
    }

    public function update_user($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete_user($id)
    {
        return $this->db->delete($this->table, array('id' => $id));
    }

    public function get_user_by_username($username) {
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        return $query->row();
    }

    public function update_last_login($user_id){
        $this->db->where('id', $user_id);
        $this->db->update('users', array('last_login' => date('Y-m-d H:i:s')));
        return $this->db->affected_rows() > 0;
    }

    public function email_exists($email, $exclude_id = null)
    {
        $this->db->where('email', $email);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->get($this->table)->num_rows() > 0;
    }

    public function username_exists($username, $exclude_id = null)
    {
        $this->db->where('username', $username);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->get($this->table)->num_rows() > 0;
    }

    public function name_exists($name, $exclude_id = null)
    {
        $this->db->where('name', $name);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->get($this->table)->num_rows() > 0;
    }

    public function count_all()
    {
        return $this->db->count_all($this->table);
    }

    public function get_recent_users($limit = 5)
    {
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        $result = $this->db->get($this->table)->result_array();
        
        foreach ($result as &$user) {
            $user['created_at_jakarta'] = date('d M Y H:i', strtotime($user['created_at']));
        }
        
        return $result;
    }
}
