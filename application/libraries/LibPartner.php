<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibPartner {
    public $CI;
    public function __construct()
	{
        $this->CI =& get_instance();
		$this->CI->load->model('ghPartner');
    }
    
    public function cbActive($partner_id = 0){
        $list_partner = $this->CI->ghPartner->getByActive();
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

    public function getNameById($partner_id) {
        $partner = $this->CI->ghPartner->get(['id' => $partner_id]);
        return $partner ? $partner[0]['name'] :'';
    }
}
?>