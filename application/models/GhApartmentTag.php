<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhApartmentTag extends CI_Model {
    private $table = 'gh_apartment_tag';

	public function get($where = []) {
        return $this->db->get_where($this->table, $where);
    }

    public function getByApartmentId($apartment_id) {
        return $this->db->get_where($this->table, ['apartment_id' => $apartment_id])->result_array();
    }

    public function getByTagId($apartment_id) {
        return $this->db->get_where($this->table, ['apartment_id' => $apartment_id])->result_array();
    }

    public function getAll() {
        return $this->db->get_where($this->table)->result_array();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function delete($data_set) {
        $this->db->where($data_set);
        $this->db->delete($this->table);
        $result = $this->db->affected_rows();
        return $result;
    }
}

/* End of file mApartment.php */
/* Location: ./application/models/tag-manager/mApartment.php */