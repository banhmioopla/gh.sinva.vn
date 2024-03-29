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
        $cb = '<option value="">Chọn Quận ...</option>';
        if(!empty($list_district)) {
            foreach ($list_district as $district) {
                $selected = '';
                if($district['code'] == $district_code) {
                    $selected = 'selected';
                }
                $cb .= '<option '.$selected.' value='.$district['code'].'>Quận '.$district['name'].'</option>';
            }
        }
        return $cb;
    }

    public function getListDistrictCode() {
        $list_district = $this->CI->ghDistrict->getByActive();
        $output = [];
        if(!empty($list_district)) {
            foreach ($list_district as $district) {
                $output[] = $district['code'];
            }
        }
        return $output;
    }

    public function getNameById($district_id) {
        $district = $this->CI->ghDistrict->get(['id' => $district_id]);
        return $district ? $district[0]['name'] :'';
    }

    public function getNameByCode($district_code) {
        $district = $this->CI->ghDistrict->getFirstByCode($district_code);
        return !empty($district) ? $district['name'] :'';
    }
}
?>