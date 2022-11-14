<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibBasePrice {
    public $CI;
    public function __construct () {
        $this->CI =& get_instance();
        $this->CI->load->model('ghBasePrice');
        $this->CI->load->helper('money');
    }

    public function getNameById($room_type_id){
        $room_type = $this->CI->ghBasePrice->getById($room_type_id);

        $name = $room_type ? $room_type[0]['name'] : '';
        return $name;
    }

    public function cbActive($price_id) {
        $list_price = $this->CI->ghBasePrice->get(['active' => 'YES']);
        $cb = '<option value=0>chọn giá ...</option>';
        if(!empty($list_price)) {
            foreach ($list_price as $price) {
                $selected = '';
                if($price['id'] == $price_id) {
                    $selected = 'selected';
                }

                $cb .= '<option '.$selected.' value='.$price['id'].'>'.$price['name'].'</option>';
            }
        }
        return $cb;
    }
}
?>