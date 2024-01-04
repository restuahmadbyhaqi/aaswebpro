<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
require_once FCPATH . 'vendor/autoload.php';

use Restserver\Libraries\REST_Controller;

class Dusun extends REST_Controller {

    function __construct($config = 'rest') {
        parent::__construct($config);
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
            header("Access-Control-Allow-Headers: Authorization, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
            exit;
        }
        $this->load->database(); 
        $this->load->model('M_Dusun');
        $this->load->library('form_validation');
        $this->load->library('jwt');
    }  

    public function options_get() {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT,DELETE");
        header("Access-Control-Allow-Headers: Content-Type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
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

    function index_get() {
        if (!$this->is_login()) {
            return;
        }
        $id = $this->get('id_dusun');
        if ($id == ''){
            $data = $this->M_Dusun->fetch_all();
        } else {
            $data = $this->M_Dusun->fetch_single_data($id);
        }
        $this->response($data, 200);
    }    

    function index_post() {
        if (!$this->is_login()) {
            return;
        }
        if ($this->post('nama_dusun') =='') {
            $response = array(
                'status' => 'fail',
                'field' => 'nama_dusun',
                'massage' =>'Isian nama dusun tidak boleh kosong!',
                'status_code' => 502
            );
            return $this->response($response);
        }
        $data = array(
            'nama_dusun' => trim($this->post('nama_dusun')),
        );
        $this->M_Dusun->insert_api($data);
        $last_row = $this->db->select('*')->order_by('id_dusun',"desc")->limit(1)->get('dusun')->row();
        $response = array(
            'status' => 'success',
            'data' => $last_row,
            'status_code' => 201,
        );
        return $this->response($response);
    }      

    function index_put() {
        if (!$this->is_login()) {
            return;
        }
        $id = $this->put('id');
        $check = $this->M_Dusun->check_data($id);
        if ($check == false) {
            $error = array(
                'status' =>'fail',
                'field' =>'id_dusun',
                'message' => 'Data tidak ditemukan!',
                'status_code' => 502
            );
            return $this->response($error);
        }
        if ($this->put('nama_dusun') == ''){
            $response = array(
                'status' =>'fail',
                'field' => 'nama_dusun',
                'messege' => 'Isian nama dusun tidak boleh kosong!',
                'status_code' => 502
            );
            return $this->response($response);
        }
        $data = array(
            'nama_dusun' => trim($this->put('nama_dusun')),
        );
        $this->M_Dusun->update_data($id,$data);
        $newData = $this->M_Dusun->fetch_single_data($id);
        $response = array(
            'status' => 'succes',
            'data' => $newData,
            'status_code' =>200,
        );
        return $this->response($response);
    }

    function index_delete() {
        $id = $this->delete('id_dusun');
        $check = $this->M_Dusun->check_data($id);
        if ($check == false) {
            $error = array(
                'status' =>'fail',
                'field' =>'id_dusun',
                'message' => 'Data tidak ditemukan!',
                'status_code' => 502
            );
            return $this->response($error);
        }
        $delete = $this->M_Dusun->delete_data($id);
        $response = array(
            'status' => 'succes',
            'data' => null,
            'status_code' =>200,
        );
        return $this->response($response);
    }
}
?>