<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhMergeBusinessApartment extends CI_Model {
    private $table = 'gh_merge_apartment_business';

    public function get($where = []) {
        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function getByActive() {
        return $this->db->get_where($this->table, ['active' => 'YES'])->result_array();
    }

    public function getByBusinessId($id) {
        return $this->db->get_where($this->table, ['business_id' => $id])->result_array();
    }

    public function getAll() {
        return $this->db->get_where($this->table)->result_array();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function updateByBusinessId($id, $data) {
        $this->db->where('business_id ', $id);
        $this->db->update($this->table, $data);
        $result = $this->db->affected_rows();
        return $result;
    }

    public function delete($district_id) {
        $this->db->where('id' , $district_id);
        $this->db->delete($this->table);
        $result = $this->db->affected_rows();
        return $result;
    }
    public function deleteByBusinessId($bid) {
        $this->db->where('business_id' , $bid);
        $this->db->delete($this->table);
        $result = $this->db->affected_rows();
        return $result;
    }
}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */