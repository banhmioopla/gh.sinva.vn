<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'Login/show';
$route['404_override'] = '';

$route['admin/logout'] = function($params = []) {
	$controller = 'Login';
	$action = '/logout';
	return $controller.$action;
};

$route['admin/notfound'] = function($params = []) {
	$controller = 'Role';
	$action = '/notfound';
	return $controller.$action;
};

// mapbox
$route['admin/list-mapbox'] = function($params = []) {
    $controller = 'Mapbox';
    $action = '/show';
    return $controller.$action;
};

// story
$route['admin/list-story'] = function($params = []) {
    $controller = 'Story';
    $action = '/show';
    return $controller.$action;
};

$route['admin/create-story'] = function($params = []) {
    $controller = 'Story';
    $action = '/create';
    return $controller.$action;
};

$route['admin/update-story-editable'] = function($params = []) {
    $controller = 'Story';
    $action = '/create';
    return $controller.$action;
};

// Penalty
$route['admin/list-penalty'] = function($params = []) {
    $controller = 'Penalty';
    $action = '/show';
    return $controller.$action;
};

$route['admin/create-penalty'] = function($params = []) {
    $controller = 'Penalty';
    $action = '/create';
    return $controller.$action;
};

$route['admin/update-penalty'] = function($params = []) {
    $controller = 'Penalty';
    $action = '/update';
    return $controller.$action;
};

$route['admin/get-penalty'] = function($params = []) {
    $controller = 'Penalty';
    $action = '/getPenalty';
    return $controller.$action;
};

$route['admin/update-penalty-editable'] = function($params = []) {
    $controller = 'Penalty';
    $action = '/updateEditable';
    return $controller.$action;
};

// UserPenalty
$route['admin/list-userpenalty'] = function($params = []) {
    $controller = 'UserPenalty';
    $action = '/show';
    return $controller.$action;
};

$route['admin/create-userpenalty'] = function($params = []) {
    $controller = 'UserPenalty';
    $action = '/create';
    return $controller.$action;
};

$route['admin/update-userpenalty'] = function($params = []) {
    $controller = 'UserPenalty';
    $action = '/update';
    return $controller.$action;
};

$route['admin/update-userpenalty-editable'] = function($params = []) {
    $controller = 'UserPenalty';
    $action = '/updateEditable';
    return $controller.$action;
};



$route['admin/list-department'] = function($params = []) {
    $controller = 'Department';
    $action = '/show';
    return $controller.$action;
};

// Merge Business Apartment
$route['admin/create-merge-apartment-business'] = function($params = []) {
    $controller = 'BusinessPartner';
    $action = '/createMergeApartment';
    return $controller.$action;
};

// report - booking customer
$route['admin/list-consultant-booking'] = function($params = []) {
	$controller = 'ConsultantBooking';
	$action = '/show';
	return $controller.$action;
};
$route['admin/consultant-booking/chart'] = function($params = []) {
    $controller = 'ConsultantBooking';
    $action = '/chart';
    return $controller.$action;
};

$route['admin/consultant-booking/get-room-id'] = function($params = []) {
	$controller = 'ConsultantBooking';
	$action = '/getRoomId';
	return $controller.$action;
};
$route['admin/create-new-consultant-booking'] = function($params = []) {
	$controller = 'ConsultantBooking';
	$action = '/create';
	return $controller.$action;
};
$route['admin/update-consultant-booking-editable'] = function($params = []) {
	$controller = 'ConsultantBooking';
	$action = '/updateEditable';
	return $controller.$action;
};
$route['admin/report/apartment-updating'] = function($params = []) {
	$controller = 'Report';
	$action = '/ApartmentUpdating';
	return $controller.$action;
};
$route['admin/create-rp-booking-customer'] = function($params = []) {
	$controller = 'Report';
	$action = '/createBookingCustomer';
	return $controller.$action;
};

$route['admin/update-rp-booking-customer'] = function($params = []) {
	$controller = 'Report';
	$action = '/update';
	return $controller.$action;
};

$route['admin/delete-rp-booking-customer'] = function($params = []) {
	$controller = 'Report';
	$action = '/delete';
	return $controller.$action;
};

$route['admin/update-rp-booking-customer-editable'] = function($params = []) {
	$controller = 'Report';
	$action = '/updateEditableBookingCustomer';
	return $controller.$action;
};
// User Target
$route['admin/create-user-target'] = function($params = []) {
    $controller = 'UserTarget';
    $action = '/create';
    return $controller.$action;
};

// Email
$route['admin/send-email-notification'] = function($params = []) {
    $controller = 'Email';
    $action = '/sendMail';
    return $controller.$action;
};
// apartment promotion
$route['admin/list-apartment-promotion'] = function($params = []) {
    $controller = 'ApartmentPromotion';
    $action = '/show';
    return $controller.$action;
};

