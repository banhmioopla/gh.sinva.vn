<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CustomBaseStep {
	public $access_role;
	public $modify_role;
	public $is_modify;
	private $is_view_all;
	private $no_update_D = ['Sar', 'Sun'];
	public function __construct()
	{
		parent::__construct();
		
		// Check permission
		$this->access_role = ['product-manager', 'ceo', 'cpo', 'cfo', 'cco'];
		$this->access_view_all_role = ['ceo', 'cpo', 'cfo', 'cco'];
		$this->modify_role = ['product-manager'];
		$this->is_modify = in_array($this->auth['role_code'], $this->modify_role) ? true:false;
		$this->is_access = in_array($this->auth['role_code'], $this->access_role) ? true:false;
		$this->is_view_all = in_array($this->auth['role_code'], $this->access_view_all_role) ? true:false;
		if(!$this->is_access) {
			return redirect('admin/list-apartment');
		}

        $this->load->model('ghBookingCustomer');
        $this->load->model('ghApartment');
        $this->load->model('ghDistrict');
        $this->load->model('ghRoom');
		$this->load->library('LibDistrict', null, 'libDistrict');
		$this->load->config('report_user_district');
	}

	// THỐNG KÊ DẪN KHÁCH
	public function showBookingCustomer() { 	
		$district_data = [];
		$list_apartment = [];
		$list_district = [];
		if(isset($this->config->item('report_user_district')[$this->auth['account_id']])) {
			$config_report = $this->config->item('report_user_district')[$this->auth['account_id']];
			if($config_report['list_district']) {
				$set_district = implode(",",$config_report['list_district']);
				$list_apartment = $this->ghApartment->getByDistrictReport($set_district);
			} else {
				return redirect('admin/list-apartment');
			}
			$list_district = $config_report['list_district'];
		}
		
		
		if($this->is_view_all) {
			$list_apartment = $this->ghApartment->get(['active= "YES"']);
			$district_model = $this->ghDistrict->get(['active= "YES"']);
			foreach($district_model as $d) {
				$list_district[] = $d['code'];
			}
		}
		foreach($list_district as $d) {
			$district_data[$d]['sum_available'] = 0;
			$district_data[$d]['sum_ready_room'] = 0;
		}
		$data['list_data'] = null;
        foreach($list_apartment as $item ) {
			$report = $this->ghBookingCustomer->getCurrentWeek($item['id']);
			if(!$report and $this->is_modify){
				$new_report['user_id'] = $this->auth['account_id'];
				$new_report['apartment_id'] = $item['id'];
				$new_report['time_report'] = strtotime('this saturday');
				$new_report['apartment_address_street'] = $item['address_street'];
				$new_report['apartment_address_ward'] = $item['address_ward'];
				$new_report['apartment_district_code'] = $item['district_code'];
				$new_report['number_of_book'] = 0;
				$new_report['number_of_deposit'] = 0;
				$new_report['number_of_contract'] = 0;
				$new_report['issue'] = null;
				$new_report['recommendation'] = null;
				$new_report['number_of_available_room'] = $this->ghRoom->getNumberByStatus($item['id'], 'Available');
				$ready_room = $this->ghRoom->get([
					'active' => 'YES',
					'apartment_id' => $item['id'],
					'time_available > ' => 0
				]);
				$new_report['number_of_ready_room'] = $ready_room ? count($ready_room[0]): 0;
				$new_report['id'] = $this->ghBookingCustomer->insert($new_report);

				$data['list_data'][] = $new_report;
				$district_data[$new_report['apartment_district_code']]['sum_available'] += $new_report['number_of_available_room'];
				$district_data[$new_report['apartment_district_code']]['sum_ready_room'] += $new_report['number_of_ready_room'];
				unset($new_report['id']);
			}
			if($report) {
				$today = date('D', time());
				if(!in_array($today, $this->no_update_D)) {
					$number_of_available_room = $this->ghRoom->getNumberByStatus($report['apartment_id'], 'Available');
					$ready_room = $this->ghRoom->get([
						'active' => 'YES',
						'apartment_id' => $report['apartment_id'],
						'time_available > ' => 0
					]);
					$number_of_ready_room =  $ready_room ? count($ready_room[0]): 0;
					$this->ghBookingCustomer->updateById($report['id'], [
						'number_of_available_room' => $number_of_available_room,
						'number_of_ready_room' => $number_of_ready_room
					]);
				}

				$data['list_data'][] = $report;
				$district_data[$report['apartment_district_code']]['sum_available'] += $report['number_of_available_room'];
				$district_data[$report['apartment_district_code']]['sum_ready_room'] += $report['number_of_ready_room'];
				
			}
		}
		$data['label_apartment'] =  $this->config->item('label.apartment');
		$data['libDistrict'] = $this->libDistrict;
		$data['list_district'] = $list_district;
		$data['district_data'] = $district_data;
		/*--- Load View ---*/
		$this->load->view('components/header',['menu' =>$this->menu]);
		$this->load->view('report/show-booking-customer', $data);
		$this->load->view('components/footer');
	}

	public function createBookingCustomer() {
	
		$data = $this->input->post();
		
		$result = $this->ghBookingCustomer->insert($data);
		$this->session->set_flashdata('fast_notify', [
			'message' => 'Tạo baocao '.$data['id'].' thành công ',
			'status' => 'success'
		]);
		return redirect('admin/show-booking-customer');
	}

	public function updateEditableBookingCustomer(){
		$report_id = $this->input->post('pk');
		$field_name = $this->input->post('name');
		$field_value = $this->input->post('value');
		if(!empty($report_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];

			$old_district = $this->ghBookingCustomer->getById($report_id);
			$old_log = json_encode($old_district[0]);
			
			$result = $this->ghBookingCustomer->updateById($report_id, $data);
			
			$modified_district = $this->ghBookingCustomer->getById($report_id);
			$modified_log = json_encode($modified_district[0]);
			
			$log = [
				'table_name' => 'gh_booking_customer',
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

	// Ajax
	public function update() {
		$district_id = $this->input->post('district_id');
		$field_value = $this->input->post('field_value');
		$field_name = $this->input->post('field_name');
		if(!empty($district_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];
			$result = $this->ghBookingCustomer->updateById($district_id, $data);
			echo json_encode(['status' => $result]); die;
		}
		echo json_encode(['status' => false]); die;
	}

	public function updateEditable() {
		$district_id = $this->input->post('pk');
		$field_name = $this->input->post('name');
		$field_value = $this->input->post('value');

		if(!empty($district_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];

			$old_district = $this->ghBookingCustomer->getById($district_id);
			$old_log = json_encode($old_district[0]);
			
			$result = $this->ghBookingCustomer->updateById($district_id, $data);
			
			$modified_district = $this->ghBookingCustomer->getById($district_id);
			$modified_log = json_encode($modified_district[0]);
			
			$log = [
				'table_name' => 'gh_district',
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
    
    public function getAddress() {
        
    }

	public function delete(){
		$district_id = $this->input->post('district_id');
		if(!empty($district_id)) {
			$old_district = $this->ghBookingCustomer->getById($district_id);

			$log = [
				'table_name' => 'gh_district',
				'old_content' => null,
				'modified_content' => json_encode($old_district[0]),
				'time_insert' => time(),
				'action' => 'delete'
			];

			// call model
			$tracker = $this->ghActivityTrack->insert($log);
			$result = $this->ghBookingCustomer->delete($district_id);
			
			if($result > 0) {
				echo json_encode(['status' => true]); die;
			}
			echo json_encode(['status' => false]); die;
		}
		echo json_encode(['status' => false]); die;
	}

}

/* End of file Apartment.php */
/* Location: ./application/controllers/role-manager/Apartment.php */