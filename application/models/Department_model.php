<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get all active departments
     */
    public function get_all_departments() {
        $this->db->select('d.*, u.name as manager_name');
        $this->db->from('departments d');
        $this->db->join('users u', 'd.manager_id = u.id', 'left');
        $this->db->where('d.status', 'active');
        $this->db->order_by('d.department_name', 'ASC');
        
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get department by ID
     */
    public function get_department_by_id($id) {
        $this->db->select('d.*, u.name as manager_name');
        $this->db->from('departments d');
        $this->db->join('users u', 'd.manager_id = u.id', 'left');
        $this->db->where('d.id', $id);
        
        $query = $this->db->get();
        return $query->row();
    }

    /**
     * Get departments for dropdown
     */
    public function get_departments_for_dropdown() {
        $this->db->select('id, department_name');
        $this->db->from('departments');
        $this->db->where('status', 'active');
        $this->db->order_by('department_name', 'ASC');
        
        $query = $this->db->get();
        return $query->result();
    }
}
