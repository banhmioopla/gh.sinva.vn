<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhBaseApartmentType extends CI_Model {
	private $table = 'gh_base_apartment_type';

	public function get($where = []) {
        return $this->db->get_where($this->table, $where);
    }

    public function getByActive() {
        return $this->db->get_where($this->table, ['active' => 'YES'])->result_array();
    }

    public function getById($apartment_type_id) {
        return $this->db->get_where($this->table, ['id' => $apartment_type_id])->result_array();
    }

    public function getAll() {
        return $this->db->get_where($this->table)->result_array();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function updateById($apartment_type_id, $data) {
        $this->db->where('id', $apartment_type_id);
        $this->db->update($this->table, $data);
        $result = $this->db->affected_rows();
        return $result;
    }

    public function delete($apartment_type_id) {
        $this->db->where('id' , $apartment_type_id);
        $this->db->delete($this->table);
        $result = $this->db->affected_rows();
        return $result;
    }
	

}

/* End of file GhBaseApartmentType.php */
/* Location: ./application/models/GhBaseApartmentType.php */