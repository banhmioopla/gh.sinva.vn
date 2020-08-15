<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibDistrict {
    public $CI;
    public function __construct()
	{
        $this->CI =& get_instance();
		$this->CI->load->model('ghDistrict');
    }
    
    public function cbActive($district_code = ''){
        $list_district = $this->CI->ghDistrict->getByActive();
        $cb = '<option value="">chọn quận ...</option>';
        if(!empty($list_district)) {
            foreach ($list_district as $district) {
                $selected = '';
                if($district['code'] == $district_code) {
                    $selected = 'selected';
                }
                $cb .= '<option '.$selected.' value='.$district['code'].'>Q. '.$district['name'].'</option>';
            }
        }
        return $cb;
    }

    public function getNameById($district_id) {
        $district = $this->CI->ghDistrict->get(['id' => $district_id]);
        return $district ? $district[0]['name'] :'';
    }

    public function getNameByCode($district_code) {
        $district = $this->CI->ghDistrict->get(['code' => $district_code]);
        return $district ? $district[0]['name'] :'';
    }
}
?>