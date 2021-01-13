<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apartment extends CustomBaseStep {

	public function __construct()
	{
		parent::__construct(); 
		$this->load->model(['ghApartment','ghNotification', 'ghDistrict', 'ghTag', 'ghApartmentComment', 'ghConsultantBooking']);
		$this->load->config('label.apartment');
		$this->load->helper('money');
		$this->load->library('LibDistrict', null, 'libDistrict');
		$this->load->library('LibPartner', null, 'libPartner');
		$this->load->library('LibRoom', null, 'libRoom');
		$this->load->library('LibBaseApartmentType', null, 'libBaseApartmentType');
		$this->load->library('LibBaseRoomType', null, 'libBaseRoomType');
		$this->load->library('LibTag', null, 'libTag');
		$this->load->library('LibUser', null, 'libUser');

		$this->permission_modify = ['product-manager', 'business-manager'];
	}

	public function showNotificaton(){}

	public function show(){
		$district_code = $this->input->get('district-code');
		$data = [];
		$district_code = !empty($district_code) ? $district_code: $this->district_default;

		if(count($this->list_district_CRUD) == 0) {
		    echo  "<strong>Bạn cần được chia quận!</strong>"; return;
        }
		
		$data['district_code'] = $district_code;
		$data['consultant_booking'] = $this->ghConsultantBooking->get(['time_booking > ' => strtotime(date('d-m-Y'))]);

		$data['contract_noti'] = $this->ghNotification->get();
		
		$data['list_district'] = $this->ghDistrict->getListLimit($this->auth['account_id']);
		$data['list_apartment'] = $this->ghApartment->get(['district_code' => $district_code, 'active' => 'YES']);

		$data['cb_district'] = $this->libDistrict->cbActive();
		$data['apartment_today'] = [];
		$data['apartment_cur_week'] = $this->ghApartment->get(['time_update >' => strtotime('last Monday') ,'active' => 'YES']);
		foreach($data['list_apartment'] as $item) {
			if(date('d') == date('d', $item['time_update'])) {
				$data['apartment_today'][] = $item;
			}
		}
		$template = 'apartment/show-full-permission';
		if(in_array($district_code, $this->list_district_view_only)) {
			$template =  'apartment/show';
		}

		$data['product_total'] = count($this->ghApartment->get(['district_code' => $district_code, 'active' => 'YES']));

		$data['room_total'] = $this->ghRoom->getNumberByDistrict($district_code, null);
		$data['available_room_total'] = $this->ghRoom->getNumberByDistrict($district_code, 'gh_room.status = "Available" ');

		$data['ready_room_total'] = $this->ghRoom->getNumberByDistrict($district_code, 'gh_room.time_available > 0 ');

		$data['list_ready_room_type'] = $this->ghRoom->getTypeByDistrict($district_code, 'gh_room.time_available > 0 ');
		$data['list_available_room_type'] = $this->ghRoom->getTypeByDistrict($district_code, 'gh_room.status = "Available" ');
		$data['list_available_room_price'] = $this->ghRoom->getPriceByDistrict($district_code, 'gh_room.status = "Available" ');
        $data['list_price'] = $this->ghRoom->getPriceList('gh_room.status = "Available" ', 'gh_room.price');
		/*--- bring library to view ---*/
		$data['libDistrict'] = $this->libDistrict;
		$data['label_apartment'] =  $this->config->item('label.apartment');
		$data['libRoom'] =  $this->libRoom;
		$data['libBaseRoomType'] =  $this->libBaseRoomType;
		$data['libTag'] = $this->libTag;
		$data['libPartner'] = $this->libPartner;
		$data['libUser'] = $this->libUser;
		$data['ghRoom'] = $this->ghRoom;
		$data['ghApartmentComment'] = $this->ghApartmentComment;
		/*--- Load View ---*/
		$this->load->view('components/header', ['menu' => $this->menu]);
		$this->load->view($template, $data);
		$this->load->view('components/footer');
	}

	public function showBySearch(){
        $roomPriceMin = 0;
        $roomPriceMax = 7000000;

        $params['price <='] = $roomPriceMax;
        $params['price >='] = $roomPriceMin;
        $params['gh_room.active = '] = '"YES"';
        $params['gh_room.status = '] = '"Available"';

        if($this->input->get('roomPriceMin')) {
            $roomPriceMin = $this->input->get('roomPriceMin');
            $params['price >='] = $roomPriceMin;
        }

        if($this->input->get('roomPriceMax')) {
            $roomPriceMax = $this->input->get('roomPriceMax');
            $params['price <='] = $roomPriceMax;
        }

        if($this->input->get('roomAreaMin') ) {
            $params['area >='] = $this->input->get('roomAreaMin');
        }



        if($this->input->get('roomAreaMax')) {
            $params['area <='] = $this->input->get('roomAreaMax');
        }

        if($this->input->get('roomDistrict') ) {
            $params['gh_apartment.district_code ='] = $this->input->get('roomDistrict');
        }


	    $data['ghApartment'] = $this->ghApartment;
        $data['list_price'] = $this->ghRoom->getPriceList('gh_room.status = "Available" ', 'gh_room.price');
	    $data['list_data'] = $this->ghRoom->getBySearch($params);
        $data['list_district'] = $this->ghDistrict->getListLimit($this->auth['account_id']);
	    $data['libRoom'] = $this->libRoom;
        $this->load->view('components/header', ['menu' => $this->menu]);
        $this->load->view('showbysearch/room', $data);
        $this->load->view('components/footer');
    }

	public function createComment() {
		$post  = $this->input->post();
		$time = time();
		$data = [
			'content' => $post['content'],
			'apartment_id' => $post['apmId'],
			'user_id' => $post['accountId'],
			'time_insert' => $time,
		];

		$this->ghApartmentComment->insert($data);
		return json_encode([
		]);
	}

	public function createConsultantBooking(){
		$post  = $this->input->post();
		
		if($post['time']) {
			if(empty($post['time'])) {
				$post['time'] = null;
			} else {
				$post['time'] = str_replace('/', '-', $post['time']);
				$post['time'] = strtotime((string)$post['time']);
			}
		}

		$data = [
			'booking_user_id' => $this->auth['account_id'],
			'time_booking' => $post['time'],
			'room_id' => $post['roomId'],
			'status' => 'Pending'
		];
		$this->ghConsultantBooking->insert($data);
		return json_encode([
		]);
	}

	public function showLikeBase(){
		$data['list_apartment'] = $this->ghApartment->getByUserDistrict($this->auth['account_id']);
		$data['cb_district'] = $this->libDistrict->cbActive();
		$data['cb_partner'] = $this->libPartner->cbActive();
		$data['cb_tag'] = $this->libPartner->cbActive();
		$data['label_apartment'] =  $this->config->item('label.apartment');
		$data['libDistrict'] = $this->libDistrict;
		$data['libPartner'] = $this->libPartner;
		$data['libTag'] = $this->libTag;
		/*--- Load View ---*/
		$this->load->view('components/header', ['menu' => $this->menu]);
		$this->load->view('apartment/show-like-base', $data);
		$this->load->view('components/footer');
	}

	public function showCommmissionRate(){
		$data['list_apartment'] = $this->ghApartment->get(['active' => 'YES'], 'district_code ASC');
		$data['label_apartment'] =  $this->config->item('label.apartment');
		$data['libDistrict'] = $this->libDistrict;
		/*--- Load View ---*/
		$this->load->view('components/header', ['menu' => $this->menu]);
		$this->load->view('apartment/show-commission-rate', $data);
		$this->load->view('components/footer');
	}
	public function create() {
		$data = $this->input->post();

		if(!empty($data['address_street']) and !empty($data['district_code'])) {
			$data['time_update'] = time();
			$result = $this->ghApartment->insert($data);
			$this->session->set_flashdata('fast_notify', [
				'message' => 'Tạo dự án '.$data['address_street'].' thành công ',
				'status' => 'success'
			]);
			return redirect('admin/list-apartment-like-base');
		}
	}

	// Ajax
	public function update() {
		$apartment_id = $this->input->post('apartment_id');
		$field_value = $this->input->post('field_value');
		$field_name = $this->input->post('field_name');

		if(!empty($apartment_id) and !empty($field_value)) {
			$data['time_update'] = time();
			$data = [
				$field_name => $field_value
			];
			$result = $this->ghApartment->updateById($apartment_id, $data);
			echo json_encode(['status' => $result]); die;
		}
		echo json_encode(['status' => false]); die;
	}

	public function updateEditable() {
		$apartment_id = $this->input->post('pk');
		$field_name = $this->input->post('name');
		$field_value = $this->input->post('value');

		$mode = $this->input->post('mode');
		if(!empty($apartment_id) and !empty($field_name)) {
			$data = [
				$field_name => $field_value,
				'time_update' => time()
			];

			if(isset($mode) and $mode == 'del') {
				$inactive_room = $this->ghRoom->updateByApartmentId($apartment_id, ['active' => 'NO', 'time_update' => time()]);
			}
			
			if($field_name == '_reloadtime' and !empty($field_value)){
				$data = [
					'time_update' => time()
				];
			}
			$old_apartment = $this->ghApartment->getById($apartment_id);
			$old_log = json_encode($old_apartment[0]);
			
			$result = $this->ghApartment->updateById($apartment_id, $data);
			
			$modified_apartment = $this->ghApartment->getById($apartment_id);
			$modified_log = json_encode($modified_apartment[0]);
			
			$log = [
				'table_name' => 'gh_apartment',
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
		$apartment_id = $this->input->post('apartment_id');
		if(!empty($apartment_id)) {
			$old_apartment = $this->ghApartment->getById($apartment_id);

			$log = [
				'table_name' => 'gh_apartment_type',
				'old_content' => null,
				'modified_content' => json_encode($old_apartment[0]),
				'time_insert' => time(),
				'action' => 'delete'
			];

			// call model
			$tracker = $this->ghActivityTrack->insert($log);
			$result = $this->ghApartment->delete($old_apartment);
			
			if($result > 0) {
				echo json_encode(['status' => true]); die;
			}
			echo json_encode(['status' => false]); die;
		}
		echo json_encode(['status' => false]); die;
	}

	public function getDistrict(){
		$list_district = $this->ghDistrict->getAll();
		$result = [];
		foreach($list_district as $d) {
			$result[] = ["value" => $d['code'], "text" => 'quận '.$d["name"]];
		}
		$pk = $this->input->post('pk');
		if(isset($pk)) {
			return die($this->updateEditable()); 
		}
		echo json_encode($result); die;
	}

	public function getPartner(){
		$list_district = $this->ghPartner->getAll();
		$result = [];
		foreach($list_district as $d) {
			$result[] = ["value" => $d['id'], "text" => 'ĐT '.$d["name"]];
		}
		$pk = $this->input->post('pk');
		if(isset($pk)) {
			return die($this->updateEditable()); 
		}
		echo json_encode($result); die;
	}

	public function getTag(){
		
		$list_tag = $this->ghTag->getAll();
		$result[] = ["value" => 0, "text" => 'chọn ...'];
		foreach($list_tag as $tag) {
			$result[] = ["value" => $tag['id'], "text" => '#'.$tag["name"]];
		}
		$pk = $this->input->post('pk');
		if(isset($pk)) {
			return die($this->updateEditable()); 
		}
		echo json_encode($result); die;
	}

	public function dashboard() {
		$data['product_total'] = count($this->ghApartment->get(['active' => 'YES'])); 
		$data['available_room_total'] = count($this->ghRoom->get(['active' => 'YES', 'status' => 'Available']));
		$data['full_room_total'] = count($this->ghRoom->get(['active' => 'YES', 'status' => 'Full']));
		$data['list_district'] = [];
		/*--- Load View ---*/
		$this->load->view('components/header', ['menu' => $this->menu]);
		$this->load->view('apartment/dashboard', $data);
		$this->load->view('components/footer');
	}

}

/* End of file apartment.php */
/* Location: ./application/controllers/role-manager/apartment.php */