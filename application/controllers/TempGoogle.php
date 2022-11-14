<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TempGoogle extends CustomBaseStep {
	private $access_control;
	public function __construct()
	{
		parent::__construct();
	}

	public function show() {
        /*--- Load View ---*/
        $data =['list_linkdrive' => $this->json_to_arr(file_get_contents("application/config/data-resources/googledrive.json"))];
		$this->load->view('components/header');
		$this->load->view('temp-google/show', $data);
		$this->load->view('components/footer');
    }

    function json_to_arr( $json_string ){
		$json_string = preg_replace("#(/\*([^*]|[\r\n]|(\*+([^*/]|[\r\n])))*\*+/)|([\s\t]//.*)|(^//.*)#", '', $json_string);
		// print_r  (json_decode($json_string, true));
		return json_decode($json_string, true);
		
	}
    


}