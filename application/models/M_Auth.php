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

            function check_data($id) {
                $this->db->where('id', $id);
                $query = $this->db->get('user');
    
                if($query->row()) {
                    return true;
                } else {
                    return false;
                }
            }

        
            function getProfile($id) {
                $this->db->select('user.id, user.username, user.email, user.password');
                $this->db->from('user');
                $this->db->where('user.id', $id);
            
                $query = $this->db->get();
                return $query->result();
            }

            function updateProfile($id, $data) {
                $this->db->where('id', $id);
                $result = $this->db->update('user', $data);
            
                return $result;
            }

            function insert($data) {
                $this->db->insert('user', $data);
                if($this->db->affected_rows()) {
                    return true;
                } else {
                    return false;
                }
            }
            
    }
?>