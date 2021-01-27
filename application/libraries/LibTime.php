<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibTime {
    public $CI;
    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function calDayInMonthThisYear($month) {
        return cal_days_in_month(CAL_GREGORIAN, $month, date('Y'));
    }


}






?>