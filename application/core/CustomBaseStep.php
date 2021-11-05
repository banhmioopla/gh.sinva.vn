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
        $this->load->library('LibRole', null, 'libRole');
        $this->load->library('LibConfig', null, 'libConfig');
        $this->load->library('LibUuid', null, 'libUuid');
        $this->load->library('LibTime', null, 'libTime');
        $this->load->library('LibUser', null, 'libUser');
		$this->load->model(['ghActivityTrack', 'ghUser', 'ghNotification', 'ghUserDistrict', 'ghApartment', 'ghRole', 'ghConfig', 'ghTeam']);
		$this->auth = $this->session->userdata('auth');
		$this->role = $this->ghRole->getFirstByCode($this->auth['role_code']);

		$ghUserDistrict = $this->ghUserDistrict->get(['user_id' => $this->auth['account_id']]);
		$this->list_district_CRUD = [];
		$this->list_apartment_CRUD = [];
        $temp_district_arr = [];
        $this->editable = false;
        $this->yourTeam = false;
        $this->list_report_issue = $this->ghNotification->get(['controller' => 'ApartmentReport']);

        $oneUD = $this->ghUserDistrict->getFirstByUser($this->auth['account_id']);
        $this->product_category = null;
        $this->list_OPEN_DISTRICT = [];
        $this->list_OPEN_APARTMENT = [];
        if(!empty($oneUD['apartment_id'])) {
            $this->product_category = "APARTMENT_GROUP";
            foreach($ghUserDistrict as $ud){
                if($ud['is_view_only'] ==='NO'){
                    $this->list_apartment_CRUD[] = $ud['apartment_id'];
                }
                $apm_model = $this->ghApartment->getFirstById($ud['apartment_id']);
                if(!in_array($apm_model['district_code'], $this->list_OPEN_DISTRICT)){
                    $this->list_OPEN_DISTRICT[] = $apm_model['district_code'];
                }

                if(!in_array($apm_model['id'], $this->list_OPEN_APARTMENT)){
                    $this->list_OPEN_APARTMENT[] = $apm_model['id'];
                }
            }
        }

        if(!empty($oneUD['district_code'])) {
            $this->product_category = "DISTRICT_GROUP";
            foreach($ghUserDistrict as $ud){
                if($ud['is_view_only'] ==='NO'){
                    $this->list_district_CRUD[] = $ud['district_code'];
                }

                if(!in_array($ud['district_code'], $this->list_OPEN_DISTRICT)){
                    $this->list_OPEN_DISTRICT[] = $ud['district_code'];
                }
            }
        }

        $this->list_product_open = $this->ghUserDistrict->get(['user_id' => $this->auth['account_id']]);

        $yourTeam = $this->ghTeam->getFirstByLeaderUserId($this->auth['account_id']);
        if($yourTeam){
            $this->yourTeam = $yourTeam;
        }

		foreach (glob($_SERVER['DOCUMENT_ROOT'].'/*.zip') as $filename) {
            unlink($filename);
        }

        if(is_dir('ImFineThanks')){
            $this->my_folder_delete('ImFineThanks');
        }

        $this->pin_notification = json_decode($this->load->view('json-content/pin-notification.json', '',true), true);

		$this->permission_set = json_decode($this->role['list_function'], true);
		$current_user = $this->ghUser->get(['account_id' => $this->auth['account_id']]);
		$authorised_user = $this->ghUser->get(['account_id' => $current_user[0]['authorised_user_id']]);
		$this->authorised_mode = false;
		if(!empty($authorised_user)) {
			$this->authorised_user = $authorised_user;
			$this->authorised_mode = true;
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
            'Apartment' => ['getWard', 'showV2', 'showEdit', 'editDescription', 'showTrending', 'duplicateApartment'],
            'Customer' => ['exportExcel', 'showYour'],
            'CustomerFeedback' => ['detail', 'show', 'showYour'],
            'Room' => ['syncStatusRoom', 'fastUpdate', 'getShaft', 'getListRoomOldTimeAvailable'],
            'Media' => ['showImgApartment', 'uploadImgApartment', 'ajaxApartmentShowImage'],
            'ConsultantBooking' => ['chart'],
            'Report' => ['ApartmentUpdating'],
            'ConsultantPost' => ['showYour', 'showDetail'],
            'ApartmentPromotion' => ["create"],
            'Team' => ['detail'],
            'ApartmentView' => ['create'],
            'ApartmentTrack' => ['show'],
            'Dashboard' => ['showSale', 'showListProject'],
            'ApartmentRequest' => ['exportApartmentExcel'],
            'ApartmentReport' => ['updateIssueApartmentInfo'],
            'HomeTown' => ['show'],
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

    function my_folder_delete($path) {
        if(!empty($path) && is_dir($path) ){
            $dir  = new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS); //upper dirs are not included,otherwise DISASTER HAPPENS :)
            $files = new RecursiveIteratorIterator($dir, RecursiveIteratorIterator::CHILD_FIRST);
            foreach ($files as $f) {if (is_file($f)) {unlink($f);} else {$empty_dirs[] = $f;} }
            if (!empty($empty_dirs)) {
                foreach ($empty_dirs as $eachDir) {
                    $tt = rmdir($eachDir);
                }
            }
            rmdir($path);
        }
    }

	
}

?>