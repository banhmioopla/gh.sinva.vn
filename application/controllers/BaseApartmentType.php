<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseApartmentType extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ghBaseApartmentType');
		$this->load->model('ghActivityTrack');
	}

	public function show(){
        $data['list_baseapartmenttype'] = $this->ghBaseApartmentType->getAll();
		/*--- Load View ---*/
		$this->load->view('components/header', ['menu' => $this->menu]);
		$this->load->view('base-apartment-type/show', $data);
		$this->load->view('components/footer');
	}

	public function create() {
	
		$data = $this->input->post();
		if(empty($data['active'])) {
			$data['active'] = 'NO';
		}

		if(!empty($data['name'])) {
			$result = $this->ghBaseApartmentType->insert($data);
			$this->session->set_flashdata('fast_notify', [
				'message' => 'Tạo '.$data['name'].' thành công ',
				'status' => 'success'
			]);
			return redirect('admin/list-apartment-type');
		}
	}

	// Ajax
	public function update() {
		$apartment_type_id = $this->input->post('apartment_type_id');
		$field_value = $this->input->post('field_value');
		$field_name = $this->input->post('field_name');

		if(!empty($apartment_type_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];
			$result = $this->ghBaseApartmentType->updateById($apartment_type_id, $data);
			echo json_encode(['status' => $result]); die;
		}
		echo json_encode(['status' => false]); die;
	}

	public function updateEditable() {
		$apartment_type_id = $this->input->post('pk');
		$field_name = $this->input->post('name');
		$field_value = $this->input->post('value');

		if(!empty($apartment_type_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];

			$old_apartmenttype = $this->ghBaseApartmentType->getById($apartment_type_id);
			$old_log = json_encode($old_apartmenttype[0]);
			
			$result = $this->ghBaseApartmentType->updateById($apartment_type_id, $data);
			
			$modified_apartmenttype = $this->ghBaseApartmentType->getById($apartment_type_id);
			$modified_log = json_encode($modified_apartmenttype[0]);
			
			$log = [
				'table_name' => 'gh_base_apartment_type',
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
		$apartment_type_id = $this->input->post('apartment_type_id');
		if(!empty($apartment_type_id)) {
			$old_apartmenttype = $this->ghBaseApartmentType->getById($apartment_type_id);

			$log = [
				'table_name' => 'gh_base_apartment_type',
				'old_content' => null,
				'modified_content' => json_encode($old_apartmenttype[0]),
				'time_insert' => time(),
				'action' => 'delete'
			];

			// call model
			$tracker = $this->ghActivityTrack->insert($log);
			$result = $this->ghBaseApartmentType->delete($apartment_type_id);
			
			if($result > 0) {
				echo json_encode(['status' => true]); die;
			}
			echo json_encode(['status' => false]); die;
		}
		echo json_encode(['status' => false]); die;
	}

}

/* End of file BaseApartmentType.php */
/* Location: ./application/controllers/role-manager/BaseApartmentType.php */