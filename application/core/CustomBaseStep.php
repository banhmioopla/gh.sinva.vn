<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CustomBaseStep extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$this->current_controller =  $this->router->fetch_class();
		$this->current_action =  $this->router->fetch_method();
		// lay so Tuan trong Nam
		// $date = '04/05/1997';
		// $int_date = strtotime($date);
		// $t =  date('d/m/Y', $int_date);
		// echo 't = '. $t ."\r\n";
		// echo date('W', strtotime($t)); die;
		if(!$this->session->has_userdata('auth'))
		{
			$this->session->sess_destroy();
			return redirect('/admin/logout');
		}
		
		$this->load->model(['ghActivityTrack', 'ghUser', 'ghUserDistrict', 'ghRole', 'ghConfig']);
		
		$this->district_default = '7';
		$this->auth = $this->session->userdata('auth');
		$this->load->library('LibRole', null, 'libRole');
		$this->load->library('LibConfig', null, 'libConfig');

		$this->load->config('usermode');
		$usermode = $this->config->item('usermode');
	
		$this->auth['modifymode'] = 'view';
		$this->menu = null;;
		
		$ghUserDistrict = $this->ghUserDistrict->get(['user_id' => $this->auth['account_id']]);
		$this->list_district_CRUD = [];
		foreach($ghUserDistrict as $ud) {
			$this->list_district_CRUD[] = $ud['district_code'];
		}
		
		$this->permission_set = json_decode($this->ghRole->get(['code' =>$this->auth['role_code']])[0]['list_function'], true);
		$current_user = $this->ghUser->get(['account_id' => $this->auth['account_id']]);
		$authorised_user = $this->ghUser->get(['account_id' => $current_user[0]['authorised_user_id']]);
		$this->authorised_mode = false;
		if(!empty($authorised_user)) {
			$this->authorised_user = $authorised_user;
			$this->authorised_mode = true;
			$temp_menu = $this->menu;
			$this->menu = $temp_menu;
		}
		$this->permission_controller_set = array_keys($this->permission_set);
		if(isset($this->permission_set[$this->current_controller])) {
			$this->permission_action_set = $this->permission_set[$this->current_controller];
		}


        $this->arr_general = $this->libConfig->getListGeneralControlDepartment();
		if(!$this->checkCurrentPermission($this->permission_set)) {
			return redirect('/admin/notfound');
		}
	}

	private function checkCurrentPermission($permission_set) {
		$permission_controller_set = array_keys($permission_set);
		$permission_action_set = $permission_set[$this->current_controller];

		if(in_array($this->current_controller, $permission_controller_set) && in_array($this->current_action, $permission_action_set)) {
			return true;
		}
		return false;
	}

	protected function isYourPermission($controller, $action){
        $list_controller = array_keys($this->permission_set);
        if(in_array($controller, $list_controller) && isset($this->permission_set[$controller]) && in_array($action, $this->permission_set[$controller])) {
            return true;
        }
        return false;
    
    }

	
}

?>