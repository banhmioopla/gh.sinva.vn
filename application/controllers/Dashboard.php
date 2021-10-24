<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CustomBaseStep {
    public function __construct()
	{
		parent::__construct(); 
		$this->load->model(['ghConsultantBooking','ghApartment', 'ghDistrict', 'ghTag',
            'ghCustomer',
            'ghRoom', 'ghContract']);
		$this->load->config('label.apartment');
		$this->load->helper('money');
		$this->load->library('LibDistrict', null, 'libDistrict');
		$this->load->library('LibPartner', null, 'libPartner');
		$this->load->library('LibRoom', null, 'libRoom');
		$this->load->library('LibTime', null, 'libTime');
		$this->load->library('LibApartment', null, 'libApartment');
		$this->load->library('LibBaseApartmentType', null, 'libBaseApartmentType');
		$this->load->library('LibBaseRoomType', null, 'libBaseRoomType');
		$this->load->library('LibApartment', null, 'libApartment');
		$this->load->library('LibTag', null, 'libTag');
		$this->load->library('LibUser', null, 'libUser');

		$this->permission_modify = [['customer-care' => 0], 'product-manager'];
	}

	public function showSale(){
        $list_user = $this->ghUser->get(['active' => 'YES']);

        $list_target = ['team', 'district','brand','member'];


        $target_metric = 'district';
        if($this->input->get('target')) {
            $target_metric = $this->input->get('target');
        }

        $days_this_month = $this->libTime->calDayInMonthThisYear(date('m'));

        $from_time = date('01-m-Y');
        $to_time = date($days_this_month.'-m-Y');


        if($this->input->get('from_time')) {
            $from_time = $this->input->get('from_time');
        }

        if($this->input->get('to_time')) {
            $to_time = $this->input->get('to_time');
        }

        $view_head1 = 'dashboard/components/'.$target_metric;

        $this->load->view('components/header');
        $this->load->view('dashboard/show-v2', [
            'libApartment' => $this->libApartment,
            'libUser' => $this->libUser,
            'ghApartment' => $this->ghApartment,
            'libTime' => $this->libTime,

            'from_time' => $from_time,
            'to_time' => $to_time,

            'view_head1' => $view_head1,
            'target' => $target_metric,

            'list_district' => $this->ghDistrict->get(['active' => 'YES']),
            'list_user' => $this->ghUser->get(['active' => 'YES']),
            'list_partner' => $this->ghPartner->get(['active' => 'YES']),
            'list_team' => $this->ghTeam->get()
        ]);
        $this->load->view('components/footer');
    }


    public function show() {
        $list_customer = $this->ghCustomer->get();
        $total_customer = $list_customer ? count($list_customer) : 0;

        $list_apartment = $this->ghApartment->get(['active' => 'YES']);
        $total_apartment = $list_apartment ? count($list_apartment) : 0;

        $list_room = $this->ghRoom->get(['active' => 'YES']);
        $list_user = $this->ghUser->get(['active' => 'YES', 'account_id > ' => 171020000]);
        $total_room = $list_room ? count($list_room) : 0;
        
        $list_room_ready = $this->ghRoom->get(['time_available > ' => 0, 'active' => 'YES']);
        $total_room_ready = $list_room_ready ? count($list_room_ready) : 0;
        $list_room_available = $this->ghRoom->get(['status' => 'Available', 'active' => 'YES']);
        $total_room_available = $list_room_available ? count($list_room_available) : 0;

        $total_room_full = $total_room - $total_room_available;

        $list_contract = $this->ghContract->get();
        $total_contract = $list_contract ? count($list_contract) : 0;
        $data['list_district'] = $this->ghDistrict->get(['active' => 'YES']);
        $chart_data = [];
        $chart_data_trong = [];
        $chart_data_full = [];
        $chart_label = [];
        $ii = 0;
        foreach($data['list_district'] as $d) {
            $chart_data[$ii] = [$ii, 0];
            $chart_data_trong[$ii] = [$ii, 0];
            $chart_data_full[$ii] = [$ii, 0];
            $chart_label[$ii] = [$ii, $d['name']];
            $ii ++;
        }
        
        $iii = 0;
        foreach($data['list_district'] as $d) {
            $chart_data[$iii] = [$iii,(int)$this->ghRoom->getNumberByDistrict($d['code'], 1)];
            $chart_data_trong[$iii] = [$iii, (int)$this->ghRoom->getNumberByDistrict($d['code'], 'gh_room.status = "Available"')];
            $chart_data_full[$iii] = [$iii, (int)$this->ghRoom->getNumberByDistrict($d['code'], 'gh_room.status = "Full"')];
            $chart_data_saptrong[$iii] = [$iii, (int)$this->ghRoom->getNumberByDistrict($d['code'], 'gh_room.time_available > 0')];
            $iii ++;
        }

        // Contract

        // consutant booking
        $data_setup = $this->setupData('LAST_30_DAY');
        $chart_consultantbooking = $this->chartConsultantBooking
        ($data_setup['data']['consultant_booking'], $data_setup['from'], $data_setup['to']);

        $chart_contract = $this->chartContract
        ($data_setup['data']['contract'], $data_setup['from'], $data_setup['to']);

        $data['chart_consultantbooking'] = json_encode($chart_consultantbooking);
        $data['chart_contract'] = json_encode($chart_contract);

        $data = [
            'total_customer' => $total_customer,
            'total_apartment' => $total_apartment,
            'total_room' => $total_room,
            'total_contract' => $total_contract,
            'total_room_ready' => $total_room_ready,
            'total_room_available' => $total_room_available,
            'total_room_full' => $total_room_full,
            'list_district' => $this->ghDistrict->get(['active' => 'YES']),
            'list_contract' => $list_contract,
            'list_user' => $list_user,
            'libApartment' => $this->libApartment,

            'chart_data_total' => json_encode($chart_data),
            'chart_data_trong' => json_encode($chart_data_trong),
            'chart_data_full' => json_encode($chart_data_full),
            'chart_data_saptrong' => json_encode($chart_data_saptrong),
            'chart_label' =>json_encode($chart_label),

            'chart_consultantbooking' => $data['chart_consultantbooking'],
            'chart_contract' => $data['chart_contract']
        ];
        $this->load->view('components/header');
        $this->load->view('dashboard/show', $data);
        $this->load->view('components/footer');
    }

    public function showListProject(){
        $this->load->view('components/header');
        $this->load->view('dashboard/show-list-project', [

        ]);
        $this->load->view('components/footer');
    }

    public function showTest(){
        $data = [];
        $data_setup = $this->setupData();

        $chart_consultantbooking = $this->chartConsultantBooking
        ($data_setup['data']['consultant_booking'], $data_setup['from'], $data_setup['to']);

        $data['chart_consultantbooking'] = json_encode($chart_consultantbooking);
        $this->load->view('components/header');
        $this->load->view('dashboard/show-test', $data);
        $this->load->view('components/footer');
    }


    private function setupData($filter='LAST_15_DAY'){
        $from = date('d-m-Y', strtotime('-15days'));
        $to = date('d-m-Y');
        if($filter === 'THIS_MONTH') {
            $from = date('01-m-Y');
            $to = date('d-m-Y');
        }

        if($filter === 'THIS_WEEK') {
            $from = date('d-m-Y',strtotime('last monday'));
            $to = date('d-m-Y');
        }

        if($filter === 'LAST_15_DAY') {
            $from = date('d-m-Y',strtotime('-15days'));
            $to = date('d-m-Y');
        }

        if($filter === 'LAST_30_DAY') {
            $from = date('d-m-Y',strtotime('-30days'));
            $to = date('d-m-Y');
        }

        $data = $this->initToZero($from, $to);


        return ['data' =>$data, 'from' => $from, 'to' => $to];

    }


    private function chartConsultantBooking(&$data_init, $from, $to){

        $int_from = strtotime($from);
        $int_to = strtotime($to) +86399;
        $list_model = $this->ghConsultantBooking->get(['time_booking >=' => $int_from, 'time_booking <=' => $int_to]);
        foreach ($list_model as $item) {
            $time_format = date('d-m-Y', $item['time_booking']);

            $data_init[$time_format] ++;
        }
        return $data_init;

    }

    private function chartContract(&$data_init, $from, $to){

        $int_from = strtotime($from);
        $int_to = strtotime($to) +86399;
        $list_model = $this->ghContract->get(['time_check_in >=' => $int_from, 'time_check_in <=' => $int_to]);
        foreach ($list_model as $item) {
            $time_format = date('d-m-Y', $item['time_check_in']);

            $data_init[$time_format] ++;
        }
        return $data_init;

    }

    private function initToZero($from, $to){
        $int_from = strtotime($from);
        $int_to = strtotime($to) + 86399;
        $data[] = $from;
        $begin = $int_from;
        while($begin <= $int_to) {
            $begin_format = date('d-m-Y', $begin);
            $data['consultant_booking'][$begin_format] = 0;
            $data['contract'][$begin_format] = 0;
            $begin += 86400;
        }

        return $data;
    }
}