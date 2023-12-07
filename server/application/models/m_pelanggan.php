<?php 
    class M_Pelanggan extends CI_Model {

        function get_all() {
            $this->db->order_by('id', 'DESC');
            $query = $this->db->get('pelanggan');
            return $query->result_array();
        }
        
        function get_by_id($id) {
            $this->db->where('id', $id);
            $query = $this->db->get('pelanggan');
            return $query->row();
        }

        function check_data($id) {
            $this->db->where('id', $id);
            $query = $this->db->get('pelanggan');

            if($query->row()) {
                return true;
            } else {
                return false;
            }
        }

        function insert($data) {
            $this->db->insert('pelanggan', $data);
            if($this->db->affected_rows()) {
                return true;
            } else {
                return false;
            }
        }

        function update($id, $data) {
            $this->db->where('id', $id);
            $this->db->update('pelanggan', $data);
        }
        
        function delete($id) {
            $this->db->where('id', $id);
            $this->db->delete('pelanggan');
            if($this->db->affected_rows()>0) {
                return true;
            } else {
                return false;
            }
        }
    }
?>