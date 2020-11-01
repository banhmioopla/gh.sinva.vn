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
			return redirect('Login');
		}
		
		$this->load->model(['ghActivityTrack', 'ghUser', 'ghUserDistrict', 'ghRole']);
		
		$this->district_default = '7';
		$this->auth = $this->session->userdata('auth');
		$this->load->library('LibRole', null, 'libRole');
		
		$this->load->config('usermode');
		$usermode = $this->config->item('usermode');
	
		$this->auth['modifymode'] = 'view';
		$this->menu = $this->config->item('accesscontrol')[$this->auth['role_code']];
		
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
			foreach($this->config->item('accesscontrol')[$authorised_user[0]['role_code']] as $item) {
				if(!in_array($item, $temp_menu)) 
					$temp_menu[] = $item;
			}
			$this->menu = $temp_menu;
		}
		$this->permission_controller_set = array_keys($this->permission_set);
		if(isset($this->permission_set[$this->current_controller])) {
			$this->permission_action_set = $this->permission_set[$this->current_controller];
		}
		
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

	
}

?>