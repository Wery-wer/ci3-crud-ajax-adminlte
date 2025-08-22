<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat_pekerjaan_model extends CI_Model {

    // protected $table = 'riwayat_pekerjaan';

    public function __construct() {
        parent::__construct();
    }

    public function get_all() {
        $query = $this->db->get('riwayat_pekerjaan');
        return $query->result();
    }

    public function get_by_id($id) {
        $query = $this->db->get_where('riwayat_pekerjaan', array('id' => $id));
        return $query->row();
    }

    public function get_by_user($user_id) {
        $this->db->where('user_id', $user_id);
        $this->db->order_by('tanggalmasuk', 'DESC');
        $query = $this->db->get('riwayat_pekerjaan');
        return $query->result();
    }

    public function insert($data) {
        return $this->db->insert('riwayat_pekerjaan', $data);
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('riwayat_pekerjaan', $data);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('riwayat_pekerjaan');
    }
}
