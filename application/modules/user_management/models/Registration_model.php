<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration_model extends CI_Model {

    private $table = 'users';

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function get_all_users_for_registration() {
        $this->db->select('id, name, username, email, role, is_active, last_login');
        $this->db->from($this->table);
        $this->db->order_by('id', 'DESC');
        $users = $this->db->get()->result_array();

        $formatted_users = [];
        foreach ($users as $user) {
             $status_badge = $user['is_active'] == 1 ? 
                '<span class="badge badge-success">Active</span>' : 
                '<span class="badge badge-danger">Inactive</span>';
                
            $role_badge = '';
            switch($user['role']) {
                case 'admin' :
                    $role_badge = '<span class="badge badge-danger">Admin</span>';
                    break;
                case 'manager' :
                    $role_badge = '<span class="badge badge-warning">Manager</span>';
                    break;
                case 'user' :
                    $role_badge = '<span class="badge badge-primary">User</span>';
                    break;
            }

            $last_login = $user['last_login'] ? 
                date('d M Y H:i', strtotime($user['last_login'])) : 
                'Never';
            
            $actions = '
                <button class="btn btn-sm btn-warning edit-btn" data-id="'.$user['id'].'">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-sm btn-danger delete-btn" data-id="'.$user['id'].'" data-name="'.$user['name'].'">
                    <i class="fas fa-trash"></i> Delete
                </button>
            ';

            $formatted_users[] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'username' => $user['username'],
                'role' => $role_badge,
                'status' => $status_badge,
                'last_login' => $last_login,
                'actions' => $actions
            ];
        }
        return $formatted_users;
    }

    public function get_user_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }

    // Create user baru
    public function create_user($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // Update user
    public function update_user($id, $data)
    {
        // Debug: Log data yang akan diupdate
        log_message('debug', 'Model update_user - ID: ' . $id . ', Data: ' . json_encode($data));
        
        $this->db->where('id', $id);
        $result = $this->db->update($this->table, $data);
        
        // Debug: Log hasil update dan error jika ada
        if (!$result) {
            $error = $this->db->error();
            log_message('error', 'Model update_user failed - Error: ' . json_encode($error));
        } else {
            log_message('debug', 'Model update_user success - Affected rows: ' . $this->db->affected_rows());
        }
        
        return $result;
    }

    // Delete user
    public function delete_user($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    // Check email exists (untuk validation)
    public function email_exists($email, $exclude_id = null)
    {
        $this->db->where('email', $email);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        $query = $this->db->get($this->table);
        return $query->num_rows() > 0;
    }

    // Check username exists (untuk validation)
    public function username_exists($username, $exclude_id = null)
    {
        $this->db->where('username', $username);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        $query = $this->db->get($this->table);
        return $query->num_rows() > 0;
    }

    // Get total users count
    public function count_all_users()
    {
        return $this->db->count_all($this->table);
    }

    // Get users by role
    public function get_users_by_role($role)
    {
        $this->db->where('role', $role);
        $this->db->where('is_active', 1);
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

}