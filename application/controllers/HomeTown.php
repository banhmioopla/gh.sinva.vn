<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class HomeTown extends CustomBaseStep {
    public function show(){
        $this->load->view('components/home-town-header');
        $this->load->view('home-town/show', [
        ]);
        $this->load->view('components/footer');
    }
}