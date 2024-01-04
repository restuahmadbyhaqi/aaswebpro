<?php
class M_Pekerjaan extends CI_Model {

    function fetch_all() {
        $this->db->order_by('id_pekerjaan', 'DESC');
        $query = $this->db->get('pekerjaan');
        return $query->result_array();
    }

    function fetch_single_data($id) {
        $this->db->where('id_pekerjaan', $id);
        $query = $this->db->get('pekerjaan');
        return $query->row();
    }

    function check_data($id) {
        $this->db->where('id_pekerjaan', $id);
        $query = $this->db->get('pekerjaan');

        if($query->row()) {
            return true;
        } else {
            return false;
        }
    }

    function insert_api($data) {
        $this->db->insert('pekerjaan', $data);
        if($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    function update_data($id, $data) {
        $this->db->where('id_pekerjaan', $id);
        $this->db->update('pekerjaan', $data);
    }

    function delete_data($id) {
        $this->db->where('id_pekerjaan', $id);
        $this->db->delete('pekerjaan');
        if($this->db->affected_rows()>0) {
            return true;
        } else {
            return false;
        }
    }
}
?>