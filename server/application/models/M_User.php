<?php 
    class M_User extends CI_Model {

        function insert($data) {
            $this->db->insert('user', $data);
            if($this->db->affected_rows()) {
                return true;
            } else {
                return false;
            }
        }

        function cek_login($email, $password) {
        $this->db->where('email', $email);
        $this->db->where('password', $password);
        $query = $this->db->get('user');

            if ($query->num_rows() == 1) {
                return $query->row_array();
            } else {
                return false;
            }
        }
    }
?>