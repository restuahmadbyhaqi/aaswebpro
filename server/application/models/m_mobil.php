<?php 
    class M_Mobil extends CI_Model {

        function get_all() {
            $this->db->order_by('id');
            $query = $this->db->get('mobil');
            return $query->result_array();
        }
        
        function get_by_id($id) {
            $this->db->where('id', $id);
            $query = $this->db->get('mobil');
            return $query->row();
        }

        function check_data($id) {
            $this->db->where('id', $id);
            $query = $this->db->get('mobil');

            if($query->row()) {
                return true;
            } else {
                return false;
            }
        }

        function update($id, $data) {
            $this->db->where('id', $id);
            $result = $this->db->update('mobil', $data);
        
            return $result;
        }
        

        function insert($data) {
            $this->db->insert('mobil', $data);
            if($this->db->affected_rows()) {
                return true;
            } else {
                return false;
            }
        }
        
        function delete($id) {
            $this->db->where('id', $id);
            $this->db->delete('mobil');
            if($this->db->affected_rows()>0) {
                return true;
            } else {
                return false;
            }
        }

        function getMobilForCustomer() {
            $mobilForCust = "SELECT mobil.id,mobil.nama_mobil, mobil.warna, mobil.no_polisi, mobil.jumlah_kursi, mobil.harga_sewa, mobil.status FROM mobil WHERE mobil.status = 1";
            $resultQuery = $this->db->query($mobilForCust);
            return $resultQuery->result();
        }

        function mobilExist($idMobil) {
            $queryTransaksi = "SELECT * FROM transaksi WHERE id_Mobil = $idMobil";
            $queryMobil = "SELECT * FROM mobil WHERE id = $idMobil";
        
            $resultTransaksi = $this->db->query($queryTransaksi);
            $resultMobil = $this->db->query($queryMobil);
        
            $mobilExists = $resultTransaksi->num_rows() > 0 || $resultMobil->num_rows() === 0;
        
            if (!$mobilExists) {
                $updateStatusQuery = "UPDATE mobil SET status = 2 WHERE id = $idMobil";
                $this->db->query($updateStatusQuery);
            }
        
            return $mobilExists;
        }

        public function mobilDiSewa($id) {
            $data = array(
                'status' => 2
            );
            $this->db->where('id', $id);
            $this->db->update('mobil_table', $data); 
        }
    }
?>