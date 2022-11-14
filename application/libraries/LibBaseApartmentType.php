<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibBaseApartmentType {
    public $CI;
    public function __construct () {
        $this->CI =& get_instance();
        $this->CI->load->model('ghBaseApartmentType');
		$this->CI->load->model('ghDistrict');
    }
    
    public function getCbByActive($apartment_type_id = 0){
        $list_apartment_type = $this->CI->ghBaseApartmentType->getByActive();
        $cb = '<option value=0> Chọn loại dự án (tòa nhà)... </option>';
        foreach ($list_apartment_type as $apartment_type) {
            $selected = '';
            if($apartment_type['id'] == $apartment_type_id) {
                $selected = 'selected';
            }
            $cb .= '<option '.$selected.' value='.$apartment_type['id'].'> - '.$apartment_type['name'].'</option>';
        }

        return $cb;
    }
}
?>