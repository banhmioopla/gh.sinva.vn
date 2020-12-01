<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CustomBaseStep {
	public function __construct()
	{
		parent::__construct();
		$this->load->config('label.apartment');
		$this->load->model('ghCustomer');
		$this->load->model('ghCareCustomer');
		$this->load->model('ghContract');
		$this->load->model('ghApartment');
		$this->load->model('ghRoom');
		$this->load->library('LibDistrict', null, 'libDistrict');
		$this->load->library('LibCustomer', null, 'libCustomer');
		$this->load->library('LibUser', null, 'libUser');
		$this->load->library('LibRoom', null, 'libRoom');
		$this->load->config('label.apartment');
	}

	public function showYour(){
		return $data['list_customer'] = $this->ghCustomer->get(['user_insert_id' => $this->auth['account_id']]);
	}

	public function show(){
		
		$data['list_customer'] = $this->ghCustomer->getAll();
		if($this->isYourPermission($this->current_controller, 'showYour')) {
			$data['list_customer'] = $this->showYour();
		}
		$data['libDistrict'] = $this->libDistrict;
		$data['select_district'] = $this->libDistrict->cbActive();
		$data['label_apartment'] =  $this->config->item('label.apartment');
		/*--- Load View ---*/
		$this->load->view('components/header',['menu' =>$this->menu]);
		$this->load->view('customer/show', $data);
		$this->load->view('components/footer');
	}

	public function care() {
		$data['list_data'] = $this->ghCareCustomer->get(['user_id' => $this->auth['account_id']]);
		$data['list_contract'] = $this->ghContract->getAll();
		$data['libCustomer'] = $this->libCustomer;
		$data['libUser'] = $this->libUser;
		$data['ghApartment'] = $this->ghApartment;
		$data['libRoom'] = $this->libRoom;
		$data['label_apartment'] =  $this->config->item('label.apartment');
		/*--- Load View ---*/
		$this->load->view('components/header',['menu' =>$this->menu]);
		$this->load->view('customer/care', $data);
		$this->load->view('components/footer');
	}

	public function create() {
	
		$data = $this->input->post();
		$data['birthdate'] = $data['birthdate'] ? strtotime(str_replace('/', '-', $data['birthdate'])) : 0;
		$data['demand_time'] = $data['demand_time'] ? strtotime(str_replace('/', '-', $data['demand_time'])) : 0;

		if(!empty($data['name'])) {
			$data['status'] = 'sinva-info-form';
			$result = $this->ghCustomer->insert($data);
			$this->session->set_flashdata('fast_notify', [
				'message' => 'thêm khách hàng: '.$data['name'].' thành công ',
				'status' => 'success'
			]);
			return redirect('admin/list-customer');
		}
	}

	public function createCare() {
		$data = $this->input->post();
		$data['time_insert'] = time();
		$data['user_id'] = $this->auth['account_id'];
		if(!empty($data['customer_id'])) {
			$result = $this->ghCareCustomer->insert($data);
			$this->session->set_flashdata('fast_notify', [
				'message' => 'Tạo báo cáo chăm sóc thành công ',
				'status' => 'success'
			]);
			return redirect('admin/list-care-customer');
		}
	}

	// Ajax
	public function update() {
		$customer_id = $this->input->post('customer_id');
		$field_value = $this->input->post('field_value');
		$field_name = $this->input->post('field_name');
		if(!empty($customer_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];
			$result = $this->ghCustomer->updateById($customer_id, $data);
			echo json_encode(['status' => $result]); die;
		}
		echo json_encode(['status' => false]); die;
	}

	public function updateEditable() {
		$customer_id = $this->input->post('pk');
		$field_name = $this->input->post('name');
		$field_value = $this->input->post('value');
		if(!empty($customer_id) and !empty($field_name)) {
			$data = [
				$field_name => $field_value
			];

			$old_customer = $this->ghCustomer->getById($customer_id);
			$old_log = json_encode($old_customer[0]);
			if($field_name == 'birthdate') {
				$data['birthdate'] = $data['birthdate'] ? strtotime($data['birthdate']): 0;
			}

			if($field_name == 'demand_time') {
				$data['demand_time'] = $data['demand_time'] ? strtotime($data['demand_time']): 0;
			}

			$result = $this->ghCustomer->updateById($customer_id, $data);
			
			$modified_customer = $this->ghCustomer->getById($customer_id);
			$modified_log = json_encode($modified_customer[0]);
			
			$log = [
				'table_name' => 'gh_customer',
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

	public function delete(){
		$customer_id = $this->input->post('customer_id');
		if(!empty($customer_id)) {
			$old_customer = $this->ghCustomer->getById($customer_id);

			$log = [
				'table_name' => 'gh_customer',
				'old_content' => null,
				'modified_content' => json_encode($old_customer[0]),
				'time_insert' => time(),
				'action' => 'delete'
			];

			// call model
			$tracker = $this->ghActivityTrack->insert($log);
			$result = $this->ghCustomer->delete($customer_id);
			
			if($result > 0) {
				echo json_encode(['status' => true]); die;
			}
			echo json_encode(['status' => false]); die;
		}
		echo json_encode(['status' => false]); die;
	}

	public function getDistrict(){
		$this->load->model('ghDistrict');
		$list_district = $this->ghDistrict->getAll();
		$result = [];
		foreach($list_district as $d) {
			$result[] = ["value" => $d['code'], "text" => 'quận '.$d["name"]];
		}
		$pk = $this->input->post('pk');
		if(isset($pk)) {
			return die($this->updateEditable()); 
		}
		echo json_encode($result); die;
	}

	public function search(){
		$q = $this->input->get('q');
		$data = [['id' => 0, 'text' => 'tìm sdt']];
		if(empty($q)) {
			$customer = $this->ghCustomer->get();
			if($customer) {
				foreach($customer as $c){
					$data[] = ['id' => $c['id'], 'text' => $c['phone'] .' - '. $c['name']];
				}
			}
			
		} else {
			$customer = $this->ghCustomer->getLike(['phone' => $q, 'name' => $q]);
			if($customer) {
				foreach($customer as $c){
					$data[] = ['id' => $c['id'], 'text' => $c['phone'] .' - '. $c['name']];
				}
			}
			
		}
		echo json_encode($data);
	}


	public function detailShow(){
	    $id = $this->input->get('id');
        $data['label'] =  $this->config->item('label.apartment');
	    $data['customer'] = $this->ghCustomer->getById($id)[0];
        $data['ghCustomer'] = $this->ghCustomer;
        $this->load->view('components/header',['menu' =>$this->menu]);
        $this->load->view('customer/detail-show', $data);
        $this->load->view('components/footer');

    }


}

/* End of file Apartment.php */
/* Location: ./application/controllers/role-manager/Apartment.php */