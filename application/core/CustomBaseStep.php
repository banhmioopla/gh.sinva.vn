<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CustomBaseStep extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Ho_Chi_Minh');
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
		
		$this->load->model('ghActivityTrack');
		$this->district_default = '7';
		$this->auth = $this->session->userdata('auth');
		$this->load->library('LibRole', null, 'libRole');
		
		$this->load->config('usermode');
		$usermode = $this->config->item('usermode');
	
		$this->auth['modifymode'] = 'view';
		$this->menu = $this->config->item('accesscontrol')[$this->auth['role_code']];
		
		$this->load->model('ghUserDistrict');
		$ghUserDistrict = $this->ghUserDistrict->get(['user_id' => $this->auth['account_id']]);
		$this->list_district_CRUD = [];
		foreach($ghUserDistrict as $ud) {
			$this->list_district_CRUD[] = $ud['district_code'];
		}
		
	}
}

?>