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
            $address = '[không có thông tin] xx ';
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

    public function cbCodeByApartmentId($apartment_id, $room_id) {
        $list_room = $this->CI->ghRoom->get(['active' => 'YES', 'apartment_id'=> $apartment_id]);
        $cb = '<option value=0>chọn mã phòng ...</option>';
        if(!empty($list_room)) {
            foreach ($list_room as $room) {
                $selected = '';
                if($room['id'] == $room_id) {
                    $selected = 'selected';
                }
                $cb .= '<option '.$selected.' value='.$room['id'].'>'.$room['code']. ' - Giá: '.number_format($room['price']).'</option>';
            }
        }
        return $cb;
    }
}

?>