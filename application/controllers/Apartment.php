<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apartment extends CustomBaseStep {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(['ghApartment', 'ghDistrict', 'ghTag']);
		$this->load->config('label.apartment');
		$this->load->helper('money');
		$this->load->library('LibDistrict', null, 'libDistrict');
		$this->load->library('LibPartner', null, 'libPartner');
		$this->load->library('LibRoom', null, 'libRoom');
		$this->load->library('LibBaseApartmentType', null, 'libBaseApartmentType');
		$this->load->library('LibBaseRoomType', null, 'libBaseRoomType');
		$this->load->library('LibTag', null, 'libTag');
	}
	public function index()
	{
		$this->show();
    }

	public function show(){
		
		$district_code = $this->input->get('district-code');
		$data = [];
		$district_code = !empty($district_code) ? $district_code: $this->district_default;
		
		$data['district_code'] = $district_code;
		
		$data['list_district'] = $this->ghDistrict->get(['active' => 'YES']);
		$data['list_apartment'] = $this->ghApartment->get(['district_code' => $district_code, 'active' => 'YES']);
		$data['cb_district'] = $this->libDistrict->cbActive();
		$data['cb_base_apartment_type'] = $this->libBaseApartmentType->getCbByActive();

		$template = 'apartment/show';
		if(in_array($district_code, $this->list_district_CRUD)) {
			$this->auth['modifymode'] = 'edit';
			$template = 'apartment/show-full-permission';
		}

		/*--- bring library to view ---*/
		$data['libDistrict'] = $this->libDistrict;
		$data['label_apartment'] =  $this->config->item('label.apartment');
		$data['libRoom'] =  $this->libRoom;
		$data['libBaseRoomType'] =  $this->libBaseRoomType;
		$data['libTag'] = $this->libTag;
		/*--- Load View ---*/
		$this->load->view('components/header', ['menu' => $this->menu]);
		$this->load->view($template, $data);
		$this->load->view('components/footer');
	}

	public function showLikeBase(){
		$data['list_apartment'] = $this->ghApartment->getAll();
		$data['cb_district'] = $this->libDistrict->cbActive();
		$data['cb_partner'] = $this->libPartner->cbActive();
		$data['cb_tag'] = $this->libPartner->cbActive();

		$data['libDistrict'] = $this->libDistrict;
		$data['libPartner'] = $this->libPartner;
		$data['libTag'] = $this->libTag;
		/*--- Load View ---*/
		$this->load->view('components/header', ['menu' => $this->menu]);
		$this->load->view('apartment/show-like-base', $data);
		$this->load->view('components/footer');
	}
	public function create() {
		$data = $this->input->post();

		if(!empty($data['address_street']) and !empty($data['district_code'])) {
			$result = $this->ghApartment->insert($data);
			$this->session->set_flashdata('fast_notify', [
				'message' => 'Tạo dự án '.$data['address_street'].' thành công ',
				'status' => 'success'
			]);
			return redirect('admin/list-apartment-like-base');
		}
	}

	// Ajax
	public function update() {
		$apartment_id = $this->input->post('apartment_id');
		$field_value = $this->input->post('field_value');
		$field_name = $this->input->post('field_name');

		if(!empty($apartment_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];
			$result = $this->ghApartment->updateById($apartment_id, $data);
			echo json_encode(['status' => $result]); die;
		}
		echo json_encode(['status' => false]); die;
	}

	public function updateEditable() {
		$apartment_id = $this->input->post('pk');
		$field_name = $this->input->post('name');
		$field_value = $this->input->post('value');

		$mode = $this->input->post('mode');

		if(!empty($apartment_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];

			if(isset($mode) and $mode == 'del') {
				$inactive_room = $this->ghRoom->updateByApartmentId($apartment_id, ['active' => 'NO']);
			}
			$old_apartment = $this->ghApartment->getById($apartment_id);
			$old_log = json_encode($old_apartment[0]);
			
			$result = $this->ghApartment->updateById($apartment_id, $data);
			
			$modified_apartment = $this->ghApartment->getById($apartment_id);
			$modified_log = json_encode($modified_apartment[0]);
			
			$log = [
				'table_name' => 'gh_apartment',
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
		$apartment_id = $this->input->post('apartment_id');
		if(!empty($apartment_id)) {
			$old_apartment = $this->ghApartment->getById($apartment_id);

			$log = [
				'table_name' => 'gh_apartment_type',
				'old_content' => null,
				'modified_content' => json_encode($old_apartmenttype[0]),
				'time_insert' => time(),
				'action' => 'delete'
			];

			// call model
			$tracker = $this->ghActivityTrack->insert($log);
			$result = $this->ghApartment->delete($apartment_type_id);
			
			if($result > 0) {
				echo json_encode(['status' => true]); die;
			}
			echo json_encode(['status' => false]); die;
		}
		echo json_encode(['status' => false]); die;
	}

	public function getDistrict(){
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

	public function getPartner(){
		$list_district = $this->ghPartner->getAll();
		$result = [];
		foreach($list_district as $d) {
			$result[] = ["value" => $d['id'], "text" => 'ĐT '.$d["name"]];
		}
		$pk = $this->input->post('pk');
		if(isset($pk)) {
			return die($this->updateEditable()); 
		}
		echo json_encode($result); die;
	}

	public function getTag(){
		
		$list_tag = $this->ghTag->getAll();
		$result[] = ["value" => 0, "text" => 'chọn ...'];
		foreach($list_tag as $tag) {
			$result[] = ["value" => $tag['id'], "text" => '#'.$tag["name"]];
		}
		$pk = $this->input->post('pk');
		if(isset($pk)) {
			return die($this->updateEditable()); 
		}
		echo json_encode($result); die;
	}

}

/* End of file apartment.php */
/* Location: ./application/controllers/role-manager/apartment.php */