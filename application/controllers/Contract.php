<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contract extends CustomBaseStep {
	private $access_control;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ghContract');
		$this->load->model('ghRoom');
		$this->load->model('ghApartment');
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

	public function create() {
	
		$data = $this->input->post();

		$result = $this->ghContract->insert($data);
        $this->session->set_flashdata('fast_notify', [
            'message' => 'Tạo hợp đồng '.$data['name'].' thành công ',
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