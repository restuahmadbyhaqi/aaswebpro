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

    
    public function getCountMobil()
    {
        try {
            return $this->db->count_all('mobil');
        } catch (Exception $e) {
            return 0; 
        }
    }

    public function getCountTransaksi()
    {
        try {
            return $this->db->count_all('transaksi');
        } catch (Exception $e) {
            return 0; 
        }
    }
}
?>
