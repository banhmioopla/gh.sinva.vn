<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhCustomer extends CI_Model { 
    private $table = 'gh_customer';

	public function get($where = []) {
        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function getByUserAndShare($user_id) {
        $sql = "
        SELECT DISTINCT c.id, c.* FROM gh_customer c, 
        gh_share_customer_user s
        WHERE 
          (c.user_insert_id = $user_id) 
          OR (c.id = s.customer_id AND c.user_insert_id <> s.user_id 
            AND s.user_id = $user_id
          ) 
        ";

        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function getByActive() {
        return $this->db->get_where($this->table, ['active' => 'YES'])->result_array();
    }

    public function getById($district_id) {
        return $this->db->get_where($this->table, ['id' => $district_id])->result_array();
    }

    public function getAll() {
        return $this->db->get_where($this->table)->result_array();
    }

    public function getLike($like = []) {
        $this->db->from($this->table);
        $this->db->or_like($like);
        return $this->db->get()->result_array();
    }

    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function updateById($id, $data) {
        $this->db->where('id', $id);
        $this->db->update($this->table, $data);
        $result = $this->db->affected_rows();
        return $result;
    }

    public function checkRentedContractByUser($id) {
        $sql = "SELECT time_expire, count(id) as counter
                FROM gh_contract 
                WHERE customer_id = $id ORDER BY time_expire ";
        $result = $this->db->query($sql);

        return $result->result_array();
    }

    public function delete($district_id) {
        $this->db->where('id' , $district_id);
        $this->db->delete($this->table);
        $result = $this->db->affected_rows();
        return $result;
    }
}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */