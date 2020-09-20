<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhBookingCustomer extends CI_Model {
    private $table = 'gh_booking_customer';

	public function get($where = []) {
        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function getById($district_id) {
        return $this->db->get_where($this->table, ['id' => $district_id])->result_array();
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

    public function delete($district_id) {
        $this->db->where('id' , $district_id);
        $this->db->delete($this->table);
        $result = $this->db->affected_rows();
        return $result;
    }

    public function getCurrentWeek($apartment_id) {
        $current_year = date('Y');
        $current_week = date('W');
        $sql = "SELECT * 
            FROM ".$this->table." 
            WHERE WEEK(FROM_UNIXTIME(time_report)) = '$current_week' 
            AND YEAR(FROM_UNIXTIME(time_report)) = '$current_year'
            AND apartment_id = $apartment_id";
        $result = $this->db->query($sql)->result_array();
        return $result ? $result[0]: false;
    }
}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */