<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhPermissionRole extends CI_Model {
    private $table = 'gh_permission_role';

	public function get($where = []) {
        return $this->db->get_where($this->table, $where);
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function delete($arr_where = ['id' => 0]) {
        $this->db->delete($this->table, $arr_where);
        $result = $this->db->affected_rows();
        return $result;
    }
}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */