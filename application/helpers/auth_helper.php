<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('check_login')) {
    function check_login() {
        $CI =& get_instance();
        if (!$CI->session->userdata('is_logged_in')) {
            redirect('auth/login');
        }
    }
}

if (!function_exists('check_role')) {
    function check_role($required_role) {
        $CI =& get_instance();
        $user_role = $CI->session->userdata('role');
        
        if (!$user_role) {
            redirect('auth/login');
        }
        
        $roles = array('user' => 1, 'manager' => 2, 'admin' => 3);
        
        if ($roles[$user_role] < $roles[$required_role]) {
            show_error('Access denied. You do not have permission to access this page.', 403, 'Access Denied');
        }
    }
}

if (!function_exists('is_logged_in')) {
    function is_logged_in() {
        $CI =& get_instance();
        return $CI->session->userdata('is_logged_in') == true;
    }
}

if (!function_exists('get_user_role')) {
    function get_user_role() {
        $CI =& get_instance();
        return $CI->session->userdata('role');
    }
}

if (!function_exists('get_user_name')) {
    function get_user_name() {
        $CI =& get_instance();
        return $CI->session->userdata('name');
    }
}

if (!function_exists('get_username')) {
    function get_username() {
        $CI =& get_instance();
        return $CI->session->userdata('username');
    }
}