<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhContractCollaborators extends CI_Model {
    private $table = 'gh_contract_collaborators';

    const TYPE_RECEIVING_CUSTOMER = 'ReceivingCustomer';
    const TYPE_PASSING_CUSTOMER = 'PassingCustomer';
    const TYPE_NONE = 'None';

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

    public function getFirstByContractId($id) {
        return $this->db->get_where($this->table, ['contract_id' => $id])->row_array();
    }
}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */