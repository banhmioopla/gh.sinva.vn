<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ShareGroupApartment extends CI_Model {
    private $table = 'share_group_apartment';

    public function get($where = []) {
        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function getById($id) {
        return $this->db->get_where($this->table, ['id' => $id])->result_array();
    }

    public function getFirstByApartmentId($id) {
        return $this->db->get_where($this->table, ['apartment_id' => $id])->row_array();
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

    public function deleteByGroup($group_uuid) {
        $this->db->where('group_uuid' , $group_uuid);
        $this->db->delete($this->table);
        $result = $this->db->affected_rows();
        return $result;
    }
}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */