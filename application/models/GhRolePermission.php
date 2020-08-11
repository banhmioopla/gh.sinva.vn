<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhRolePermission extends CI_Model {
    private $table = 'gh_role_permission';

	public function get($where = []) {
        return $this->db->get_where($this->table, $where);
    }

    public function getByActive() {
        return $this->db->get_where($this->table, ['active' => 'YES'])->result_array();
    }

    public function checkAccess($data_set) {
        return $this->db->get_where($this->table, $data_set)->result_array();
    }

    public function getByRoleId($role_id) {
        return $this->db->get_where($this->table, ['role_id' => $role_id])->result_array();
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

    public function delete($arr_where = ['id' => 0]) {
        $this->db->delete($this->table, $arr_where);
        $result = $this->db->affected_rows();
        return $result;
    }
}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */