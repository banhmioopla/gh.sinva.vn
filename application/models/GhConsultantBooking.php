<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhConsultantBooking extends CI_Model {
    private $table = 'gh_consultant_booking';

	public function get($where = []) {
        $this->db->order_by('time_booking desc');
        $where['share_user_uuid'] = NULL;

        return $this->db->get_where($this->table, $where)->result_array();
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

    public function delete($district_id) {
        $this->db->where('id' , $district_id);
        $this->db->delete($this->table);
        $result = $this->db->affected_rows();
        return $result;
    }

    public function getNumber($apartment_id){
        $result = $this->db->get_where(
            $this->table,
            ['apartment_id' => $apartment_id])->result_array();
        return count($result);
    }

    public function getNumberFromRangeTime($from_time, $to_time){
        $sql = "SELECT apartment_id, COUNT(apartment_id) as counter
                FROM gh_consultant_booking
                WHERE time_booking >= {$from_time} AND time_booking <= {$to_time}
                GROUP BY apartment_id
                ORDER BY COUNT(apartment_id) DESC
                LIMIT 10
                ";

        $result = $this->db->query($sql)->result_array();
        return $result;
    }

    public function getGroupByUserId($from = 0, $to = null){
	    if(empty($to)) {
	        $to = strtotime('+1months');
        }
        $sql = "SELECT gh_consultant_booking.*, count(id) AS counter FROM gh_consultant_booking WHERE time_booking >= $from AND time_booking <= $to GROUP BY booking_user_id";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function getGroupByStatus($from = 0, $to = null, $user_id = 0 , $status = ''){
        if(empty($to)) {
            $to = strtotime('+1months');
        }
        $sql = "SELECT gh_consultant_booking.*, count(id) AS counter FROM 
        gh_consultant_booking 
        WHERE time_booking >= $from AND time_booking <= $to AND status= 
        '$status' 
        AND 
        booking_user_id = $user_id";

        $result = $this->db->query($sql);
        return $result->result_array();
    }




    public function getGroupByDistrict($from = 0, $to = null){
        if(empty($to)) {
            $to = strtotime('+1months');
        }
        $sql = "SELECT gh_consultant_booking.*, count(id) AS counter FROM gh_consultant_booking WHERE time_booking >= $from AND time_booking <= $to GROUP BY booking_user_id";
        $result = $this->db->query($sql);
        return $result->result_array();
    }

    public function syncPendingToSuccess(){
	    $sql = "UPDATE " . $this->table . " SET status = 'Success' WHERE status = 'Pending' AND time_booking <= " . time();
        return $this->db->query($sql);
    }
}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */