<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CustomBaseStep extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$this->current_controller =  $this->router->fetch_class();
		$this->current_action =  $this->router->fetch_method();

		if(!$this->session->has_userdata('auth'))
		{
//			$this->session->sess_destroy();
			return redirect('/');
		}
		
		$this->load->model(['ghActivityTrack', 'ghUser', 'ghNotification', 'ghUserDistrict', 'ghApartment', 'ghRole', 'ghConfig', 'ghTeam']);
		$this->auth = $this->session->userdata('auth');
		$this->role = $this->ghRole->get(['code' =>$this->auth['role_code']])[0];
		$this->load->library('LibRole', null, 'libRole');
		$this->load->library('LibConfig', null, 'libConfig');
		$this->load->library('LibUuid', null, 'libUuid');
		$this->load->library('LibTime', null, 'libTime');
		$this->load->library('LibUser', null, 'libUser');

		$this->load->config('usermode');
		$usermode = $this->config->item('usermode');
	
		$this->auth['modifymode'] = 'view';
		$this->menu = null;;
		
		$ghUserDistrict = $this->ghUserDistrict->get(['user_id' => $this->auth['account_id']]);
		$this->list_district_CRUD = [];
		$this->list_apartment_CRUD = [];
		$this->list_apartment_view_only = [];
        $this->list_district_view_only = [];
        $temp_district_arr = [];
        $this->editable = false;
        $this->yourTeam = false;
        $this->list_report_issue = $this->ghNotification->get(['controller' => 'ApartmentReport']);

        $yourTeam = $this->ghTeam->getFirstByLeaderUserId($this->auth['account_id']);
        if($yourTeam){
            $this->yourTeam = $yourTeam;
        }

		foreach($ghUserDistrict as $ud) {

            if($ud['apartment_id']){
                $this->list_apartment_CRUD = $ud['apartment_id'];
                $model_apm = $this->ghApartment->getFirstById($ud['apartment_id']);
                if($model_apm && !in_array($model_apm['district_code'], $temp_district_arr)){
                    $temp_district_arr[]= $model_apm['district_code'];
                    $this->list_district_CRUD[] = $model_apm['district_code'];
                }
            } else {
                if(!in_array($ud['district_code'], $temp_district_arr)) {
                    $this->list_district_CRUD[] = $ud['district_code'];
                    $temp_district_arr[]= $ud['district_code'];
                }

            }

			if($ud['is_view_only'] == 'YES') {
                $this->list_district_view_only[] = $ud['district_code'];
                if($ud['apartment_id']){
                    $this->list_apartment_view_only[] = $ud['apartment_id'];
                }
            } else {
                $this->editable = true;
            }
		}
		
		$this->permission_set = json_decode($this->role['list_function'], true);
		$current_user = $this->ghUser->get(['account_id' => $this->auth['account_id']]);
		$authorised_user = $this->ghUser->get(['account_id' => $current_user[0]['authorised_user_id']]);
		$this->authorised_mode = false;
		if(!empty($authorised_user)) {
			$this->authorised_user = $authorised_user;
			$this->authorised_mode = true;
			$temp_menu = $this->menu;
			$this->menu = $temp_menu;
		}
		$this->permission_controller_set = array_keys($this->permission_set);
		if(isset($this->permission_set[$this->current_controller])) {
			$this->permission_action_set = $this->permission_set[$this->current_controller];
		}


        $this->arr_general = $this->libConfig->getListGeneralControlDepartment();
		$open_modules = [
		    /*Controller => [actions]*/
		    'InternalContent' => ['show', 'pageIncomeRule', 'create', 'updateEditable'],
            'Image' => ['ajax_get_room_image', 'downloadAllMediaApartment'],
            'Apartment' => ['getWard', 'showV2', 'showEdit', 'editDescription', 'showTrending'],
            'Customer' => ['exportExcel', 'showYour'],
            'CustomerFeedback' => ['detail', 'show', 'showYour'],
            'Room' => ['syncStatusRoom', 'fastUpdate', 'getShaft'],
            'Media' => ['showImgApartment', 'uploadImgApartment', 'ajaxApartmentShowImage'],
            'ConsultantBooking' => ['chart'],
            'Report' => ['ApartmentUpdating'],
            'ConsultantPost' => ['showYour', 'showDetail'],
            'ApartmentPromotion' => [],
            'Team' => ['detail'],
            'ApartmentView' => ['create'],
            'Dashboard' => ['showSale'],
            'ApartmentRequest' => ['exportApartmentExcel'],
            'ApartmentReport' => ['updateIssueApartmentInfo'],
        ];

        if(!(isset($open_modules[$this->current_controller]) && in_array($this->current_action,$open_modules[$this->current_controller]))) {

            if(!$this->checkCurrentPermission($this->permission_set)) {
                return redirect('/admin/notfound');
            }
        }


	}

	private function checkCurrentPermission($permission_set) {
		$permission_controller_set = array_keys($permission_set);
		$permission_action_set = isset($permission_set[$this->current_controller]) ? $permission_set[$this->current_controller] : [];

		if(in_array($this->current_controller, $permission_controller_set)
            && in_array($this->current_action, $permission_action_set)) {
			return true;
		}
		return false;
	}

	protected function isYourPermission($controller, $action){
        $list_controller = array_keys($this->permission_set);
        if(in_array($controller, $list_controller) && isset($this->permission_set[$controller]) && in_array($action, $this->permission_set[$controller])) {
            return true;
        }
        return false;
    
    }

	
}

?>