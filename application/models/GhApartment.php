<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhApartment extends CI_Model {
    private $table = 'gh_apartment';
    const REAL_ESTATE_FOR_RENT = 1;
    const REAL_ESTATE_FOR_SALE = 2;
    const REAL_ESTATE_NONE = 3;

    public function getTitleProductType($type_id){
        $list =  [
            self::REAL_ESTATE_FOR_RENT => 'CHO THUÊ',
            self::REAL_ESTATE_FOR_SALE => 'BÁN',
            self::REAL_ESTATE_NONE => 'NONE',
        ];

        return isset($list[$type_id]) ? $list[$type_id] : $list[self::REAL_ESTATE_FOR_RENT];
    }

    public function switchProductType($type_id){

        $list =  [
            self::REAL_ESTATE_FOR_RENT,
            self::REAL_ESTATE_FOR_SALE,
            self::REAL_ESTATE_NONE
        ];
        if(!empty($type_id)){
            foreach ($list as $k => $v) {
                if($type_id === $v){
                    unset($list[$k]);
                }
            }
        }

        $result = array_splice($list, 1, 2, array_reverse(array_slice($list, 1, 2)));
        return $result[0];
    }

	public function get($where = [], $orderByString = null) {

	    if($orderByString) {
            $this->db->order_by($orderByString);
        } else {
            $this->db->order_by('length(order_item) ASC,order_item ASC,  id DESC, address_street ASC'); // comment xxx yyy
        }
        $where['apartment_type_id'] = $this->product_type;
	    if(empty($this->product_type)){
            $where['apartment_type_id'] = self::REAL_ESTATE_FOR_RENT;
        }
        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function getLike($like = []) {
        $this->db->from($this->table);
        $this->db->or_like($like);
        return $this->db->get()->result_array();
    }

    public function getByActive() {
        $where = [
            'active' => 'YES',
            'group_uuid' => null
        ];
        if(empty($this->product_type)){
            $where['apartment_type_id'] = self::REAL_ESTATE_FOR_RENT;
        }

        return $this->db->get_where($this->table, $where)->result_array();
	}

	public function getListContractById($id, $timeFrom, $timeTo){
        $list_contract = [];
        if(!empty($apm)){
            $list_contract = $this->ghContract->get([
                "time_check_in >=" => strtotime($timeFrom),
                "time_check_in <=" => strtotime($timeFrom)+86399,
                "apartment_id" => $id
            ]);
        }
        return $list_contract;

    }
	
	public function getByDistrictId($district_id) {
        $where = [
            'district_id' => $district_id,
            'group_uuid' => null
        ];
        if(empty($this->product_type)){
            $where['apartment_type_id'] = self::REAL_ESTATE_FOR_RENT;
        }

        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function getById($apartment_id) {
        $where = ['id' => $apartment_id, 'group_uuid' => null];
        if(empty($this->product_type)){
            $where['apartment_type_id'] = self::REAL_ESTATE_FOR_RENT;
        }

        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function getAll() {
        $this->db->order_by('id','DESC'); 
        $result = $this->db->get_where($this->table)->result_array();
        return $result;
    }

    public function getByUserDistrict($account_id) {
        $q = "SELECT * FROM gh_apartment, gh_user_district 
                WHERE gh_apartment.district_code = gh_user_district.district_code AND gh_user_district.user_id = $account_id 
                AND gh_apartment.apartment_type_id = ".$this->product_type." AND group_uuid IS NULL
        ";
        // if($account_id == 2019 or $account_id == 171020010) {
        //     $q = "SELECT * FROM gh_apartment, gh_user_district 
        //         WHERE gh_apartment.district_code = gh_user_district.district_code AND gh_user_district.user_id = $account_id AND gh_apartment.district_code = '7'";
        // }
        $result = $this->db->query($q);
        return $result->result_array();
    }

    public function getProductManagerByApm($apm_id){
        $this->load->model('ghUser');
	    $apm = $this->getFirstById($apm_id);
	    if($apm && !empty($apm['user_collected_id'])){
	        $user = $this->ghUser->getFirstByAccountId($apm['user_collected_id']);

            return [
                'account_id' => $user['account_id'],
                'name' => $user['name'],
            ];
        }

        return false;
    }

    public function getByDistrictReport($set_district) {
        $q = "SELECT * FROM gh_apartment 
                WHERE FIND_IN_SET(gh_apartment.district_code, '".$set_district."')  
                AND gh_apartment.active = 'YES' AND gh_apartment.apartment_type_id = ".$this->product_type." AND group_uuid IS NULL
        ";
        $result = $this->db->query($q);
        return $result->result_array();
    }

    public function getUpdateTimeByApm($apm_id) {
        $apartment = $this->getFirstById($apm_id);
        if($apartment){
            $time_update = $apartment['time_update'];
            $q_room = "SELECT MAX(time_update) as time_update FROM gh_room WHERE  apartment_id = ".$apm_id." AND active = 'YES'";
            $result = $this->db->query($q_room)->row_array();
            if($result['time_update'] > $time_update) {
                $time_update = $result['time_update'];
            }
            return $time_update;
        }
        return false;
    }

    public function getFirstById($room_id) {
        return $this->db->get_where($this->table, ['id' => $room_id])->row_array();
    }

    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function updateById($apartment_id, $data) {
        $this->db->where('id', $apartment_id);
        $this->db->update($this->table, $data);
        $result = $this->db->affected_rows();
        return $result;
    }

    public function delete($apartment_id) {
        $this->db->where('id' , $apartment_id);
        $this->db->delete($this->table);
        $result = $this->db->affected_rows();
        return $result;
    }

    public function getListCol() {
        $result = $this->db->get_where($this->table, ['id > ' => 1, 'apartment_type_id' => 1])->row_array();
        $out =  [];

        foreach ($result as $col => $val) {
            $out[] = $col;
        }

        return $out;
	}

	public function getApmWithTimeAvailableRemain($n_day_remain, $apm_id){
        $this->load->model("ghRoom");
        $list_room = $this->ghRoom->get([
            'apartment_id' => $apm_id,
            'active' => 'YES',
            'time_available >=' => strtotime(date('d-m-Y')),
            'time_available <=' => strtotime('+'.$n_day_remain.'days'),
        ]);
        if(count($list_room)) {
            return $list_room;
        }
        return false;
    }
}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */