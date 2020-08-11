<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class LibAccessControl{
    public $ci;
    public function __construct () {
        $this->ci =& get_instance();
        $this->cf = $this->ci->config->load('accesscontrol');
    }
    public function getMenu($role_code) {
        
        if(!empty($role_code)) {
            var_dump($this->cf); die;
            return $this->cf->config;
        }
    }
}

?>

