<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhApartment extends CI_Model {
    private $table = 'gh_apartment';
    const REAL_ESTATE_FOR_RENT = 1;
    const REAL_ESTATE_FOR_SALE = 2;
    const REAL_ESTATE_NONE = 3;
    private $product_type = null;

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
    public function get_where_in($col = 'id', $arr = []) {
        $this->db->where_in($col, $arr);
        return $this->db->get($this->table)->result_array();
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
        $this->load->model('ghContract');
        $list_contract = $this->ghContract->get([
            "time_check_in >=" => strtotime($timeFrom),
            "time_check_in <=" => strtotime($timeTo)+86399,
            "apartment_id" => $id,
            'status <>' => 'Cancel'
        ]);
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

    public function isEmptyRoomPrice($apm_id){
        $this->load->model("ghRoom");
        $list_room = $this->ghRoom->get([
            'apartment_id' => $apm_id,
            'active' => 'YES',
            'price' => 0
        ]);
        if(count($list_room)) return '<div class="alert alert-warning bg-warning text-white border-0" role="alert">
                            <i class="fa fa-twitter"></i> Có một số phòng <strong>chưa cập nhật giá </strong>
                        </div>';

        return false;
    }

    public function visitedAccount($apm_id, $except_account){
        $this->load->model(["ghApartmentView","ghUser"]);
        $list_view = $this->ghApartmentView->get([
            'apartment_id' => $apm_id,
            'user_id <>' => $except_account,
            'time_create >=' => strtotime('-1 week'),
        ]);
        $arr_account = $arr_account_name = [];
        foreach ($list_view as $view){
            if(!in_array($view["user_id"],$arr_account)){
                $account = $this->ghUser->getFirstByAccountId($view["user_id"]);
                if(!empty($account)){
                    $arr_account[] = $account["account_id"];
                    $split_name = explode(' ', $account["name"]);
                    $account_name = $split_name[count($split_name)-1];
                    if(count($split_name) > 1){
                        $account_name = $split_name[count($split_name)-2]." ".$account_name;
                    }
                    $arr_account_name[] =$account_name;
                }

            }
        }

        return $arr_account_name;


    }

    public function getRoomPriceRange($apm_id){
        $list_room = $this->ghRoom->get([
            'apartment_id' => $apm_id,
            'active' => 'YES',
        ]);
        $list_price = [];
        foreach ($list_room as $room){
            if(!in_array($room["price"], $list_price)){
                $list_price[] = $room["price"];
            }

        }
        if(count($list_price) > 0) {
            return [min($list_price), max($list_price)];
        }
        return [0, 0];
    }

}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */