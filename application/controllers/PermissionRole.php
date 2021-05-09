<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PermissionRole extends CustomBaseStep {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ghPermission');
		$this->load->model('ghRole');
		$this->load->model('ghActivityTrack');
		$this->load->model('ghRole');
		$this->load->library('libControllerList');
	}

	public function show(){
		$data['controller'] = $this;
		$data['role_function'] = $this->ghRole->get(['code' => $this->input->get('role-code')])[0]['list_function'];
		$data['list_permission'] = $this->libcontrollerlist->getControllers();
		/*--- Load View ---*/
		$this->load->view('components/header', ['menu' =>$this->menu]);
		$this->load->view('permission/show', $data);
		$this->load->view('components/footer');
	}

	public function checkPermissionRole($controller = null, $action = null, $role_code = null) {
	
		$permission_controller_set = array_keys($role_function);
		$permission_action_set = $role_function[$controller];

		if(in_array($controller, $permission_controller_set) && in_array($action, $permission_action_set)) {
			return true;
		}
		return false;
	}


	// Ajax
	public function update() {
		$post = $this->input->post();
		$data = [
			'list_function' => json_encode($post)
		];
		$this->ghRole->updateByRoleCode($this->input->get('role-code'), $data);
		redirect('/admin/list-role');
	}

}

/* End of file permission.php */
/* Location: ./application/controllers/permission-manager/permission.php */