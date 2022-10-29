<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhContractPartial extends CI_Model {
    private $table = 'gh_contract_partial';

    public function get($where = []) {
        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function getFirstById($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

    public function getTotalByContractId($con_id) {
        $list_con = $this->get(['contract_id' => $con_id]);
        $total = 0;

        foreach ($list_con as $item) {
            $total += $item['amount'];
        }
        return $total;
    }
    public function delete($id) {
        $this->db->where('id' , $id);
        $this->db->delete($this->table);
        $result = $this->db->affected_rows();
        return $result;
    }
}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */