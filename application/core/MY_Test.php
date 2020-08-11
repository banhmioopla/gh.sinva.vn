<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Test extends CI_Controller {
    public $accesscontrol;
    public function __construct()
	{
		parent::__construct();
        $this->access_control = $this->config->item('accesscontrol')['admin'];
        $this->load->model('ghActivityTrack');
	}
}