$route['admin/apartment-promotion/delete'] = function($params = []) {
    $controller = 'ApartmentPromotion';
    $action = '/delete';
    return $controller.$action;
};

$route['admin/apartment-promotion/show-edit'] = function($params = []) {
    $controller = 'ApartmentPromotion';
    $action = '/showEdit';
    return $controller.$action;
};

$route['admin/create-apartment-promotion'] = function($params = []) {
    $controller = 'ApartmentPromotion';
    $action = '/create';
    return $controller.$action;
};

$route['admin/update-apartment-promotion-editable'] = function($params = []) {
    $controller = 'ApartmentPromotion';
    $action = '/updateEditable';
    return $controller.$action;
};

// CommissionBilling
$route['admin/list-commission-billing'] = function($params = []) {
    $controller = 'CommissionBilling';
    $action = '/show';
    return $controller.$action;
};

$route['admin/commission-billing/update-full-contract-partial'] = function($params = []) {
    $controller = 'CommissionBilling';
    $action = '/updateFullContractPartial';
    return $controller.$action;
};

// contract
$route['admin/list-contract'] = function($params = []) {
	$controller = 'Contract';
	$action = '/show';
	return $controller.$action;
};

$route['admin/create-contract-partial'] = function($params = []) {
    $controller = 'Contract';
    $action = '/createPartial';
    return $controller.$action;
};

$route['admin/contract/partial/delete'] = function($params = []) {
    $controller = 'Contract';
    $action = '/deletePartial';
    return $controller.$action;
};

$route['admin/list-personal-contract'] = function($params = []) {
    $controller = 'Contract';
    $action = '/showYour';
    return $controller.$action;
};

$route['admin/detail-contract'] = function($params = []) {
	$controller = 'Contract';
	$action = '/detailShow';
	return $controller.$action;
};

$route['admin/room/copyClipboard'] = function($params = []) {
    $controller = 'Room';
    $action = '/copyClipboard';
    return $controller.$action;
};

$route['admin/ajax/contract/chart'] = function($params = []) {
    $controller = 'Contract';
    $action = '/drawChart';
    return $controller.$action;
};
$route['admin/contract/sync-status-expire'] = function($params = []) {
	$controller = 'Contract';
	$action = '/syncStatusExpire';
	return $controller.$action;
};
$route['admin/contract/approved'] = function($params = []) {
	$controller = 'Contract';
	$action = '/approved';
	return $controller.$action;
};

$route['admin/create-contract-show'] = function($params = []) {
	$controller = 'Contract';
	$action = '/createShow';
	return $controller.$action;
};
$route['admin/create-contract'] = function($params = []) {
	$controller = 'Contract';
	$action = '/create';
	return $controller.$action;
};

$route['admin/update-contract'] = function($params = []) {
	$controller = 'Contract';
	$action = '/update';
	return $controller.$action;
};

$route['admin/delete-contract'] = function($params = []) {
	$controller = 'Contract';
	$action = '/delete';
	return $controller.$action;
};
$route['admin/update-contract-editable'] = function($params = []) {
	$controller = 'Contract';
	$action = '/updateEditable';
	return $controller.$action;
};

$route['admin/contract-cashflow/ajax-update'] = function($params = []) {
	$controller = 'ContractCashflow';
	$action = '/ajaxUpdate';
	return $controller.$action;
};

$route['admin/update-customer-editable'] = function($params = []) {
	$controller = 'Customer';
	$action = '/updateEditable';
	return $controller.$action;
};
$route['admin/customer/show-your'] = function($params = []) {
    $controller = 'Customer';
    $action = '/showYour';
    return $controller.$action;
};
// Cron
$route['admin/cron-customer'] = function($params = []) {
	$controller = 'CronCustomer';
	$action = '/show';
	return $controller.$action;
};
$route['admin/cron-follow-customer'] = function($params = []) {
	$controller = 'CronCustomer';
	$action = '/follow';
	return $controller.$action;
};

$route['admin/cron-income-contract'] = function($params = []) {
    $controller = 'CronCustomer';
    $action = '/incomeV1';
    return $controller.$action;
};

$route['admin/cron-remove-image'] = function($params = []) {
    $controller = 'CronCustomer';
    $action = '/removeImg';
    return $controller.$action;
};

//

$route['admin/search-business-partner-apartment'] = function($params = []) {
    $controller = 'BusinessPartner';
    $action = '/searchApartment';
    return $controller.$action;
};
$route['admin/list-business-partner'] = function($params = []) {
    $controller = 'BusinessPartner';
    $action = '/show';
    return $controller.$action;
};


$route['admin/create-business-partner'] = function($params = []) {
    $controller = 'BusinessPartner';
    $action = '/create';
    return $controller.$action;
};

