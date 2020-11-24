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

// team
$route['admin/list-team'] = function($params = []) {
	$controller = 'Team';
	$action = '/show';
	return $controller.$action;
};
$route['admin/create-team'] = function($params = []) {
	$controller = 'Team';
	$action = '/create';
	return $controller.$action;
};
$route['admin/list-dashboard'] = function($params = []) {
	$controller = 'Dashboard';
	$action = '/show';
	return $controller.$action;
};

$route['admin/dashboard/list-chart'] = function($params = []) {
    $controller = 'Dashboard';
    $action = '/showTest';
    return $controller.$action;
};
// report - booking customer
$route['admin/list-consultant-booking'] = function($params = []) {
	$controller = 'ConsultantBooking';
	$action = '/show';
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
$route['admin/list-rp-booking-customer'] = function($params = []) {
	$controller = 'Report';
	$action = '/showBookingCustomer';
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
// contract
$route['admin/list-contract'] = function($params = []) {
	$controller = 'Contract';
	$action = '/show';
	return $controller.$action;
};

$route['admin/detail-contract'] = function($params = []) {
	$controller = 'Contract';
	$action = '/detailShow';
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

$route['admin/update-customer-editable'] = function($params = []) {
	$controller = 'Customer';
	$action = '/updateEditable';
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

$route['admin/update-business-partner-editable'] = function($params = []) {
    $controller = 'BusinessPartner';
    $action = '/updateEditable';
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
$route['admin/list-care-customer'] = function($params = []) {
	$controller = 'Customer';
	$action = '/care';
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
// Fee
$route['admin/list-fee-contract-income'] = function($params = []) {
    $controller = 'Fee';
    $action = '/showContractIncome';
    return $controller.$action;
};

$route['admin/list-fee-income-mechanism'] = function($params = []) {
    $controller = 'Fee';
    $action = '/showIncomeMechanism';
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

// -- service
$route['admin/list-service'] = function($params = []) {
	$controller = 'Service';
	$action = '/show';
	return $controller.$action;
};

$route['admin/create-service'] = function($params = []) {
	$controller = 'Service';
	$action = '/create';
	return $controller.$action;
};

$route['admin/update-service'] = function($params = []) {
	$controller = 'Service';
	$action = '/update';
	return $controller.$action;
};

$route['admin/delete-service'] = function($params = []) {
	$controller = 'Service';
	$action = '/delete';
	return $controller.$action;
};

$route['admin/update-service-editable'] = function($params = []) {
	$controller = 'Service';
	$action = '/updateEditable';
	return $controller.$action;
};

// -- room
$route['admin/list-room'] = function($params = []) {
	$controller = 'Room';
	$action = '/show';
	return $controller.$action;
};

$route['admin/create-room'] = function($params = []) {
	$controller = 'Room';
	$action = '/create';
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
$route['admin/list-apartment'] = function($params = []) {
	$controller = 'Apartment';
	$action = '/show';
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

$route['admin/get-room-type'] = function($params = []) {
	$controller = 'Room';
	$action = '/getType';
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

$route['admin/search-apartment'] = function($params = []) {
	$controller = 'Image';
	$action = '/searchApartment';
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


$route['translate_uri_dashes'] = FALSE;
