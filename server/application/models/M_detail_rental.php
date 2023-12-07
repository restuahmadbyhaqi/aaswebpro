<?php

class M_Detail_Rental extends CI_Model {

    function get_all() {
        return $this->db->query("SELECT 
                                    detail_pesanan.id, 
                                    detail_pesanan.harga, 
                                    detail_pesanan.tgl_pinjam, 
                                    detail_pesanan.tgl_kembali, 
                                    mobil.nama_mobil AS nama_mobil, 
                                    pelanggan.nama AS nama_pelanggan 
                                FROM 
                                    detail_pesanan 
                                INNER JOIN 
                                    mobil ON detail_pesanan.id_mobil = mobil.id 
                                INNER JOIN 
                                    pelanggan ON detail_pesanan.id_pelanggan = pelanggan.id")->result();
    }
    

    function get_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('detail_pesanan');
        return $query->row();
    }

    function check_data($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('detail_pesanan');

        if($query->row()) {
            return true;
        } else {
            return false;
        }
    }

    function insert($data) {
        $this->db->insert('detail_pesanan', $data);
        if($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    function update($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('detail_pesanan', $data);
    }

    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('detail_pesanan');
        if($this->db->affected_rows()>0) {
            return true;
        } else {
            return false;
        }
    }

    function detail($id) {
        return $this->db->query("SELECT detail_pesanan.*, pelanggan.nama AS nama_pelanggan, mobil.nama AS nama_mobil, tbl_perjalanan.asal, tbl_perjalanan.tujuan, tbl_jenis_bayar.jenis_bayar FROM detail_pesanan INNER JOIN pelanggan ON detail_pesanan.id_pemesan = pelanggan.id INNER JOIN mobil ON detail_pesanan.id_mobil = mobil.id INNER JOIN tbl_jenis_bayar ON detail_pesanan.id_jenis_bayar = tbl_jenis_bayar.id INNER JOIN tbl_perjalanan ON detail_pesanan.id_perjalanan = tbl_perjalanan.id WHERE detail_pesanan.id = $id")->row();
    }

}

?>