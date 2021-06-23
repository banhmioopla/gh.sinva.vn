<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhRoom extends CI_Model {
    private $table = 'gh_room';

	public function get($where = [], $order_column  = 'id', $trend = 'DESC') {
        $this->db->order_by($order_column, $trend);
        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function getByActive() {
        return $this->db->get_where($this->table, ['active' => 'YES'])->result_array();
    }
    public function getByApartmentIdAndActive($apartment_id) {
        return $this->db->get_where($this->table, ['active' => 'YES', 'apartment_id' => $apartment_id ])->result_array();
    }

    public function getFirstById($room_id) {
        return $this->db->get_where($this->table, ['id' => $room_id])->row_array();
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

    public function getBySearch($where){
        $where_string = "";
	    if(!empty($where)) {
            $where_string = " AND ";
	        foreach ($where as $k => $v) {
                $where_string .= ' '.$k.$v . ' AND';
            }
            $where_string = substr($where_string, 0, -3);
        }

	    $sql = "SELECT gh_room.* 
                FROM gh_room, gh_apartment
                WHERE gh_room.apartment_id = gh_apartment.id AND gh_room.active='YES' ". $where_string;

        $result = $this->db->query($sql);

        return $result->result_array();
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
        $this->db->where(['apartment_id' => $apartment_id, 'active' => 'YES']);
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

    public function getTypeByDistrict($district_code = null, $where_string = null) {
        $sql = "SELECT gh_room.type as room_type, count(gh_room.id) as object_counter FROM  gh_room, gh_apartment 
                WHERE gh_apartment.id = gh_room.apartment_id
                AND gh_apartment.active = 'YES'
                AND gh_room.active = 'YES'
                AND gh_room.type IS NOT NULL
                AND gh_room.type <> ''
        ";
        
        if(!empty($district_code)) {
            $sql .= "AND gh_apartment.district_code = '$district_code'";
        }
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

    public function getWardByDistrict($district_code) {
        $sql = "SELECT DISTINCT gh_apartment.address_ward as address_ward FROM gh_apartment 
                WHERE gh_apartment.active = 'YES' AND LENGTH(gh_apartment.address_ward) > 0
                AND gh_apartment.district_code = '$district_code'
                ORDER BY cast(gh_apartment.address_ward as unsigned);
        ";

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