$route['admin/business-partner/detail'] = function($params = []) {
    $controller = 'BusinessPartner';
    $action = '/showDetail';
    return $controller.$action;
};

$route['admin/update-business-partner-editable'] = function($params = []) {
    $controller = 'BusinessPartner';
    $action = '/updateEditable';
    return $controller.$action;
};
$route['admin/delete-business-partner'] = function($params = []) {
    $controller = 'BusinessPartner';
    $action = '/delete';
    return $controller.$action;
};

// Crawler
$route['external-api/telegram-bot'] = function($params = []) {
    $controller = 'TelegramBot';
    $action = '/show';
    return $controller.$action;
};

$route['external-api/telegram-bot/index'] = function($params = []) {
    $controller = 'TelegramBot';
    $action = '/index';
    return $controller.$action;
};
$route['public/export-gg-sheet'] = function($params = []) {
    $controller = '/public-world/PublicGoogleSheet';
    $action = '/getJsonData';
    return $controller.$action;
};

// track apartment
$route['admin/list-apartment-track'] = function($params = []) {
    $controller = 'ApartmentTrack';
    $action = '/show';
    return $controller.$action;
};

// customer
$route['admin/search-customer'] = function($params = []) {
	$controller = 'Customer';
	$action = '/search';
	return $controller.$action;
};
$route['admin/list-customer'] = function($params = []) {
	$controller = 'Customer';
	$action = '/show';
	return $controller.$action;
};

$route['admin/list-customer-feedback'] = function($params = []) {
    $controller = 'CustomerFeedback';
    $action = '/show';
    return $controller.$action;
};
$route['personal/customer-feedback/list'] = function($params = []) {
    $controller = 'CustomerFeedback';
    $action = '/showYour';
    return $controller.$action;
};

$route['admin/customer-feedback/detail'] = function($params = []) {
    $controller = 'CustomerFeedback';
    $action = '/detail';
    return $controller.$action;
};

$route['admin/list-care-customer'] = function($params = []) {
	$controller = 'Customer';
	$action = '/care';
	return $controller.$action;
};

$route['admin/detail-customer'] = function($params = []) {
    $controller = 'Customer';
    $action = '/detailShow';
    return $controller.$action;
};

$route['admin/export-customer'] = function($params = []) {
    $controller = 'Customer';
    $action = '/exportExcel';
    return $controller.$action;
};

$route['admin/create-care-customer'] = function($params = []) {
	$controller = 'Customer';
	$action = '/createCare';
	return $controller.$action;
};

$route['admin/create-customer'] = function($params = []) {
	$controller = 'Customer';
	$action = '/create';
	return $controller.$action;
};

$route['admin/customer-get-district'] = function($params = []) {
	$controller = 'Customer';
	$action = '/getDistrict';
	return $controller.$action;
};

$route['admin/update-customer'] = function($params = []) {
	$controller = 'Customer';
	$action = '/update';
	return $controller.$action;
};

$route['admin/delete-customer'] = function($params = []) {
	$controller = 'Customer';
	$action = '/delete';
	return $controller.$action;
};

$route['admin/update-customer-editable'] = function($params = []) {
	$controller = 'Customer';
	$action = '/updateEditable';
	return $controller.$action;
};

// apartment
$route['admin/list-apartment'] = function($params = []) {
	$controller = 'Apartment';
	$action = '/show';
	return $controller.$action;
};

$route['admin/apartment/trending'] = function($params = []) {
    $controller = 'Apartment';
    $action = '/showTrending';
    return $controller.$action;
};

$route['admin/apartment/dashboard/show'] = function($params = []) {
    $controller = 'Apartment';
    $action = '/showDashboard';
    return $controller.$action;
};
$route['admin/ajax/apartment/chart'] = function($params = []) {
    $controller = 'Apartment';
    $action = '/drawChart';
    return $controller.$action;
};
$route['admin/apartment/show-edit'] = function($params = []) {
    $controller = 'Apartment';
    $action = '/showEdit';
    return $controller.$action;
};

$route['admin/profile-apartment'] = function($params = []) {
    $controller = 'Apartment';
    $action = '/showProfile';
    return $controller.$action;
};

$route['admin/apartment/show-by-search'] = function($params = []) {
	$controller = 'Apartment';
	$action = '/showBySearch';
	return $controller.$action;
};

$route['admin/list-apartment-commission-rate'] = function($params = []) {
	$controller = 'Apartment';
	$action = '/showCommmissionRate';
	return $controller.$action;
};

$route['admin/create-consultant-booking'] = function($params = []) {
	$controller = 'Apartment';
	$action = '/createConsultantBooking';
	return $controller.$action;
};

$route['normal/list-apartment'] = function($params = []) {
	$controller = 'role-sale/Apartment';
	$action = '/showNormal';
	return $controller.$action;
};

$route['chart/get-data'] = function($params = []) {
    $controller = 'SystemIncomeRunning';
    $action = '/chartData';
    return $controller.$action;
};

$route['admin/overview-get-new-apartment'] = function($params = []) {
    $controller = 'User';
    $action = '/showOverviewGetNewApartment';
    return $controller.$action;
};

$route['admin/overview-refer-new-user'] = function($params = []) {
    $controller = 'User';
    $action = '/showOverviewReferNewUser';
    return $controller.$action;
};

$route['user/profile'] = function($params = []) {
    $controller = 'User';
    $action = '/showProfile';
    return $controller.$action;
};

$route['user/dashboard'] = function($params = []) {
    $controller = 'User';
    $action = '/showDashboard';
    return $controller.$action;
};

$route['admin/list-share-customer-user'] = function($params = []) {
    $controller = 'ShareCustomerUser';
    $action = '/show';
    return $controller.$action;
};
$route['admin/show-create-share-customer-user'] = function($params = []) {
    $controller = 'ShareCustomerUser';
    $action = '/showCreate';
    return $controller.$action;
};
$route['admin/create-share-customer-user'] = function($params = []) {
    $controller = 'ShareCustomerUser';
    $action = '/create';
    return $controller.$action;
};

$route['admin/delete-share-customer-user'] = function($params = []) {
    $controller = 'ShareCustomerUser';
    $action = '/delete';
    return $controller.$action;
};

$route['admin/create-district'] = function($params = []) {
    $controller = 'District';
    $action = '/create';
    return $controller.$action;
};

$route['admin/update-district'] = function($params = []) {
    $controller = 'District';
    $action = '/update';
    return $controller.$action;
};

$route['admin/delete-district'] = function($params = []) {
    $controller = 'District';
    $action = '/delete';
    return $controller.$action;
};

$route['admin/update-district-editable'] = function($params = []) {
    $controller = 'District';
    $action = '/updateEditable';
    return $controller.$action;
};


$route['admin/list-team'] = function($params = []) {
    $controller = 'Team';
    $action = '/show';
    return $controller.$action;
};

$route['admin/team/detail'] = function($params = []) {
    $controller = 'Team';
    $action = '/detail';
    return $controller.$action;
};

$route['admin/create-team'] = function($params = []) {
    $controller = 'Team';
    $action = '/create';
    return $controller.$action;
};
$route['admin/update-team-editable'] = function($params = []) {
    $controller = 'Team';
    $action = '/updateEditable';
    return $controller.$action;
};

$route['admin/create-team-user'] = function($params = []) {
    $controller = 'Team';
    $action = '/createMember';
    return $controller.$action;
};


$route['admin/list-district'] = function($params = []) {
	$controller = 'District';
	$action = '/show';
	return $controller.$action;
};

$route['admin/create-district'] = function($params = []) {
	$controller = 'District';
	$action = '/create';
	return $controller.$action;
};

$route['admin/update-district'] = function($params = []) {
	$controller = 'District';
	$action = '/update';
	return $controller.$action;
};

$route['admin/delete-district'] = function($params = []) {
	$controller = 'District';
	$action = '/delete';
	return $controller.$action;
};

$route['admin/update-district-editable'] = function($params = []) {
	$controller = 'District';
	$action = '/updateEditable';
	return $controller.$action;
};
// -- google drive
$route['admin/list-google'] = function($params = []) {
	$controller = 'TempGoogle';
	$action = '/show';
	return $controller.$action;
};
// -- apartment type
$route['admin/list-apartment-type'] = function($params = []) {
	$controller = 'BaseApartmentType';
	$action = '/show';
	return $controller.$action;
};

$route['admin/create-apartment-type'] = function($params = []) {
	$controller = 'BaseApartmentType';
	$action = '/create';
	return $controller.$action;
};

$route['admin/update-apartment-type'] = function($params = []) {
	$controller = 'BaseApartmentType';
	$action = '/update';
	return $controller.$action;
};

$route['admin/create-apartment-comment'] = function($params = []) {
	$controller = 'Apartment';
	$action = '/createComment';
	return $controller.$action;
};

$route['admin/delete-apartment-type'] = function($params = []) {
	$controller = 'BaseApartmentType';
	$action = '/delete';
	return $controller.$action;
};

$route['admin/update-apartment-type-editable'] = function($params = []) {
	$controller = 'Tag';
	$action = '/updateEditable';
	return $controller.$action;
};

// -- tag
$route['admin/list-tag'] = function($params = []) {
	$controller = 'Tag';
	$action = '/show';
	return $controller.$action;
};

$route['admin/create-tag'] = function($params = []) {
	$controller = 'Tag';
	$action = '/create';
	return $controller.$action;
};

$route['admin/update-tag'] = function($params = []) {
	$controller = 'Tag';
	$action = '/update';
	return $controller.$action;
};

$route['admin/delete-tag'] = function($params = []) {
	$controller = 'Tag';
	$action = '/delete';
	return $controller.$action;
};

$route['admin/update-tag-editable'] = function($params = []) {
	$controller = 'Tag';
	$action = '/updateEditable';
	return $controller.$action;
};

// -- room type
$route['admin/list-room-type'] = function($params = []) {
    $controller = 'BaseRoomType';
    $action = '/show';
    return $controller.$action;
};
$route['admin/room-type/get-list-editable'] = function($params = []) {
    $controller = 'BaseRoomType';
    $action = '/getEditableRoomTypeId';
    return $controller.$action;
};

$route['admin/create-room-type'] = function($params = []) {
	$controller = 'BaseRoomType';
	$action = '/create';
	return $controller.$action;
};

$route['admin/update-room-type'] = function($params = []) {
	$controller = 'BaseRoomType';
	$action = '/update';
	return $controller.$action;
};

$route['admin/delete-room-type'] = function($params = []) {
	$controller = 'BaseRoomType';
	$action = '/delete';
	return $controller.$action;
};

$route['admin/update-room-type-editable'] = function($params = []) {
	$controller = 'BaseRoomType';
	$action = '/updateEditable';
	return $controller.$action;
};

// ApartmentRequest
$route['sale/apartment-request/show'] = function($params = []) {
    $controller = 'ApartmentRequest';
    $action = '/show';
    return $controller.$action;
};

$route['sale/apartment-request/detail'] = function($params = []) {
    $controller = 'ApartmentRequest';
    $action = '/detail';
    return $controller.$action;
};

$route['sale/apartment-export'] = function($params = []) {
    $controller = 'ApartmentRequest';
    $action = '/exportApartmentExcel';
    return $controller.$action;
};

// -- room
$route['admin/list-room'] = function($params = []) {
	$controller = 'Room';
	$action = '/show';
	return $controller.$action;
};

$route['room/import-from-excel'] = function($params = []) {
    $controller = 'Room';
    $action = '/importRoomExcel';
    return $controller.$action;
};

$route['admin/room/fastUpdatedSlc'] = function($params = []) {
    $controller = 'Room';
    $action = '/fastUpdatedSlc';
    return $controller.$action;
};

$route['admin/create-room'] = function($params = []) {
	$controller = 'Room';
	$action = '/create';
	return $controller.$action;
};
$route['admin/room/show-create'] = function($params = []) {
    $controller = 'Room';
    $action = '/showCreate';
    return $controller.$action;
};
$route['admin/update-room'] = function($params = []) {
	$controller = 'Room';
	$action = '/update';
	return $controller.$action;
};

$route['admin/delete-room'] = function($params = []) {
	$controller = 'Room';
	$action = '/delete';
	return $controller.$action;
};

$route['admin/update-room-editable'] = function($params = []) {
	$controller = 'Room';
	$action = '/updateEditable';
	return $controller.$action;
};

$route['admin/room/sync-status-room'] = function($params = []) {
	$controller = 'Room';
	$action = '/syncStatusRoom';
	return $controller.$action;
};

// -- partner
$route['admin/list-partner'] = function($params = []) {
	$controller = 'Partner';
	$action = '/show';
	return $controller.$action;
};

$route['admin/create-partner'] = function($params = []) {
	$controller = 'Partner';
	$action = '/create';
	return $controller.$action;
};

$route['admin/update-partner'] = function($params = []) {
	$controller = 'Partner';
	$action = '/update';
	return $controller.$action;
};

$route['admin/delete-partner'] = function($params = []) {
	$controller = 'Partner';
	$action = '/delete';
	return $controller.$action;
};

$route['admin/update-partner-editable'] = function($params = []) {
	$controller = 'Partner';
	$action = '/updateEditable';
	return $controller.$action;
};

// -- role
$route['admin/list-role'] = function($params = []) {
	$controller = 'Role';
	$action = '/show';
	return $controller.$action;
};

$route['admin/create-role'] = function($params = []) {
	$controller = 'Role';
	$action = '/create';
	return $controller.$action;
};

$route['admin/update-role'] = function($params = []) {
	$controller = 'Role';
	$action = '/update';
	return $controller.$action;
};

$route['admin/delete-role'] = function($params = []) {
	$controller = 'Role';
	$action = '/delete';
	return $controller.$action;
};

$route['admin/update-role-editable'] = function($params = []) {
	$controller = 'Role';
	$action = '/updateEditable';
	return $controller.$action;
};

// -- user
$route['admin/list-user'] = function($params = []) {
	$controller = 'User';
	$action = '/show';
	return $controller.$action;
};

$route['admin/user/edit'] = function($params = []) {
	$controller = 'User';
	$action = '/edit';
	return $controller.$action;
};

$route['admin/get-user-role'] = function($params = []) {
	$controller = 'User';
	$action = '/getRole';
	return $controller.$action;
};

$route['admin/create-user'] = function($params = []) {
	$controller = 'User';
	$action = '/create';
	return $controller.$action;
};

$route['admin/user/get-select'] = function($params = []) {
	$controller = 'User';
	$action = '/getSelectUser';
	return $controller.$action;
};

$route['admin/update-user'] = function($params = []) {
	$controller = 'User';
	$action = '/update';
	return $controller.$action;
};

$route['admin/delete-user'] = function($params = []) {
	$controller = 'User';
	$action = '/delete';
	return $controller.$action;
};

$route['admin/change-password-user'] = function($params = []) {
	$controller = 'User';
	$action = '/changePassword';
	return $controller.$action;
};

$route['admin/update-user-editable'] = function($params = []) {
	$controller = 'User';
	$action = '/updateEditable';
	return $controller.$action;
};

// -- permission
$route['admin/list-permission'] = function($params = []) {
	$controller = 'PermissionRole';
	$action = '/show';
	return $controller.$action;
};

$route['admin/update-permission-role'] = function($params = []) {
	$controller = 'PermissionRole';
	$action = '/update';
	return $controller.$action;
};

// -- role-rule
$route['admin/list-role-rule'] = function($params = []) {
	$controller = 'RolePermission';
	$action = '/show';
	return $controller.$action;
};

$route['admin/create-role-rule'] = function($params = []) {
	$controller = 'RolePermission';
	$action = '/create';
	return $controller.$action;
};

$route['admin/update-role-rule'] = function($params = []) {
	$controller = 'RolePermission';
	$action = '/update';
	return $controller.$action;
};

$route['admin/delete-role-rule'] = function($params = []) {
	$controller = 'RolePermission';
	$action = '/delete';
	return $controller.$action;
};

$route['admin/update-role-rule-editable'] = function($params = []) {
	$controller = 'RolePermission';
	$action = '/update';
	return $controller.$action;
};
$route['admin/detail-user-role-rule'] = function($params = []) {
	$controller = 'RolePermission';
	$action = '/show';
	return $controller.$action;
};


// Login
$route['admin/login'] = function($params = []) {
	$controller = 'Login';
	$action = '/show';
	return $controller.$action;
};


// -- apartment
$route['admin/list-apartment/(:any)'] = function($product_type) {
	$controller = 'Apartment';
	$action = '/show/'.$product_type;
	return $controller.$action;
};

$route['admin/apartment/edit-description'] = function($params = []) {
    $controller = 'Apartment';
    $action = '/editDescription';
    return $controller.$action;
};
$route['admin/apartment/create'] = function($params = []) {
    $controller = 'Apartment';
    $action = '/showCreate';
    return $controller.$action;
};
$route['admin/apartment/following/update'] = function($params = []) {
    $controller = 'Apartment';
    $action = '/updateFollowing';
    return $controller.$action;
};

$route['admin/apartment/rating'] = function($params = []) {
    $controller = 'Apartment';
    $action = '/updateRating';
    return $controller.$action;
};

$route['admin/create-apartment'] = function($params = []) {
	$controller = 'Apartment';
	$action = '/create';
	return $controller.$action;
};

$route['admin/update-apartment'] = function($params = []) {
	$controller = 'Apartment';
	$action = '/update';
	return $controller.$action;
};

$route['admin/delete-apartment'] = function($params = []) {
	$controller = 'Apartment';
	$action = '/delete';
	return $controller.$action;
};

$route['admin/update-apartment-editable'] = function($params = []) {
	$controller = 'Apartment';
	$action = '/updateEditable';
	return $controller.$action;
};

$route['admin/list-apartment-like-base'] = function($params = []) {
	$controller = 'Apartment';
	$action = '/showLikeBase';
	return $controller.$action;
};

$route['admin/apartment-get-district'] = function($params = []) {
	$controller = 'Apartment';
	$action = '/getDistrict';
	return $controller.$action;
};
$route['admin/apartment-get-ward'] = function($params = []) {
    $controller = 'Apartment';
    $action = '/getWard';
    return $controller.$action;
};
$route['admin/apartment-get-partner'] = function($params = []) {
	$controller = 'Apartment';
	$action = '/getPartner';
	return $controller.$action;
};

$route['admin/apartment-get-tag'] = function($params = []) {
	$controller = 'Apartment';
	$action = '/getTag';
	return $controller.$action;
};
//
$route['report/issue-apm-info'] = function($params = []) {
    $controller = 'ApartmentReport';
    $action = '/updateIssueApartmentInfo';
    return $controller.$action;
};

//

$route['admin/get-room-type'] = function($params = []) {
	$controller = 'Room';
	$action = '/getType';
	return $controller.$action;
};

$route['admin/room/time-available/get'] = function($params = []) {
	$controller = 'Room';
	$action = '/getListRoomOldTimeAvailable';
	return $controller.$action;
};
$route['admin/get-room-status'] = function($params = []) {
	$controller = 'Room';
	$action = '/getStatus';
	return $controller.$action;
};
$route['admin/get-room-price'] = function($params = []) {
	$controller = 'Room';
	$action = '/getPrice';
	return $controller.$action;
};

$route['admin/room/fast-update'] = function($params = []) {
    $controller = 'Room';
    $action = '/fastUpdate';
    return $controller.$action;
};

$route['admin/create-room-datatable'] = function($params = []) {
	$controller = 'Room';
	$action = '/createDatatable';
	return $controller.$action;
};

// admin/userdistrict
$route['admin/list-user-district'] = function($params = []) {
	$controller = 'UserDistrict';
	$action = '/show';
	return $controller.$action;
};


$route['admin/create-user-district'] = function($params = []) {
    $controller = 'UserDistrict';
    $action = '/create';
    return $controller.$action;
};

$route['admin/user-setting/update'] = function($params = []) {
    $controller = 'UserConfig';
    $action = '/update';
    return $controller.$action;
};
// admin/image
$route['admin/upload-image'] = function($params = []) {
	$controller = 'Image';
	$action = '/show';
	return $controller.$action;
};

$route['admin/update-image'] = function($params = []) {
	$controller = 'Image';
	$action = '/update';
	return $controller.$action;
};

$route['admin/show-image-apartment'] = function($params = []) {
	$controller = 'Image';
	$action = '/showGalleryApartment';
	return $controller.$action;
};

$route['admin/delete-image'] = function($params = []) {
    $controller = 'Image';
    $action = '/delete';
    return $controller.$action;
};

$route['ajax/get-room-images'] = function($params = []) {
    $controller = 'Image';
    $action = '/ajax_get_room_image';
    return $controller.$action;
};
$route['admin/image/show-room'] = function($params = []) {
    $controller = 'Image';
    $action = '/showRoom';
    return $controller.$action;
};
// MEDIA
$route['admin/apartment/upload-img'] = function($params = []) {
    $controller = 'Media';
    $action = '/uploadImgApartment';
    return $controller.$action;
};

$route['admin/apartment/show-image'] = function($params = []) {
    $controller = 'Media';
    $action = '/showImgApartment';
    return $controller.$action;
};

$route['admin/ajax/apartment/show-img'] = function($params = []) {
    $controller = 'Media';
    $action = '/ajaxApartmentShowImage';
    return $controller.$action;
};

$route['admin/ajax/gallery/show-img'] = function($params = []) {
    $controller = 'Media';
    $action = '/ajaxGalleryShowImage';
    return $controller.$action;
};

$route['admin/ajax/gallery/show-img/service'] = function($params = []) {
    $controller = 'Media';
    $action = '/ajaxGalleryShowImageService';
    return $controller.$action;
};

$route['admin/ajax/gallery/upload-img/service'] = function($params = []) {
    $controller = 'Media';
    $action = '/uploadImgService';
    return $controller.$action;
};
$route['admin/gallery/delete'] = function($params = []) {
    $controller = 'Media';
    $action = '/delete';
    return $controller.$action;
};

$route['admin/gallery/delete-by-room'] = function($params = []) {
    $controller = 'Media';
    $action = '/deleteByRoom';
    return $controller.$action;
};


$route['admin/apartment/search'] = function($params = []) {
	$controller = 'Apartment';
	$action = '/searchApartment';
	return $controller.$action;
};

$route['admin/apartment/duplicate'] = function($params = []) {
    $controller = 'Apartment';
    $action = '/duplicateApartment';
    return $controller.$action;
};


$route['admin/download-image-apartment'] = function($params = []) {
    $controller = 'Image';
    $action = '/downloadMedia';
    return $controller.$action;
};

$route['admin/download-all-image-apartment'] = function($params = []) {
    $controller = 'Image';
    $action = '/downloadAllMediaApartment';
    return $controller.$action;
};

$route['admin/download-image-by-room'] = function($params = []) {
    $controller = 'Image';
    $action = '/downloadByRoom';
    return $controller.$action;
};


// admin/price
$route['admin/list-price'] = function($params = []) {
	$controller = 'BasePrice';
	$action = '/show';
	return $controller.$action;
};

$route['admin/create-price'] = function($params = []) {
	$controller = 'BasePrice';
	$action = '/create';
	return $controller.$action;
};

$route['admin/update-price'] = function($params = []) {
	$controller = 'BasePrice';
	$action = '/update';
	return $controller.$action;
};

$route['admin/update-price'] = function($params = []) {
	$controller = 'BasePrice';
	$action = '/update';
	return $controller.$action;
};

$route['admin/delete-price'] = function($params = []) {
	$controller = 'BasePrice';
	$action = '/delete';
	return $controller.$action;
};

