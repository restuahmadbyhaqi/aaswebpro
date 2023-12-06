<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Mobil extends REST_Controller
{
    function __construct(){
        parent::__construct();
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

    function index_put(){
        $id_mobil = $this->put('id_mobil');
        $check = $this->M_Mobil->check_data($id_mobil);
            if($check == false) {
                $error = array(
                    'status' => 'fail',
                    'field' => 'id',
                    'message' => 'id is not found',
                    'status_code' => 502
                );

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
        $this->M_Mobil->update($id_mobil, $data);
            $newData = $this->M_Mobil->get_by_id($id_mobil);
            $response = array(
                'status' => 'success',
                'data' => $newData,
                'status_code' => 200
            );

            return $this->response($response);
        }   

    }  
    

}

?>