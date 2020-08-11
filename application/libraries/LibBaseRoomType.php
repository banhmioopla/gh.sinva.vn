<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibBaseRoomType {
    public $CI;
    public function __construct () {
        $this->CI =& get_instance();
        $this->CI->load->model('ghBaseRoomType');

    }
    
    public function getNameById($room_type_id){
        $room_type = $this->CI->ghBaseRoomType->getById($room_type_id);

        $name = $room_type ? $room_type[0]['name'] : '';
        return $name;
    }
}
?>