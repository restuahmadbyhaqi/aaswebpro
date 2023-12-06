<?php

class M_mobil extends CI_Model {
        public function get_data()
        {
                return $this->db->get('mobil');
        }
}

?>