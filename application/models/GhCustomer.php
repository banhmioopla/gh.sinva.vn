<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GhCustomer extends CI_Model {
    private $table = 'gh_customer';
    const CUSTOMER_STATUS_SINVA_RENTED = 'sinva-rented';

	public function get($where = []) {
        return $this->db->get_where($this->table, $where)->result_array();
    }
    public function getFirstById($room_id) {
        return $this->db->get_where($this->table, ['id' => $room_id])->row_array();
    }

    public function getByUserAndShare($user_id) {
        $sql = "
        SELECT DISTINCT c.id, c.* FROM gh_customer c, 
        gh_share_customer_user s, gh_contract con
        WHERE 
          (c.user_insert_id = $user_id) 
          OR (c.id = s.customer_id AND c.user_insert_id <> s.user_id 
            AND s.user_id = $user_id
          ) 
          OR (c.id = con.customer_id AND con.consultant_id = $user_id)
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
        $sql = "SELECT time_expire, count(id) as counter, consultant_id
                FROM gh_contract 
                WHERE customer_id = $id ORDER BY time_expire DESC";
        $result = $this->db->query($sql);

        return $result->result_array();
    }

    public function getNearestContractByCustomerId($id) {
        $sql = "SELECT MAX(time_expire) as max_time_expire
                FROM gh_contract 
                WHERE customer_id = $id";
        $result = $this->db->query($sql);

        return $result->row_array();
    }

    public function getNumberContract($id) {
        $sql = "SELECT COUNT(id) as counter
                FROM gh_contract 
                WHERE customer_id = $id";
        $result = $this->db->query($sql);

        return $result->row_array();
    }

    public function getAllConsultantByCustomerId($id) {
        $sql = "SELECT consultant_id
                FROM gh_contract 
                WHERE customer_id = $id";
        $result = $this->db->query($sql);

        return $result->row_array();
    }

    public function delete($district_id) {
        $this->db->where('id' , $district_id);
        $this->db->delete($this->table);
        $result = $this->db->affected_rows();
        return $result;
    }

    public function getCustomerOfConsultant($account_id){
        $this->load->model('ghContract');
        $this->load->model('ghConsultantBooking');
        $arr_id_customer = [];
        $arr_customer = [];
	    $list_from_contract = $this->ghContract->get(['consultant_id' => $account_id]);
	    foreach ($list_from_contract as $item){
            if(!in_array($item['customer_id'], $arr_id_customer)){
                $customer_model = $this->getFirstById($item['customer_id']);
                if($customer_model){
                    $arr_id_customer[] = $item['customer_id'];
                    $arr_customer[] = $customer_model;
                }
            }
        }

        $list_from_booking = $this->ghConsultantBooking->get(['booking_user_id' => $account_id]);

        foreach ($list_from_booking as $item){
            if(!in_array($item['customer_id'], $arr_id_customer)){
                $customer_model = $this->getFirstById($item['customer_id']);
                if($customer_model){
                    $arr_id_customer[] = $item['customer_id'];
                    $arr_customer[] = $customer_model;
                }
            }
        }

        return [
            'customers' => $arr_customer,
            'arr_id' => $arr_id_customer
        ];

    }

    public function getCustomerOfExpireDays($n_day_remain, $customer_id, $account_id){
        $this->load->model('ghContract');
        $time_to = strtotime("+" . $n_day_remain . ' days');
        $time_from = strtotime(date('d-m-Y'));
        $last_contract = $this->ghContract->get([
            'customer_id' => $customer_id,
            'time_expire >= ' => $time_from,
            'time_expire <= ' => $time_to,
            'consultant_id' => $account_id
        ]);
        $last_contract = count($last_contract) > 0 ? $last_contract[count($last_contract) - 1] : null;
        if(!empty($last_contract)){
            return $last_contract;
        }
        return false;
    }

    public function getCustomerBirthDateOfRemainDays($n_day_remain, $customer_id){
        $time_to = strtotime("+" . $n_day_remain . ' days');
        $time_from = strtotime(date('d-m-Y'));
        $model = $this->getFirstById($customer_id);

        if($model){

            if(!empty($model['birthdate'])){
                $mapping_this_year = strtotime(date('d-m', $model['birthdate']).'-'.date('Y'));
                if($mapping_this_year >= $time_from &&  $mapping_this_year <= $time_to){
                    return $model;
                }
            }
        }
        return false;
    }
}

/* End of file mApartment.php */
/* Location: ./application/models/role-manager/mApartment.php */