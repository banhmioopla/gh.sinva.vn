<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhDistrict extends CI_Model {
    private $table = 'gh_district';

    public function get($where = [], $order_column  = 'name', $trend = 'ASC') {
        $this->db->order_by($order_column, $trend);
        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function getByActive() {
        return $this->db->get_where($this->table, ['active' => 'YES'])->result_array();
    }

    public function getById($district_id) {
        return $this->db->get_where($this->table, ['id' => $district_id])->result_array();
    }

    public function getFirstByCode($room_id) {
        return $this->db->get_where($this->table, ['code' => $room_id])->row_array();
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


    public function getListLimit($user_id){
	    $sql = "SELECT DISTINCT d.* FROM gh_district d, gh_user_district ud , gh_apartment apm
                WHERE (d.code = ud.district_code AND ud.user_id = $user_id) OR (ud.apartment_id = apm.id AND ud.user_id = $user_id) AND (d.code = apm.district_code)
                 AND (d.active= 'YES') ORDER_BY d.name ASC 
                ";
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