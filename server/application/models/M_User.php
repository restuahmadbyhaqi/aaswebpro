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

    }
?>