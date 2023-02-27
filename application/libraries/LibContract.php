<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibCustomer {
	public $CI;
	public function __construct () {
		$this->CI =& get_instance();
		$this->CI->load->model('ghCustomer');
		$this->CI->load->library('session');
		$auth = $this->CI->session->userdata('auth');
		$this->list_customer_arr_id = $this->CI->ghCustomer->getCustomerOfConsultant($auth['account_id'])["arr_id"];
	}

	public function getStatusById(){

	}

	public function getCashInById(){

	}

	public function getCashOutById(){

	}

	public function getConfigCashFlow(){
		return json_encode([
			''
		]);
	}
}
?>
