<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Register extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        header('Access-Control-Allow-Origin:*');
        header("Access-Control-Allow-Headers:X-API-KEY,Origin,X-Requested-With,Content-Type,Accept,Access-Control-Request-Method,Authorization");
        header("Access-Control-Allow-Methods:GET,POST,OPTIONS,PUT,DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "OPTIONS") {
            die();
        }
        $this->load->database();
        $this->load->model('M_User');
        $this->load->library('form_validation');
    }
    function validate()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[user.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
    }

    public function options_get() {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        exit();
    }
    
    function index_post()
    {
        $this->validate();
        if ($this->form_validation->run() === FALSE) {
            $error = $this->form_validation->error_array();
            $response = array(
                'status_code' => 502,
                'message' => $error
            );
            return $this->response($response,502);
        }
        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));

        $data = array(
            'username' => $username,
            'email' => $email,
            'password' => $password,
        );
        $this->M_User->insert($data);
            $response = array(
                'status_code' => 201,
                'message' => 'success',
                'data' => $data,
            );

            return $this->response($response);
    }
    
}
?>