<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhPermission extends CI_Model {
    private $table = 'gh_permission';

	public function get($where = []) {
        return $this->db->get_where($this->table, $where);
    }

    public function getByActive() {
        return $this->db->get_where($this->table, ['active' => 'YES'])->result_array();
    }

    public function getById($permission_id) {
        return $this->db->get_where($this->table, ['id' => $permission_id])->result_array();
    }

    public function getAll() {
        return $this->db->get_where($this->table)->result_array();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function updateById($permission_id, $data) {
        $this->db->where('id', $permission_id);
        $this->db->update($this->table, $data);
        $result = $this->db->affected_rows();
        return $result;
    }

    public function delete($permission_id) {
        $this->db->where('id' , $permission_id);
        $this->db->delete($this->table);
        $result = $this->db->affected_rows();
        return $result;
    }
}

/* End of file mApartment.php */
/* Location: ./application/models/permission-manager/mApartment.php */