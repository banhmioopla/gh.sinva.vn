<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhBasePrice extends CI_Model {
	private $table = 'gh_base_price';

	public function get($where = []) {
        return $this->db->get_where($this->table, $where);
    }

    public function getByActive() {
        return $this->db->get_where($this->table, ['active' => 'YES'])->result_array();
    }

    public function getById($price_id) {
        return $this->db->get_where($this->table, ['id' => $price_id])->result_array();
    }

    public function getAll() {
        return $this->db->get_where($this->table)->result_array();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function updateById($price_id, $data) {
        $this->db->where('id', $price_id);
        $this->db->update($this->table, $data);
        $result = $this->db->affected_rows();
        return $result;
    }

    public function delete($price_id) {
        $this->db->where('id' , $price_id);
        $this->db->delete($this->table);
        $result = $this->db->affected_rows();
        return $result;
    }
	

}

/* End of file GhBaseApartmentType.php */
/* Location: ./application/models/GhBaseApartmentType.php */