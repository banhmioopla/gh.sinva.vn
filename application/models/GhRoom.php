<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhRoom extends CI_Model {
    private $table = 'gh_room';

	public function get($where = []) {
        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function getByActive() {
        return $this->db->get_where($this->table, ['active' => 'YES'])->result_array();
    }
    public function getByApartmentIdAndActive($apartment_id) {
        return $this->db->get_where($this->table, ['active' => 'YES', 'apartment_id' => $apartment_id ])->result_array();
    }

    public function getById($room_id) {
        return $this->db->get_where($this->table, ['id' => $room_id])->result_array();
    }
    public function getByApartmentId($apartment_id) {
        return $this->db->get_where($this->table, ['apartment_id' => $apartment_id])->result_array();
    }

    public function getAll() {
        return $this->db->get_where($this->table)->result_array();
    }

    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function updateById($room_id, $data) {
        $this->db->where('id', $room_id);
        $this->db->update($this->table, $data);
        $result = $this->db->affected_rows();
        return $result;
    }

    public function updateByApartmentId($apartment_id, $data) {
        $this->db->where('apartment_id', $apartment_id);
        $this->db->update($this->table, $data);
        $result = $this->db->affected_rows();
        return $result;
    }

    public function delete($room_id) {
        $this->db->where('id' , $room_id);
        $this->db->delete($this->table);
        $result = $this->db->affected_rows();
        return $result;
    }

    public function getNumberByStatus($apartment_id, $status) {
        $result = $this->db->get_where(
            $this->table, 
            ['apartment_id' => $apartment_id, 'status' => $status, 'active' => 'YES'])->result_array();
        return count($result) > 0 ? count($result): null;
    }

    public function getNumberByTimeavailable($apartment_id) {
        $result = $this->db->get_where(
            $this->table, 
            ['apartment_id' => $apartment_id, 'time_available > ' => 0, 'active' => 'YES'])->result_array();
        return count($result) > 0 ? count($result): null;
    }
}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */