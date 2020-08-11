<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ghPermission');
		$this->load->model('ghActivityTrack');
		$this->load->model('ghRole');
		$this->load->library('libControllerList');
        // var_dump($this->libRole->getNameById(1)); die;
	}
	public function index()
	{
		$this->show();
    }

	private function show(){
		$data['auth'] = ['role_id' => 1];
		$role_model = $this->ghRole->getById($data['auth']['role_id'])[0];
        $data['auth'] = ['name' => $role_model['name']];
        $data['list_permission'] = $this->libcontrollerlist->getControllers();
		/*--- Load View ---*/
		$this->load->view('components/header');
		$this->load->view('permission/show', $data);
		$this->load->view('components/footer');
	}

	public function syncDb() {
	
		$data = $this->input->post();
		if(empty($data['active'])) {
			$data['active'] = 'NO';
		}

		if(!empty($data['name'])) {
			$result = $this->ghPermission->insert($data);
			// $this->session->set_flashdata('fast_notify', [
			// 	'message' => 'Tạo chức năng: <strong>'.$data['name'].'<strong> thành công ',
			// 	'status' => 'success'
			// ]);
			return redirect('admin/list-permission');
		}
	}

	// Ajax
	public function update() {
		$permission_id = $this->input->post('permission_id');
		$field_value = $this->input->post('field_value');
		$field_name = $this->input->post('field_name');

		if(!empty($permission_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];
			$result = $this->ghPermission->updateById($permission_id, $data);
			echo json_encode(['status' => $result]); die;
		}
		echo json_encode(['status' => false]); die;
	}

	public function updateEditable() {
		$permission_id = $this->input->post('pk');
		$field_name = $this->input->post('name');
		$field_value = $this->input->post('value');

		if(!empty($permission_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];

			$old_permission = $this->ghPermission->getById($permission_id);
			$old_log = json_encode($old_permission[0]);
			
			$result = $this->ghPermission->updateById($permission_id, $data);
			
			$modified_permission = $this->ghPermission->getById($permission_id);
			$modified_log = json_encode($modified_permission[0]);
			
			$log = [
				'table_name' => 'gh_permission',
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
		$permission_id = $this->input->post('permission_id');
		if(!empty($permission_id)) {
			$old_permission = $this->ghPermission->getById($permission_id);

			$log = [
				'table_name' => 'gh_permission',
				'old_content' => null,
				'modified_content' => json_encode($old_permission[0]),
				'time_insert' => time(),
				'action' => 'delete'
			];

			// call model
			$tracker = $this->ghActivityTrack->insert($log);
			$result = $this->ghPermission->delete($permission_id);
			
			if($result > 0) {
				echo json_encode(['status' => true]); die;
			}
			echo json_encode(['status' => false]); die;
		}
		echo json_encode(['status' => false]); die;
	}

}

/* End of file permission.php */
/* Location: ./application/controllers/permission-manager/permission.php */