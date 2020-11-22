<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Story extends CustomBaseStep {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ghRoom');
        $this->load->model('ghBaseRoomType');
        $this->load->model('ghApartment');
    }

    public function show(){
        /*--- Load View ---*/
        $this->load->view('components/header', ['menu' => $this->menu]);
        $this->load->view('story/show');
        $this->load->view('components/footer');
    }


}

/* End of file BaseRoomType.php */
/* Location: ./application/controllers/role-manager/BaseRoomType.php */