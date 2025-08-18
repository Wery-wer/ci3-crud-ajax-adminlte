<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_registration extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_registration_model');
        $this->load->helper(['url', 'form']);
        $this->load->library(['form_validation', 'session']);
        
        // Check if user is logged in
        if (!$this->session->userdata('is_logged_in')) {
            redirect('auth/login');
        }
        
        // Check if user has admin role
        if (strtolower($this->session->userdata('role')) !== 'admin') {
            show_error('Access denied. You need admin privileges to access this page.', 403, 'Access Denied');
        }
    }

    public function index() {
        $data['title'] = 'User Registration Management';
        $data['page_title'] = 'User Registration';
        $data['breadcrumb'] = [
            ['title' => 'Home', 'url' => base_url()],
            ['title' => 'Master Data'],
            ['title' => 'User Registration']
        ];
        
        $this->load->view('templates/header', $data);
        $this->load->view('user_registration/index');
        $this->load->view('templates/footer');
    }

    public function get_roles_ajax() {
        $roles = $this->User_registration_model->get_all_roles();
        echo json_encode(['status' => true, 'data' => $roles]);
    }

    // public function test_role()
    // {
    //     $roles = $this->User_registration_model->get_all_roles();
    //     echo '<pre>';
    //     print_r($roles);
    //     echo '</pre>';
    //     echo json_encode(['data' => $roles]);
    // }

    public function get_departments_ajax() {
        $departments = $this->User_registration_model->get_all_departments();
        echo json_encode(['status' => true, 'data' => $departments]);
    }

    // public function test_depart()
    // {
    //     $users = $this->User_registration_model->get_all_departments();
    //     echo '<pre>';
    //     print_r($users);
    //     echo '</pre>';
    //     echo json_encode(['data' => $users]);
    // }

    public function get_users_ajax() {
        $users = $this->User_registration_model->get_all_users_for_registration();
        echo json_encode(['data' => $users]);
    }

    // public function test_user()
    // {
    //     $users = $this->User_registration_model->get_all_users_for_registration();
    //     echo '<pre>';
    //     print_r($users);
    //     echo '</pre>';
    //     echo json_encode(['data' => $users]);
    // }

    public function add_user() {
        $this->form_validation->set_rules('name', 'Full Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('role_id', 'Role', 'required');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => false, 'message' => validation_errors()]);
        } else {
            $result = $this->User_registration_model->create_user($this->input->post());
            echo json_encode(['status' => $result, 'message' => $result ? 'User added successfully' : 'Failed to add user']);
        }
    }

    public function get_user_by_id() {
        $user_id = $this->input->post('id');
        $user = $this->User_registration_model->get_user_by_id($user_id);
        if ($user) {
            echo json_encode(['status' => true, 'data' => $user]);
        } else {
            echo json_encode(['status' => false, 'message' => 'User not found']);
        }
    }

    // public function test_getid()
    // {
    //     $user = $this->User_registration_model->get_user_by_id(46);
    //     echo '<pre>';
    //     print_r($user);
    //     echo '</pre>';
    //     // echo json_encode($user);
    //     $query = $this->db->get('users');
    //     echo '</pre>';
    //     // print_r($query->row_array());
    //     // print_r($query->row());
    //     // print_r($query->result_array());
    //     print_r($query->result());
    // }

    public function update_user() {
        $this->form_validation->set_rules('name', 'Full Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('role_id', 'Role', 'required');
        $this->form_validation->set_rules('is_active', 'Status', 'required');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => false, 'message' => validation_errors()]);
        } else {
            $result = $this->User_registration_model->update_user($this->input->post());
            echo json_encode(['status' => $result, 'message' => $result ? 'User updated successfully' : 'Failed to update user']);
        }
    }

    public function delete_user() {
        $user_id = $this->input->post('id');
        $result = $this->User_registration_model->delete_user($user_id);
        echo json_encode(['status' => $result, 'message' => $result ? 'User deleted successfully' : 'Failed to delete user']);
    }
}