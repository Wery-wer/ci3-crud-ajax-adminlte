<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Debug extends CI_Controller {
    
    public function session_data() {
        echo "<h3>Session Data Debug:</h3>";
        echo "<pre>";
        print_r($this->session->all_userdata());
        echo "</pre>";
        
        echo "<h3>Role Functions:</h3>";
        echo "get_user_role(): " . get_user_role() . "<br>";
        echo "Session role: " . $this->session->userdata('role') . "<br>";
        echo "Role lowercase: " . strtolower($this->session->userdata('role')) . "<br>";
        
        echo "<h3>Condition Check:</h3>";
        echo "get_user_role() == 'admin': " . (get_user_role() == 'admin' ? 'TRUE' : 'FALSE') . "<br>";
        echo "strtolower(get_user_role()) == 'admin': " . (strtolower(get_user_role()) == 'admin' ? 'TRUE' : 'FALSE') . "<br>";
    }
}
