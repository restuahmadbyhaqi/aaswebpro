<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
require_once FCPATH . 'vendor/autoload.php';

use Restserver\Libraries\REST_Controller;
class Sewa extends REST_Controller
{
    function __construct($config = 'rest'){
        parent::__construct($config);
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
            header("Access-Control-Allow-Headers: Authorization, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, ");
            exit;
        }
        $this->load->database();
        $this->load->model('M_Transaksi');
        $this->load->model('M_Mobil');
        $this->load->library('form_validation');
        $this->load->library('jwt');
    }

    function validate(){
        $input_data = file_get_contents("php://input");
        parse_str($input_data, $put_data);

        $this->form_validation->set_data($put_data);
        
        $this->form_validation->set_rules('nama', 'Nama Customer', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat Customer','required');
        $this->form_validation->set_rules('no_hp', 'Nomor Hp Customer', 'required');
        $this->form_validation->set_rules('tgl_pinjam', 'Tanggal Sewa Customer', 'required');
        $this->form_validation->set_rules('tgl_kembali', 'Tanggal Pengembalian Customer', 'required');
        $this->form_validation->set_rules('id_mobil', 'Id Mobil', 'required');
    }

    public function options_get() {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        exit();
    }

    function is_login() {
        $authorizationHeader = $this->input->get_request_header('Authorization', true);

        if (empty($authorizationHeader) || $this->jwt->decode($authorizationHeader) === false) {
            $this->response(
                array(
                    'kode' => '401',
                    'pesan' => 'signature tidak sesuai',
                    'data' => []
                ), '401'
            );
            return false;
        }

        return true;
    }
    
    public function index_post() {
        if (!$this->is_login()) {
            return;
        }

        $this->validate();

        if ($this->form_validation->run() === FALSE) {
            $error = $this->form_validation->error_array();
            $response = array(
                'status_code' => 502,
                'message' => $error
            );
            return $this->response($response);
        }
        
        $idMobil = $this->post('id_mobil');

        if ($this->M_Mobil->mobilExist($idMobil)) {
            $response = array(
                'status_code' => 400,
                'message' => 'Mobil sedang dipinjam atau tidak ditemukan.'
            );
            return $this->response($response);
        }

        $data = [
            'nama' => $this->post('nama'),
            'alamat' => $this->post('alamat'),
            'no_hp' => $this->post('no_hp'),
            'tgl_pinjam' => $this->post('tgl_pinjam'),
            'tgl_kembali' => $this->post('tgl_kembali'),
            'id_mobil' => $this->post('id_mobil'),
        ];

        if ($this->M_Transaksi->customerSewaMobil($data)) {
            $response = array(
                'status_code' => 201,
                'message' => 'success',
                'data' => $data,
            );

            return $this->response($response);
        } else {
            $error = array(
                'status_code' => 400,
                'message' => 'gagal menambahkan data',
            );

            return $this->response($error);
        }
    }
    
    function index_delete() {
        if (!$this->is_login()) {
            return;
        }
    
        $id = $this->delete('id');
        $check = $this->M_Transaksi->get_by_id($id);
    
        if($check == false) {
            $error = array(
                'status' => 'fail',
                'field' => 'id',
                'message' => 'id is not found',
                'status_code' => 502
            );
    
            return $this->response($error);
        }
    
        $transaksiData = $this->M_Transaksi->get_by_id($id);
        $idMobil = $transaksiData['id_mobil'];
    
        $delete = $this->M_Transaksi->delete($id);
    
        $mobilStillInUse = $this->M_Mobil->mobilExist($idMobil);
    
        if (!$mobilStillInUse) {
            $updateStatusQuery = "UPDATE mobil SET status = 1 WHERE id = $idMobil";
            $this->db->query($updateStatusQuery);
        
            echo $updateStatusQuery;
        }
        
    
        $response = array(
            'status' => 'success',
            'data' => $delete,
            'status_code' => 200
        );
    
        return $this->response($response);
    }
    

}

?>