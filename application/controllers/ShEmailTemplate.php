<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ShEmailTemplate extends CustomBaseStep {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ghUser');
        $this->load->model('ghRole');
        $this->load->model('ghEmailTemplate');
        $this->load->library('LibEmail', null, 'libEmail');
    }

    public function show(){
        $data['list_template'] = $this->ghEmailTemplate->get();
        /*--- Load View ---*/
        $this->load->view('components/share-header');
        $this->load->view('sh-email-template/show', $data);
        $this->load->view('components/footer');
    }

    public function create(){

    }


}

/* End of file role.php */
/* Location: ./application/controllers/role-manager/role.php */