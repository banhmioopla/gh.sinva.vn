<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CustomBaseStep {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ghUser');
		$this->load->model('ghRole');
		$this->load->library('LibRole', null, 'libRole');
	}
	public function index()
	{
		$this->show();
    }

	private function show(){
		$data['list_user'] = $this->ghUser->getAll();
		$data['max_account_id'] = $this->ghUser->getMaxAccountId()[0]['account_id'];
		$data['libRole'] = $this->libRole;
		/*--- Load View ---*/
		$this->load->view('components/header', ['menu' => $this->menu]);
		$this->load->view('user/show', $data);
		$this->load->view('components/footer');
	}

	public function create() {
	
		$data = $this->input->post();
		$data['time_insert'] = $data['time_update'] = time();
		$data['password'] = $data['account_id'];
		$data['date_of_birth'] = strtotime($data['date_of_birth']);

		$result = $this->ghUser->insert($data);
		$this->session->set_flashdata('fast_notify', [
			'message' => 'Tạo thành viên: <strong>'.$data['account_id'].'<strong> thành công ',
			'status' => 'success'
		]);
		return redirect('admin/list-user');
	}

	// Ajax
	public function update() {
		$user_id = $this->input->post('user_id');
		$field_value = $this->input->post('field_value');
		$field_name = $this->input->post('field_name');

		if(!empty($user_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];
			$result = $this->ghUser->updateById($user_id, $data);
			echo json_encode(['status' => $result]); die;
		}
		echo json_encode(['status' => false]); die;
	}

	public function updateEditable() {
		$user_id = $this->input->post('pk');
		$field_name = $this->input->post('name');
		$field_value = $this->input->post('value');

		if(!empty($user_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];

			$old_user = $this->ghUser->getById($user_id);
			$old_log = json_encode($old_user[0]);
			
			$result = $this->ghUser->updateById($user_id, $data);
			
			$modified_user = $this->ghUser->getById($user_id);
			$modified_log = json_encode($modified_user[0]);
			
			$log = [
				'table_name' => 'gh_user',
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

	public function getRole() {
		$list_role = $this->ghRole->getAll();
		$result = [];
		foreach($list_role as $role) {
			$result[] = ["value" => $role['code'], "text" => $role["name"]];
		}
		$pk = $this->input->post('pk');
		if(isset($pk)) {
			return die($this->updateEditable()); 
		}
		echo json_encode($result); die;
	}

	public function delete(){
		$user_id = $this->input->post('user_id');
	
		if(!empty($user_id)) {
			$old_user = $this->ghUser->getById($user_id);
			// var_dump($old_user[0]); die;
			$log = [
				'table_name' => 'gh_user',
				'old_content' => null,
				'modified_content' => json_encode($old_user[0]),
				'time_insert' => time(),
				'action' => 'delete'
			];

			// call model
			$tracker = $this->ghActivityTrack->insert($log);
			$result = $this->ghUser->delete($user_id);
			
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