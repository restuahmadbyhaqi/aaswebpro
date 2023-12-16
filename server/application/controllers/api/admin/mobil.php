<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
require_once FCPATH . 'vendor/autoload.php';

use Restserver\Libraries\REST_Controller;
class Mobil extends REST_Controller
{
    function __construct($config = 'rest'){
        parent::__construct($config);
        header('Access-Control-Allow-Origin:*');
        header("Access-Control-Allow-Headers:X-API-KEY,Origin,X-Requested-With,Content-Type,Accept,Access-Control-Request-Method,Authorization");
        header("Access-Control-Allow-Methods:GET,POST,OPTIONS,PUT,DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
        $this->load->database();
        $this->load->model('M_Mobil');
        $this->load->library('form_validation');
        $this->load->library('jwt');
    }

    public function options_get() {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        exit();
    }

    function validate(){
        $input_data = file_get_contents("php://input");
        parse_str($input_data, $put_data);

        $this->form_validation->set_data($put_data);
        
        $this->form_validation->set_rules('nama_mobil', 'Nama Mobil', 'required|trim');
        $this->form_validation->set_rules('warna', 'Warna Mobil','required|trim');
        $this->form_validation->set_rules('no_polisi', 'Nomor Polisi', 'required|trim');
        $this->form_validation->set_rules('jumlah_kursi', 'Jumlah Kursi', 'required|trim|numeric');
        $this->form_validation->set_rules('harga_sewa', 'Harga Sewa', 'required|trim');
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

    function index_get() {
        if (!$this->is_login()) {
            return;
        }

        $id = $this->get('id');
        if($id == '') {
            $data = $this->M_Mobil->get_all();
        } else {
            $data = $this->M_Mobil->get_by_id($id);
        }
        $this->response($data, 200);
    }
    
    function index_post(){
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
        $nama_mobil = $this->input->post('nama_mobil');
        $warna = $this->input->post('warna');
        $no_polisi = $this->input->post('no_polisi');
        $jumlah_kursi = $this->input->post('jumlah_kursi');
        $harga_sewa = $this->input->post('harga_sewa');
        $status = 1; //tersedia

        $data = array(
            'nama_mobil' => $nama_mobil,
            'warna' => $warna,
            'no_polisi' => $no_polisi,
            'jumlah_kursi' => $jumlah_kursi,
            'harga_sewa' => $harga_sewa,
            'status' => $status
        );
        $this->M_Mobil->insert($data);
        $response = array(
                'status_code' => 201,
                'message' => 'success',
                'data' => $data,
            );

            return $this->response($response);
    }

    public function index_put(){
        if (!$this->is_login()) {
            return;
        }

        $id = $this->put('id');
        $check = $this->M_Mobil->check_data($id);

        if (!$check) {
            $error = array(
                'status' => 'fail',
                'field' => 'id',
                'message' => 'ID is not found',
                'status_code' => 502
            );

            return $this->response($error);
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

        $data = array(
            'nama_mobil' => $this->put('nama_mobil'),
            'warna' => $this->put('warna'),
            'no_polisi' => $this->put('no_polisi'),
            'jumlah_kursi' => $this->put('jumlah_kursi'),
            'harga_sewa' => $this->put('harga_sewa'),
            'status' => $this->put('status')
        );

        $this->M_Mobil->update($id, $data);
        $newData = $this->M_Mobil->check_data($id);
        $response = array(
            'status' => 'success',
            'data' => $newData,
            'status_code' => 200
        );

        return $this->response($response, 200);
    }
    
    function index_delete() {
        if (!$this->is_login()) {
            return;
        }

        $id = $this->delete('id');
        $check = $this->M_Mobil->check_data($id);
        if($check == false) {
            $error = array(
                'status' => 'fail',
                'field' => 'id',
                'message' => 'id is not found',
                'status_code' => 502
            );

            return $this->response($error);
        }
        $delete = $this->M_Mobil->delete($id);
        $response = array(
            'status' => 'success',
            'data' => $delete,
            'status_code' => 200
        );
        return $this->response($response);
    }

}

?>