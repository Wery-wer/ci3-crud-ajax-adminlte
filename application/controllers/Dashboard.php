<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->helper(array('url', 'auth'));
        
        // Check if user is logged in
        check_login();
    }

    public function index()
    {
        // Get statistics for dashboard
        $data['total_users'] = $this->User_model->count_all();
        $data['recent_users'] = $this->User_model->get_recent_users(5);
        
        // Get current user data
        $data['user_name'] = $this->session->userdata('name');
        $data['username'] = $this->session->userdata('username');
        $data['user_role'] = $this->session->userdata('role');
        
        // Set page data
        $data['title'] = 'Dashboard';
        $data['page_title'] = 'Dashboard';
        $data['breadcrumb'] = [
            ['title' => 'Home', 'url' => base_url()],
            ['title' => 'Dashboard']
        ];
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }
}
