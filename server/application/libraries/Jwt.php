<?php 

    defined('BASEPATH') OR exit('No direct script access allowed');

    use Firebase\JWT\JWT as JWTLib;
    use Firebase\JWT\Key;

    class Jwt {

        private $CI;

        public function __construct() {
            $this->CI =& get_instance();
            $this->CI->load->config('jwt');
        }

        public function encode($data) {
            $key = $this->CI->config->item('jwt_key');
            $algorithm = $this->CI->config->item('jwt_algorithm');
            $issuer = $this->CI->config->item('jwt_issuer');
            $audience = $this->CI->config->item('jwt_audience');
            $expire = $this->CI->config->item('jwt_expire');

            $token = [
                'iss' => $issuer,
                'aud' => $audience,
                'iat' => time(),
                'exp' => time() + $expire,
                'data' => $data,
            ];

            return JWTLib::encode($token, $key, $algorithm);
        }

        public function decode($param) {
            $key = $this->CI->config->item('jwt_key');
            $algorithm = $this->CI->config->item('jwt_algorithm');

            if(isset($param)) {
                $authHeader = $param;
                $arr = explode("Bearer ", $authHeader);
                if (count($arr) > 1) {
                    $token = $arr[1];
                    if ($token) {
                        try {
                            $decoded = JWTLib::decode($token, new Key($key, $algorithm));
                            if ($decoded) {
                                return true;
                            }
                        } catch (\Exception $e) {
                            return false;
                        }
                    }
                }else {
                    return false;
                }
            } else {
                return false;
            }
        } 
    }

?>