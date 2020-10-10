<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CustomBaseStep {
    public function __construct()
	{
		parent::__construct(); 
		$this->load->model(['ghApartment', 'ghDistrict', 'ghTag', 'ghCustomer', 'ghRoom', 'ghContract']);
		$this->load->config('label.apartment');
		$this->load->helper('money');
		$this->load->library('LibDistrict', null, 'libDistrict');
		$this->load->library('LibPartner', null, 'libPartner');
		$this->load->library('LibRoom', null, 'libRoom');
		$this->load->library('LibBaseApartmentType', null, 'libBaseApartmentType');
		$this->load->library('LibBaseRoomType', null, 'libBaseRoomType');
		$this->load->library('LibTag', null, 'libTag');
		$this->load->library('LibUser', null, 'libUser');

		$this->permission_modify = [['customer-care' => 0], 'product-manager'];
	}
    public function index() {
        $list_customer = $this->ghCustomer->get();
        $total_customer = $list_customer ? count($list_customer) : 0;

        $list_apartment = $this->ghApartment->get(['active' => 'YES']);
        $total_apartment = $list_apartment ? count($list_apartment) : 0;

        $list_room = $this->ghRoom->get(['active' => 'YES']);
        $total_room = $list_room ? count($list_room) : 0;
        
        $list_room_ready = $this->ghRoom->get(['time_available > ' => 0, 'active' => 'YES']);
        $total_room_ready = $list_room_ready ? count($list_room_ready) : 0;
        $list_room_available = $this->ghRoom->get(['status' => 'Available', 'active' => 'YES']);
        $total_room_available = $list_room_available ? count($list_room_available) : 0;

        $total_room_full = $total_room - $total_room_available;

        $list_contract = $this->ghContract->get();
        $total_contract = $list_contract ? count($list_contract) : 0;

        $data = [
            'total_customer' => $total_customer,
            'total_apartment' => $total_apartment,
            'total_room' => $total_room,
            'total_contract' => $total_contract,
            'total_room_ready' => $total_room_ready,
            'total_room_available' => $total_room_available,
            'total_room_full' => $total_room_full
        ];
        $this->load->view('components/header', ['menu' => $this->menu]);
        $this->load->view('dashboard/show', $data);
        $this->load->view('components/footer');
    }
}