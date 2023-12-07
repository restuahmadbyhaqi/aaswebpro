<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Pelanggan extends REST_Controller
{
    function __construct(){
        parent::__construct();
        header('Access-Control-Allow-Origin:*');
        header("Access-Control-Allow-Headers:X-API-KEY,Origin,X-Requested-With,Content-Type,Accept,Access-Control-Request-Method,Authorization");
        header("Access-Control-Allow-Methods:GET,POST,OPTIONS,PUT,DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
        $this->load->database();
        $this->load->model('M_Pelanggan');
        $this->load->library('form_validation');
    }

    function validate(){
        $input_data = file_get_contents("php://input");
        parse_str($input_data, $put_data);

        $this->form_validation->set_data($put_data);
        
        $this->form_validation->set_rules('nama', 'Nama Pelanggan', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat Pelanggan','required|trim');
        $this->form_validation->set_rules('no_hp', 'Nomor Hp Pelanggan', 'required|trim');
    }



    public function options_get() {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        exit();
    }

    function index_get() {
        // $authorizationHeader = $this->input->get_request_header('Authorization', true);

        // if(empty($authorizationHeader) || $this->jwt->decode($authorizationHeader) === false) {
        //     return $this->response(
        //         array(
        //             'kode' => '401',
        //             'pesan' => 'signature tidak sesuai',
        //             'data' => []
        //         ), '401'
        //     );
        // }

        $id = $this->get('id');
        if($id == '') {
            $data = $this->M_Pelanggan->get_all();
        } else {
            $data = $this->M_Pelanggan->get_by_id($id);
        }
        $this->response($data, 200);
    }
    
    function index_post(){
        $this->validate();
        if ($this->form_validation->run() === FALSE) {
            $error = $this->form_validation->error_array();
            $response = array(
                'status_code' => 502,
                'message' => $error
            );
            return $this->response($response);
        }
        $nama = $this->input->post('nama');
        $alamat = $this->input->post('alamat');
        $no_hp = $this->input->post('no_hp');

        $data = array(
            'nama' => $nama,
            'alamat' => $alamat,
            'no_hp' => $no_hp,
        );
        $this->M_Pelanggan->insert($data);
        $response = array(
                'status_code' => 201,
                'message' => 'success',
                'data' => $data,
            );

            return $this->response($response);
    }


    // ERROR UPDATE DATA FORM VALIDATION
    public function index_put(){
        $id = $this->put('id');
        $check = $this->M_Pelanggan->check_data($id);

        if (!$check) {
            $error = array(
                'status' => 'fail',
                'field' => 'id',
                'message' => 'ID is not found',
                'status_code' => 502
            );

            return $this->response($error, 502);
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
            'nama' => $this->put('nama'),
            'alamat' => $this->put('alamat'),
            'no_hp' => $this->put('no_hp'),
        );

        $this->M_Pelanggan->update($id, $data);
        $newData = $this->M_Pelanggan->get_by_id($id);
        $response = array(
            'status' => 'success',
            'data' => $newData,
            'status_code' => 200
        );

        return $this->response($response, 200);
    }
    
    function index_delete() {
        $id = $this->delete('id');
        $check = $this->M_Pelanggan->check_data($id);
        if($check == false) {
            $error = array(
                'status' => 'fail',
                'field' => 'id',
                'message' => 'id is not found',
                'status_code' => 502
            );

            return $this->response($error);
        }
        $delete = $this->M_Pelanggan->delete($id);
        $response = array(
            'status' => 'success',
            'data' => $delete,
            'status_code' => 200
        );
        return $this->response($response);
    }


}

?>