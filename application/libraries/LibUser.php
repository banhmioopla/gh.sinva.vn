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
        return $cb;
    }
}






?>