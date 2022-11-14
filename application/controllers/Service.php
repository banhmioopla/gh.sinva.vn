<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CustomBaseStep {
	private $access_control;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ghService');
	}

	public function show(){
		$this->load->model('ghService'); // load model ghUser
		$data['list_service'] = $this->ghService->getAll();
		
		/*--- Load View ---*/
		$this->load->view('components/header');
		$this->load->view('service/show', $data);
		$this->load->view('components/footer');
	}

	public function create() {
	
		$data = $this->input->post();
		if(empty($data['active'])) {
			$data['active'] = 'NO';
		}

		if(!empty($data['name'])) {
			$result = $this->ghService->insert($data);
			$this->session->set_flashdata('fast_notify', [
				'message' => 'Tạo Danh Mục Phí '.$data['name'].' thành công ',
				'status' => 'success'
			]);
			return redirect('admin/list-service');
		}
	}

	// Ajax
	public function update() {
		$service_id = $this->input->post('service_id');
		$field_value = $this->input->post('field_value');
		$field_name = $this->input->post('field_name');
		if(!empty($service_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];
			$result = $this->ghService->updateById($service_id, $data);
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

			$old_district = $this->ghService->getById($district_id);
			$old_log = json_encode($old_district[0]);
			
			$result = $this->ghService->updateById($district_id, $data);
			
			$modified_district = $this->ghService->getById($district_id);
			$modified_log = json_encode($modified_district[0]);
			
			$log = [
				'table_name' => 'gh_service',
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
		$district_id = $this->input->post('service_id');
		if(!empty($district_id)) {
			$old_district = $this->ghDistrict->getById($district_id);

			$log = [
				'table_name' => 'gh_service',
				'old_content' => null,
				'modified_content' => json_encode($old_district[0]),
				'time_insert' => time(),
				'action' => 'delete'
			];

			// call model
			$tracker = $this->ghActivityTrack->insert($log);
			$result = $this->ghDistrict->delete($district_id);
			
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