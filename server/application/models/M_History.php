<?php

class M_History extends CI_Model {

    function get_all() {
        $this->db->order_by('id');
        $query = $this->db->get('history');
        return $query->result_array();
    }
    

    function get_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('history');
        return $query->row();
    }

    function check_data($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('history');
    
        return $query->num_rows() > 0;
    }
    
    

    function insert($data) {
        $this->db->insert('history', $data);
        if($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('history');
    
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            $error = $this->db->error();  
        }
    }
    

}

?>