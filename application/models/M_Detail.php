<?php
class M_Detail extends CI_Model {

    public function index_get($id=false) {
        $this->db->select('detail_penduduk.*, pekerjaan.nama_pekerjaan, dusun.nama_dusun');
        $this->db->from('detail_penduduk');
        $this->db->join('dusun', 'detail_penduduk.id_dusun = dusun.id_dusun', 'left');
        $this->db->join('pekerjaan', 'detail_penduduk.id_pekerjaan = pekerjaan.id_pekerjaan', 'left');
        if($id!=false){
            $this->db->where('id_detail', $id);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function check_data($id) {
        $this->db->where('id_detail', $id);
        $query = $this->db->get('detail_penduduk');

        if($query->row()) {
            return true;
        } else {
            return false;
        }
    }

    function insert_api($data) {
        $this->db->insert('detail_penduduk', $data);
        if($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }
    public function is_nik_exist($nik) {
        $this->db->where('nik', $nik);
        $query = $this->db->get('detail_penduduk');

        return $query->num_rows() > 0;
    }

    function update_data($id, $data) {
        $this->db->where('id_detail', $id);
        $this->db->update('detail_penduduk', $data);
    }

    function delete_data($id) {
        $this->db->where('id_detail', $id);
        $this->db->delete('detail_penduduk');
        if($this->db->affected_rows()>0) {
            return true;
        } else {
            return false;
        }
    }
}
?>
