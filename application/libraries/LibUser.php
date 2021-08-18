<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class LibUser {
    public $CI;
    public function __construct()
	{
        $this->CI =& get_instance();
		$this->CI->load->model('ghUser');
		$this->CI->load->model('ghContract');
		$this->CI->load->model('ghTeamUser');
		$this->CI->load->model('ghConsultantBooking');
    }
    public function cbUserByRoleCode($role_code, $account_id) {
        $list_user = $this->CI->ghUser->get(['active' => 'YES', 'role_code'=> $role_code]);
        $cb = '<option value=0>chọn thanh vien ...</option>';
        if(!empty($list_user)) {
            foreach ($list_user as $user) {
                $selected = '';
                if($user['account_id'] == $account_id) {
                    $selected = 'selected';
                }
                $cb .= '<option '.$selected.' value='.$user['account_id'].'>'.$user['account_id'].' - '.$user['name'].'</option>';
            }
        }

        $list_user = $this->CI->ghUser->get(['active' => 'YES', 'authorised_user_id <> '=> null ]);
        if(!empty($list_user)) {
            foreach ($list_user as $user) {
                $selected = '';
                if($user['account_id'] == $account_id) {
                    $selected = 'selected';
                }
                $cb .= '<option '.$selected.' value='.$user['account_id'].'>'.$user['account_id'].' - '.$user['name'].'</option>';
            }
        }
        return $cb;
    }

    public function getNameByAccountid($account_id){
        $list_user = $this->CI->ghUser->get(['account_id' => $account_id]);
        return $list_user ? $list_user[0]['name'] : $account_id;
    }

    public function getLastNameByAccountId($account_id){
        $user = $this->CI->ghUser->getFirstByAccountId($account_id);

        $output = "";
        $user_name_arr = $user ? explode(" ",trim($user['name'])) : [];
        $length = count($user_name_arr);
        $output = $length>0 ? '<strong>'.$user_name_arr[$length-1].'</strong> ' : "";
        return $output;
    }

    public function cb($account_id = 0, $is_active = null) {
        $params['role_code <>'] = '';
        $params['account_id >='] = '171020000';
        if($is_active == 'YES') {
            $params['active'] = 'YES';
        }

        $list_user = $this->CI->ghUser->get($params);
        $cb = '<option value=0>chọn thành viên ...</option>';
        if(!empty($list_user)) {
            foreach ($list_user as $user) {
                $selected = '';
                if($user['account_id'] == $account_id) {
                    $selected = 'selected';
                }

                $cb .= '<option '.$selected.' value='.$user['account_id'].'>'.$user['name'] . " - " . substr($user['account_id'], -3).'</option>';
            }
        }
        return $cb;
    }

    public function getTotalSaleByUser($account_id, $from_time, $to_time){
        $from_date = strtotime($from_time);
        $to_date = strtotime($to_time);

        $list_contract = $this->CI->ghContract->get([
            'consultant_id' => $account_id,
            'time_check_in >=' => $from_date,
            'time_check_in <=' => $to_date +  86399,
        ]);
        $total_sale = 0;
        foreach ($list_contract as $cc) {
            $total_sale += $cc['commission_rate'] * $cc['room_price'] / 100;
        }

        return $total_sale;

    }

    public function getNumberContractByTeam($team_id, $from_time, $to_time){
        $list_user = $this->CI->ghTeamUser->get([
            'team_id' => $team_id,
        ]);

        $from_date = strtotime($from_time);
        $to_date = strtotime($to_time);

        $total = 0;
        foreach ($list_user as $uu) {
            $list_contract = $this->CI->ghContract->get([
                'consultant_id' => $uu['user_id'],
                'time_check_in >=' => $from_date,
                'time_check_in <=' => $to_date +  86399,
            ]);

            $total += count($list_contract);
        }

        return $total;
    }

    public function getTotalSaleByTeam($team_id, $from_time, $to_time){
        $list_user = $this->CI->ghTeamUser->get([
            'team_id' => $team_id,
        ]);

        $total = 0;
        foreach ($list_user as $uu) {
            $total += $this->getTotalSaleByUser($uu['user_id'], $from_time, $to_time);
        }

        if($total == 0) {
            return '0.00';
        }

        return number_format($total);
    }

    public function getTotalUserByTeam($team_id){
        $list_user = $this->CI->ghTeamUser->get([
            'team_id' => $team_id,
        ]);

        $total = 0;
        foreach ($list_user as $uu) {
            $total++;
        }

        return $total;
    }

    public function getTotalBookingByTeam($team_id, $from_time, $to_time){
        $list_user = $this->CI->ghTeamUser->get([
            'team_id' => $team_id,
        ]);

        $total = 0;
        foreach ($list_user as $uuu) {

            $booking =count($this->CI->ghConsultantBooking->get([
                'booking_user_id' => $uuu['user_id'],
                'time_booking >=' => strtotime($from_time),
                'time_booking <=' => strtotime($to_time) + 86399,
            ]));

            $total += $booking;
        }

        return $total;

    }
}






?>