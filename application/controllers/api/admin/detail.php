<?php

defined('BASEPATH') OR exit('No direct script');

    require APPPATH . '/libraries/REST_Controller.php';
    require_once FCPATH . 'vendor/autoload.php';
    
    use Restserver\Libraries\REST_Controller;

class Detail extends REST_Controller {

    function __construct($config = 'rest'){
        parent::__construct($config);
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Authorization, X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        
            exit;
        }
        $this->load->database();
        $this->load->model('M_Detail');
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

    public function index_get() {
        if(isset($_GET['id'])){
            $data = $this->M_Detail->index_get($_GET['id']);
        }else{
            $data = $this->M_Detail->index_get();
        }
        

        if ($data) {
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Data not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    function index_post() 
    {
        if (!$this->is_login()) {
            return;
        }
        $nik = trim($this->post('nik'));
        $isNikExist = $this->M_Detail->is_nik_exist($nik);

        if ($isNikExist) {
            $response = array(
                'status' => 'fail',
                'field' => 'nik',
                'message' => 'NIK already exists!',
                'status_code' => 502
            );
            return $this->response($response);
        }
        if ($this->post('nama_penduduk') == ''){
            $response = array(
                'status' =>'fail',
                'field' => 'nama_penduduk',
                'messege' => 'Isian nama penduduk tidak boleh kosong!',
                'status_code' => 502
            );
            return $this->response($response);
        }
        if ($this->post('id_dusun') == ''){
            $response = array(
                'status' =>'fail',
                'field' => 'id_dusun',
                'messege' => 'Isian id desa tidak boleh kosong!',
                'status_code' => 502
            );
            return $this->response($response);
        }
        if ($this->post('id_pekerjaan') == ''){
            $response = array(
                'status' =>'fail',
                'field' => 'id_pekerjaan',
                'messege' => 'Isian id pekerjaan tidak boleh kosong!',
                'status_code' => 502
            );
            return $this->response($response);
        }
        if ($this->post('gender') == ''){
            $response = array(
                'status' =>'fail',
                'field' => 'gender',
                'messege' => 'Isian jenis kelamin penduduk tidak boleh kosong!',
                'status_code' => 502
            );
            return $this->response($response);
        }
        if ($this->post('date_birth') == ''){
            $response = array(
                'status' =>'fail',
                'field' => 'date_birth',
                'messege' => 'Isian tanggal lahir tidak boleh kosong!',
                'status_code' => 502
            );
            return $this->response($response);
        }
        $data = array(
            'nik' => trim($this->post('nik')),
            'nama_penduduk' => trim($this->post('nama_penduduk')),
            'id_dusun' => trim($this->post('id_dusun')),
            'id_pekerjaan' => trim($this->post('id_pekerjaan')),
            'gender' => trim($this->post('gender')),
            'date_birth' => trim($this->post('date_birth')),
        );

        $this->M_Detail->insert_api($data);
        $last_row = $this->db->select('*')->order_by('id_detail', 'DESC')->limit(1)->get('detail_penduduk')->row();
        $response = array(
            'status' => 'success',
            'data' => $last_row,
            'status_code' => 201
        );
        return $this->response($response);
    }
    function index_put() 
    {
        if (!$this->is_login()) {
            return;
        }
        $id = $this->put('id'); 

        if ($this->put('nik') == ''){
            $response = array(
                'status' =>'fail',
                'field' => 'nik',
                'messege' => 'Isian nik tidak boleh kosong!',
                'status_code' => 502
            );
            return $this->response($response);
        }
        if ($this->put('nama_penduduk') == ''){
            $response = array(
                'status' =>'fail',
                'field' => 'nama_penduduk',
                'messege' => 'Isian nama penduduk tidak boleh kosong!',
                'status_code' => 502
            );
            return $this->response($response);
        }
        if ($this->put('id_dusun') == ''){
            $response = array(
                'status' =>'fail',
                'field' => 'id_dusun',
                'messege' => 'Isian id desa tidak boleh kosong!',
                'status_code' => 502
            );
            return $this->response($response);
        }
        if ($this->put('id_pekerjaan') == ''){
            $response = array(
                'status' =>'fail',
                'field' => 'id_pekerjaan',
                'messege' => 'Isian id pekerjaan tidak boleh kosong!',
                'status_code' => 502
            );
            return $this->response($response);
        }
        if ($this->put('gender') == ''){
            $response = array(
                'status' =>'fail',
                'field' => 'gender',
                'messege' => 'Isian jenis kelamin penduduk tidak boleh kosong!',
                'status_code' => 502
            );
            return $this->response($response);
        }
        if ($this->put('date_birth') == ''){
            $response = array(
                'status' =>'fail',
                'field' => 'date_birth',
                'messege' => 'Isian tanggal lahir tidak boleh kosong!',
                'status_code' => 502
            );
            return $this->response($response);
        }
        $data = array(
            'nik' => trim($this->put('nik')),
            'nama_penduduk' => trim($this->put('nama_penduduk')),
            'id_dusun' => trim($this->put('id_dusun')),
            'id_pekerjaan' => trim($this->put('id_pekerjaan')),
            'gender' => trim($this->put('gender')),
            'date_birth' => trim($this->put('date_birth')),
        );
        $this->M_Detail->update_data($id,$data);
    }
    function index_delete() {
        $id = $this->delete('id_detail');
        $check = $this->M_Detail->check_data($id);
        if ($check == false) {
            $error = array(
                'status' =>'fail',
                'field' =>'id_detail',
                'message' => 'Data tidak ditemukan!',
                'status_code' => 502
            );
            return $this->response($error);
        }
        $delete = $this->M_Detail->delete_data($id);
        $response = array(
            'status' => 'succes',
            'data' => null,
            'status_code' =>200,
        );
        return $this->response($response);
    }
}
?>