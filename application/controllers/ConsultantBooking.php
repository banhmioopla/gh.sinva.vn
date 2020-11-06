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

	public function showAllTimeLine(){}

	public function showYour(){
		return $this->ghConsultantBooking->get(['time_booking > ' => strtotime('last monday'), 'booking_user_id' =>$this->auth['account_id']]);
	}

	public function syncPendingToSuccess() {
	    return $this->ghConsultantBooking->syncPendingToSuccess();
    }

	public function show(){
		
		$data['list_booking'] = $this->ghConsultantBooking->get(['time_booking > ' => 0]);
		$data['title_1'] = "Lượt dẫn của tất cả thành viên";
        $this->syncPendingToSuccess();
        $time_from = strtotime('last monday');
        $time_to = time();
		if($this->isYourPermission($this->current_controller, 'showAllTimeLine')) {

            if($this->input->get('filterTime') == 'TODAY'){
                $time_from = strtotime(date('d-m-Y'));
                $time_to = time();

            }

            if($this->input->get('filterTime') == 'THIS_WEEK'){
                $time_from = strtotime('last monday');
                $time_to = time();
            }

            if($this->input->get('filterTime') == 'LAST_WEEK'){
                $time_from = strtotime(date('d-m-Y', strtotime('last monday'. ' - 7days')));
                $time_to = strtotime('last sunday');
            }
            $data['list_booking'] = $this->ghConsultantBooking->get(['time_booking >= ' => $time_from, 'time_booking <= ' => $time_to]);
		}
		if($this->isYourPermission($this->current_controller, 'showYour')) {
			$data['list_booking'] = $this->showYour();
			$data['title_1'] = "Lượt dẫn của tôi tuần hiện tại từ". date('d/m/Y', $time_from);
		} 
		$data['list_booking_this_week'] = $this->ghConsultantBooking->getGroupByUserId($time_from, $time_to);

		$list_district = $this->ghDistrict->get(['active' => 'YES']);
		$district_counter_booking = [];

		$quantity['booking_district'] = 0;
		$quantity['booking_district_max'] = 0;
		$quantity['booking_apm'] = 0;
		$data['label_apartment'] = $this->config->item('label.apartment');
		$data['select_district'] = $this->libDistrict->cbActive();
		foreach($list_district as $d){
			$district_counter_booking[$d['code']] = 0;
		}
		foreach($list_district as $d){
			$district_counter_booking[$d['code']] += count(
				$this->ghConsultantBooking->get(
					['district_code' =>$d['code'],
					'time_booking >= ' => $time_from,
					'time_booking <= ' => $time_to]
                )
            );

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

	public function getRoomId() {
		$apartment_id = $this->input->get('apartment_id');
		$room = $this->ghRoom->get(['apartment_id' => $apartment_id, 'active' => 'YES']);
		$result = [];
		foreach($room as $item) {
			$result[] = ["value" => $item['id'], "text" => $item["code"] . ' - '. $item["price"]];
		}
		$pk = $this->input->post('pk');
		if(isset($pk)) {
			return die($this->updateEditable()); 
		}
		echo json_encode($result); die;
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
		} else {
			$this->session->set_flashdata('fast_notify', [
				'message' => 'Vui lòng chọn ngày dẫn khách',
				'status' => 'danger'
			]);
			return redirect('admin/list-consultant-booking?apartment-id='.$post['apartment_id'].'&district-code='.$post['district_code'].'&mode=create');
		}
		if($post['customer_id'] > 0) {
			$data['customer_id'] = $post['customer_id'];
			if($this->auth['role_code'] !== 'customer-care') {
				$update_customer = ['test_mode' => '[YES,'.$this->auth['name'].']'];
				$customer_model = $this->ghCustomer->updateById($data['customer_id'], $update_customer);
			}
			
		} else {
			if(empty($post['phone_number']) || empty($post['customer_name'])) {
				$this->session->set_flashdata('fast_notify', [
					'message' => 'Vui lòng nhập số điện thoại, Tên khách hàng nếu bạn dẫn khách mới',
					'status' => 'danger'
				]);
				return redirect('admin/list-consultant-booking?apartment-id='.$post['apartment_id'].'&district-code='.$post['district_code'].'&mode=create');
			}

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
			$customer['test_mode'] = 'YES';
			$data['customer_id'] = $this->ghCustomer->insert($customer);
		}

		$data['apartment_id'] = $post['apartment_id'];
		$data['booking_user_id'] = $this->auth['account_id'];
		$data['time_booking'] = $post['time_booking'];
		$data['room_id'] = isset($post['room_id']) ? json_encode($post['room_id']):'[]';
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

			if($field_name == 'room_id') {
				$field_value = json_encode($field_value);
			}
			$data = [
				$field_name => $field_value
			];
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