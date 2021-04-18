<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhBaseRoomType extends CI_Model {
	private $table = 'gh_base_room_type';

	public function get($where = []) {
        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function getByActive() {
        return $this->db->get_where($this->table, ['active' => 'YES'])->result_array();
    }

    public function getFirstById($room_id) {
        return $this->db->get_where($this->table, ['id' => $room_id])->row_array();
    }

    public function getById($room_type_id) {
        return $this->db->get_where($this->table, ['id' => $room_type_id])->result_array();
    }

    public function getAll() {
        return $this->db->get_where($this->table)->result_array();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function updateById($room_type_id, $data) {
        $this->db->where('id', $room_type_id);
        $this->db->update($this->table, $data);
        $result = $this->db->affected_rows();
        return $result;
    }

    public function delete($room_type_id) {
        $this->db->where('id' , $room_type_id);
        $this->db->delete($this->table);
        $result = $this->db->affected_rows();
        return $result;
    }
	

}

/* End of file GhBaseApartmentType.php */
/* Location: ./application/models/GhBaseApartmentType.php */