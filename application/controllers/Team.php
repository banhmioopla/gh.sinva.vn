<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Team extends CustomBaseStep {
	private $access_control;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ghTeam');
		$this->load->model('ghTeamUser');
        $this->load->library('LibUser', null, 'libUser');
	}

	public function show(){
		
		$data['list_team'] = $this->ghTeam->getAll();
		$data['list_leader'] = $this->libUser->cb();
		$data['libUser'] = $this->libUser;
		/*--- Load View ---*/
		$this->load->view('components/header');
		$this->load->view('team/show', $data);
		$this->load->view('components/footer');
	}

	public function detail(){
	    $id = $this->input->get('id');
	    $list_member = $this->ghTeamUser->get(['team_id' => $id]);
        $team = $this->ghTeam->getFirstById($id);
        /*--- Load View ---*/
        $this->load->view('components/header');
        $this->load->view('team/detail', [
            'list_member' => $list_member,
            'team' => $team,
            'libUser' => $this->libUser,
            'ghTeam' => $this->ghTeam,
            'list_user' => $this->libUser->cb()
        ]);
        $this->load->view('components/footer');
    }

	public function create() {
	
		$data = $this->input->post();
		if(!empty($data['name'])) {
			$result = $this->ghTeam->insert($data);
			$this->session->set_flashdata('fast_notify', [
				'message' => 'Tạo team '.$data['name'].' thành công ',
				'status' => 'success'
			]);
			return redirect('admin/list-team');
		}
	}

	public function createMember() {
	    $post = $this->input->post();
        $result = $this->ghTeamUser->insert($post);

        $this->session->set_flashdata('fast_notify', [
            'message' => 'Thêm thành viên '.$data['name'].' thành công ',
            'status' => 'success'
        ]);
        return redirect('admin/team/detail?id='.$post['team_id']);
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
			$result = $this->ghDistrict->updateById($district_id, $data);
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

			$old_district = $this->ghTeam->getFirstById($district_id);
			$old_log = json_encode($old_district);
			
			$result = $this->ghTeam->updateById($district_id, $data);
			
			$modified_district = $this->ghTeam->getFirstById($district_id);
			$modified_log = json_encode($modified_district);
			
			$log = [
				'table_name' => 'gh_team',
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
		$district_id = $this->input->post('district_id');
		if(!empty($district_id)) {
			$old_district = $this->ghDistrict->getById($district_id);

			$log = [
				'table_name' => 'gh_district',
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