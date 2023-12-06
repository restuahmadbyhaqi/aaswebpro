<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Login extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('M_User');
        $this->load->library('form_validation');
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

        $user = $this->M_User->cek_login($email, $password);

        if (!$user) {
            $response = array(
                'status_code' => 401,
                'message' => 'Invalid email or password'
            );
            return $this->response($response, 401);
        }

        $response = array(
            'status_code' => 200,
            'message' => 'Login successful',
            'user_data' => $user,
        );

        return $this->response($response);
    }
}
?>
