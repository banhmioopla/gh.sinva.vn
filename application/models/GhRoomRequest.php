<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhRoomRequest extends CI_Model {
    private $table = 'gh_room_request';

    public function get($where = []) {
        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function getByRoomId($apartment_id) {
        return $this->db->get_where($this->table, ['room_id' => $apartment_id])->result_array();
    }

    public function getFirstById($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

    public function getAll() {
        return $this->db->get_where($this->table)->result_array();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function updateById($apartment_id, $data) {
        $this->db->where('id', $apartment_id);
        $this->db->update($this->table, $data);
        $result = $this->db->affected_rows();
        return $result;
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