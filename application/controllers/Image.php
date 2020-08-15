<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image extends CustomBaseStep {
    public function __construct()
	{
		parent::__construct();
		$this->load->model('ghDistrict');
		$this->load->model('ghApartment');
    }
    
    public function show() {

        
        $data = [];

        $apartment_id = $this->input->get('apartment-id');
        
        if(isset($apartment_id) and !empty($apartment_id)) {
            
            $apartment_model = $this->ghApartment->getById($apartment_id);
            $list_room = $this->ghRoom->getByApartmentId($apartment_id);
            
            if(!empty($apartment_model)) {
                $data['apartment_model'] = $apartment_model[0];
            }
            // var_dump($apartment_model); die;
        }

        $this->load->view('components/header', ['menu' => $this->menu]);
        $this->load->view('media/apartment/show', $data);
        $this->load->view('components/footer');
    }
}

?>