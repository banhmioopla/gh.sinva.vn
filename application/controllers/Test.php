<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

	public function index()
	{
		
		$this->load->view('components/header');
		$this->load->view('v-sale/apartment/template-apartment', [
			'list_apartment' => [1,2,3,4,5]
		]);
		$this->load->view('components/footer');
	}

}

/* End of file Test.php */
/* Location: ./application/controllers/Test.php */