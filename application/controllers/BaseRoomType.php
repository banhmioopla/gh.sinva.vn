<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BaseRoomType extends CustomBaseStep {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ghBaseRoomType');
		$this->load->model('ghActivityTrack');
	}

	public function show(){
        $data['list_baseroomtype'] = $this->ghBaseRoomType->getAll();
		/*--- Load View ---*/
		$this->load->view('components/header', ['menu' => $this->menu]);
		$this->load->view('base-room-type/show', $data);
		$this->load->view('components/footer');
	}

	public function create() {
	
		$data = $this->input->post();
		if(empty($data['active'])) {
			$data['active'] = 'NO';
		}

		if(!empty($data['name'])) {
			$result = $this->ghBaseRoomType->insert($data);
			$this->session->set_flashdata('fast_notify', [
				'message' => 'Tạo <strong>'.$data['name'].'<strong> thành công ',
				'status' => 'success'
			]);
			return redirect('admin/list-room-type');
		}
	}

	// Ajax
	public function update() {
		$room_type_id = $this->input->post('baseroomtype_id');
		$field_value = $this->input->post('field_value');
		$field_name = $this->input->post('field_name');
		if(!empty($room_type_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];

			$result = $this->ghBaseRoomType->updateById($room_type_id, $data);
			echo json_encode(['status' => $result]); die;
		}
		echo json_encode(['status' => false]); die;
	}

	public function updateEditable() {
		$room_type_id = $this->input->post('pk');
		$field_name = $this->input->post('name');
		$field_value = $this->input->post('value');

		if(!empty($room_type_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];

			$old_roomtype = $this->ghBaseRoomType->getById($room_type_id);
			$old_log = json_encode($old_roomtype[0]);
			
			$result = $this->ghBaseRoomType->updateById($room_type_id, $data);
			
			$modified_roomtype = $this->ghBaseRoomType->getById($room_type_id);
			$modified_log = json_encode($modified_roomtype[0]);
			
			$log = [
				'table_name' => 'gh_base_room_type',
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
		$Room_type_id = $this->input->post('room_type_id');
		if(!empty($Room_type_id)) {
			$old_roomtype = $this->ghBaseRoomType->getById($room_type_id);

			$log = [
				'table_name' => 'gh_base_room_type',
				'old_content' => null,
				'modified_content' => json_encode($old_roomtype[0]),
				'time_insert' => time(),
				'action' => 'delete'
			];

			// call model
			$tracker = $this->ghActivityTrack->insert($log);
			$result = $this->ghBaseRoomType->delete($room_type_id);
			
			if($result > 0) {
				echo json_encode(['status' => true]); die;
			}
			echo json_encode(['status' => false]); die;
		}
		echo json_encode(['status' => false]); die;
	}

	public function getEditableRoomTypeId(){
        $room = $this->ghBaseRoomType->get( ['active' => 'YES']);
        $result = [];
        foreach($room as $item) {
            $result[] = ["value" => $item['id'], "text" => $item["name"]];
        }
        echo json_encode($result); die;
    }

}

/* End of file BaseRoomType.php */
/* Location: ./application/controllers/role-manager/BaseRoomType.php */