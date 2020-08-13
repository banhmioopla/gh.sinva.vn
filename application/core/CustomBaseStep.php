<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CustomBaseStep extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
		$this->load->model('ghActivityTrack');
		$this->district_default = '7';
		if($this->session->userdata('auth')) {
			$this->auth = $this->session->userdata('auth');
			$this->load->library('LibRole', null, 'libRole');
			
			$this->load->config('usermode');
			// var_dump($this->auth['modifymode'] = $this->config->item('usermode')['consultant']); die;
			$usermode = $this->config->item('usermode');
			
			// echo "<pre>"; print_r($usermode[$this->auth['role_code']]); die;
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
}

?>