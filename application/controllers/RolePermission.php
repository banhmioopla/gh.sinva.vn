<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RolePermission extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ghRolePermission');
		$this->load->model('ghRole');
		$this->load->model('ghActivityTrack');
		$this->load->library('libControllerList');
	}
	public function index()
	{
		$this->show();
    }

	public function showtest(){
        $data['list_role_permission'] = $this->ghRolePermission->getAll();
        $data['list_role'] = $this->ghRole->getByActive();
        $data['list_permission'] = $this->libcontrollerlist->getControllers();
		/*--- Load View ---*/
		$this->load->view('components/header');
		$this->load->view('role-permission/show', $data);
		$this->load->view('components/footer');
	}

	public function show() { // detail page

		$role_id = $this->input->get('role-id');
		$permission_role_model = $this->ghRolePermission->getByRoleId($role_id);
		$role_model = $this->ghRole->getById($role_id);
		if(!empty($role_model)) {
			$data['list_role_permission'] = $this->ghRolePermission->getAll();
			$data['role'] = $role_model;
			$data['list_permission'] = $this->libcontrollerlist->getControllers();
			$data['permission_role_model'] = $permission_role_model;
			$this->load->view('components/header');
			$this->load->view('role-permission/show', $data);
			$this->load->view('components/footer');
		}
	}

	// Ajax
	public function update() {
		$role_id = $this->input->post('role_id');
		$flag = $this->input->post('flag');
		$controller_name = $this->input->post('controller_name');
		$action_name = $this->input->post('action_name');

		if(!empty($role_id)) {
			$data = [
				'permission_controller' => $controller_name,
				'permission_action' => $action_name,
				'role_id' => $role_id
			];
			if(!empty($flag)) {
				$result = $this->ghRolePermission->insert($data);
			}
			else {
				$result = $this->ghRolePermission->delete($data);
			}
			
			if($result) {
				echo json_encode(['status' => true]); die;
			}
			echo json_encode(['status' => false]); die;
			
		}
		echo json_encode(['status' => false]); die;
	}

	public function updateEditable() {
		$role_permission_id = $this->input->post('pk');
		$field_name = $this->input->post('name');
		$field_value = $this->input->post('value');

		if(!empty($role_permission_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];

			$old_role_permission = $this->ghRolePermission->getById($role_permission_id);
			$old_log = json_encode($old_role_permission[0]);
			
			$result = $this->ghRolePermission->updateById($role_permission_id, $data);
			
			$modified_role = $this->ghRolePermission->getById($role_permission_id);
			$modified_log = json_encode($modified_role[0]);
			
			$log = [
				'table_name' => 'gh_role_permission',
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
		$role_permission_id = $this->input->post('role_permission_id');
		if(!empty($role_id)) {
			$old_role_permission = $this->ghRolePermission->getById($role_id);

			$log = [
				'table_name' => 'gh_role_permission',
				'old_content' => null,
				'modified_content' => json_encode($old_role_permission[0]),
				'time_insert' => time(),
				'action' => 'delete'
			];

			// call model
			$tracker = $this->ghActivityTrack->insert($log);
			$result = $this->ghRolePermission->delete($role_permission_id);
			
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