<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhUserCumulativeSale extends CI_Model {
    private $table = 'gh_user_cumulative_sale';

    public function get($where = []) {
        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function getByUserId($user_id) {
        return $this->db->get_where($this->table, ['user_id' => $user_id])->result_array();
    }

    public function updateByUserId($id, $data) {
        $this->db->where('user_id', $id);
        $this->db->update($this->table, $data);
        $result = $this->db->affected_rows();
        return $result;
    }

    public function getAll() {
        return $this->db->get_where($this->table)->result_array();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function delete($district_id) {
        $this->db->where('user_id' , $district_id);
        $this->db->delete($this->table);
        $result = $this->db->affected_rows();
        return $result;
    }
}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */