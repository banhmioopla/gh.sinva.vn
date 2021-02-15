<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhUserIncomeDetail extends CI_Model {
    private $table = 'gh_user_income_detail';
    const INCOME_TYPE_CONTRACT = 'Contract';
    const INCOME_TYPE_CONTRACT_SUPPORTER = 'ContractSupporter';
    const INCOME_TYPE_PENALTY = 'Penalty';
    const INCOME_TYPE_REFER_USER = 'ReferUser';
    const INCOME_TYPE_GET_NEW_APARTMENT = 'GetNewApartment';

    public function get($where = []) {
        $this->db->order_by('id DESC');
        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function getById($tag_id) {
        return $this->db->get_where($this->table, ['id' => $tag_id])->result_array();
    }

    public function getByContractId($contract_id) {
        return $this->db->get_where($this->table, ['contract_id' => $contract_id])->result_array();
    }
    public function getByUserIdAndApartmentId($user_id, $apartment_id) {
        return $this->db->get_where($this->table, ['user_id' => $user_id, 'apartment_id' => $apartment_id])->result_array();
    }

    public function getByUserIdAndTimeApply($user_id, $apply_time) {
        return $this->db->get_where($this->table,
            [
                'user_id' => $user_id,
                'apply_time' => $apply_time,
                'type' => self::INCOME_TYPE_REFER_USER
            ])->result_array();
    }

    public function getAll() {
        return $this->db->get_where($this->table)->result_array();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function updateById($tag_id, $data) {
        $this->db->where('id', $tag_id);
        $this->db->update($this->table, $data);
        $result = $this->db->affected_rows();
        return $result;
    }

    public function delete($tag_id) {
        $this->db->where('id' , $tag_id);
        $this->db->delete($this->table);
        $result = $this->db->affected_rows();
        return $result;
    }
}

/* End of file mApartment.php */
/* Location: ./application/models/tag-manager/mApartment.php */