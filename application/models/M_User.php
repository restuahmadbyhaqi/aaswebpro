<?php 
    class M_User extends CI_Model {
        
        function fetch_all() {
            $this->db->order_by('id', 'DESC');
            $query = $this->db->get('user');
            return $query->result_array();
        }
    
        function fetch_single_data($id) {
            $this->db->where('id', $id);
            $query = $this->db->get('user');
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

        function update($id, $data) {
            $this->db->where('id', $id);
            $result = $this->db->update('user', $data);

            return $result;
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