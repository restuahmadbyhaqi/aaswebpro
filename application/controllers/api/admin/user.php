<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
require_once FCPATH . 'vendor/autoload.php';

use Restserver\Libraries\REST_Controller;
class User extends REST_Controller
{
    function __construct($config = 'rest'){
        parent::__construct($config);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'OPTIONS') {
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, DELETE, PATCH");
            header("Access-Control-Allow-Headers: Authorization, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, X-My-Custom-Header");
             
        } else {
            exit(); 
        }
        $this->load->database();
        $this->load->model('M_User');
        $this->load->library('form_validation');
        $this->load->library('jwt');
    }

    function validate(){
        $input_data = file_get_contents("php://input");
        parse_str($input_data, $put_data);

        $this->form_validation->set_data($put_data);
        
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email','required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
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

    function index_get()
    {
        $id = $this->get('id
        ');
        if ($id == ''){
            $data = $this->M_User->fetch_all();
        } else {
            $data = $this->M_User->fetch_single_data($id);
        }
        $this->response($data,200);
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
        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));
        $role_id = 2;

        $user = $this->M_User->userExist($email, $password);
        if ($user) {
            $response = array(
                'status_code' => 409,
                'message' => 'User already exists'
            );
            return $this->response($response);
        }

        $data = array(
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'role_id' => $role_id
        );

        $this->M_User->insert($data);
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
        $check = $this->M_User->check_data($id);

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
        $username = $this->put('username');
        $email = $this->put('email');
        $password = md5($this->put('password'));
        $role_id = $this->put('role_id');

        $user = $this->M_User->userExist($email, $password);
        if ($user) {
            $response = array(
                'status_code' => 409,
                'message' => 'User already exists'
            );
            return $this->response($response);
        }

        $data = array(
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'role_id' => $role_id,
        );

        $this->M_User->update($id, $data);
        $newData = $this->M_User->check_data($id);
        $response = array(
            'status' => 'success',
            'data' => $newData,
            'status_code' => 200
        );

        return $this->response($response);
    }
    
    function index_delete() {
        $id = $this->delete('id');
        $check = $this->M_User->check_data($id);
        if($check == false) {
            $error = array(
                'status' => 'fail',
                'field' => 'id',
                'message' => 'id is not found',
                'status_code' => 502
            );

            return $this->response($error);
        }
        $delete = $this->M_User->delete($id);
        $response = array(
            'status' => 'success',
            'data' => $delete,
            'status_code' => 200
        );
        return $this->response($response);
    }



}

?>