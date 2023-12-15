<?php 
    class M_Auth extends CI_Model {

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