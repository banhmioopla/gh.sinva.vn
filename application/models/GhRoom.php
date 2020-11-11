<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhRoom extends CI_Model {
    private $table = 'gh_room';

	public function get($where = []) {
        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function getByActive() {
        return $this->db->get_where($this->table, ['active' => 'YES'])->result_array();
    }
    public function getByApartmentIdAndActive($apartment_id) {
        return $this->db->get_where($this->table, ['active' => 'YES', 'apartment_id' => $apartment_id ])->result_array();
    }

    public function getById($room_id) {
        return $this->db->get_where($this->table, ['id' => $room_id])->result_array();
    }
    public function getByApartmentId($apartment_id) {
        return $this->db->get_where($this->table, ['apartment_id' => $apartment_id])->result_array();
    }

    public function getAll() {
        return $this->db->get_where($this->table)->result_array();
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

    public function updateByApartmentId($apartment_id, $data) {
        $this->db->where('apartment_id', $apartment_id);
        $this->db->update($this->table, $data);
        $result = $this->db->affected_rows();
        return $result;
    }

    public function delete($room_id) {
        $this->db->where('id' , $room_id);
        $this->db->delete($this->table);
        $result = $this->db->affected_rows();
        return $result;
    }

    public function getNumberByStatus($apartment_id, $status) {
        $result = $this->db->get_where(
            $this->table, 
            ['apartment_id' => $apartment_id, 'status' => $status, 'active' => 'YES'])->result_array();
        return count($result) > 0 ? count($result): 0;
    }

    public function getNumber($apartment_id){
        $result = $this->db->get_where(
            $this->table, 
            ['apartment_id' => $apartment_id, 'active' => 'YES'])->result_array();
        return count($result) > 0 ? count($result): null;
    }

    public function getNumberByTimeavailable($apartment_id) {
        $result = $this->db->get_where(
            $this->table, 
            ['apartment_id' => $apartment_id, 'time_available > ' => 0, 'active' => 'YES'])->result_array();
        return count($result) > 0 ? count($result): 0;
    }
    public function getMaxTimeUpdate($apartment_id){
        $this->db->where(['apartment_id' => $apartment_id]);
        $this->db->select_max('time_update');
        $result = $this->db->get($this->table);
        return $result->result_array() ? $result->result_array()[0]['time_update']:'';
    }

    public function getNumberByDistrict($district_code, $where_string) {
        $sql = "SELECT count(gh_room.id) as object_counter FROM  gh_room, gh_apartment 
                WHERE gh_apartment.id = gh_room.apartment_id
                AND gh_apartment.active = 'YES'
                AND gh_room.active = 'YES'
                AND gh_apartment.district_code = '$district_code'
        ";
        if(!empty($where_string)) {
            $sql .= " AND $where_string";
        }
        $result = $this->db->query($sql);
        // var_dump($result->result_array());die;
        return $result->result_array() ? $result->result_array()[0]['object_counter'] : 0;
    }

    public function getTypeByDistrict($district_code, $where_string) {
        $sql = "SELECT gh_room.type as room_type, count(gh_room.id) as object_counter FROM  gh_room, gh_apartment 
                WHERE gh_apartment.id = gh_room.apartment_id
                AND gh_apartment.active = 'YES'
                AND gh_room.active = 'YES'
                AND gh_apartment.district_code = '$district_code'
        ";
        if(!empty($where_string)) {
            $sql .= " AND $where_string";
        }
        $sql .= ' GROUP BY gh_room.type';
        $result = $this->db->query($sql);
        // var_dump($result->result_array());die;
        return $result->result_array() ? $result->result_array() : 0;
    }

    public function getPriceByDistrict($district_code, $where_string, $groupby = 'gh_room.type') {
        $sql = "SELECT gh_room.price as room_price, count(gh_room.id) as object_counter FROM  gh_room, gh_apartment 
                WHERE gh_apartment.id = gh_room.apartment_id
                AND gh_apartment.active = 'YES'
                AND gh_room.active = 'YES'
                AND gh_apartment.district_code = '$district_code'
        ";
        if(!empty($where_string)) {
            $sql .= " AND $where_string";
        }
        $sql .= ' GROUP BY '.$groupby . ' ORDER BY object_counter DESC, room_price DESC';
        $result = $this->db->query($sql);
        return $result->result_array() ? $result->result_array() : 0;
    }

    public function getPriceList($where_string = null, $groupby = 'gh_room.type') {
        $sql = "SELECT gh_room.price as room_price, gh_room.*, count(gh_room.price) as object_counter FROM  
gh_room, gh_apartment 
                WHERE gh_apartment.id = gh_room.apartment_id
                AND gh_apartment.active = 'YES'
                AND gh_room.active = 'YES'
        ";
        if(!empty($where_string)) {
            $sql .= " AND $where_string";
        }
        $sql .= ' GROUP BY '.$groupby . ' ORDER BY gh_room.price DESC, object_counter DESC';
        $result = $this->db->query($sql);
        return $result->result_array() ? $result->result_array() : 0;
    }

    public function getAreaList($where_string = null, $groupby = 'gh_room.type') {
        $sql = "SELECT gh_room.area as room_area, gh_room.*, count(gh_room.area) as object_counter FROM  
gh_room, gh_apartment 
                WHERE gh_apartment.id = gh_room.apartment_id
                AND gh_apartment.active = 'YES'
                AND gh_room.active = 'YES'
        ";
        if(!empty($where_string)) {
            $sql .= " AND $where_string";
        }
        $sql .= ' GROUP BY '.$groupby . ' ORDER BY gh_room.area DESC, object_counter DESC';
        $result = $this->db->query($sql);
        return $result->result_array() ? $result->result_array() : 0;
    }
}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */