<?php

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
require_once FCPATH . 'vendor/autoload.php';

use Restserver\Libraries\REST_Controller;

class Dashboard extends REST_Controller
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
        $this->load->model('M_Dashboard');
        $this->load->library('form_validation');
        $this->load->library('jwt');
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

    function index_get() {
        if (!$this->is_login()) {
            return;
        }

        $detail_penduduk=$this->M_Dashboard->getCountdetail_penduduk();
        $dusun=$this->M_Dashboard->getCountdusun();
        $pekerjaan=$this->M_Dashboard->getCountpekerjaan();

        $data = array(
            'total penduduk' => $detail_penduduk,
            'total desa' => $dusun,
            'total pekerjaan' => $pekerjaan,
        );

        $this->response($data, 200);
    }

}

?>