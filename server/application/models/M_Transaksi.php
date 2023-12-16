<?php

class M_Transaksi extends CI_Model {

    function get_all() {
        $this->db->select('transaksi.id, transaksi.nama, mobil.nama_mobil, mobil.harga_sewa, transaksi.tgl_pinjam, transaksi.tgl_kembali ');
        $this->db->from('transaksi');
        $this->db->join('mobil', 'transaksi.id_mobil = mobil.id');

        $query = $this->db->get();
        return $query->result_array();

    }   

    function get_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('transaksi');
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

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('transaksi');
        if($this->db->affected_rows()>0) {
            return true;
        } else {
            return false;
        }
    }

    function customerSewaMobil($data) {
        $this->db->insert('transaksi', $data);
        if($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
    

}

?>