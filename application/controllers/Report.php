<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CustomBaseStep {

	public function __construct()
	{
		parent::__construct();//
        $this->load->model('ghBookingCustomer');
        $this->load->model('ghApartment');
        $this->load->library('LibDistrict', null, 'libDistrict');
        
	}
	public function index()
	{
		$this->show();
    }

	public function showBookingCustomer() { // thống kê dẫn khách

        $list_apartment = $this->ghApartment->getByUserDistrict($this->auth['account_id']);
		$project = [];
        foreach($list_apartment as $item ) {
			$report = $this->ghBookingCustomer->getCurrentWeek();
			if($report and $item) {
				$project[] = array_merge($item, $report);
			}
		}
		$data['project'] = $project;
		$data['label_apartment'] =  $this->config->item('label.apartment');
		$data['libDistrict'] = $this->libDistrict;
		
		/*--- Load View ---*/
		$this->load->view('components/header',['menu' =>$this->menu]);
		$this->load->view('report/show-booking-customer', $data);
		$this->load->view('components/footer');
	}

	public function create() {
	
		$data = $this->input->post();
		
		$result = $this->ghBookingCustomer->insert($data);
		$this->session->set_flashdata('fast_notify', [
			'message' => 'Tạo baocao '.$data['id'].' thành công ',
			'status' => 'success'
		]);
		return redirect('admin/show-booking-customer');
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