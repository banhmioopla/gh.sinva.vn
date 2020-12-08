<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibPenalty {
    public $CI;
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('ghPenalty');
    }

    public function cbActive($partner_id = 0){
        $list_partner = $this->CI->ghPenalty->getByActive();
        $cb = '<option value= 0 >chọn đối tác ...</option>';
        if(!empty($list_partner)) {
            foreach ($list_partner as $partner) {
                $selected = '';
                if($partner['id'] == $partner_id) {
                    $selected = 'selected';
                }
                $cb .= '<option '.$selected.' value='.$partner['id'].'>ĐT. '.$partner['name'].'</option>';
            }
        }
        return $cb;
    }

    public function getNameById($id) {
        $obj = $this->CI->ghPenalty->get(['id' => $id]);
        return $obj ? $obj[0]['name'] :'';
    }
}
?>