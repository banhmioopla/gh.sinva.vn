<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhRole extends CI_Model {
    private $table = 'gh_role';

	public function get($where = []) {
        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function getByActive() {
        return $this->db->get_where($this->table, ['active' => 'YES'])->result_array();
    }

    public function getById($role_id) {
        return $this->db->get_where($this->table, ['id' => $role_id])->result_array();
    }

    public function getAll() {
        return $this->db->get_where($this->table)->result_array();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function updateById($role_id, $data) {
        $this->db->where('id', $role_id);
        $this->db->update($this->table, $data);
        $result = $this->db->affected_rows();
        return $result;
    }

    public function updateByRoleCode($role_code, $data) {
        $this->db->where('code', $role_code);
        $this->db->update($this->table, $data);
        $result = $this->db->affected_rows();
        return $result;
    }

    public function delete($role_id) {
        $this->db->where('id' , $role_id);
        $this->db->delete($this->table);
        $result = $this->db->affected_rows();
        return $result;
    }
}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */