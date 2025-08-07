<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper('url');
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
            
            // Cek apakah username dan password valid
            $user = $this->User_model->get_user_by_username($username);
            
            // jika user dan password di cek di database cocok
            if ($user && password_verify($password, $user->password) && $user->is_active == 1) {
                // Update last login
                $this->User_model->update_last_login($user->id);
                
                // session nya di tampilkan
                $session_data = array(
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
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