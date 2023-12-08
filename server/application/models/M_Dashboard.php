<?php
class M_Dashboard extends CI_Model {
    public function getCountUser()
    {
        try {
            return $this->db->count_all('user');
        } catch (Exception $e) {
            return 0; 
        }
    }

    public function getCountPelanggan()
    {
        try {
            return $this->db->count_all('pelanggan');
        } catch (Exception $e) {
            return 0; 
        }
    }
    
    public function getCountMobil()
    {
        try {
            return $this->db->count_all('mobil');
        } catch (Exception $e) {
            return 0; 
        }
    }
}
?>
