<?php

class LibRoom {
    public $CI;
    public function __construct()
	{
        $this->CI =& get_instance();
		$this->CI->load->model('ghDistrict');
		$this->CI->load->model('ghApartment');
		$this->CI->load->model('ghRoom');
    }

    public function getByApartmentId($apartment_id) {
        $room_list = $this->CI->ghRoom->getByApartmentId($apartment_id);
        return $room_list;
    }

    public function getCodeById($room_id) {
        $room = $this->CI->ghRoom->get(['id' => $room_id, 'active' => 'YES']);
        return $room ? $room[0]['code'] : '';
    }

    public function getAddressById($room_id) {
        $room = $this->CI->ghRoom->get(['id' => $room_id, 'active' => 'YES']);
        $address = '[không có thông tin]';
        if($room) {
            $address = '[không có thông tin]';
            $apartment = $this->CI->ghApartment->get(['id' => $room[0]['apartment_id']]);
            if($apartment) {
                $address = $apartment[0]['address_street'];
            }
        }
        return $address;
    }

    public function getByApartmentIdAndActive($apartment_id) {
        $room_list = $this->CI->ghRoom->getByApartmentIdAndActive($apartment_id);
        return $room_list;
    }

    public function cbAvailableRoomPrice($room_id = 0){
        $list_room = $this->CI->ghRoom->getPriceList('gh_room.status = "Available" ', 'gh_room.price');
        $cb = '<option value=0>Giá Phòng</option>';
        if(!empty($list_room)) {
            foreach ($list_room as $room) {
                $selected = '';
                if($room['price'] == $room_id) {
                    $selected = 'selected';
                }
                $status = '';
                $status_text = '';
                if($room['status'] == 'Available') {
                    $status = 'text-success';
                    $status_text .= ' - trống';
                }
                if($room['time_available'] > 0) {
                    $status = 'text-warning';
                    $status_text .= ' - <span class="text-warning">'. date('d/m/Y', $room['time_available']) . '</span>';
                }

                $cb .= '<option '.$selected.' value='.$room['price'].'> '.number_format($room['price']).' ('.$room["object_counter"].')</option>';
            }
        }
        return $cb;
    }

    public function cbAvailableRoomArea($room_id = 0){
        $list_room = $this->CI->ghRoom->getAreaList('gh_room.status = "Available" ', 'gh_room.area');

        $cb = '<option value=0>Diện tích</option>';
        if(!empty($list_room)) {
            foreach ($list_room as $room) {
                $selected = '';
                if($room['area'] == $room_id) {
                    $selected = 'selected';
                }
                $status = '';
                $status_text = '';
                if($room['status'] == 'Available') {
                    $status = 'text-success';
                    $status_text .= ' - trống';
                }
                if($room['time_available'] > 0) {
                    $status = 'text-warning';
                    $status_text .= ' - <span class="text-warning">'. date('d/m/Y', $room['time_available']) . '</span>';
                }

                $cb .= '<option class=" font-weight-bold '.$status.'" '.$selected.' value='.$room['area'].'> - DT: '.number_format($room['area']).' ('.$room["object_counter"].')</option>';
            }
        }
        return $cb;
    }

    public function cbCodeByApartmentId($apartment_id, $room_id) {
        $list_room = $this->CI->ghRoom->get(['active' => 'YES', 'apartment_id'=> $apartment_id]);
        $cb = '<option value=0>Mã Phòng</option>';
        if(!empty($list_room)) {
            foreach ($list_room as $room) {
                $selected = '';
                if($room['id'] == $room_id) {
                    $selected = 'selected';
                }
                $status = '';
                $status_text = '';
                if($room['status'] == 'Available') {
                    $status = 'text-success';
                    $status_text .= ' - trống';
                }
                if($room['time_available'] > 0) {
                    $status = 'text-warning';
                    $status_text .= ' - <span class="text-warning">'. date('d/m/Y', $room['time_available']) . '</span>';
                }

                $cb .= '<option class=" font-weight-bold '.$status.'" '.$selected.' value='.$room['id'].'>'.$room['code']. ' - Giá: '.number_format($room['price']).$status_text.'</option>';
            }
        }
        return $cb;
    }
}

?>