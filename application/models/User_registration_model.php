<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_registration_model extends CI_Model {
    public function get_all_users_for_registration() {
        $this->db->select('u.id, u.name, u.username, u.email, u.is_active, u.last_login, r.role_name, d.department_name, d.department_code');
        $this->db->from('users u');
        $this->db->join('master_role r', 'u.role_id = r.id', 'left');
        $this->db->join('departments d', 'u.department_id = d.id', 'left');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_roles() {
        $query = $this->db->get('master_role');
        return $query->result_array();
    }

    public function get_all_departments() {
        $this->db->select('id, department_name, department_code');
        $this->db->from('departments');
        $this->db->where('status', 'active');
        $this->db->order_by('department_name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function create_user($data) {
        $insert = [
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role_id' => $data['role_id'],
            'department_id' => !empty($data['department_id']) ? $data['department_id'] : null,
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ];
        return $this->db->insert('users', $insert);
    }

    public function update_user($data) {
        $update = [
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'role_id' => $data['role_id'],
            'department_id' => !empty($data['department_id']) ? $data['department_id'] : null,
            'is_active' => $data['is_active']
        ];
        if (!empty($data['password'])) {
            $update['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        $this->db->where('id', $data['user_id']);
        return $this->db->update('users', $update);
    }

    public function get_user_by_id($user_id) {
        $this->db->select('u.*, r.role_name, d.department_name, d.department_code');
        $this->db->from('users u');
        $this->db->join('master_role r', 'u.role_id = r.id', 'left');
        $this->db->join('departments d', 'u.department_id = d.id', 'left');
        $this->db->where('u.id', $user_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function delete_user($user_id) {
        $this->db->where('id', $user_id);
        return $this->db->delete('users');
    }
}
