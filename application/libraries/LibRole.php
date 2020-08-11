<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class LibRole{
    public function __construct()
	{
        $this->CI =& get_instance();
        
		$this->CI->load->model('ghRole');
    }
    
    public function getCbRole($role_id) {
        $list_role = $this->ghRole->getByActive();
        $cb = '<option value=0>chọn quyền ...</option>';
        foreach ($list_role as $role) {
            $selected = '';
            if($role['id'] == $role_id) {
                $selected = 'selected';
            }
            $cb .= '<option '.$selected.' value='.$role['id'].'>quận '.$role['name'].'</option>';
        }

        return $cb;
    }

    public function getCodeById($role_id) {
        $role = $this->CI->ghRole->get(['id' => $role_id]);
        
        return !empty($role) ? $role[0]['code']: 'consultant';
    }
}

?>