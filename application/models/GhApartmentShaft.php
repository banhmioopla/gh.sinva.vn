<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhApartmentShaft extends CI_Model {
    private $table = 'gh_apartment_shaft';

    public function get($where = []) {
        return $this->db->get_where($this->table, $where)->result_array();
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

    public function updateByApartmentId($id, $data) {
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
        $result = $this->db->affected_rows();
        return $result;
    }

    public function getFirstById($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }
}

/* End of file mApartment.php */
/* Location: ./application/models/tag-manager/mApartment.php */