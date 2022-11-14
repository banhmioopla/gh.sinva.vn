<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibIncomeV1 {
    public $CI;
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('ghContract');
        $this->CI->load->model('ghUser');
    }


}
?>