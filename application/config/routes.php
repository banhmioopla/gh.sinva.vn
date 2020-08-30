<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'Login';
$route['404_override'] = '';

$route['admin/logout'] = function($params = []) {
	$controller = 'Login';
	$action = '/logout';
	return $controller.$action;
};

$route['admin/list-apartment'] = function($params = []) {
	$controller = 'Apartment';
	$action = '/show';
	return $controller.$action;
};

$route['normal/list-apartment'] = function($params = []) {
	$controller = 'role-sale/Apartment';
	$action = '/showNormal';
	return $controller.$action;
};

$route['admin/list-district'] = function($params = []) {
	$controller = 'district';
	$action = '/index'; // hàm
	return $controller.$action;
};

$route['admin/create-district'] = function($params = []) {
	$controller = 'district';
	$action = '/create';
	return $controller.$action;
};

$route['admin/update-district'] = function($params = []) {
	$controller = 'district';
	$action = '/update';
	return $controller.$action;
};

$route['admin/delete-district'] = function($params = []) {
	$controller = 'district';
	$action = '/delete';
	return $controller.$action;
};

$route['admin/update-district-editable'] = function($params = []) {
	$controller = 'district';
	$action = '/updateEditable';
	return $controller.$action;
};
// -- google drive
$route['admin/list-google'] = function($params = []) {
	$controller = 'TempGoogle';
	$action = '/index';
	return $controller.$action;
};
// -- apartment type
$route['admin/list-apartment-type'] = function($params = []) {
	$controller = 'BaseApartmentType';
	$action = '/index';
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
	$action = '/index';
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
	$action = '/index';
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

// -- room
$route['admin/list-room'] = function($params = []) {
	$controller = 'Room';
	$action = '/index';
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
	$controller = 'partner';
	$action = '/index';
	return $controller.$action;
};

$route['admin/create-partner'] = function($params = []) {
	$controller = 'partner';
	$action = '/create';
	return $controller.$action;
};

$route['admin/update-partner'] = function($params = []) {
	$controller = 'partner';
	$action = '/update';
	return $controller.$action;
};

$route['admin/delete-partner'] = function($params = []) {
	$controller = 'partner';
	$action = '/delete';
	return $controller.$action;
};

$route['admin/update-partner-editable'] = function($params = []) {
	$controller = 'partner';
	$action = '/updateEditable';
	return $controller.$action;
};

// -- role
$route['admin/list-role'] = function($params = []) {
	$controller = 'role';
	$action = '/index';
	return $controller.$action;
};

$route['admin/create-role'] = function($params = []) {
	$controller = 'role';
	$action = '/create';
	return $controller.$action;
};

$route['admin/update-role'] = function($params = []) {
	$controller = 'role';
	$action = '/update';
	return $controller.$action;
};

$route['admin/delete-role'] = function($params = []) {
	$controller = 'role';
	$action = '/delete';
	return $controller.$action;
};

$route['admin/update-role-editable'] = function($params = []) {
	$controller = 'role';
	$action = '/updateEditable';
	return $controller.$action;
};

// -- user
$route['admin/list-user'] = function($params = []) {
	$controller = 'user';
	$action = '/index';
	return $controller.$action;
};

$route['admin/get-user-role'] = function($params = []) {
	$controller = 'user';
	$action = '/getRole';
	return $controller.$action;
};

$route['admin/create-user'] = function($params = []) {
	$controller = 'user';
	$action = '/create';
	return $controller.$action;
};

$route['admin/update-user'] = function($params = []) {
	$controller = 'user';
	$action = '/update';
	return $controller.$action;
};

$route['admin/delete-user'] = function($params = []) {
	$controller = 'user';
	$action = '/delete';
	return $controller.$action;
};

$route['admin/update-user-editable'] = function($params = []) {
	$controller = 'user';
	$action = '/updateEditable';
	return $controller.$action;
};

// -- permission
$route['admin/list-permission'] = function($params = []) {
	$controller = 'permission';
	$action = '/index';
	return $controller.$action;
};

// -- role-rule
$route['admin/list-role-rule'] = function($params = []) {
	$controller = 'RolePermission';
	$action = '/index';
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
	$controller = 'apartment';
	$action = '/show';
	return $controller.$action;
};

$route['admin/create-apartment'] = function($params = []) {
	$controller = 'apartment';
	$action = '/create';
	return $controller.$action;
};

$route['admin/update-apartment'] = function($params = []) {
	$controller = 'apartment';
	$action = '/update';
	return $controller.$action;
};

$route['admin/delete-apartment'] = function($params = []) {
	$controller = 'apartment';
	$action = '/delete';
	return $controller.$action;
};

$route['admin/update-apartment-editable'] = function($params = []) {
	$controller = 'apartment';
	$action = '/updateEditable';
	return $controller.$action;
};

$route['admin/list-apartment-like-base'] = function($params = []) {
	$controller = 'apartment';
	$action = '/showLikeBase';
	return $controller.$action;
};

$route['admin/apartment-get-district'] = function($params = []) {
	$controller = 'apartment';
	$action = '/getDistrict';
	return $controller.$action;
};
$route['admin/apartment-get-partner'] = function($params = []) {
	$controller = 'apartment';
	$action = '/getPartner';
	return $controller.$action;
};

$route['admin/apartment-get-tag'] = function($params = []) {
	$controller = 'apartment';
	$action = '/getTag';
	return $controller.$action;
};
//

$route['admin/get-room-type'] = function($params = []) {
	$controller = 'room';
	$action = '/getType';
	return $controller.$action;
};
$route['admin/get-room-status'] = function($params = []) {
	$controller = 'room';
	$action = '/getStatus';
	return $controller.$action;
};
$route['admin/get-room-price'] = function($params = []) {
	$controller = 'room';
	$action = '/getPrice';
	return $controller.$action;
};

$route['admin/create-room-datatable'] = function($params = []) {
	$controller = 'room';
	$action = '/createDatatable';
	return $controller.$action;
};

// admin/userdistrict
$route['admin/list-user-district'] = function($params = []) {
	$controller = 'userdistrict';
	$action = '/show';
	return $controller.$action;
};

// admin/image
$route['admin/upload-image'] = function($params = []) {
	$controller = 'image';
	$action = '/show';
	return $controller.$action;
};

$route['admin/update-image'] = function($params = []) {
	$controller = 'image';
	$action = '/update';
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
