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

    public function cbActive($type_id) {
        $list_room_type = $this->CI->ghBaseRoomType->get(['active' => 'YES']);
        $cb = '<option value=0>chọn loại phòng ...</option>';
        if(!empty($list_room_type)) {
            foreach ($list_room_type as $type) {
                $selected = '';
                if($type['id'] == $type_id) {
                    $selected = 'selected';
                }
                $cb .= '<option '.$selected.' value='.$type['id'].'>'.$type['name'].'</option>';
            }
        }
        return $cb;
    }
}
?>