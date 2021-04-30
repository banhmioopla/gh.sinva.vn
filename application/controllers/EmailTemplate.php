<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmailTemplate extends CustomBaseStep {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ghUser');
        $this->load->model('ghRole');
        $this->load->library('LibRole', null, 'libRole');
        $this->load->library('LibEmail', null, 'libEmail');
    }

    public function show(){
        $data['list_template'] = $this->libEmail->getAllTemplate();
        /*--- Load View ---*/
        $this->load->view('components/header');
        $this->load->view('email-template/show', $data);
        $this->load->view('components/footer');
    }

    public function test() {
        $to_email = $this->auth['email'];
    }


}

/* End of file role.php */
/* Location: ./application/controllers/role-manager/role.php */