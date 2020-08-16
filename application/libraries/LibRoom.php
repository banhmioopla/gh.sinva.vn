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
                $cb .= '<option '.$selected.' value='.$room['id'].'>'.$room['code'].'</option>';
            }
        }
        return $cb;
    }
}

?>