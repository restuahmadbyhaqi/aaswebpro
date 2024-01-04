<?php
class M_Dashboard extends CI_Model {
    public function getCountdetail_penduduk()
    {
        try {
            return $this->db->count_all('detail_penduduk');
        } catch (Exception $e) {
            return 0; 
        }
    }

    
    public function getCountdusun()
    {
        try {
            return $this->db->count_all('dusun');
        } catch (Exception $e) {
            return 0; 
        }
    }

    public function getCountpekerjaan()
    {
        try {
            return $this->db->count_all('pekerjaan');
        } catch (Exception $e) {
            return 0; 
        }
    }
}
?>
