<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Room extends CustomBaseStep {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ghRoom');
		$this->load->model('ghBaseRoomType');
	}
	public function index()
	{
		$this->show();
    }

	private function show(){
        $data['list_room'] = $this->ghRoom->getAll();
		/*--- Load View ---*/
		$this->load->view('components/header');
		$this->load->view('room/show', $data);
		$this->load->view('components/footer');
	}

	public function create() {
	
		$data = $this->input->post();
		if(!empty($data['name'])) {
			$data['time_update'] = time();
			$data['time_insert'] = time();
			$result = $this->ghRoom->insert($data);
			$this->session->set_flashdata('fast_notify', [
				'message' => 'Tạo <strong>'.$data['name'].'<strong> thành công ',
				'status' => 'success'
			]);
			return redirect('admin/list-room');
		}
	}

	public function createDatatable(){
		$data = $this->input->post();
		$data['time_update'] = time();
		$data['time_insert'] = time();
		$data['active'] = 'YES';
		$result = $this->ghRoom->insert($data);
		echo json_encode(['room_id' => $result]); die;
	}
	// Ajax
	public function update() {
		$room_id = $this->input->post('room_id');
		$field_value = $this->input->post('field_value');
		$field_name = $this->input->post('field_name');

		if(!empty($room_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];
			$data['time_update'] = time();

			$result = $this->ghRoom->updateById($room_id, $data);
			echo json_encode(['status' => $result]); die;
		}
		echo json_encode(['status' => false]); die;
	}

	public function updateEditable() {
		$room_id = $this->input->post('pk');
		$field_name = $this->input->post('name');
		$field_value = $this->input->post('value');

		if(!empty($room_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];

			if($field_name == 'time_available') {
				$data = [
					$field_name => strtotime($field_value)
				];
			}
			$data['time_update'] = time();

			$old_room = $this->ghRoom->getById($room_id);
			$old_log = json_encode($old_room[0]);
		
			$result = $this->ghRoom->updateById($room_id, $data);
			
			$modified_room = $this->ghRoom->getById($room_id);
			$modified_log = json_encode($modified_room[0]);
			
			$log = [
				'table_name' => 'gh_room',
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
		$room_id = $this->input->post('room_id');
		if(!empty($room_id)) {
			$old_room = $this->ghRoom->getById($room_id);

			$log = [
				'table_name' => 'gh_room',
				'old_content' => null,
				'modified_content' => json_encode($old_roomtype[0]),
				'time_insert' => time(),
				'action' => 'delete'
			];

			// call model
			$tracker = $this->ghActivityTrack->insert($log);
			$result = $this->ghRoom->delete($room_id);
			
			if($result > 0) {
				echo json_encode(['status' => true]); die;
			}
			echo json_encode(['status' => false]); die;
		}
		echo json_encode(['status' => false]); die;
	}

	public function getType() {
		$list_type = $this->ghBaseRoomType->getAll();
		$result = [];
		foreach($list_type as $type) {
			$result[] = ["value" => $type['id'], "text" => $type["name"]];
		}
		$pk = $this->input->post('pk');
		if(isset($pk)) {
			return die($this->updateEditable()); 
		}
		echo json_encode($result); die;
	}

	public function getStatus() {
		$list_status = [
			['id' => 'Available', 'text' => 'trống'],
			['id' => 'Full', 'text' => 'đã thuê'],
			['id' => 'Consulting', 'text' => 'đang dắt khách']
		];
		$result = [];
		foreach($list_status as $status) {
			$result[] = ["value" => $status['id'], "text" => $status["text"]];
		}
		$pk = $this->input->post('pk');
		if(isset($pk)) {
			return die($this->updateEditable()); 
		}
		echo json_encode($result); die;
	}
	public function getPrice() {
		$this->load->model('ghBasePrice');
		$list_price = $this->ghBasePrice->getAll();
		$result [] =  ["value" => 0, "text" => 'chọn giá...'];
		foreach($list_price as $type) {
			$result[] = ["value" => $type['id'], "text" => $type["name"]];
		}
		$pk = $this->input->post('pk');
		if(isset($pk)) {
			return die($this->updateEditable()); 
		}
		echo json_encode($result); die;
	}


}

/* End of file BaseRoomType.php */
/* Location: ./application/controllers/role-manager/BaseRoomType.php */