<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_management extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        // Set timezone Jakarta
        date_default_timezone_set('Asia/Jakarta');
        
        $this->load->model('User_management_model');
        $this->load->model('Department_model');
        $this->load->library('form_validation');
        $this->load->helper(array('url', 'auth'));
        
        // Check if user is logged in
        check_login();
        
        // Check if user has admin role for Users Management
        check_role('admin');
    }

    public function index()
    {
        // Set page data
        $data['title'] = 'Users Management';
        $data['page_title'] = 'Users Management';
        $data['breadcrumb'] = [
            ['title' => 'Home', 'url' => base_url()],
            ['title' => 'Master Data'],
            ['title' => 'Users Management']
        ];
        
        // Load views with AdminLTE template
        $this->load->view('templates/header', $data);
        $this->load->view('users/index', $data);
        $this->load->view('templates/footer');
    }

    public function get_users_ajax()
    {
        $users = $this->User_management_model->get_all_users();
        
        $response = array(
            'success' => true,
            'data' => $users
        );
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function create_user_ajax()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[2]|callback_check_name_unique');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_check_email_unique');

        if ($this->form_validation->run() == FALSE) {
            $error_message = $this->get_formatted_errors();
            $response = array(
                'success' => false,
                'message' => $error_message
            );
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email')
                // created_at akan otomatis di-set di model
            );

            if ($this->User_management_model->create_user($data)) {
                $response = array(
                    'success' => true,
                    'message' => 'User berhasil ditambahkan!'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Gagal menambahkan user. Silakan coba lagi.'
                );
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function update_user_ajax()
    {
        $id = $this->input->post('id');
        
        $this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[2]|callback_check_name_unique_edit[' . $id . ']');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_check_email_unique_edit[' . $id . ']');

        if ($this->form_validation->run() == FALSE) {
            $error_message = $this->get_formatted_errors();
            $response = array(
                'success' => false,
                'message' => $error_message
            );
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email')
            );

            if ($this->User_management_model->update_user($id, $data)) {
                $response = array(
                    'success' => true,
                    'message' => 'User berhasil diupdate!'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Gagal mengupdate user. Silakan coba lagi.'
                );
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function delete_user_ajax()
    {
        $id = $this->input->post('id');
        
        if (empty($id)) {
            $response = array(
                'success' => false,
                'message' => 'ID user tidak ditemukan.'
            );
        } else {
            if ($this->User_management_model->delete_user($id)) {
                $response = array(
                    'success' => true,
                    'message' => 'User berhasil dihapus!'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Gagal menghapus user. Silakan coba lagi.'
                );
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function check_email_unique($email)
    {
        if ($this->User_management_model->email_exists($email)) {
            $this->form_validation->set_message('check_email_unique', 'Email ini sudah digunakan.');
            return FALSE;
        }
        return TRUE;
    }

    public function check_email_unique_edit($email, $id)
    {
        if ($this->User_management_model->email_exists($email, $id)) {
            $this->form_validation->set_message('check_email_unique_edit', 'Email ini sudah digunakan.');
            return FALSE;
        }
        return TRUE;
    }

    public function check_name_unique($name)
    {
        if ($this->User_management_model->name_exists($name)) {
            $this->form_validation->set_message('check_name_unique', 'Nama ini sudah digunakan.');
            return FALSE;
        }
        return TRUE;
    }

    public function check_name_unique_edit($name, $id)
    {
        if ($this->User_management_model->name_exists($name, $id)) {
            $this->form_validation->set_message('check_name_unique_edit', 'Nama ini sudah digunakan.');
            return FALSE;
        }
        return TRUE;
    }

    private function get_formatted_errors()
    {
        $errors = array();
        
        if (form_error('name')) {
            $errors[] = strip_tags(form_error('name'));
        }
        
        if (form_error('email')) {
            $errors[] = strip_tags(form_error('email'));
        }

        return implode("\n", $errors);
    }
}
