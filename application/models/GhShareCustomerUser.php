<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhShareCustomerUser extends CI_Model {
    private $table = 'gh_share_customer_user';

    public function get($where = []) {
        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function getById($obj_id) {
        return $this->db->get_where($this->table, ['id' => $obj_id])->result_array();
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

    public function delete($obj_id) {
        $this->db->where('id' , $obj_id);
        $this->db->delete($this->table);
        $result = $this->db->affected_rows();
        return $result;
    }
}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */