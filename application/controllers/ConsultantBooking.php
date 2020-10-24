<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ConsultantBooking extends CustomBaseStep {
	private $access_control;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ghConsultantBooking');
		$this->load->model('ghApartment');
		$this->load->model('ghDistrict');
		$this->load->model('ghRoom');
		$this->load->library('LibUser', null, 'libUser');
		$this->load->library('LibDistrict', null, 'libDistrict');
	}
	public function index()
	{
		$this->show();
    }

	public function show(){
		$data['list_booking'] = $this->ghConsultantBooking->get(['time_booking >= ' => strtotime('last monday')]);
		$data['list_booking_this_week'] = $this->ghConsultantBooking->getGroupByUserId(strtotime('last monday'));
		$list_district = $this->ghDistrict->get(['active' => 'YES']);
		$district_counter_booking = [];

		$quantity['booking_district'] = 0;
		$quantity['booking_district_max'] = 0;
		$quantity['booking_apm'] = 0;
		foreach($list_district as $d){
			$district_counter_booking[$d['code']] = 0;
		}
		foreach($list_district as $d){
			$list_apm = $this->ghApartment->get(['district_code' => $d['code']]);
			if(count($list_apm) > 0) {
				foreach($list_apm as $apm) {
					$list_room = $this->ghRoom->get(['apartment_id' => $apm['id']]);
					if(count($list_room) >0) {
						foreach($list_room as $r) {
							$district_counter_booking[$d['code']] += count(
								$this->ghConsultantBooking->get(
									['room_id' => $r['id'], 
									'time_booking >= ' => strtotime('last monday')]));
						}
					}

				}
			} 

			if($district_counter_booking[$d['code']] > 0) {
				$quantity['booking_district']++;
				$quantity['booking_apm']++;
			}
		}
		$data['ghApartment'] = $this->ghApartment;
		$data['ghRoom'] = $this->ghRoom;
		$data['libDistrict'] = $this->libDistrict;
		$data['libUser'] = $this->libUser;
		$data['district_counter_booking'] = $district_counter_booking;
		$data['quantity'] = $quantity;
		/*--- Load View ---*/
		$this->load->view('components/header',['menu' =>$this->menu]);
		$this->load->view('consultantbooking/show', $data);
		$this->load->view('components/footer');
	}

}

/* End of file Apartment.php */
/* Location: ./application/controllers/role-manager/Apartment.php */