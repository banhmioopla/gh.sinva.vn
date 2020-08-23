<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibTag {
    public $CI;
    public function __construct()
	{
        $this->CI =& get_instance();
		$this->CI->load->model('ghTag');
    }
    
    public function cbActive($tag_id = ''){
        $list_tag = $this->CI->ghTag->getByActive();
        $cb = '<option value="">chọn # ...</option>';
        if(!empty($list_tag)) {
            foreach ($list_tag as $tag) {
                $selected = '';
                if($tag['id'] == $tag_id) {
                    $selected = 'selected';
                }
                $cb .= '<option '.$selected.' value='.$tag['id'].'>Q. '.$tag['name'].'</option>';
            }
        }
        return $cb;
    }

    public function getNameById($tag_id) {
        $tag = $this->CI->ghTag->get(['id' => $tag_id]);
        return $tag ? $tag[0]['name'] :'';
    }
}
?>