<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApartmentImage extends CustomBaseStep {
    public function __construct()
	{
		parent::__construct();
		
    }
    
    public function show(){
        $apartment_id = $this->input->get('apartment-id');
    }
}