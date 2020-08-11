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
}

?>