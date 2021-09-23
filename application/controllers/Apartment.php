<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apartment extends CustomBaseStep {

	public function __construct()
	{
		parent::__construct(); 
		$this->load->model(['ghApartment','ghNotification', 'ghContract', 'ghDistrict',
            'ghApartmentPromotion', 'ghApartmentRequest', 'ghApartmentView', 'ghConsultantBooking', 'ghApartmentShaft',
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

	public function showTrending(){
        $time_from = date('d-m-Y', strtotime('last monday'));
        $time_to = date('d-m-Y');

	    $view = $this->ghApartmentView->getNumberFromRangeTime(strtotime($time_from), strtotime($time_to) + 86399);

	    $booking = $this->ghConsultantBooking->getNumberFromRangeTime(strtotime($time_from), strtotime($time_to) + 86399);

        $arr_view = [];
	    foreach ($view as $v){
	        $apm = $this->ghApartment->getFirstById($v['apartment_id']);
	        if($apm) {
                $arr_view[$v['apartment_id']] = [
                    'apartment_address' => "<span class='text-purple'> "
                        ."Q.". $this->libDistrict->getNameByCode($apm['district_code'])
                        . ' | ' . $apm['address_street'] . " Ph. " . $apm['address_ward'] . "</span>",
                    'counter_view' => $v['counter']
                ];
            }
        }

        $arr_booking = [];
        foreach ($booking as $bb){
            $apm = $this->ghApartment->getFirstById($v['apartment_id']);
            if($apm) {
                $arr_booking[$v['apartment_id']] = [
                    'apartment_address' => "<span class='text-purple'> "
                        ."Q.". $this->libDistrict->getNameByCode($apm['district_code'])
                        . ' | ' . $apm['address_street'] . " Ph. " . $apm['address_ward'] . "</span>",
                    'counter_view' => $v['counter']
                ];
            }
        }

        $this->load->view('components/header');
        $this->load->view('apartment/explorer/trending',[
            'arr_view' => $arr_view,
            'arr_booking' => $arr_booking,
            'libUser' => $this->libUser,
            'ghApartment' => $this->ghApartment
        ]);
        $this->load->view('components/footer');
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

        $this->session->set_userdata(['current_district_code' => $district_code]);
		$data['district_code'] = $district_code;
		$data['consultant_booking'] = $this->ghConsultantBooking->get(['time_booking > ' => strtotime(date('d-m-Y'))]);

		$data['contract_noti'] = $this->ghNotification->get();
		
		$data['list_district'] = $this->ghDistrict->getListLimit($this->auth['account_id']);
		$data['list_ward'] = $this->ghRoom->getWardByDistrict($district_code);
        if(
            strlen($this->input->get('apmTag'))
            || strlen($this->input->get('rangeTime'))
        ){
            $params = ['active' => 'YES'];
        }

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
			    $flag_continue = false;
                if($item['time_update'] < strtotime(date('d-m-Y')) || $item['time_update'] > strtotime(date('d-m-Y')) +86399){
                    $flag_continue = true;
                }

                if($flag_continue) {
                    $list_room = $this->ghRoom->get([
                        'active' => 'YES',
                        'time_update >=' =>  strtotime(date('d-m-Y')),
                        'time_update <=' =>  strtotime(date('d-m-Y')) +86399,
                        'apartment_id' => $item['id'],
                    ]);

                    if(count($list_room) == 0) {
                        $flag_continue = true;
                    } else {
                        $flag_continue = false;
                    }
                }

                if($flag_continue) {
                    continue;
                }

            }

            $data['list_apartment'][] = $item;
		}

//		$template = 'apartment/show-full-permission';
        $template =  'apartment/show-version-2';
		/*if(!$this->editable) {
			$template =  'apartment/show-version-2';
		}*/

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
		$data['ghConsultantBooking'] = $this->ghConsultantBooking;
		$data['ghApartmentView'] = $this->ghApartmentView;
		$data['ghApartmentComment'] = $this->ghApartmentComment;
		$data['ghApartmentPromotion'] = $this->ghApartmentPromotion;
		$data['libApartment'] = $this->libApartment;
		$data['ghApartmentShaft'] = $this->ghApartmentShaft;
        $list_apm_temp = $this->ghApartment->get(['active' => 'YES']);
        $list_apm_ready = [];
        foreach ($list_apm_temp as $apm ) {
            if(!in_array($apm['district_code'], $this->list_district_CRUD)) {
                continue;
            }

            $list_apm_ready[] = $apm;
        }
        $data['list_apm_ready'] = $list_apm_ready;
		/*--- Load View ---*/
		$this->load->view('components/header');
		$this->load->view($template, $data);
		$this->load->view('components/footer');
	}

	public function pendingForApprove(){

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

        $list_room_search = $this->ghRoom->getBySearch($params);

        $arr_apartment_room = [];
        $arr_apartment_info = [];
        foreach ($list_room_search as $r){
            $type_arr = [];
            $list_type_id = json_decode($r['room_type_id'], true);
            if($list_type_id) {
                $js_list_type = implode(",", $list_type_id);
                if ($list_type_id && count($list_type_id) > 0) {
                    foreach ($list_type_id as $type_id) {
                        $typeModel = $this->ghBaseRoomType->getFirstById($type_id);
                        $type_arr[]= $typeModel['name'];
                    }
                }
            }

            $text_type_name = implode(", ",$type_arr );


            $status_txt = '<span class="badge badge-danger">Full</span>';
            if($r['status'] === 'Available'){
                $status_txt = '<span class="badge badge-success">Trống</span>';
            }

            $arr_apartment_room[$r['apartment_id']][] = [
                'room_id' => $r['id'],
                'room_code' => $r['code'],
                'room_price' => number_format($r['price']/1000),
                'room_type' => $text_type_name,
                'room_area' => $r['area'] . ' ㎡',
                'room_status' => $status_txt,
                'room_time_available' => $r['time_available'] > 0 ? date('d-m-Y', $r['time_available']) : '-',
            ];

            if(!isset($arr_apartment_info[$r['apartment_id']])){
                $apm_info = $this->ghApartment->getFirstById($r['apartment_id']);
                if($apm_info) {
                    $arr_apartment_info[$r['apartment_id']] = [
                        'apartment_id' => $r['apartment_id'],
                        'address' =>
                            "<span class='text-purple'> "
                            ."Q.". $this->libDistrict->getNameByCode($apm_info['district_code'])
                            . ' | ' . $apm_info['address_street'] . " Ph. " . $apm_info['address_ward'] . "</span>",
                        'district_code' => $this->libDistrict->getNameByCode($apm_info['district_code']),
                    ];
                }

            }
        }

        $this->load->view('components/header');
        $this->load->view('apartment/search-result', [
            'arr_apartment_info' => $arr_apartment_info,
            'arr_apartment_room' => $arr_apartment_room,
            'number_result' => count($list_room_search),
            'list_price' => $this->ghRoom->getPriceList('gh_room.status = "Available" ', 'gh_room.price'),
            'label_apartment' => $this->config->item('label.apartment'),
            'list_type' => $this->ghRoom->getTypeByDistrict(),
            'list_ward' => $this->ghRoom->getWardByDistrict($this->input->get('roomDistrict')),
            'list_district' => $this->ghDistrict->getListLimit($this->auth['account_id']),
            'ghApartment' => $this->ghApartment,
            'libRoom' => $this->libRoom,
        ]);
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
	    $list_col = $this->ghApartment->getListCol();


	    if(isset($_POST['submit'])) {
            $update_data = [
                'address_street' => $this->input->post('address_street'),
                'address_ward' => $this->input->post('address_ward'),
                'district_code' => $this->input->post('district_code'),
                'description' => $this->input->post('description'),
                'note' => $this->input->post('note'),
                'electricity' => $this->input->post('electricity'),
                'water' => $this->input->post('water'),
                'internet' => $this->input->post('internet'),
                'elevator' => $this->input->post('elevator'),
                'washing_machine' => $this->input->post('washing_machine'),
                'room_cleaning' => $this->input->post('room_cleaning'),
                'parking' => $this->input->post('parking'),
                'deposit' => $this->input->post('deposit'),
                'kitchen' => $this->input->post('kitchen'),
                'car_park' => $this->input->post('car_park'),
                'kt3' => $this->input->post('kt3'),
                'pet' => $this->input->post('pet'),
                'extra_fee' => $this->input->post('extra_fee'),
                'management_fee' => $this->input->post('management_fee'),
                'security' => $this->input->post('security'),
                'contract_long_term' => $this->input->post('contract_long_term'),
                'contract_short_term' => $this->input->post('contract_short_term'),
                'number_of_floor' => $this->input->post('number_of_floor'),
                'short_message' => $this->input->post('short_message'),
                'commission_rate' => $this->input->post('commission_rate'),
                'commission_rate_6m' => $this->input->post('commission_rate_6m'),
                'commission_rate_9m' => $this->input->post('commission_rate_9m'),
                'number_of_people' => $this->input->post('number_of_people'),
                'map_longitude' => $this->input->post('map_longitude'),
                'map_latitude' => $this->input->post('map_latitude'),
                'user_collected_id' => $this->input->post('user_collected_id'),
                'partner_id' => $this->input->post('partner_id'),
                'active' => $this->input->post('active'),
                'direction' => $this->input->post('direction'),
                'tag_id' => json_encode($this->input->post('tag_id')),

                'time_update' => time(),
                'time_insert' => strtotime($this->input->post('time_insert')),
                'hidden_service' => $this->input->post("hidden_cols") && count($this->input->post("hidden_cols")) ? json_encode($this->input->post("hidden_cols")) : "[]"
            ];

            $ok = false;
            if($this->isYourPermission('Apartment', 'pendingForApprove')){
                $this->ghApartmentRequest->insert([
                    'account_id' => $this->auth['account_id'],
                    'apartment_id' => $apartment['id'],
                    'status' => 'Pending',
                    'request_data' => json_encode($update_data),
                    'time_update' => time()
                ]);
                $this->session->set_flashdata('fast_notify', [
                    'message' => 'Yêu cầu Update của bạn đã được tạo thành công',
                    'status' => 'warning'
                ]);
            } else {
                $ok = $this->ghApartment->updateById($apartment['id'], $update_data);
            }


            $apartment = $this->ghApartment->getFirstById($apartment['id']);
            if($ok) {
                $this->session->set_flashdata('fast_notify', [
                    'message' => 'Cập Nhật Thành Công',
                    'status' => 'success'
                ]);
            }
        }
        $list_apm_temp = $this->ghApartment->get(['active' => 'YES']);
	    $list_apm = [];
	    foreach ($list_apm_temp as $apm ) {
            if(!in_array($apm['district_code'], $this->list_district_CRUD)) {
                continue;
            }

            $list_apm[] = $apm;
        }

        $list_brand = $this->ghPartner->get(['active' => 'YES']);

        $room_type_model = $this->ghBaseRoomType->get();
        $list_room_type = [];
        foreach($room_type_model as $item) {
            $list_room_type[$item['id']] = $item["name"];
        }

        $this->load->view('components/header');
        $this->load->view('apartment/show-profile', [
            'apartment' => $apartment,
            'list_room' => $list_room,
            'contract' => $contract,
            'libUser' => $this->libUser,
            'cbDistrictActive' => $this->libDistrict->cbActive($apartment['district_code']),
            'libCustomer' => $this->libCustomer,
            'label_apartment' =>  $this->config->item('label.apartment'),
            'list_apm' => $list_apm,
            'list_brand' => $list_brand,
            'ghBaseRoomType' => $this->ghBaseRoomType,
            'list_room_type' => $list_room_type,
            'list_tag' => $this->ghTag->getAll()
        ]);
        $this->load->view('components/footer');
    }

    public function showCreate(){

        $list_brand = $this->ghPartner->get(['active' => 'YES']);

        if(isset($_POST['submit'])) {
            $post_data = $this->input->post();

            $update_data = [
                'address_street' => $this->input->post('address_street'),
                'address_ward' => $this->input->post('address_ward'),
                'district_code' => $this->input->post('district_code'),
                'description' => $this->input->post('description'),
                'note' => $this->input->post('note'),
                'electricity' => $this->input->post('electricity'),
                'water' => $this->input->post('water'),
                'internet' => $this->input->post('internet'),
                'elevator' => $this->input->post('elevator'),
                'washing_machine' => $this->input->post('washing_machine'),
                'room_cleaning' => $this->input->post('room_cleaning'),
                'parking' => $this->input->post('parking'),
                'deposit' => $this->input->post('deposit'),
                'kitchen' => $this->input->post('kitchen'),
                'car_park' => $this->input->post('car_park'),
                'kt3' => $this->input->post('kt3'),
                'pet' => $this->input->post('pet'),
                'extra_fee' => $this->input->post('extra_fee'),
                'management_fee' => $this->input->post('management_fee'),
                'security' => $this->input->post('security'),
                'contract_long_term' => $this->input->post('contract_long_term'),
                'contract_short_term' => $this->input->post('contract_short_term'),
                'number_of_floor' => $this->input->post('number_of_floor'),
                'short_message' => $this->input->post('short_message'),
                'commission_rate' => $this->input->post('commission_rate'),
                'commission_rate_6m' => $this->input->post('commission_rate_6m'),
                'commission_rate_9m' => $this->input->post('commission_rate_9m'),
                'map_longitude' => $this->input->post('map_longitude'),
                'map_latitude' => $this->input->post('map_latitude'),
                'user_collected_id' => $this->input->post('user_collected_id'),
                'partner_id' => $this->input->post('partner_id'),
                'active' => $this->input->post('active'),
                'direction' => $this->input->post('direction'),

                'time_update' => time(),
                'time_insert' => strtotime($this->input->post('time_insert')),
            ];

            $new_id = $this->ghApartment->insert($update_data);
            $this->session->set_flashdata('fast_notify', [
                'message' => 'Tạo Thành Công Dư Án: '.$update_data['address_street'],
                'status' => 'success'
            ]);
            return redirect('/admin/room/show-create?apartment-id='.$new_id);
        }


        $room_type_model = $this->ghBaseRoomType->get();
        $list_room_type = [];
        foreach($room_type_model as $item) {
            $list_room_type[$item['id']] = $item["name"];
        }

        $this->load->view('components/header');
        $this->load->view('apartment/show-create', [
            'libUser' => $this->libUser,
            'cbDistrictActive' => $this->libDistrict->cbActive(),
            'libCustomer' => $this->libCustomer,
            'list_brand' => $list_brand,
            'ghBaseRoomType' => $this->ghBaseRoomType,
            'list_room_type' => $list_room_type
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
            if(count($customer)) {
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