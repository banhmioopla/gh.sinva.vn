<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class LibUser {
    public $CI;
    public function __construct()
	{
        $this->CI =& get_instance();
		$this->CI->load->model('ghUser');
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
        return $list_user ? $list_user[0]['name'] : '#';
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

                $cb .= '<option '.$selected.' value='.$user['account_id'].'>'.$user['name'].'</option>';
            }
        }
        return $cb;
    }
}






?>