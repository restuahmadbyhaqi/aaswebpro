<?php 
    class M_Mobil extends CI_Model {

        function get_all() {
            $this->db->order_by('id_mobil', 'DESC');
            $query = $this->db->get('mobil');
            return $query->result_array();
        }
        
        function get_by_id($id) {
            $this->db->where('id_mobil', $id);
            $query = $this->db->get('mobil');
            return $query->row();
        }

        function check_data($id) {
            $this->db->where('id_mobil', $id);
            $query = $this->db->get('mobil');

            if($query->row()) {
                return true;
            } else {
                return false;
            }
        }

        function insert($data) {
            $this->db->insert('mobil', $data);
            if($this->db->affected_rows()) {
                return true;
            } else {
                return false;
            }
        }

        function update($id_mobil, $data) {
            $this->db->where('id_mobil', $id_mobil);
            $this->db->update('mobil', $data);
        }
        
        function delete($id) {
            $this->db->where('id_mobil', $id);
            $this->db->delete('mobil');
            if($this->db->affected_rows()>0) {
                return true;
            } else {
                return false;
            }
        }
    }
?>