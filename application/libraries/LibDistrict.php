<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibDistrict {
    public $CI;
    public function __construct()
	{
        $this->CI =& get_instance();
		$this->CI->load->model('ghDistrict');
    }
    
    public function getCbByActive($district_id = 0){
        $list_district = $this->CI->ghDistrict->getByActive();
        $cb = '<option value=0>chọn quận ...</option>';
        if(!empty($list_district)) {
            foreach ($list_district as $district) {
                $selected = '';
                if($district['id'] == $district_id) {
                    $selected = 'selected';
                }
                $cb .= '<option '.$selected.' value='.$district['id'].'>quận '.$district['name'].'</option>';
            }
        }
        return $cb;
    }

    public function getNameById($district_id) {
        $district = $this->CI->ghDistrict->get(['id' => $district_id]);
        return $district ? $district[0]['name'] :'';
    }

    public function test() {
        return "hello";
    }
}
?>