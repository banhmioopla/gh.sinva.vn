<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contract extends CustomBaseStep {
	private $access_control;
	public function __construct()
	{
		parent::__construct();
		$permission_roles = [
			'admin',
			'customer-care',
		];

		if(!in_array($this->auth['role_code'], $permission_roles)) {
			return redirect('admin/list-apartment');
		}

		$this->load->model('ghContract');
		$this->load->model('ghRoom');
		$this->load->model('ghApartment');
		$this->load->model('ghCustomer');
		$this->load->library('LibCustomer', null, 'libCustomer');
		$this->load->library('LibDistrict', null, 'libDistrict');
		$this->load->library('LibUser', null, 'libUser');
	}
	public function index()
	{
		$this->show();
    }

	public function show(){
		$this->load->model('ghContract'); // load model ghUser
		$data['list_contract'] = $this->ghContract->getAll();
		$data['libCustomer'] = $this->libCustomer;
		$data['libUser'] = $this->libUser;
		$data['ghApartment'] = $this->ghApartment;
		/*--- Load View ---*/
		$this->load->view('components/header',['menu' =>$this->menu]);
		$this->load->view('contract/show', $data);
		$this->load->view('components/footer');
	}

	public function createShow(){
		$room_id = $this->input->get('room-id');
		$data['room'] = $this->ghRoom->get(['id' =>$room_id])[0];
		$data['apartment'] = $this->ghApartment->get(['id' =>$data['room']['apartment_id']])[0];
		$data['select_customer'] = $this->libCustomer->cb();
		$data['select_user'] = $this->libUser->cb();
		$data['libDistrict'] = $this->libDistrict;
		
		/*--- Load View ---*/
		$this->load->view('components/header',['menu' =>$this->menu]);
		$this->load->view('contract/create-show', $data);
		$this->load->view('components/footer');
	}

	public function detailShow(){
		$contract_id = $this->input->get('id');
		$model = $this->ghContract->get(['id' => $contract_id])[0];
		$data['contract'] = $model;
		$data['libCustomer'] = $this->libCustomer;
		$data['libUser'] = $this->libUser;
		$data['ghApartment'] = $this->ghApartment;
		$this->load->view('components/header',['menu' =>$this->menu]);
		$this->load->view('contract/detail-show', $data);
		$this->load->view('components/footer');
	}

	public function create() {
	
		$post = $this->input->post();
		if($post['time_open']) {
			$dt = DateTime::createFromFormat('d/m/Y', $post['time_open']);
			$post['time_open'] = $dt->getTimestamp();
		} else {
			$post['time_open'] = 0;
		}
		if(!$post['customer_name']) {
			$customer_id = $this->ghCustomer->insert(
				[
					'name' => $post['customer_name_new'],
					'status' => 'sinva-rented',
				]);
		} else {
			$customer_id = $post['customer_name'];
			$customer_model = $this->ghCustomer->updateById($customer_id, [
				'status' => 'sinva-rented'
			]);
		}
		
		$service_set = $this->ghRoom->get(['id' =>$post['room_id']])[0];
		$contract = [
			'customer_id' => $customer_id,
			'room_id' => $post['room_id'],
			'apartment_id' => $service_set['apartment_id'],
			'consultant_id' => $post['consultant_id'],
			'room_price' => $post['room_price'] > 0 ? 
					(int) filter_var($post["room_price"], FILTER_SANITIZE_NUMBER_INT) 
						: $service_set['price'],
			'time_check_in' => $post['time_open'],
			'number_of_month' => $post['number_of_month'],
			'service_set' => json_encode($service_set),
			'status' => $post['status'],
			'note' => $post['note']
		];
		$result = $this->ghContract->insert($contract);
        $this->session->set_flashdata('fast_notify', [
            'message' => 'Tạo hợp đồng thành công ',
            'status' => 'success'
        ]);
        return redirect('admin/list-contract');
	}

	// Ajax
	public function update() {
		$contract_id = $this->input->post('contract_id');
		$field_value = $this->input->post('field_value');
		$field_name = $this->input->post('field_name');
		if(!empty($contract_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];
			$result = $this->ghContract->updateById($contract_id, $data);
			echo json_encode(['status' => $result]); die;
		}
		echo json_encode(['status' => false]); die;
	}

	public function updateEditable() {
		$contract_id = $this->input->post('pk');
		$field_name = $this->input->post('name');
		$field_value = $this->input->post('value');

		if(!empty($contract_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];

			$old_contract = $this->ghContract->getById($contract_id);
			$old_log = json_encode($old_contract[0]);
			
			$result = $this->ghContract->updateById($contract_id, $data);
			
			$modified_contract = $this->ghContract->getById($contract_id);
			$modified_log = json_encode($modified_contract[0]);
			
			$log = [
				'table_name' => 'gh_contract',
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
		$contract_id = $this->input->post('contract_id');
		if(!empty($contract_id)) {
			$old_contract = $this->ghContract->getById($contract_id);

			$log = [
				'table_name' => 'gh_contract',
				'old_content' => null,
				'modified_content' => json_encode($old_contract[0]),
				'time_insert' => time(),
				'action' => 'delete'
			];

			// call model
			$tracker = $this->ghActivityTrack->insert($log);
			$result = $this->ghContract->delete($contract_id);
			
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