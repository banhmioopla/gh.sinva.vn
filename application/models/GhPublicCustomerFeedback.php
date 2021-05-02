<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhPublicCustomerFeedback extends CI_Model {
    private $table = 'gh_public_customer_feedback';

    public function get($where = []) {
        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function updateById($room_id, $data) {
        $this->db->where('id', $room_id);
        $this->db->update($this->table, $data);
        $result = $this->db->affected_rows();
        return $result;
    }
}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */