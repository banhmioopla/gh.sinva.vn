<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhContract extends CI_Model {
    private $table = 'gh_contract';
    const STATUS_ACTIVE = 'Active';
    const STATUS_CANCEL = 'Cancel';
    const STATUS_PENDING = 'Pending';
    const STATUS_EXPIRED = 'Expired';

	public function get($where = []) {
        $this->db->order_by('id','DESC');
        return $this->db->get_where($this->table, $where)->result_array();
    }

    public function getTotalSaleByConsultant($user_id, $timeFrom, $timeTo) {
        $this->db->order_by('id','DESC');
        $list = $this->db->get_where($this->table, [
            'consultant_id' => $user_id,
            'time_insert >= ' => strtotime($timeFrom),
            'time_insert <= ' => strtotime($timeTo) + 86399,
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

    public function getTotalSaleByUser($account_id, $from_date, $to_date){
	    $list_con = $this->get([
	        'consultant_id' => $account_id,
            'time_check_in >=' => strtotime($from_date),
            'time_check_in <=' => strtotime($to_date)+86399,
        ]);
        $total = 0;
	    foreach ($list_con as $con){
            $total += $this->getTotalSaleByContract($con['id']);
        }

        return $total;
    }

    public function getTotalSaleByTeam($team_id, $from_date, $to_date){
        $this->load->model('ghTeamUser');
        $list_uu = $this->ghTeamUser->get(["team_id" => $team_id]);
        $total = 0;

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
                 
                 ORDER BY gh_contract.id ASC " ;

        $result = $this->db->query($sql);

        return $result->result_array();
    }

    public function getTotalSaleByUserLimit($account_id, $n, $from, $to){
        $list_con = $this->getLimitByUser($account_id, $n, $from, $to);

        $total = 0;
        foreach ($list_con as $con) {
            $total +=$this->getTotalSaleByContract($con['id']);
        }

        return $total;
    }

    public function getSaleRefByContract($account_id , $from, $to){
        $apply_date = "01-11-2021";
        $num_contract_apply = 3;
        $sinva_get_rate_ref = 0.05;


        $sale_by_limit = $this->getTotalSaleByUserLimit($account_id, $num_contract_apply, $apply_date, $to);

        return [
            "sinva" => $sale_by_limit * $sinva_get_rate_ref
        ];

    }


}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */