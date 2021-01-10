<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibConfig {
    public $CI;
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('ghConfig');
    }

    public function getListGeneralControlDepartment() {
        $content = $this->CI->ghConfig->get(['code' => 'cf_general_control_department'])[0]["value"];

        return json_decode($content, true);
    }

}
?>