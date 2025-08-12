<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_registration extends MX_Controller {
    public function __construct() {
        parent:: __construct();

        $this->load->model('Registration_model');
        $this->load->library('form_validation');
        $this->load->helper(array('url', 'auth'));

        check_login();
        check_role('admin');
    }

    public function index(){

        $data['title'] = 'User Registration';
        $data['page_title'] = 'User Registration';
        $data['breadcrumb'] = [
            ['title' => 'Home', 'url' => base_url()],
            ['title' => 'User Management'],
            ['title' => 'User Registration']
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('registration/index', $data);
        $this->load->view('templates/footer');
    }

    public function get_users_ajax() {
        $users = $this->Registration_model->get_all_users_for_registration();

        $response = array(
            'draw' => intval($this->input->post('draw')),
            'recordsTotal' => count($users), 
            'recordsFiltered' => count($users),
            'data' => $users
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function create_user_ajax(){
        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_check_email_unique');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.username]|min_length[4]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[admin,manager,user]');

        if ($this->form_validation->run() == FALSE) {
            $response = array (
                'success' => false,
                'message' => validation_errors()
            );
        } else {
            $data = array (
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'username' => $this->input->post('username'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role' => $this->input->post('role'),
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s')
            );

            if($this->Registration_model->create_user($data)) {
                $response = array (
                    'success' => true,
                    'message' => 'User created successfully'
                );
            } else {
                $response = array (
                    'success' => false,
                    'message' => 'Failed to create user'
                );
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function edit_user_ajax() {
        $user_id = $this->input->post('user_id');
        $user = $this->Registration_model->get_user_by_id($user_id);

        if ($user) {
            $response = array(
                'success' => true,
                'data' => $user
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'User not found'
            );
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function update_user_ajax() {
        try {
            $user_id = $this->input->post('user_id');
            
            log_message('debug', 'Update User Input: ' . json_encode($this->input->post()));

            $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check[' . $user_id . ']');
            $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[4]|callback_username_check[' . $user_id . ']');
            $this->form_validation->set_rules('role', 'Role', 'required|in_list[admin,manager,user]');

            if ($this->form_validation->run() == FALSE) {
                $response = array(
                    'success' => false,
                    'message' => validation_errors()
                );
            } else {
                $data = array(
                    'name' => $this->input->post('name'),
                    'email' => $this->input->post('email'),
                    'username' => $this->input->post('username'),
                    'role' => $this->input->post('role'),
                    'is_active' => $this->input->post('is_active'),
                    'updated_at' => date('Y-m-d H:i:s')
                );

                $new_password = $this->input->post('password');
                if (!empty($new_password)) {
                    $data['password'] = password_hash($new_password, PASSWORD_DEFAULT);
                }

                log_message('debug', 'Update User Data: ' . json_encode($data));

                if ($this->Registration_model->update_user($user_id, $data)) {
                    $response = array(
                        'success' => true,
                        'message' => 'User updated successfully!'
                    );
                } else {
                    $db_error = $this->db->error();
                    log_message('error', 'Database Update Error: ' . json_encode($db_error));
                    
                    $response = array(
                        'success' => false,
                        'message' => 'Database error: ' . ($db_error['message'] ? $db_error['message'] : 'Failed to update user!')
                    );
                }
            }
        } catch (Exception $e) {
            log_message('error', 'Update User Exception: ' . $e->getMessage());
            $response = array(
                'success' => false,
                'message' => 'System error: ' . $e->getMessage()
            );
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function delete_user_ajax() {
        $user_id = $this->input->post('user_id');

        if ($user_id == $this->session->userdata('user_id')) {
            $response = array(
                'success' => false,
                'message' => 'You cannot delete your own account!'
            );
        } else {
            if ($this->Registration_model->delete_user($user_id)) {
                $response = array(
                    'success' => true,
                    'message' => 'User deleted successfully!'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Failed to delete user!'
                );
            }
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function email_check($email, $user_id){
        if ($this->Registration_model->email_exists($email, $user_id)) {
            $this->form_validation->set_message('email_check', 'Email already exists');
            return FALSE;
        }
        return TRUE;
    }

    public function username_check($username, $user_id){
        if ($this->Registration_model->username_exists($username, $user_id)) {
            $this->form_validation->set_message('username_check', 'Username already exists');
            return FALSE;
        }
        return TRUE;
    }

    public function check_email_unique($email) {
        if ($this->Registration_model->email_exists($email)) {
            $this->form_validation->set_message('check_email_unique', 'Email already exists');
            return FALSE;
        }
        return TRUE;
    }


}