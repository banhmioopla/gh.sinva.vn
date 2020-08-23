<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Partner extends CustomBaseStep {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ghPartner');
		$this->load->model('ghActivityTrack');
	}
	public function index()
	{
		$this->show();
    }

	private function show(){
        $data['list_partner'] = $this->ghPartner->getAll();
		/*--- Load View ---*/
		$this->load->view('components/header', ['menu' =>$this->menu]);
		$this->load->view('partner/show', $data);
		$this->load->view('components/footer');
	}

	public function create() {
	
		$data = $this->input->post();
		if(empty($data['active'])) {
			$data['active'] = 'NO';
		}

		if(!empty($data['name'])) {
			$result = $this->ghPartner->insert($data);
			$this->session->set_flashdata('fast_notify', [
				'message' => 'Tạo đối tác: <strong>'.$data['name'].'<strong> thành công ',
				'status' => 'success'
			]);
			return redirect('admin/list-partner');
		}
	}

	// Ajax
	public function update() {
		$partner_id = $this->input->post('partner_id');
		$field_value = $this->input->post('field_value');
		$field_name = $this->input->post('field_name');

		if(!empty($partner_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];
			$result = $this->ghPartner->updateById($partner_id, $data);
			echo json_encode(['status' => $result]); die;
		}
		echo json_encode(['status' => false]); die;
	}

	public function updateEditable() {
		$partner_id = $this->input->post('pk');
		$field_name = $this->input->post('name');
		$field_value = $this->input->post('value');

		if(!empty($partner_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];

			$old_partner = $this->ghPartner->getById($partner_id);
			$old_log = json_encode($old_partner[0]);
			
			$result = $this->ghPartner->updateById($partner_id, $data);
			
			$modified_partner = $this->ghPartner->getById($partner_id);
			$modified_log = json_encode($modified_partner[0]);
			
			$log = [
				'table_name' => 'gh_partner',
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
		$partner_id = $this->input->post('partner_id');
		if(!empty($partner_id)) {
			$old_partner = $this->ghPartner->getById($partner_id);

			$log = [
				'table_name' => 'gh_partner',
				'old_content' => null,
				'modified_content' => json_encode($old_partner[0]),
				'time_insert' => time(),
				'action' => 'delete'
			];

			// call model
			$tracker = $this->ghActivityTrack->insert($log);
			$result = $this->ghPartner->delete($partner_id);
			
			if($result > 0) {
				echo json_encode(['status' => true]); die;
			}
			echo json_encode(['status' => false]); die;
		}
		echo json_encode(['status' => false]); die;
	}

}

/* End of file partner.php */
/* Location: ./application/controllers/role-manager/partner.php */