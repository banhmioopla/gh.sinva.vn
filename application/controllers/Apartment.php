<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apartment extends CustomBaseStep {

	public function __construct()
	{
		parent::__construct(); 
		$this->load->model(['ghApartment','ghNotification', 'ghContract', 'ghDistrict', 'ghImage',
            'ghApartmentPromotion', 'ghApartmentRequest', 'ghApartmentView', 'ghConsultantBooking', 'ghApartmentShaft',
            'ghApartmentUserFollow',
            'ghTag', 'ghApartmentComment', 'ghConsultantBooking', 'ghBaseRoomType']);
		$this->load->config('label.apartment');
		$this->load->helper('money');
		$this->load->library('LibDistrict', null, 'libDistrict');
		$this->load->library('LibPartner', null, 'libPartner');
		$this->load->library('LibRoom', null, 'libRoom');
		$this->load->library('LibTime', null, 'libTime');
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

	public function showDashboard(){
	    $list_user = $this->ghUser->get(["active" =>  "YES"]);


	    $ranking_user_contract = $ranking_price_segment = [];
	    $arr_user_id = [];
	    $n_day = 90;

	    $price_segment = [
	        ["min" => 0         , 'max' => 2999999],
	        ["min" => 3000000   , 'max' => 5999999],
	        ["min" => 6000000   , 'max' => 8999999],
	        ["min" => 9000000   , 'max' => 11999999],
	        ["min" => 12000000   , 'max' => 50000000],
        ];

	    foreach ($price_segment as $segment) {
            $list_contract_segment = $this->ghContract->get([
                'time_check_in >=' => strtotime("-{$n_day}days"),
                'status' => 'Active',
                'room_price >=' => $segment['min'],
                'room_price <=' => $segment['max'],
            ]);

            if(count($list_contract_segment)){
                $price_segment_name = number_format($segment['min']) . " - " . number_format($segment['max']);
                $total_sale = 0;
                foreach ($list_contract_segment as $con) {
                    $total_sale += $this->ghContract->getTotalSaleByContract($con['id']);
                }
                $ranking_price_segment[] =[
                    'price_segment' =>  $price_segment_name ,
                    'contract_number' => count($list_contract_segment),
                    'contract_total_sale' => $total_sale,
                ];
            }
        }

        usort($ranking_price_segment, function ($item1, $item2) {
            return $item2['contract_total_sale'] <=> $item1['contract_total_sale'];
        });

	    foreach ($list_user as $user) {
            $list_contract = $this->ghContract->get([
                'time_check_in >=' => strtotime("-{$n_day}days"),
                'status' => 'Active',
                'consultant_id' => $user['account_id'],
            ]);
            if(count($list_contract) > 0) {
                $ranking_user_contract[] = [
                    'consultant_name' => $user["name"],
                    'contract_total' => count($list_contract),
                    'contract_total_sale' => $this->ghContract->getTotalSaleByUser($user['account_id'], date('d-m-Y', strtotime("-{$n_day}days")), date('d-m-Y', strtotime("+{$n_day}days"))),
                ];
            }
        }

        $ranking_contract_total = $ranking_user_contract;
        usort($ranking_contract_total, function ($item1, $item2) {
            return $item2['contract_total'] <=> $item1['contract_total'];
        });
        $ranking_contract_total = array_slice($ranking_contract_total, 0,10);


        $ranking_contract_total_sale = $ranking_user_contract;
        usort($ranking_contract_total_sale, function ($item1, $item2) {
            return $item2['contract_total_sale'] <=> $item1['contract_total_sale'];
        });
        $ranking_contract_total_sale = array_slice($ranking_contract_total_sale, 0,10);
        
        
        $list_apartment = $this->ghApartment->get([
            'active' =>'YES',
        ]);
        $ranking_apartment = [];
        foreach ($list_apartment as $item) {
            $list_contract = $this->ghContract->get([
                'time_check_in >=' => strtotime("-{$n_day}days"),
                'status' => 'Active',
                'apartment_id' => $item['id'],
            ]);

            if(count($list_contract) > 0) {
                $ranking_apartment[] = [
                    'address_full' => $item["address_street"] . ", phường ".$item["address_ward"],
                    'contract_total' => count($list_contract),
                    'contract_total_sale' => $this->ghContract->getTotalSaleByApartment($item['id'], date('d-m-Y', strtotime("-{$n_day}days")), date('d-m-Y', strtotime("+{$n_day}days"))),
                ];
            }
            
        }

        $ranking_apartment_total = $ranking_apartment;
        usort($ranking_apartment_total, function ($item1, $item2) {
            return $item2['contract_total'] <=> $item1['contract_total'];
        });
        $ranking_apartment_total = array_slice($ranking_apartment_total, 0,10);

        $ranking_apartment_total_sale = $ranking_apartment;
        usort($ranking_apartment_total_sale, function ($item1, $item2) {
            return $item2['contract_total_sale'] <=> $item1['contract_total_sale'];
        });
        $ranking_apartment_total_sale = array_slice($ranking_apartment_total_sale, 0,10);

        $this->load->view('components/header');
        $this->load->view('apartment/show-dashboard', [
            'ranking_contract_total' => $ranking_contract_total,
            'ranking_contract_total_sale' => $ranking_contract_total_sale,
            'ranking_apartment_total' => $ranking_apartment_total,
            'ranking_apartment_total_sale' => $ranking_apartment_total_sale,
            'ranking_price_segment' => $ranking_price_segment,
            'n_day' => $n_day,
        ]);
        $this->load->view('components/footer');
    }

	public function show($product_type = 1){
        $this->product_type = $product_type;

        $this->session->set_userdata(['switch_product_type' => $this->ghApartment->switchProductType($product_type)]);
        $list_features = [
            "new" => " <i class='fa fa-bookmark'></i> Mới (30d)",
            "best_seller_month" => " <i class='fa fa-flash'></i> Best seller ".date("m-Y"),
            "following" => " <i class='fa fa-heart'></i> Theo dõi",
//            "best_view_month" => "Xem nhiều trong tháng",
        ];
        $timeFrom = date("01-m-Y");
        $timeTo = date("d-m-Y",strtotime('last day of this month', time()));

		$data = $list_apartment = [];
        if(empty($this->product_category)) {
            $this->load->view('components/header');
            $this->load->view('apartment/error');
            $this->load->view('components/footer');
            return;
        }
        $current_apartment = null;
        $district_code = $this->list_OPEN_DISTRICT[0];
        if(!empty( $this->input->get('district-code'))){
            $district_code = $this->input->get('district-code');
        }

        if($this->input->get('current_apm_id')){
            $current_apartment = $this->ghApartment->getFirstById($this->input->get('current_apm_id'));
            $district_code = $current_apartment['district_code'];
            $apm_view = $this->ghApartmentView->get([
                'apartment_id' => $this->input->get('current_apm_id'),
                'user_id' => $this->auth['account_id'],
                'time_create >' => strtotime(date('d-m-Y'))
            ]);
            if(count($apm_view) == 0){
                if(!in_array($this->auth['account_id'],$this->except_account)){
                    $this->ghApartmentView->insert([
                        'apartment_id' => $this->input->get('current_apm_id'),
                        'user_id' => $this->auth['account_id'],
                        'time_create' => time()
                    ]);
                }
            }

        }

		$params = [
            'district_code' => $district_code,
            'active' => 'YES'
        ];
        if(!empty( $this->input->get('feature'))){
            $feature = $this->input->get('feature');
            if($feature == "best_seller_month"){
                $feature_list_contract = $this->ghContract->get([
                    "time_check_in >=" => strtotime($timeFrom),
                    "time_check_in <=" => strtotime($timeTo)+86399,
                    'status <>' => 'Cancel'
                ]);
                $feature_list_apm_id = [];
                foreach ($feature_list_contract as $item){
                    $feature_list_apm_id[] = $item["apartment_id"];
                }
                $params = [];
                if(!empty($feature_list_apm_id)){
                    $list_apartment = $this->ghApartment->get_where_in("id", array_unique($feature_list_apm_id));
                }
            }

            if($feature == "new"){
                $params = [
                    'time_insert >=' => strtotime("-30days"),
                    'active' => 'YES'
                ];
            }

            if($feature == "following"){
                $feature_list_follow_apm = $this->ghApartmentUserFollow->get([
                    'account_id' => $this->auth['account_id']
                ]);
                $feature_list_apm_id = [];
                foreach ($feature_list_follow_apm as $item){
                    $feature_list_apm_id[] = $item["apartment_id"];
                }
                $params = [];

                if(!empty($feature_list_apm_id)){
                    $list_apartment = $this->ghApartment->get_where_in("id", array_unique($feature_list_apm_id));
                }
            }

        }

        $this->session->set_userdata(['current_district_code' => $district_code]);

		$list_district = $this->ghDistrict->get(['active' => 'YES'],'length(name),name', '');
		foreach ($list_district as $key => $dd){
		    if(!in_array($dd['code'], $this->list_OPEN_DISTRICT)){
		        unset($list_district[$key]);
            }
        }

		$list_ward = $this->ghRoom->getWardByDistrict($district_code);

        if(!empty($params)){
            $list_apartment = $this->ghApartment->get($params, 'time_update DESC,  id DESC, address_street ASC');
        }

		$today = time();
        $list_apm_5days = $list_contract = [];
        $data['today'] = $today;  $data['list_apartment'] = [];
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

            if(!$this->isValidUserApartment($item)) continue;

            $data['list_apartment'][] = $item;
		}

        if(empty($this->input->get('current_apm_id')) && count($data['list_apartment'])) {

            $current_apartment = $list_apartment[0];
        }
        if(!empty($this->input->get('feature')) && count($list_apartment)){
            $current_apartment = $list_apartment[0];
        }


        $list_apm_temp = $this->ghApartment->get(['active' => 'YES'], 'district_code DESC');
        $list_apm_ready = $list_apm_5days_CURD = $list_apm_30d_available =  [];

        foreach ($list_apm_temp as $apm ) {
            $time_update = $this->ghApartment->getUpdateTimeByApm($apm['id']);
            $isFiveDays = $this->libTime->calDay2Time($today, $time_update);
            if(!$this->isValidUserApartment($apm)) continue;

            if($isFiveDays > 4) {
                if(in_array($apm['id'], $this->list_apartment_CRUD) || in_array($apm['district_code'], $this->list_district_CRUD))
                $list_apm_5days_CURD[] = [
                    'address' => $apm['address_street'],
                    'num_days' => $isFiveDays,
                    'district' => $apm['district_code'],
                    'apm_id' => $apm['id'],
                ];
            }


            $list_apm_ready[] = $apm;
            if($this->ghApartment->getApmWithTimeAvailableRemain(30, $apm['id']) !== false){
                $list_apm_30d_available[] = $apm;
            }
        }

        usort($list_apm_5days, function($a, $b)
        {
            return $a['num_days'] <  $b['num_days'];
        });

        if($this->isYourPermission('Apartment', 'showProfile')){
            usort($list_apm_5days_CURD, function($a, $b)
            {
                return $a['num_days'] <  $b['num_days'];
            });
        }

        if($this->isYourPermission('Apartment', 'showProfile')){
            if(!$this->session->has_userdata('isTriggerFiveDay')){
                $this->session->set_userdata(['isTriggerFiveDay' => true]);
            }
        }

        $hidden_service = isset($current_apartment['hidden_service'])
            ? json_decode($current_apartment['hidden_service'], true) : [];

        $cb_room = []; $list_customer_birth_10d_remain = []; $list_contract_30d_remain = [];
        if($current_apartment) {
            $list_room = $this->ghRoom->get(['apartment_id' => $current_apartment['id'], 'active' => 'YES']);
            foreach ($list_room as $room) {
                $cb_room[] = ['value' => $room['id'], 'text' => $room['code'] . ' - '. number_format($room['price'])];
            }

            $list_contract = $this->ghApartment->getListContractById($current_apartment['id'], $timeFrom, $timeTo);
        }

        $list_customer = $this->ghCustomer->getCustomerOfConsultant($this->auth['account_id']);
        if(!empty($list_customer["customers"])){
            foreach ($list_customer["customers"] as $cus){
                $customer_checker = $this->ghCustomer->getCustomerBirthDateOfRemainDays(10, $cus["id"]);
                if($customer_checker !== false){
                    $list_customer_birth_10d_remain[] = $cus;
                }

                $contract_checker = $this->ghCustomer->getCustomerOfExpireDays(30, $cus["id"], $this->auth['account_id']);
                if($contract_checker !== false) {
                    $list_contract_30d_remain[] = $contract_checker;
                }
            }
        }

        if(!empty($current_apartment)){
            $this->head_title = "GH - ". $current_apartment['address_street'];
        }
		/*--- Load View ---*/
		$this->load->view('components/header');
        $template =  'apartment/show';


		$this->load->view($template, [
		    'district_code' => $district_code,
            'current_apartment' => $current_apartment,
            'list_ward' => $list_ward,
            'list_district' => $list_district,
            'list_features' => $list_features,
            "list_contract" => $list_contract,
            'list_apartment' => $list_apartment,
            'cb_room' => $cb_room,
            'list_apm_5days' => $list_apm_5days,
            'list_apm_5days_CURD' => $list_apm_5days_CURD,
            'list_apm_ready' => $list_apm_ready,
            'label_apartment' => $this->config->item('label.apartment'),
            'hidden_service' => $hidden_service,
            'list_price' => $this->ghRoom->getPriceList('gh_room.status = "Available" ', 'gh_room.price'),
            'list_type' => $this->ghRoom->getTypeByDistrict(),
            'list_ready_room_type' => $this->ghRoom->getTypeByDistrict($district_code, 'gh_room.time_available > 0 '),
            'list_customer_birth_10d_remain' => $list_customer_birth_10d_remain,
            'list_contract_30d_remain' => $list_contract_30d_remain,
            'list_apm_30d_available' => $list_apm_30d_available,
        ]);
		$this->load->view('components/footer');
	}

	public function updateRating(){
        $post = $this->input->post();

        $from_date = date("01-m-Y");
        $to_month = date("m");
        $to_year = date("Y");

        $day_last = cal_days_in_month(CAL_GREGORIAN, $to_month, $to_year);
        $to_date = $day_last."-".$to_month."-".$to_year;

        $list = $this->ghApartmentComment->get([
            'apartment_id' => $post['apm_id'],
            'user_id' => $this->auth['account_id'],
            'time_insert >=' => strtotime($from_date),
            'time_insert <=' => strtotime($to_date)+86399,
        ]);
        foreach ($list as $rate){
            $this->ghApartmentComment->deleteById($rate['id']);
        }
        $this->ghApartmentComment->insert([
            'apartment_id' => $post['apm_id'],
            'content' =>$post['content'],
            'user_id' => $this->auth['account_id'],
            'time_insert' => time(),
            'score' => $post['score'],
        ]);
    }

    public function updateFollowing(){
        $post = $this->input->post();
        $follow_apm = $this->ghApartmentUserFollow->getFirst([
            'apartment_id' => $post['apm_id'],
            'account_id' => $this->auth['account_id'],
        ]);

        if($post['status'] === 'true' && empty($follow_apm)){
            $checker = $this->ghApartmentUserFollow->insert([
                'apartment_id' => $post['apm_id'],
                'account_id' => $this->auth['account_id'],
                'insert_time' => time(),
            ]);

            echo json_encode([
                'status' => true,'msg' => 'Cập nhật thành công'
            ]); die;
        }


        if(!empty($follow_apm)){
            $this->ghApartmentUserFollow->delete($follow_apm['id']);
        }

        echo json_encode([
            'status' => false, 'msg' => 'Cập nhật fail'
        ]); die;

    }

    public function drawChart(){
        $groupBy = $this->input->post('groupBy');
        $res = [];
        switch ($groupBy) {
            case "District":
                $res[] = ["Quận", "Dự án", "Trống"];
                $list_district = $this->ghDistrict->get(['active' => 'YES']);
                foreach ($list_district as $district) {
                    $list_apartment = $this->ghApartment->get(['active' => 'YES', 'district_code' => $district['code']]);
                    $count_apm_available = 0;
                    foreach ($list_apartment as $apm) {
                        $room_available = $this->ghRoom->get(["status" => 'Available' , "apartment_id" => $apm['id'] ]);
                        if(count($room_available)) {
                            $count_apm_available++;
                        }
                    }
                    if(count($list_apartment) ==0 && $count_apm_available == 0 ) {
                        continue;
                    }


                    $res[] = [
                        "Q. ".$district['name'],
                        count($list_apartment),
                        $count_apm_available

                    ];
                }

                break;

        }


        echo json_encode($res);

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
        $number_result = 0;

        $from24h = strtotime('-24hours');
        $to24h =  strtotime(date("d-m-Y"))+86399;
        foreach ($list_room_search as $r){
            $border_highlight = "";
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


            $room_price = number_format($r['price']/1000);
            $highlight = ""; $continue = false;
            if($this->input->get('inUpdate24h') == "true"){

                if($r['time_update'] < $from24h){
                    $continue = true;
                }


                if($continue === false) {
                    $log = $this->ghActivityTrack->getLimitOneByObjId($r['id'],'gh_room', $from24h, $to24h);

                    if(!empty($log)) {
                        $old_log = json_decode($log['old_content'], true);
                        $room_price .= " <br> <span class='text-muted'><del>".number_format($old_log["price"]/1000)."</del></span>";
                        $highlight = "row-24h-highlight";
                        $border_highlight = "border-highlight";
                    } else {
                        $continue = true;
                    }

                    if($r['status'] !== 'Available'){
                        $continue = true;
                    }
                }

            }
            if($continue === false) {

                $arr_apartment_room[$r['apartment_id']][] = [
                    'room_id' => $r['id'],
                    'room_code' => $r['code'],
                    'room_price' => $room_price,
                    'room_type' => "<div>".$text_type_name."</div>" . "<div class='text-primary'>".$r['type']."</div>",
                    'room_area' => $r['area'] . ' ㎡',
                    'room_status' => $status_txt,
                    'room_time_available' => $r['time_available'] > 0 ? date('d-m-Y', $r['time_available']) : '-',
                    'room_high_light' => $highlight
                ];
            }


            if(!isset($arr_apartment_info[$r['apartment_id']])){
                $apm_info = $this->ghApartment->getFirstById($r['apartment_id']);
                if($apm_info) {
                    $contract_term = "";
                    if($this->input->get('contractTerm') == 'short') {
                        $checker = strpos(trim(strtolower($apm_info['contract_short_term'])), "không");
                        if($checker !== false || empty($apm_info['contract_short_term'])) {
                            continue;
                        }
                        $contract_term = "Ngắn hạn: ". $apm_info['contract_short_term'];
                    }

                    if($this->input->get('contractTerm') == 'long') {
                        $checker = strpos(trim(strtolower($apm_info['contract_long_term'])), "không");
                        if($checker !== false || empty($apm_info['contract_long_term'])) {
                            continue;
                        }
                        $contract_term = "Dài hạn: ". $apm_info['contract_long_term'];
                    }

                    $description_old = ""; $list_promotion = [];
                    if($this->input->get('inUpdate24h') == "true"){

                        if($apm_info['time_update'] < $from24h && $continue === true){
                            $continue = true;
                        }

                        $list_promotion = $this->ghApartmentPromotion->get(['insert_time >=' => $from24h, "apartment_id" => $r['apartment_id']]);
                        $log = $this->ghActivityTrack->getLimitOneByObjId($r['apartment_id'], 'gh_apartment', $from24h, $to24h);

                        if(!empty($log)) {
                            $continue = false;
                            $old_log = json_decode($log['old_content'], true);
                            $description_old = "<span class='text-muted'>".$old_log["description"]."</span>";
                            $border_highlight = "border-highlight";
                        }

                        if($continue === true) continue;
                    }

                    $arr_apartment_info[$r['apartment_id']] = [
                        'apartment_id' => $r['apartment_id'],
                        'address' =>
                            "<span class='text-purple'> "
                            ."Q.". $this->libDistrict->getNameByCode($apm_info['district_code'])
                            . ' | ' . $apm_info['address_street'] . " Ph. " . $apm_info['address_ward'] . "</span>",
                        'district_code' => $this->libDistrict->getNameByCode($apm_info['district_code']),
                        'contract_term' => $contract_term,
                        'description' => $apm_info['description'],
                        'description_old' => $description_old,
                        'border_highlight' => $border_highlight,
                        "list_promotion" => $list_promotion,
                    ];
                }
                $number_result++;
            }
        }

        $this->load->view('components/header');
        $this->load->view('apartment/search-result', [
            'arr_apartment_info' => $arr_apartment_info,
            'arr_apartment_room' => $arr_apartment_room,
            'number_result' => $number_result,
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
        $list_apm_temp = $this->ghApartment->get(['active' => 'NO']);
        $list_apm = [];
        foreach ($list_apm_temp as $apm ) {
            if(!$this->isValidUserApartment($apm)) continue;

            $list_apm[] = $apm;
        }

        $data['list_apartment'] = $list_apm;
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
		$this->load->view('components/header');
		$this->load->view('apartment/show-like-base', $data);
		$this->load->view('components/footer');
	}


	public function showProfile(){
	    $id = $this->input->get('id');

	    $list_room = $this->ghRoom->get(['apartment_id' => $id, 'active' => 'YES']);
	    $contract = $this->ghContract->get(['apartment_id' => $id]);
	    $list_col = $this->ghApartment->getListCol();
        $apartment = $this->ghApartment->getFirstById($id);

	    if(isset($_POST['submit'])) {
            $update_data = [
                'address_street' => $this->input->post('address_street'),
                'zalo_group_url' => $this->input->post('zalo_group_url'),
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
                'hidden_service' => $this->input->post("hidden_cols") && count($this->input->post("hidden_cols")) ? json_encode($this->input->post("hidden_cols")) : "[]",
                'surrounding_facilities' => $this->input->post("surrounding_facilities") && count($this->input->post("surrounding_facilities")) ? json_encode($this->input->post("surrounding_facilities")) : "[]",

            ];
            $old_log = json_encode($apartment);
            /*if($this->isYourPermission('Apartment', 'pendingForApprove')){
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
            }*/

            $ok = $this->ghApartment->updateById($apartment['id'], $update_data);

            if($ok) {
                $modified_log = json_encode($this->ghApartment->getFirstById($apartment['id']));
                $diff = array_diff_assoc($this->ghApartment->getFirstById($apartment['id']),json_decode($old_log,true));
                $obj_id = null;
                if(array_key_exists("description",$diff)){
                    $obj_id = $apartment['id'];
                }
                $log = [
                    'table_name' => 'gh_apartment',
                    'old_content' => $old_log,
                    'modified_content' => $modified_log,
                    'time_insert' => time(),
                    'action' => 'update',
                    'user_id' => $this->auth['account_id'],
                    "obj_id" => $obj_id
                ];
                $tracker = $this->ghActivityTrack->insert($log);


                $this->session->set_flashdata('fast_notify', [
                    'message' => 'Cập Nhật Thành Công',
                    'status' => 'success'
                ]);
            }
        }
        $list_apm_temp = $this->ghApartment->get(['active' => 'YES']);
	    $list_apm = [];
	    foreach ($list_apm_temp as $apm ) {
	        if(!$this->isValidUserApartment($apm)) continue;
            $list_apm[] = $apm;
        }

        $list_brand = $this->ghPartner->get(['active' => 'YES']);
        $apartment = $this->ghApartment->getFirstById($id);
        $room_type_model = $this->ghBaseRoomType->get();
        $list_room_type = [];
        foreach($room_type_model as $item) {
            $list_room_type[$item['id']] = $item["name"];
        }


        $list_user = $this->ghUser->get(['active' => "YES"]);
        $this->head_title = "GH Update - ". $apartment['address_street'];
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
            'list_user' => $list_user,
            'ghBaseRoomType' => $this->ghBaseRoomType,
            'list_room_type' => $list_room_type,
            'list_tag' => $this->ghTag->getAll(),
            "ghApartmentPromotion" => $this->ghApartmentPromotion,
        ]);
        $this->load->view('components/footer');
    }

    public function showSortable(){
        if(empty($this->product_category)) {
            $this->load->view('components/header');
            $this->load->view('apartment/error');
            $this->load->view('components/footer');
            return;
        }

        $district_code = $this->input->get('district-code');
        $district_code = !empty($district_code) ? $district_code: $this->list_OPEN_DISTRICT[0];
        $params = [
            'district_code' => $district_code,
            'active' => 'YES'
        ];

        $this->session->set_userdata(['current_district_code' => $district_code]);
        $list_apm_temp = $this->ghApartment->get($params);
        $list_apm_ready = [];

        foreach ($list_apm_temp as $apm ) {
            if(!$this->isValidUserApartment($apm)) continue;
            $list_apm_ready[] = $apm;
        }

        $this->load->view('components/header');
        $this->load->view('apartment/show-sortable', [
            'list_apm_ready' => $list_apm_ready,
            'district_code' => $district_code
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
//                'note' => $this->input->post('note'),
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
            if($new_id){
                $log = [
                    'table_name' => 'gh_apartment',
                    'old_content' => "[]",
                    'modified_content' => json_encode($this->ghApartment->getFirstById($new_id)),
                    'time_insert' => time(),
                    'action' => 'create'
                ];
                $tracker = $this->ghActivityTrack->insert($log);
            }
            $this->session->set_flashdata('fast_notify', [
                'message' => 'Tạo Thành Công Dư Án: '.$update_data['address_street'],
                'status' => 'success'
            ]);
            return redirect('/admin/room/show-create?apartment-id='.$new_id, "refresh");
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

    public function duplicateApartment(){
        $apm_id = $this->input->get('id');
        $apartment_clone = $this->ghApartment->getFirstById($apm_id);
        unset($apartment_clone['id']);
        $apartment_clone['time_insert'] =  $apartment_clone['time_update'] = time();
        $apartment_clone['user_collected_id'] = $this->auth['account_id'];
        $apartment_clone['address_street'] = "COPY | " .$apartment_clone['address_street'];
        $result = $this->ghApartment->insert($apartment_clone);
        if($result){
            $log = [
                'table_name' => 'gh_apartment',
                'old_content' => "[]",
                'modified_content' => json_encode($this->ghApartment->getFirstById($result)),
                'time_insert' => time(),
                'action' => 'create',
                'user_id' => $this->auth['account_id']
            ];
            $tracker = $this->ghActivityTrack->insert($log);
        }
        $this->session->set_flashdata('fast_notify', [
            'message' => 'Tạo dự án '.$apartment_clone['address_street'] .' thành công ',
            'status' => 'success'
        ]);
        if($this->session->has_userdata('current_district_code')){
            return redirect('/admin/list-apartment?district-code='.$this->session->userdata('current_district_code'));
        }
        return redirect('/admin/list-apartment');
    }

	public function showCommmissionRate(){
		$data['list_apartment'] = $this->ghApartment->get(['active' => 'YES'], 'district_code ASC');
		$data['label_apartment'] =  $this->config->item('label.apartment');
		$data['libDistrict'] = $this->libDistrict;

		/*--- Load View ---*/
		$this->load->view('components/header');
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
        if($mode == 'pin_notification') {
            $file = $this->load->view('json-content/pin-notification.json', '',true);
            file_put_contents(APPPATH.'views/'.'json-content/pin-notification.json', json_encode(["content" => $field_value]));
            echo json_encode(['status' => true, "content" => "Cập nhật thành công!"]); die;
        }
		if($mode == 'sort') {
	        $counter = 0;
            foreach ($field_value as $itemmm) {
                $checker = $this->ghApartment->updateById($itemmm['apm_id'], [
                    'order_item' => $itemmm['order']
                ]);
                if($checker){
                    $counter++;
                }

            }
            echo json_encode(['status' => $counter]); die;
        }
        $time = time();
        if($mode == 'only_time_update') {
            $result = $this->ghApartment->updateById($apartment_id, [
                'time_update' => $time
            ]);
            if($result) {
                echo json_encode(['status' => $result, 'content' => date('d-m-Y h:i\'', $time)]); die;
            }
        }

        if($mode == 'list_only_time_update') {

            $arr_pk = $this->input->post('arr_pk');
            $counter = 0;
            foreach ($arr_pk as $apm_id){
                $is_update = $this->ghApartment->updateById($apm_id, [
                    'time_update' => $time
                ]);
                if($is_update) {
                    $counter++;
                }

            }
            echo json_encode(['status' => $counter, 'content' => "Cập nhật thành công, Vui lòng load lại GH để tận hưởng!"]); die;
        }
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


    public function isValidUserApartment($apartment){
        if($this->product_category == "APARTMENT_GROUP" && !in_array($apartment['id'], $this->list_OPEN_APARTMENT)) {
            return false;
        }
        if($this->product_category == "DISTRICT_GROUP" && !in_array($apartment['district_code'], $this->list_OPEN_DISTRICT)) {
            return false;
        }
        return true;
    }

}

/* End of file apartment.php */
/* Location: ./application/controllers/role-manager/apartment.php */