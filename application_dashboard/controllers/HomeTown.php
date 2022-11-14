<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class HomeTown extends CustomBaseStep {
    public function show(){

        $this->load->view('components/header');
        $this->load->view('apartment/show-version-3');
        $this->load->view('components/footer');
    }
}