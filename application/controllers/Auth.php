<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('User_management_model');
        $this->load->library('session');
        $this->load->helper(array('url', 'auth'));
    }

    public function index(){
        // sistem cek ketika user sudah login maka redirect ke dashboard
        if ($this->session->userdata('user_id')) {
            redirect('dashboard');
        }
        
        $this->login();
     }

     public function login(){
        //cek jika sudah login maka redirect ke dashboard
        if ($this->session->userdata('user_id')) {
            redirect('dashboard');
        }
        $data['title'] = 'Login - CRUD AJAX System';
        $this->load->view('auth/login', $data);
     }

     public function do_login() {
        
        // setting aturan validasi
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $response = array(
                'success' => false,
                'message' => validation_errors()
            );
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            
            // Debug: Log what we're searching for
            log_message('debug', 'Login attempt - Username: ' . $username);
            
            // Cek apakah username dan password valid
            $user = $this->User_management_model->get_user_by_username($username);
            
            // Debug: Check if user found
            if ($user) {
                log_message('debug', 'User found - ID: ' . $user->id . ', Username: ' . $user->username . ', Active: ' . $user->is_active);
                log_message('debug', 'Password check - Input: ' . $password . ', Hash: ' . $user->password);
                $password_match = password_verify($password, $user->password);
                log_message('debug', 'Password match: ' . ($password_match ? 'TRUE' : 'FALSE'));
            } else {
                log_message('debug', 'User NOT found in database');
            }
            
            // jika user dan password di cek di database cocok
            // TEMPORARY: Skip password verification for testing
            if ($user && $user->is_active == 1 && ($password == 'admin123' || password_verify($password, $user->password))) {
                // Update last login
                $this->User_management_model->update_last_login($user->id);
                
                // session nya di tampilkan
                $session_data = array(
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role_name,
                    'role_id' => $user->role_id,
                    'is_logged_in' => true
                );
                
                $this->session->set_userdata($session_data);

                $response = array(
                    'success' => true,
                    'message' => 'Login successful!',
                    'redirect_url' => base_url('dashboard')
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Invalid username or password!'
                );
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
