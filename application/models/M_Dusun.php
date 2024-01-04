<?php
class M_Dusun extends CI_Model {

    function fetch_all() {
        $this->db->order_by('id_dusun', 'DESC');
        $query = $this->db->get('dusun');
        return $query->result_array();
    }

    function fetch_single_data($id) {
        $this->db->where('id_dusun', $id);
        $query = $this->db->get('dusun');
        return $query->row();
    }

    function check_data($id) {
        $this->db->where('id_dusun', $id);
        $query = $this->db->get('dusun');

        if($query->row()) {
            return true;
        } else {
            return false;
        }
    }

    function insert_api($data) {
        $this->db->insert('dusun', $data);
        if($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    function update_data($id, $data) {
        $this->db->where('id_dusun', $id);
        $this->db->update('dusun', $data);
    }

    function delete_data($id) {
        $this->db->where('id_dusun', $id);
        $this->db->delete('dusun');
        if($this->db->affected_rows()>0) {
            return true;
        } else {
            return false;
        }
    }
}
?>