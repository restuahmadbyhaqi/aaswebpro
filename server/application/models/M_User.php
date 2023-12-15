<?php 
    class M_User extends CI_Model {

        function getCustomer() {
            $queryCust = "SELECT user.id,user.username,user.email, user.role_id FROM user WHERE user.role_id = 2";
            $resultCust = $this->db->query($queryCust);
            return $resultCust->result();
        }

        function get_by_id($id) {
            $this->db->where('id', $id);
            $query = $this->db->get('mobil');
            return $query->row();
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

        function userExist($email, $password) {
            $this->db->where('email', $email);
            $this->db->where('password', $password);
            $query = $this->db->get('user');
    
                if ($query->num_rows() == 1) {
                    return $query->row_array();
                } else {
                    return false;
                }
            }


        function insert($data) {
            $this->db->insert('user', $data);
            if($this->db->affected_rows()) {
                return true;
            } else {
                return false;
            }
        }

        

        function update($id, $data) {
            $this->db->where('id', $id);
            $this->db->update('user', $data);
        }
        
        function delete($id) {
            $this->db->where('id', $id);
            $this->db->delete('user');
            if($this->db->affected_rows()>0) {
                return true;
            } else {
                return false;
            }
        }
    }
?>