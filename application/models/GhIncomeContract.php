<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhIncomeContract extends CI_Model {
    private $table = 'gh_income_contract';

    public function get($where = []) {
        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function getByActive() {
        return $this->db->get_where($this->table, ['active' => 'YES'])->result_array();
    }

    public function matchingIncome($price){
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE income_unit <= '.$price .' AND active = "YES" ORDER BY income_unit DESC LIMIT 1';

        $result = $this->db->query($sql);
        return $result->result_array() ? $result->result_array()[0] : null;
    }

    public function getById($district_id) {
        return $this->db->get_where($this->table, ['id' => $district_id])->result_array();
    }

    public function getAll() {
        return $this->db->get_where($this->table)->result_array();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function updateById($id, $data) {
        $this->db->where('id', $id);
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
}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */