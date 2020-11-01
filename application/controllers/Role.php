<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CustomBaseStep {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ghRole');
		$this->load->model('ghActivityTrack');
	}

	public function show(){
		$data['list_role'] = $this->ghRole->get();
		/*--- Load View ---*/
		$this->load->view('components/header', ['menu' => $this->menu]);
		$this->load->view('role/show', $data);
		$this->load->view('components/footer');
	}

	public function notfound() {
		$this->load->view('components/header', ['menu' => $this->menu]);
		$this->load->view('role/notfound');
		$this->load->view('components/footer');
	}

	public function create() {
	
		$data = $this->input->post();
		if(empty($data['active'])) {
			$data['active'] = 'NO';
		}

		if(!empty($data['name'])) {
			$result = $this->ghRole->insert($data);
			$this->session->set_flashdata('fast_notify', [
				'message' => 'Tạo quyền: <strong>'.$data['name'].'<strong> thành công ',
				'status' => 'success'
			]);
			return redirect('admin/list-role');
		}
	}

	// Ajax
	public function update() {
		$role_id = $this->input->post('role_id');
		$field_value = $this->input->post('field_value');
		$field_name = $this->input->post('field_name');

		if(!empty($role_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];
			$result = $this->ghRole->updateById($role_id, $data);
			echo json_encode(['status' => $result]); die;
		}
		echo json_encode(['status' => false]); die;
	}

	public function updateEditable() {
		$role_id = $this->input->post('pk');
		$field_name = $this->input->post('name');
		$field_value = $this->input->post('value');

		if(!empty($role_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];

			$old_role = $this->ghRole->getById($role_id);
			$old_log = json_encode($old_role[0]);
			
			$result = $this->ghRole->updateById($role_id, $data);
			
			$modified_role = $this->ghRole->getById($role_id);
			$modified_log = json_encode($modified_role[0]);
			
			$log = [
				'table_name' => 'gh_role',
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
		$role_id = $this->input->post('role_id');
		if(!empty($role_id)) {
			$old_role = $this->ghRole->getById($role_id);

			$log = [
				'table_name' => 'gh_role',
				'old_content' => null,
				'modified_content' => json_encode($old_role[0]),
				'time_insert' => time(),
				'action' => 'delete'
			];

			// call model
			$tracker = $this->ghActivityTrack->insert($log);
			$result = $this->ghRole->delete($role_id);
			
			if($result > 0) {
				echo json_encode(['status' => true]); die;
			}
			echo json_encode(['status' => false]); die;
		}
		echo json_encode(['status' => false]); die;
	}

}

/* End of file role.php */
/* Location: ./application/controllers/role-manager/role.php */