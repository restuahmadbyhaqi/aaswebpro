<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Mobil extends REST_Controller
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
        $this->load->model('M_Mobil');
        $this->load->library('form_validation');
    }

    function validate(){
        $this->form_validation->set_rules('merk_mobil', 'Merk Mobil', 'required|trim');
        $this->form_validation->set_rules('cc_mobil', 'CC Mobil','required|numeric');
        $this->form_validation->set_rules('jml_seat_mobil', 'Jumlah Seat Mobil', 'required|numeric');
        $this->form_validation->set_rules('harga_sewa_mobil', 'Harga Sewa Mobil', 'required|numeric');
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

        $id = $this->get('id_mobil');
        if($id == '') {
            $data = $this->M_Mobil->get_all();
        } else {
            $data = $this->M_Mobil->get_by_id($id);
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
        $merk_mobil = $this->input->post('merk_mobil');
        $cc_mobil = $this->input->post('cc_mobil');
        $jml_seat_mobil = $this->input->post('jml_seat_mobil');
        $harga_sewa_mobil = $this->input->post('harga_sewa_mobil');
        $status_mobil = '1'; //tersedia

        $data = array(
            'merk_mobil' => $merk_mobil,
            'cc_mobil' => $cc_mobil,
            'jml_seat_mobil' => $jml_seat_mobil,
            'harga_sewa_mobil' => $harga_sewa_mobil,
            'status_mobil' => $status_mobil
        );
        $this->M_Mobil->insert($data);
        $response = array(
                'status_code' => 201,
                'message' => 'success',
                'data' => $data,
            );

            return $this->response($response);
    }


    // ERROR UPDATE DATA FORM VALIDATION
    public function index_put(){
        $id = $this->put('id_mobil');
        $check = $this->M_Mobil->check_data($id);

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

        $merk_mobil = $this->put('merk_mobil');
        $cc_mobil = $this->put('cc_mobil');
        $jml_seat_mobil = $this->put('jml_seat_mobil');
        $harga_sewa_mobil = $this->put('harga_sewa_mobil');
        $status_mobil = $this->put('status_mobil');

        $data = array(
            'merk_mobil' => $merk_mobil,
            'cc_mobil' => $cc_mobil,
            'jml_seat_mobil' => $jml_seat_mobil,
            'harga_sewa_mobil' => $harga_sewa_mobil,
            'status_mobil' => $status_mobil
        );

        $this->M_Mobil->update($id, $data);
        $newData = $this->M_Mobil->get_by_id($id);
        $response = array(
            'status' => 'success',
            'data' => $newData,
            'status_code' => 200
        );

        return $this->response($response, 200);
    }
    
    function index_delete() {
        $id = $this->delete('id_mobil');
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