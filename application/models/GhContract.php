<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhContract extends CI_Model {
    private $table = 'gh_contract';
    const STATUS_ACTIVE = 'Active';
    const STATUS_CANCEL = 'Cancel';
    const STATUS_PENDING = 'Pending';
    const STATUS_EXPIRED = 'Expired';
    public function __construct()
    {
        $this->apply_date = "01-11-2021";
        $this->num_contract_apply = 3;
        $this->refer_fund = 0.05;
        $this->rate_team_fund = 0.02;
        $this->consultant_boss_fund = 0.03;

        $this->general_fund = 0.02;
        $this->product_manager_fund = 0.05;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $this->load->model('ghApartment');
        $this->load->model('ghRoom');
    }

    public function get($where = [], $order_column  = 'id', $trend = 'DESC') {
        $this->db->order_by($order_column, $trend);
        return $this->db->get_where($this->table, $where)->result_array();
    }
    public function getFirst($where = [], $order_column  = 'id', $trend = 'DESC') {
        $this->db->order_by($order_column, $trend);
        return $this->db->get_where($this->table, $where)->row_array();
    }

    public function getAlertNewestByApartment($apm_id) {

        $last_contract = $this->get([
            "apartment_id" => $apm_id,
            'time_check_in >=' => strtotime("-6 month"),
            'time_check_in <=' => strtotime("+1 year"),
        ]);
        if(count($last_contract) == 0){
            return '<div class="alert alert-warning bg-warning text-white border-0" role="alert">
                            <i class="dripicons-rocket"></i> ... đã hơn <strong> 6 tháng</strong> chưa có hợp đồng
                        </div>';
        }
        return '<div class="alert alert-warning bg-warning text-white border-0" role="alert">
                            <i class="fa fa-twitter"></i> Hợp đồng cuối cùng ký vào <strong>'.date("d/m/Y",$last_contract[0]["time_check_in"]).'</strong>
                        </div>';
    }

    public function getTotalSaleByConsultant($user_id, $timeFrom, $timeTo) {
        $this->db->order_by('id','DESC');
        $list = $this->db->get_where($this->table, [
            'consultant_id' => $user_id,
            'time_check_in >= ' => strtotime($timeFrom),
            'time_check_in <= ' => strtotime($timeTo) + 86399,
            'status <>' => 'Cancel'
            ])->result_array();

        $total = 0;
        foreach ($list as $item) {
            $total += $item['room_price'] * $item['commission_rate'] / 100;
        }

        return $total;
    }

    public function getByActive() {
        return $this->db->get_where($this->table, ['active' => 'YES'])->result_array();
    }

    public function getById($district_id) {
        return $this->db->get_where($this->table, ['id' => $district_id])->result_array();
    }

    public function getFirstById($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

    public function getByCustomerIdAndNotPending($id) {
        return $this->db->get_where($this->table, ['customer_id' => $id, 'status <> ' => "Pending"])->result_array();
    }

    public function getAll() {
        return $this->db->get_where($this->table)->result_array();
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

    public function getBySearch($where) {
        $where_string = "";
        if(!empty($where)) {
            $where_string = " AND ";
            foreach ($where as $k => $v) {
                $where_string .= ' '.$k.$v . ' AND';
            }
            $where_string = substr($where_string, 0, -3);
        }
        $sql = "SELECT *
                FROM gh_user, gh_role, gh_contract
                WHERE gh_user.account_id = gh_contract.consultant_id AND 
                 gh_role.code = gh_user.role_code
                 ". $where_string . "  ORDER BY gh_contract.id DESC" ;

        $result = $this->db->query($sql);

        return $result->result_array();
    }

    public function syncStatusExpire() {
        $sql = "UPDATE ". $this->table . " SET status = 'Expired' WHERE status <> 'Cancel' AND
        time_expire < " . strtotime(date('d-m-Y'));
        
        $result = $this->db->query($sql);
    }

    public function approved($id, $object_id = null) {
        $sql = "UPDATE ". $this->table . " SET status = 'Active' WHERE
        id = " . $object_id;
        
        $result = $this->db->query($sql);
        $sql = "UPDATE gh_notification SET is_approve = 'YES' WHERE
        object_id = " . $object_id;
        $result = $this->db->query($sql);
    }

    public function delete($district_id) {
        $this->db->where('id' , $district_id);
        $this->db->delete($this->table);
        $result = $this->db->affected_rows();
        return $result;
    }

    public function getTotalSaleByContract($c_id) {
        $con = $this->getFirstById($c_id);
        return round($con['commission_rate']/100*$con['room_price'],2);
    }

    public function getTotalRateStar($account_id, $from_date, $to_date){
        $list_con = $this->get([
            'time_check_in >=' => strtotime($from_date),
            'time_check_in <=' => strtotime($to_date)+86399,
            'status <>' => 'Cancel'
        ]);
        $rate = 0;
        foreach ($list_con as $con) {
            if(!empty($con['arr_supporter_id'])){
                $arr = json_decode($con['arr_supporter_id'], true);
                if(in_array($account_id, $arr)){
                    $rate += (1-$con['rate_type']) / (count($arr));
                }
            }
            if($con['consultant_id'] == $account_id){
                $rate += $con['rate_type'];
            }
        }
        return (string) $rate;
    }

    public function getTotalSaleByUser($account_id, $from_date, $to_date){
	    $list_con = $this->get([
	        'consultant_id' => $account_id,
            'time_check_in >=' => strtotime($from_date),
            'time_check_in <=' => strtotime($to_date)+86399,
            'status <>' => 'Cancel'
        ]);
        $total = 0;
	    foreach ($list_con as $con){
            $total += $con['rate_type'] * $this->getTotalSaleByContract($con['id']);
        }

        $list_contract_supporter = $this->ghContract->get([
            'time_check_in >=' => strtotime($from_date),
            'time_check_in <=' => strtotime($to_date)+86399,
            'arr_supporter_id <>' => null,
            'status' => "Active"
        ]);

        foreach ($list_contract_supporter as $con) {
            if(!empty($con["arr_supporter_id"])){
                $arr = json_decode($con["arr_supporter_id"], true);
                if(in_array($account_id, $arr)){
                    if($con['rate_type'] < 1){
                        $total += (1- $con['rate_type']) * $this->getTotalSaleByContract($con['id']);
                    }
                }
            }
        }

        return $total;
    }

    public function getTotalSaleByDistrict($district, $from_date, $to_date){
        $list_con = $this->get([
            'time_check_in >=' => strtotime($from_date),
            'time_check_in <=' => strtotime($to_date)+86399,
            'status <>' => 'Cancel'
        ]);
        $arr_district_apm = [];
        $list_apm = $this->ghApartment->get(['active' => 'YES', 'district_code' => $district]);
        foreach ($list_apm as $apm){
            $arr_district_apm[] = $apm['id'];
        }
        if(empty($arr_district_apm)){
            return 0;
        }

        $total = 0;
        foreach ($list_con as $con){
            if(in_array($con['apartment_id'], $arr_district_apm)){
                $total += $this->getTotalSaleByContract($con['id']);
            }
        }

        return $total;
    }

    public function getCountContractByDistrict($district, $from_date, $to_date){
        $list_con = $this->get([
            'time_check_in >=' => strtotime($from_date),
            'time_check_in <=' => strtotime($to_date)+86399,
            'status <>' => 'Cancel'
        ]);
        $arr_district_apm = [];
        $list_apm = $this->ghApartment->get(['active' => 'YES', 'district_code' => $district]);
        foreach ($list_apm as $apm){
            $arr_district_apm[] = $apm['id'];
        }
        $count = 0;
        if(empty($arr_district_apm)){
            return 0;
        }
        foreach ($list_con as $con){
            if(in_array($con['apartment_id'], $arr_district_apm)){
                $count ++;
            }
        }

        return $count;
    }

    public function getCountContractByUser($account_id, $from_date, $to_date){
        $list_con = $this->get([
            'consultant_id' => $account_id,
            'time_check_in >=' => strtotime($from_date),
            'time_check_in <=' => strtotime($to_date)+86399,
            'status <>' => 'Cancel'
        ]);

        return count($list_con);
    }

    public function getTotalIncomeByUser($account_id, $from_date, $to_date){

        $this->load->model('ghTeamUser');
        $this->load->model('ghTeam');
        $this->load->model('ghUser');


        $total_sale = 0;
        $income_rate = 0.63;
        $refer_fund = 0;
        $this->rate_team_fund = 0.02;

        $user = $this->ghUser->getFirstByAccountId($account_id);
        $refer_by = $refer_by = "SINVA | ". date("d-m-Y", $user['time_joined']);
        $refer_me = $this->ghUser->getFirstByAccountId($user["user_refer_id"]);


        $list_con = $this->get([
            'consultant_id' => $account_id,
            'time_check_in >=' => strtotime($from_date),
            'time_check_in <=' => strtotime($to_date)+86399,
        ]);
        $team_fund_plus_rate = 0;
        if(strtotime($from_date) >= strtotime($this->apply_date)){
            if(count($list_con) < 4 ) {
                $income_rate = 0.6;
                if($user['time_joined'] >= strtotime($this->apply_date)){
                    $this->rate_team_fund = 0;
                }
            }
        }

        $list_pro_manager = [];
        foreach ($list_con as $con){
            $sale_amount = $this->getTotalSaleByContract($con['id']);
            $total_sale += $sale_amount;
            $p_m = $this->ghApartment->getProductManagerByApm($con['apartment_id']);
            if(!empty($p_m)){
                if(isset($list_pro_manager[$p_m['account_id']])){
                    $list_pro_manager[$p_m['account_id']] += $this->product_manager_fund * $sale_amount;
                } else {
                    $list_pro_manager[$p_m['account_id']] = $this->product_manager_fund * $sale_amount;
                }

            }
        }


        $my_team = $this->ghTeamUser->getFirstByUserId($account_id);
        $team_id = $refer_account_id = 0;
        $team_name = "";
        if(empty($my_team)){
            $my_team = $this->ghTeam->getFirstByLeaderUserId($account_id);
            if($my_team){
                $team_id = $my_team['id'];
                $team_name = $this->ghTeam->getFirstById($my_team['id'])["name"];
            }
        } else {
            $team_id = $my_team['team_id'];
            $team_name = $this->ghTeam->getFirstById($my_team['team_id'])["name"];
        }



        if($refer_me){
            $refer_by = $refer_me['name']. " | ". date("d-m-Y", $user['time_joined']);
            $refer_account_id = $refer_me['account_id'];
        }


        if($user['time_joined'] >= strtotime($from_date) && strtotime($from_date) >= strtotime($this->apply_date)){
            $refer_fund = $this->getSaleRefByContract($account_id);
        }
        if($income_rate === 0.6 && empty($refer_fund)){
            $team_fund_plus_rate = 0.03;
        }

        return [
            "total_sale" => $total_sale,
            "total_income" => $total_sale * $income_rate,
            "income_rate" => $income_rate,
            "team_fund" => $total_sale * ($this->rate_team_fund+$team_fund_plus_rate),
            "consultant_boss_fund" => $total_sale * $this->consultant_boss_fund,
            "general_fund" => $total_sale * $this->general_fund,
            "product_manager_fund" => $total_sale * $this->product_manager_fund,
            "product_manager_list" => $list_pro_manager,
            "refer_fund" => $refer_fund,
            "refer_by" => $refer_by,
            "refer_account_id" => $refer_account_id,
            "team_name" => $team_name,
            "team_id" => $team_id,
        ];
    }

    public function getTotalSaleByTeam($team_id, $from_date, $to_date){
        $this->load->model('ghTeamUser');
        $this->load->model('ghTeam');
        $list_uu = $this->ghTeamUser->get(["team_id" => $team_id]);
        $leader = $this->ghTeam->getFirstById($team_id);
        $total = $this->getTotalSaleByUser($leader['leader_user_id'], $from_date, $to_date);

        foreach ($list_uu as $uu) {

            $list_con = $this->get([
                'consultant_id' => $uu['user_id'],
                'time_check_in >=' => strtotime($from_date),
                'time_check_in <=' => strtotime($to_date)+86399,
            ]);


            foreach ($list_con as $con){
                $total += $this->getTotalSaleByContract($con['id']);
            }
        }
        return $total;
    }

    public function getLimitByUser($account_id,$n, $from, $to){

        $int_from = strtotime($from);
        $int_to = strtotime($to)+86399;
        $sql = "SELECT *
                FROM  gh_contract
                WHERE {$account_id} = consultant_id 
                 AND time_check_in >= {$int_from}  AND time_check_in <= {$int_to} 
                 
                 ORDER BY gh_contract.id ASC LIMIT $n" ;

        $result = $this->db->query($sql);

        return $result->result_array();
    }

    public function getTotalSaleByApartment($apm_id,$from_time, $to_time){
        $total = 0;
        $list_con = $this->get([
            'apartment_id' => $apm_id,
            'time_check_in >=' => strtotime($from_time),
            'time_check_in <=' => strtotime($to_time)+86399,
        ]);
        foreach ($list_con as $con) {

            $total +=$this->getTotalSaleByContract($con['id']);
        }

        return $total;
    }

    public function getTotalSaleByUserLimit($account_id, $n, $from, $to){
        $list_con = $this->getLimitByUser($account_id, $n, $from, $to);

        $total = 0;
        foreach ($list_con as $con) {
            $total +=$this->getTotalSaleByContract($con['id']);
        }

        return $total;
    }

    public function getSaleRefByContract($account_id){ // get total refer user fund
        $sale_by_limit = $this->getTotalSaleByUserLimit($account_id, $this->num_contract_apply, $this->apply_date, date("d-m-Y"));
        return $sale_by_limit * $this->refer_fund;
    }

    public function getListSaleItemByUser($account_id, $from, $to){
        $list_contract =$this->get([
            'consultant_id' => $account_id,
            'time_check_in >=' => strtotime($from),
            'time_check_in <=' => strtotime($to)+86399,
        ], "id", "ASC");

        $arr = [];
        foreach ($list_contract as $con){

            $room = $this->ghRoom->getFirstById($con['room_id']);
            $apm = $this->ghApartment->getFirstById($room['apartment_id']);
            $arr[] = [
                "total_sale" => $this->getTotalSaleByContract($con['id']),
                "description" => "<span class='text-muted'> Ngày ký ".date("d-m-Y", $con['time_check_in']) . "</span>, ". $apm['address_street'] . " <strong>".$room['code']."</strong> ",
            ];
        }

        return $arr;

    }

    public function getFirstSignContractOfApartment($apm_id){
    	$con = $this->getFirst([
			'apartment_id' =>  $apm_id,
			'status <>' => 'Cancel',
		], 'time_check_in','ASC');
    	if($con){
    		return $con;
		}

    	return false;
	}


}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */
