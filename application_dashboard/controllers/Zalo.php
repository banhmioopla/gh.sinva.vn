<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zalo extends CI_Controller
{
    private $access_control;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ghApartment');
        $this->load->model('ghDistrict');
        $this->load->model('ghRoom');
        $this->load->model('ghBaseRoomType');
    }

    public function sendApi(){
        http_response_code(200);
        return;
    }
}