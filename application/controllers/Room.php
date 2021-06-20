<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Room extends CustomBaseStep {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ghRoom');
		$this->load->model('ghBaseRoomType');
		$this->load->model('ghApartment');
		$this->load->library('LibRoom', null, 'libRoom');
        $this->load->config('label.apartment');
	}

	public function show(){
        $data['list_room'] = $this->ghRoom->getAll();
		/*--- Load View ---*/
		$this->load->view('components/header');
		$this->load->view('room/show', $data);
		$this->load->view('components/footer');
	}

	

	public function create() {
	
		$data = $this->input->post();

        $data['time_update'] = time();
        $data['time_insert'] = time();

        if($data['time_available']) {
            $data['time_available'] = strtotime( $data['time_available']);
        }

        if(isset($data['room_type_id'])) {
            $data['room_type_id'] = json_encode($data['room_type_id']);
        }

        $result = $this->ghRoom->insert($data);
        $this->session->set_flashdata('fast_notify', [
            'message' => 'Tạo <strong>'.$data['name'].'<strong> thành công ',
            'status' => 'success'
        ]);
        return redirect('/admin/room/show-create?apartment-id='.$this->input->get('apartment-id'));
	}

    public function syncStatusRoom(){
        $list_apartment = $this->ghApartment->get(['active' => 'YES']);
        foreach ($list_apartment as $apartment) {
            $list_room = $this->ghRoom->get(['active' => 'YES', 'time_available' => strtotime(date('d-m-Y'))]);
            foreach ($list_room as $room) {
                $this->ghRoom->updateById($room['id'], ['status' => 'Available']);
            }
        }
        $this->session->set_flashdata('fast_notify', [
            'message' => 'Đồng Bộ Trạng Thái Phòng Thành Công',
            'status' => 'success'
        ]);
        return redirect($_SERVER['HTTP_REFERER']);
    }

	public function showCreate() {
        $apm_id = $this->input->get("apartment-id");
        $list_room = $this->ghRoom->get(['apartment_id' => $apm_id, 'active' => 'YES']);
        $apartment = $this->ghApartment->getFirstById($apm_id);

        $data = [
            'list_room' => $list_room,
            'apartment' => $apartment,
            'libRoom' => $this->libRoom,
            'ghBaseRoomType' => $this->ghBaseRoomType,
            'label_apartment' => $this->config->item('label.apartment'),
        ];

        $list_apm_temp = $this->ghApartment->get(['active' => 'YES']);
        $list_apm = [];
        foreach ($list_apm_temp as $apm ) {
            if(!in_array($apm['district_code'], $this->list_district_CRUD)) {
                continue;
            }

            $list_apm[] = $apm;
        }
        $data['list_apm'] = $list_apm;
        $this->load->view('components/header');
        $this->load->view('room/showCreate', $data);
        $this->load->view('components/footer');
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

	public function fastUpdate() {
	    $post = $this->input->post();
	    $list_room = $this->ghRoom->get(['apartment_id' => $post['apartment_id'], 'active' => 'YES']);

	    $list_room_code = $post['room_code']; // [code => price]

        $counter = 0;
        $arr_room_id = [];
	    foreach ($list_room as $item) {
	        foreach ($list_room_code as $index => $room) {
	            if(strtolower(trim($item['code'])) == strtolower(trim($room['code']))) {
	                if(!in_array($item['id'], $arr_room_id)) {
                        $result = $this->ghRoom->updateById($item['id'], [
                            'price' => $room['price'],
                            'time_update' => time()
                        ]);
                        if($result) {
                            $counter++;
                        }
                        $arr_room_id[] = $item['id'];
                    }
                }
            }
        }
        echo json_encode(['status' => true, 'msg' => 'Đã Cập Nhật Thành Công '.$counter . ' Phòng, Vui lòng F5 để tận hưởng Kết Quả' ]); die;
    }

	public function updateEditable() {
		$room_id = $this->input->post('pk');
		$field_name = $this->input->post('name');
		$field_value = $this->input->post('value');

		if(!empty($room_id) and !empty($field_name)) {
			$data = [
				$field_name => $field_value
			];
            if($field_name == 'room_type_id') {
                $data = [
                    $field_name => json_encode($field_value)
                ];
            }

			if($field_name == 'time_available') {
                $field_value = str_replace('/', '-', $field_value);
				$data = [
					$field_name => $field_value ? strtotime($field_value):null
				];
			}
			if($field_name == 'type_id') {
				$data = [
					$field_name => implode(',', $field_value)
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
				'action' => 'update',
                'user_id' => $this->auth['account_id']
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
				'modified_content' => json_encode($old_room[0]),
				'time_insert' => time(),
				'action' => 'delete',
                'user_id' => $this->auth['account_id']
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
			var_dump($this->input->post());die;
			return die($this->updateEditable()); 
		}
		echo json_encode($result); die;
	}

	public function getStatus() {
		$list_status = [
			['id' => 'Available', 'text' => 'trống'],
			['id' => 'Full', 'text' => 'đã thuê'],
			['id' => 'Consulting', 'text' => 'đang tư vấn'],
			['id' => 'Deposited', 'text' => 'đã cọc'],

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