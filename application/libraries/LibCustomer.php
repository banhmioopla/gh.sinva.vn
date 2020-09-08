<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibCustomer {
    public $CI;
    public function __construct () {
        $this->CI =& get_instance();
        $this->CI->load->model('ghCustomer');
    }

    public function getNameById($room_type_id){
        $room_type = $this->CI->ghCustomer->getById($room_type_id);

        $name = $room_type ? $room_type[0]['name'] : '';
        return $name;
    }

    public function cb($price_id = 0) {
        $list_price = $this->CI->ghCustomer->get();
        $cb = '<option value=0>chọn khách hàng ...</option>';
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