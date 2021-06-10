<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apartment extends CustomBaseStep {

	public function __construct()
	{
		parent::__construct(); 
		$this->load->model(['ghApartment','ghNotification', 'ghContract', 'ghDistrict',
            'ghApartmentPromotion',
            'ghTag', 'ghApartmentComment', 'ghConsultantBooking', 'ghBaseRoomType']);
		$this->load->config('label.apartment');
		$this->load->helper('money');
		$this->load->library('LibDistrict', null, 'libDistrict');
		$this->load->library('LibPartner', null, 'libPartner');
		$this->load->library('LibRoom', null, 'libRoom');
		$this->load->library('LibBaseApartmentType', null, 'libBaseApartmentType');
		$this->load->library('LibBaseRoomType', null, 'libBaseRoomType');
		$this->load->library('LibTag', null, 'libTag');
		$this->load->library('LibUser', null, 'libUser');
		$this->load->library('LibApartment', null, 'libApartment');
		$this->load->library('LibCustomer', null, 'libCustomer');
	}

	public function showNotificaton(){}

	public function show(){

		$data = [];
        if(count($this->list_district_CRUD) == 0) {
            $this->load->view('components/header');
            $this->load->view('apartment/error');
            $this->load->view('components/footer');
            return;
        }

        $district_code = $this->input->get('district-code');
		$district_code = !empty($district_code) ? $district_code: $this->list_district_CRUD[0];
		$params = [
            'district_code' => $district_code,
            'active' => 'YES'
        ];

		$data['district_code'] = $district_code;
		$data['consultant_booking'] = $this->ghConsultantBooking->get(['time_booking > ' => strtotime(date('d-m-Y'))]);

		$data['contract_noti'] = $this->ghNotification->get();
		
		$data['list_district'] = $this->ghDistrict->getListLimit($this->auth['account_id']);
		$data['list_ward'] = $this->ghRoom->getWardByDistrict($district_code);
		$list_apartment = $this->ghApartment->get($params);

		$data['cb_district'] = $this->libDistrict->cbActive();
		$data['apartment_today'] = [];
		$data['list_gadget_around'] = [];
		$data['apartment_cur_week'] = $this->ghApartment->get(['time_update >' => strtotime('last Monday') ,'active' => 'YES']);

		$data['list_apartment'] = [];
		foreach($list_apartment as $item) {
			if($this->input->get('apmTag') && !$this->input->get('apmTag') == $item['tag_id']) {
                continue;
            }

            if($this->input->get('rangeTime') == 'Today') {
                if($item['time_update'] < strtotime(date('d-m-Y')) || $item['time_update'] > strtotime(date('d-m-Y')) +86399){
                    continue;
                }
            }

            $data['list_apartment'][] = $item;
		}

		$template = 'apartment/show-full-permission';

		if(!$this->editable) {
			$template =  'apartment/show-version-2';
		}

		$data['product_total'] = count($this->ghApartment->get(['district_code' => $district_code, 'active' => 'YES']));

		$data['room_total'] = $this->ghRoom->getNumberByDistrict($district_code, null);
		$data['available_room_total'] = $this->ghRoom->getNumberByDistrict($district_code, 'gh_room.status = "Available" ');

		$data['ready_room_total'] = $this->ghRoom->getNumberByDistrict($district_code, 'gh_room.time_available > 0 ');

		$data['list_ready_room_type'] = $this->ghRoom->getTypeByDistrict($district_code, 'gh_room.time_available > 0 ');
		$data['list_available_room_type'] = $this->ghRoom->getTypeByDistrict($district_code, 'gh_room.status = "Available" ');
		$data['list_available_room_price'] = $this->ghRoom->getPriceByDistrict($district_code, 'gh_room.status = "Available" ');
        $data['list_price'] = $this->ghRoom->getPriceList('gh_room.status = "Available" ', 'gh_room.price');
        $data['list_type'] = $this->ghRoom->getTypeByDistrict();
		/*--- bring library to view ---*/
		$data['libDistrict'] = $this->libDistrict;
		$data['label_apartment'] =  $this->config->item('label.apartment');
		$data['libRoom'] =  $this->libRoom;
		$data['libBaseRoomType'] =  $this->libBaseRoomType;
		$data['libTag'] = $this->libTag;
		$data['libPartner'] = $this->libPartner;
		$data['libUser'] = $this->libUser;
		$data['ghRoom'] = $this->ghRoom;
		$data['ghBaseRoomType'] = $this->ghBaseRoomType;
		$data['ghApartmentComment'] = $this->ghApartmentComment;
		$data['ghApartmentPromotion'] = $this->ghApartmentPromotion;
		$data['libApartment'] = $this->libApartment;
		/*--- Load View ---*/
		$this->load->view('components/header');
		$this->load->view($template, $data);
		$this->load->view('components/footer');
	}


	public function editDescription(){
	    $apm_id = $this->input->get('id');
	    $apm = $this->ghApartment->getFirstById($apm_id);
	    if(isset($_POST['submit'])){
            $description = $this->input->post('description');
            $test = $this->ghApartment->updateById($apm_id, [
                'description' => $description,
                'time_update' => time()
            ]);
            $apm = $this->ghApartment->getFirstById($apm_id);
            $this->session->set_flashdata('fast_notify', [
                'message' => 'Cập Nhật Mô Tả Thành Công',
                'status' => 'success'
            ]);
        }


        $this->load->view('components/header');
        $this->load->view('apartment/edit-description', [
            'apartment' => $apm,
        ]);
        $this->load->view('components/footer');
    }

	public function showV2(){
		$district_code = $this->input->get('district-code');
		$data = [];
		$district_code = !empty($district_code) ? $district_code: null;
		if(count($this->list_district_CRUD) == 0) {
            $this->load->view('components/header');
            $this->load->view('apartment/error');
            $this->load->view('components/footer');
		    return;
        }
        if(empty($district_code)) {
            return redirect('/admin/list-apartment?district-code='.$this->list_district_CRUD[0]);
        }

		$data['district_code'] = $district_code;
		$data['consultant_booking'] = $this->ghConsultantBooking->get(['time_booking > ' => strtotime(date('d-m-Y'))]);

		$data['contract_noti'] = $this->ghNotification->get();

		$data['list_district'] = $this->ghDistrict->getListLimit($this->auth['account_id']);
		$data['list_ward'] = $this->ghRoom->getWardByDistrict($district_code);
		$data['list_apartment'] = $this->ghApartment->get(['district_code' => $district_code, 'active' => 'YES']);

		$data['cb_district'] = $this->libDistrict->cbActive();
		$data['apartment_today'] = [];
		$data['list_gadget_around'] = [];
		$data['apartment_cur_week'] = $this->ghApartment->get(['time_update >' => strtotime('last Monday') ,'active' => 'YES']);
		foreach($data['list_apartment'] as $item) {
			if(date('d') == date('d', $item['time_update'])) {
				$data['apartment_today'][] = $item;
			}
		}
		$template = 'apartment/show-full-permission';

		if(!$this->editable) {
			$template =  'apartment/show-version-2';
		}

		$data['product_total'] = count($this->ghApartment->get(['district_code' => $district_code, 'active' => 'YES']));

		$data['room_total'] = $this->ghRoom->getNumberByDistrict($district_code, null);
		$data['available_room_total'] = $this->ghRoom->getNumberByDistrict($district_code, 'gh_room.status = "Available" ');

		$data['ready_room_total'] = $this->ghRoom->getNumberByDistrict($district_code, 'gh_room.time_available > 0 ');

		$data['list_ready_room_type'] = $this->ghRoom->getTypeByDistrict($district_code, 'gh_room.time_available > 0 ');
		$data['list_available_room_type'] = $this->ghRoom->getTypeByDistrict($district_code, 'gh_room.status = "Available" ');
		$data['list_available_room_price'] = $this->ghRoom->getPriceByDistrict($district_code, 'gh_room.status = "Available" ');
        $data['list_price'] = $this->ghRoom->getPriceList('gh_room.status = "Available" ', 'gh_room.price');
        $data['list_type'] = $this->ghRoom->getTypeByDistrict();
		/*--- bring library to view ---*/
		$data['libDistrict'] = $this->libDistrict;
		$data['label_apartment'] =  $this->config->item('label.apartment');
		$data['libRoom'] =  $this->libRoom;
		$data['libBaseRoomType'] =  $this->libBaseRoomType;
		$data['libTag'] = $this->libTag;
		$data['libPartner'] = $this->libPartner;
		$data['libUser'] = $this->libUser;
		$data['ghRoom'] = $this->ghRoom;
		$data['ghBaseRoomType'] = $this->ghBaseRoomType;
		$data['ghApartmentComment'] = $this->ghApartmentComment;
		$data['libApartment'] = $this->libApartment;
		/*--- Load View ---*/
		$this->load->view('components/header', ['menu' => $this->menu]);
		$this->load->view($template, $data);
		$this->load->view('components/footer');
	}


	public function showEdit(){
	    $apm_id = $this->input->get('id');
	    $apartment = $this->ghApartment->getFirstById($apm_id);
	    $list_room = $this->ghRoom->get(['active' => 'YES']);
        $cb_district = $this->libDistrict->cbActive();
        $data['cb_partner'] = $this->libPartner->cbActive();
        $data['cb_tag'] = $this->libPartner->cbActive();
        $this->load->view('components/header');
        $this->load->view('apartment/show-edit', [
            'apartment' => $apartment,
            'list_room' => $list_room,
            'cb_district' => $cb_district,
            ''
        ]);
        $this->load->view('components/footer');
    }

    public function showDetail(){
        $apm_id = $this->input->get('id');
        $apartment = $this->ghApartment->getFirstById($apm_id);
        $list_room = $this->ghRoom->get(['active' => 'YES']);
        $this->load->view('components/header');
        $this->load->view('apartment/show-edit', [
            'apartment' => $apartment,
            'list_room' => $list_room,
            'cb_partner' => $this->libPartner->cbActive(),
        ]);
        $this->load->view('components/footer');
    }

	public function showBySearch(){
        $params['gh_apartment.active = '] = '"YES"';

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

        if($this->input->get('roomType') ) {
            $params['type ='] = "'".$this->input->get('roomType')."'";
        }

        if($this->input->get('roomStatus') ) {
            $params['status ='] = "'".$this->input->get('roomStatus')."'";
        }

        if($this->input->get('roomTimeAvailable') ) {
            $params['time_available >='] = strtotime($this->input->get('roomTimeAvailable'));
        }



        if($this->input->get('roomAreaMax')) {
            $params['area <='] = $this->input->get('roomAreaMax');
        }

        if($this->input->get('roomDistrict') ) {
            $params['gh_apartment.district_code ='] = "'".$this->input->get('roomDistrict')."'";
        }

        if($this->input->get('roomWard') ) {
            $params['gh_apartment.address_ward ='] = "'".$this->input->get('roomWard')."'";
        }


	    $data['ghApartment'] = $this->ghApartment;
        $data['list_price'] = $this->ghRoom->getPriceList('gh_room.status = "Available" ', 'gh_room.price');
	    $data['list_data'] = $this->ghRoom->getBySearch($params);
        $data['list_district'] = $this->ghDistrict->getListLimit($this->auth['account_id']);
        $data['list_type'] = $this->ghRoom->getTypeByDistrict();
        $data['list_ward'] = $this->ghRoom->getWardByDistrict($this->input->get('roomDistrict'));
	    $data['libRoom'] = $this->libRoom;
	    $data['libDistrict'] = $this->libDistrict;
	    $data['ghBaseRoomType'] = $this->ghBaseRoomType;
        $data['label_apartment'] =  $this->config->item('label.apartment');
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
		$data['libUser'] = $this->libUser;
		$data['cb_user'] = $this->libUser->cb();
		/*--- Load View ---*/
		$this->load->view('components/header', ['menu' => $this->menu]);
		$this->load->view('apartment/show-like-base', $data);
		$this->load->view('components/footer');
	}


	public function showProfile(){
	    $id = $this->input->get('id');
	    $apartment = $this->ghApartment->getFirstById($id);

	    $list_room = $this->ghRoom->get(['apartment_id' => $id, 'active' => 'YES']);
	    $contract = $this->ghContract->get(['apartment_id' => $id]);

        $this->load->view('components/header');
        $this->load->view('apartment/show-profile', [
            'apartment' => $apartment,
            'list_room' => $list_room,
            'contract' => $contract,
            'libUser' => $this->libUser,
            'cbDistrictActive' => $this->libDistrict->cbActive(),
            'libCustomer' => $this->libCustomer,
            'label_apartment' =>  $this->config->item('label.apartment')
        ]);
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
			$data['time_insert'] = strlen($data['time_insert']) > 0 ? strtotime($data['time_insert']):null;
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
            if($field_name == 'time_insert' and !empty($field_value)){
                $data = [
                    'time_insert' => strtotime($field_value)
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

    public function getWard(){
        $list_ward = $this->ghRoom->getWardByDistrict($this->input->post('district'));
        $result = [];
        foreach($list_ward as $d) {
            $result[] = ["value" => $d['address_ward'], "text" => 'Ph. '.$d["address_ward"]];
        }
        echo json_encode($result); die;
    }

	public function getPartner(){
		$list_district = $this->ghPartner->getAll();
		$result = [];
		$result[] = ["value" => "", "text" => "Vui Lòng Chọn"];
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

    public function searchApartment(){
        $q = $this->input->get('q');
        $data = [['id' => 0, 'text' => 'Tìm dự án']];
        if(empty($q)) {
            $customer = $this->ghApartment->get(['active' => 'YES']);
            if($customer) {
                foreach($customer as $c){
                    $data[] = ['id' => $c['id'], 'text' => 'Quận '.$c['district_code']
                        .' | '.
                        $c['address_street']];
                }
            }

        } else {
            $customer = $this->ghApartment->getLike(['address_street' => $q]);
            if($customer) {
                foreach($customer as $c){
                    $data[] = ['id' => $c['id'], 'text' => 'Quận '.$c['district_code']
                        .' | '. $c['address_street']];
                }
            }

        }
        echo json_encode($data);
    }

}

/* End of file apartment.php */
/* Location: ./application/controllers/role-manager/apartment.php */