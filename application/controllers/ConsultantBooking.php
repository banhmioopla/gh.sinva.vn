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
		$this->load->model('ghCustomer');
		$this->load->model('ghRoom');
		$this->load->library('LibUser', null, 'libUser');
		$this->load->library('LibDistrict', null, 'libDistrict');
		$this->load->library('LibCustomer', null, 'libCustomer');
		$this->load->config('label.apartment');
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
		$data['label_apartment'] =  $this->config->item('label.apartment');
		$data['select_district'] = $this->libDistrict->cbActive();
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
		$data['libCustomer'] = $this->libCustomer;
		$data['district_counter_booking'] = $district_counter_booking;
		$data['quantity'] = $quantity;
		/*--- Load View ---*/
		$this->load->view('components/header',['menu' =>$this->menu]);
		$this->load->view('consultantbooking/show', $data);
		$this->load->view('components/footer');
	}

	public function create(){
		$post = $this->input->post();
		
		if($post['time_booking']) {
			if(empty($post['time_booking'])) {
				$post['time_booking'] = null;
			} else {
				$post['time_booking'] = str_replace('/', '-', $post['time_booking']);
				$post['time_booking'] = strtotime((string)$post['time_booking']);
			}
		}
		if($post['customer_id'] > 0) {
			$data['customer_id'] = $post['customer_id'];
			
		} else {
			$customer['name'] = $post['customer_name'];
			$customer['gender'] = $post['gender'];
			$customer['birthdate'] = $post['birthdate'] ? strtotime(str_replace('/', '-', $post['birthdate'])) : 0;
			$customer['status'] = 'sinva-info-form';
			$customer['source'] = $post['source'];
			$customer['phone'] = $post['phone_number'];
			$customer['email'] = $post['email'];
			$customer['user_insert_id'] = $this->auth['account_id'];
			$customer['time_insert'] = time();
			$customer['demand_price'] = $post['demand_price'];
			$customer['demand_district_code'] = $post['demand_district_code'];
			$customer['demand_time'] = $post['demand_time'] ? strtotime(str_replace('/', '-', $post['demand_time'])) : 0;
			$data['customer_id'] = $this->ghCustomer->insert($customer);
		}

		$data['apartment_id'] = $post['apartment_id'];
		$data['booking_user_id'] = $this->auth['account_id'];
		$data['time_booking'] = $post['time_booking'];
		$data['room_id'] = $post['room_id'];
		$data['district_code'] = $post['district_code'];
		$data['status'] = 'Pending';
		$this->ghConsultantBooking->insert($data);

		redirect('/admin/list-consultant-booking');
	}

	public function updateEditable() {
		$customer_id = $this->input->post('pk');
		$field_name = $this->input->post('name');
		$field_value = $this->input->post('value');
		if(!empty($customer_id) and !empty($field_name)) {
			$data = [
				$field_name => $field_value
			];
			var_dump($data);
			$old_customer = $this->ghConsultantBooking->get(['id' => $customer_id]);
			$old_log = json_encode($old_customer[0]);

			$result = $this->ghConsultantBooking->updateById($customer_id, $data);
			
			$modified_customer = $this->ghConsultantBooking->get(['id' => $customer_id]);
			$modified_log = json_encode($modified_customer[0]);
			
			$log = [
				'table_name' => 'gh_consultant_booking',
				'old_content' => $old_log,
				'modified_content' => $modified_log,
				'time_insert' => time(),
				'action' => 'update'
			];
			$tracker = $this->ghActivityTrack->insert($log);

			echo json_encode(['status' => $result]); die;
		}
		echo json_encode(['status' => false]); die;
	}

}

/* End of file Apartment.php */
/* Location: ./application/controllers/role-manager/Apartment.php */