<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhPartner extends CI_Model {
    private $table = 'gh_partner';

	public function get($where = []) {
        return $this->db->get_where($this->table, $where);
    }

    public function getByActive() {
        return $this->db->get_where($this->table, ['active' => 'YES'])->result_array();
    }

    public function getById($partner_id) {
        return $this->db->get_where($this->table, ['id' => $partner_id])->result_array();
    }

    public function getAll() {
        return $this->db->get_where($this->table)->result_array();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function updateById($partner_id, $data) {
        $this->db->where('id', $partner_id);
        $this->db->update($this->table, $data);
        $result = $this->db->affected_rows();
        return $result;
    }

    public function delete($partner_id) {
        $this->db->where('id' , $partner_id);
        $this->db->delete($this->table);
        $result = $this->db->affected_rows();
        return $result;
    }
}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */