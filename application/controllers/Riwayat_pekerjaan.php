<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat_pekerjaan extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('date_format');
    }

    public function add_user() {
        // Proses validasi field lain
        $data_user = $this->input->post();
        
        // Konversi tanggal menggunakan helper
        $data_user = convert_form_dates_to_db($data_user, ['tanggal_lahir']);
        
        // Insert user ke DB
        // ... kode insert user ...
    }

    public function update_user() {
        // Proses validasi field lain
        $data_user = $this->input->post();
        
        // Konversi tanggal menggunakan helper
        $data_user = convert_form_dates_to_db($data_user, ['tanggal_lahir']);
        
        // Update user di DB
        // ... kode update user ...
    }

    public function get_user_by_id() {
        $id = $this->input->post('id');
        $this->load->model('User_registration_model');
        $user = $this->User_registration_model->get_user_by_id($id);
        
        if ($user) {
            // Format tanggal untuk display menggunakan helper
            $user = format_dates_in_object($user);
            echo json_encode(['status' => true, 'data' => $user]);
        } else {
            echo json_encode(['status' => false, 'message' => 'User not found']);
        }
    }

    public function get_user_with_history($id){
        $this->load->model('User_registration_model');
        $this->load->model('Riwayat_pekerjaan_model');

        $user = $this->User_registration_model->get_user_by_id($id);
        $riwayat = $this->Riwayat_pekerjaan_model->get_by_user($id);

        // Format tanggal user untuk display (dd.mm.yyyy)
        if ($user) {
            $user = format_dates_in_object($user);
        }

        // Format tanggal riwayat untuk display (dd.mm.yyyy)
        if ($riwayat) {
            foreach ($riwayat as &$job) {
                $job = format_dates_in_object($job);
            }
        }

        $this->output->set_content_type('application/json')
            ->set_output(json_encode([
            'profil' => $user,
            'riwayat' => $riwayat
        ]));
    }

    public function add_job_history() {
        header('Content-Type: application/json');
        
        $this->load->model('Riwayat_pekerjaan_model');
        
        try {
            $data = $this->input->post();
            
            // Remove job_id from data if it exists (untuk add, tidak perlu job_id)
            if (isset($data['job_id'])) {
                unset($data['job_id']);
            }
            
            // Validasi data required
            if (empty($data['user_id']) || empty($data['namaperusahaan']) || empty($data['titlepekerjaan'])) {
                echo json_encode(['status' => false, 'message' => 'Data tidak lengkap - user_id, namaperusahaan, dan titlepekerjaan harus diisi']);
                return;
            }
            
            // Konversi tanggal dari format dd.mm.yyyy ke yyyy-mm-dd
            if (!empty($data['tanggalmasuk'])) {
                $parts = explode('.', $data['tanggalmasuk']);
                if (count($parts) == 3 && checkdate($parts[1], $parts[0], $parts[2])) {
                    $data['tanggalmasuk'] = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
                } else {
                    echo json_encode(['status' => false, 'message' => 'Format tanggal masuk tidak valid']);
                    return;
                }
            }
            
            if (!empty($data['tanggalkeluar'])) {
                $parts = explode('.', $data['tanggalkeluar']);
                if (count($parts) == 3 && checkdate($parts[1], $parts[0], $parts[2])) {
                    $data['tanggalkeluar'] = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
                } else {
                    $data['tanggalkeluar'] = null;
                }
            } else {
                $data['tanggalkeluar'] = null;
            }
            
            $result = $this->Riwayat_pekerjaan_model->insert($data);
            
            if ($result) {
                echo json_encode(['status' => true, 'message' => 'Riwayat pekerjaan berhasil ditambahkan']);
            } else {
                echo json_encode(['status' => false, 'message' => 'Gagal menambahkan riwayat pekerjaan']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function update_job_history() {
        $this->load->model('Riwayat_pekerjaan_model');
        
        try {
            $data = $this->input->post();
            $job_id = $data['job_id'];
            unset($data['job_id']);
            
            // Konversi tanggal menggunakan helper (PERBAIKAN BUG: gunakan format database yang benar)
            $data = convert_form_dates_to_db($data, ['tanggalmasuk', 'tanggalkeluar']);
            
            $result = $this->Riwayat_pekerjaan_model->update($job_id, $data);
            
            if ($result) {
                echo json_encode(['status' => true, 'message' => 'Riwayat pekerjaan berhasil diupdate']);
            } else {
                echo json_encode(['status' => false, 'message' => 'Gagal mengupdate riwayat pekerjaan']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function delete_job_history() {
        $this->load->model('Riwayat_pekerjaan_model');
        
        $job_id = $this->input->post('id');
        $result = $this->Riwayat_pekerjaan_model->delete($job_id);
        
        if ($result) {
            echo json_encode(['status' => true, 'message' => 'Riwayat pekerjaan berhasil dihapus']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Gagal menghapus riwayat pekerjaan']);
        }
    }

    // public function test_job_history(){
    
    //     $this->load->model('Riwayat_pekerjaan_model');
    //     $this->Riwayat_pekerjaan_model->insert([
    //         'user_id' => 46,
    //         'namaperusahaan' => 'Telkom Indonesia',
    //         'titlepekerjaan' => 'Fullstack Developer',
    //         'tanggalmasuk' => '2024-01-01',
    //         'tanggalkeluar' => '2024-12-31',
    //         'universitas' => 'Telkom University'
    //     ]);

    //     $data = $this->Riwayat_pekerjaan_model->get_by_user(46);
    //     echo '<pre>'; print_r($data); echo '</pre>';
    // }

}