<?php

class LibRoom {
    public $CI;
    public function __construct()
	{
        $this->CI =& get_instance();
		$this->CI->load->model('ghDistrict');
		$this->CI->load->model('ghApartment');
		$this->CI->load->model('ghApartmentShaft');
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
        $cb = '<option value="">Chọn giá phòng</option>';
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

                $cb .= '<option '.$selected.' value='.$room['price'].'> '.number_format($room['price']/1000).' ('.$room["object_counter"].')</option>';
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

    public function getSaleTotalFromRoom($room_id, $from, $to){

        $from_time = strtotime($from);
        $to_time = strtotime($to);

        $list_contract = $this->ghContract->get([
            'time_insert >=' => $from_time,
            'time_insert <=' => $to_time,
            'room_id' => $room_id
        ]);
        $total = 0;
        foreach ($list_contract as $ct) {
            $total += $ct['room_price'] * $ct['commission_rate'] / 100;

        }

        return $total;

    }

    public function getNameByShaftId($shaft_id) {
        $model = $this->CI->ghApartmentShaft->getFirstById($shaft_id);
        if($model) {
            return $model['name'];
        }
        return '';
    }
}

?>