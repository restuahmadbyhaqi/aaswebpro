<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
require_once FCPATH . 'vendor/autoload.php';

use Restserver\Libraries\REST_Controller;
class Login extends REST_Controller
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
        $this->load->model('M_Auth');
        $this->load->library('form_validation');
        $this->load->library('jwt');
    }

    public function options_get() {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        exit();
    }

    function validate()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
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
            return $this->response($response, 502);
        }
    
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));
    
        $user = $this->M_Auth->cek_login($email, $password);
    
        if (!$user) {
            $response = array(
                'status_code' => 401,
                'message' => 'Invalid email or password'
            );
            return $this->response($response, 401);
        }
    
        $token = $this->jwt->encode($email, $password);
    
        $response = array(
            'status_code' => 200,
            'message' => 'Login successful',
            'user_data' => $user,
            'token' => $token
        );
    
        return $this->response($response);
    }
    
    

}

?>