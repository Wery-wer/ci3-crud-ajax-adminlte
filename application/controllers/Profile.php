<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        // Set timezone Jakarta
        date_default_timezone_set('Asia/Jakarta');
        
        $this->load->model('User_management_model');
        $this->load->library('form_validation');
        $this->load->helper(array('url', 'auth'));
        
        // Check if user is logged in (any role can access)
        check_login();
    }

    public function index()
    {
        // Get current user data
        $user_id = $this->session->userdata('user_id');
        $user_data = $this->User_management_model->get_user_by_id($user_id);
        
        // Set page data
        $data['title'] = 'My Profile';
        $data['page_title'] = 'My Profile';
        $data['breadcrumb'] = [
            ['title' => 'Home', 'url' => base_url()],
            ['title' => 'My Profile']
        ];
        $data['user'] = $user_data;
        
        // Load views with AdminLTE template
        $this->load->view('templates/header', $data);
        $this->load->view('profile/index', $data);
        $this->load->view('templates/footer');
    }

    public function update_profile_ajax()
    {
        $user_id = $this->session->userdata('user_id');
        
        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check[' . $user_id . ']');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[4]|callback_username_check[' . $user_id . ']');

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
                'updated_at' => date('Y-m-d H:i:s')
            );

            // Update password jika diisi
            $new_password = $this->input->post('password');
            if (!empty($new_password)) {
                $this->form_validation->set_rules('password', 'Password', 'min_length[6]');
                if ($this->form_validation->run() == FALSE) {
                    $response = array(
                        'success' => false,
                        'message' => validation_errors()
                    );
                    header('Content-Type: application/json');
                    echo json_encode($response);
                    return;
                }
                $data['password'] = password_hash($new_password, PASSWORD_DEFAULT);
            }

            if ($this->User_management_model->update_user($user_id, $data)) {
                // Update session data
                $this->session->set_userdata('name', $data['name']);
                $this->session->set_userdata('username', $data['username']);
                
                $response = array(
                    'success' => true,
                    'message' => 'Profile updated successfully!'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Failed to update profile!'
                );
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    // Validation methods
    public function email_check($email, $user_id){
        if ($this->User_management_model->email_exists($email, $user_id)) {
            $this->form_validation->set_message('email_check', 'Email already exists');
            return FALSE;
        }
        return TRUE;
    }

    public function username_check($username, $user_id){
        if ($this->User_management_model->username_exists($username, $user_id)) {
            $this->form_validation->set_message('username_check', 'Username already exists');
            return FALSE;
        }
        return TRUE;
    }
}