$route['admin/update-price-editable'] = function($params = []) {
	$controller = 'BasePrice';
	$action = '/updateEditable';
	return $controller.$action;
};

$route['admin/room/create-shaft'] = function($params = []) {
    $controller = 'Room';
    $action = '/createShaft';
    return $controller.$action;
};

$route['admin/room/create-shaft'] = function($params = []) {
    $controller = 'Room';
    $action = '/createShaft';
    return $controller.$action;
};

$route['admin/get-room-shaft'] = function($params = []) {
    $controller = 'Room';
    $action = '/getShaft';
    return $controller.$action;
};

// POST

$route['admin/ajax/create-consulting-post'] = function($params = []) {
    $controller = 'Image';
    $action = '/createConsultingPost';
    return $controller.$action;
};

$route['sinva-home/post/detail-editorial'] = function($params = []) {
    $controller = '/public-world/PublicConsultingPost';
    $action = '/detailEditorial';
    return $controller.$action;
};

$route['sinva/commission-billing/detail'] = function($params = []) {
    $controller = '/public-world/PublicCommissionBilling';
    $action = '/showDetail';
    return $controller.$action;
};

$route['public/customer-feedback/show'] = function($params = []) {
    $controller = '/public-world/PublicCustomerFeedback';
    $action = '/show';
    return $controller.$action;
};

$route['public/customer-feedback/create'] = function($params = []) {
    $controller = '/public-world/PublicCustomerFeedback';
    $action = '/create';
    return $controller.$action;
};

$route['admin/user-contract-order'] = function($params = []) {
    $controller = 'UserContractOrder';
    $action = '/showCreate';
    return $controller.$action;
};

$route['admin/list-internal-content'] = function($params = []) {
    $controller = 'InternalContent';
    $action = '/show';
    return $controller.$action;
};

$route['admin/internal-content/create'] = function($params = []) {
    $controller = 'InternalContent';
    $action = '/create';
    return $controller.$action;
};

// Merge Business Apartment
$route['admin/consultant-post/your-list'] = function($params = []) {
    $controller = 'ConsultantPost';
    $action = '/showYour';
    return $controller.$action;
};

$route['admin/consultant-post/detail'] = function($params = []) {
    $controller = 'ConsultantPost';
    $action = '/showDetail';
    return $controller.$action;
};

// VIEW NUMBER
$route['admin/apartment-view/create'] = function($params = []) {
    $controller = 'ApartmentView';
    $action = '/create';
    return $controller.$action;
};

/* :::SHARE:::*/
$route['facebook/sendapi'] = function($params = []) {
    $controller = 'Facebook';
    $action = '/sendApi';
    return $controller.$action;
};

$route['share/agency-group/dashboard/show'] = function($params = []) {
    $controller = 'ShDashboard';
    $action = '/show';
    return $controller.$action;
};

$route['share/agency-group/dashboard/show-group-detail'] = function($params = []) {
    $controller = 'ShDashboard';
    $action = '/showGroupDetail';
    return $controller.$action;
};

$route['share/agency-group/show'] = function($params = []) {
    $controller = 'ShAgencyGroup';
    $action = '/show';
    return $controller.$action;
};

$route['share/agency-group-apartment/show'] = function($params = []) {
    $controller = 'ShAgencyGroupApartment';
    $action = '/show';
    return $controller.$action;
};

$route['share/user/show'] = function($params = []) {
    $controller = 'ShUser';
    $action = '/show';
    return $controller.$action;
};

$route['share/agency-group/create'] = function($params = []) {
    $controller = 'ShAgencyGroup';
    $action = '/create';
    return $controller.$action;
};

$route['share/user/create'] = function($params = []) {
    $controller = 'ShUser';
    $action = '/create';
    return $controller.$action;
};
$route['share/user/show'] = function($params = []) {
    $controller = 'ShUser';
    $action = '/show';
    return $controller.$action;
};
$route['share/agency-group/apartment/list'] = function($params = []) {
    $controller = 'ShAgencyGroup';
    $action = '/create';
    return $controller.$action;
};

$route['share/email-template/show'] = function($params = []) {
    $controller = 'ShEmailTemplate';
    $action = '/show';
    return $controller.$action;
};
/*HOMETOWN*/


$route['home-town/show'] = function($params = []) {
    $controller = 'Apartment';
    $action = '/show';
    return $controller.$action;
};

/* :::API-INTERNAL:::*/

$route['api-internal/apartments'] = function($params = []) {
    $controller = '/api-internal/Apartment';
    $action = '/apartment';
    return $controller.$action;
};

$route['api-internal/apartment/:num'] = function($params = []) {
    $controller = '/api-internal/Apartment';
    $action = '/apartmentById';
    return $controller.$action;
};

$route['translate_uri_dashes'] = FALSE;
