<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhUserContractOrder extends CI_Model {
    private $table = 'gh_user_contract_order';

    public function get($where = []) {
        return $this->db->get_where($this->table, $where)->result_array();
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
    public function getFirstById($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

    public function delete($where) {
        $this->db->delete($this->table, $where);
        $result = $this->db->affected_rows();
        return $result;
    }

}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */