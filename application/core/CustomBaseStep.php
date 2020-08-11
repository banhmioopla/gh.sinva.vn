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
			$this->auth['role_code'] = $this->libRole->getCodeById($this->auth['role_id']);
			
			$this->load->config('usermode');
			// var_dump($this->auth['modifymode'] = $this->config->item('usermode')['consultant']); die;
			$usermode = $this->config->item('usermode');
			
			// echo "<pre>"; print_r($usermode[$this->auth['role_code']]); die;
			$this->auth['modifymode'] = $usermode[$this->auth['role_code']];
			$this->menu = $this->config->item('accesscontrol')[$this->auth['role_code']];
		}
		
	}
}

?>