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

    public function standardizedFormat($time_str) {
        return str_replace('/', '-', $time_str);
    }

    public function unixTimeFormat($time_str) {
        return strtotime(str_replace('/', '-', $time_str));
    }

    public function formatDMY($time) {
        if(is_numeric($time)) {
            return date('d/m/Y', $time);
        }
        $unix_time = strtotime(str_replace('/', '-', $time));
        return date('d/m/Y', $unix_time);
    }

    function weekOfMonth($qDate) {
        $dt = strtotime($qDate);
        $day  = date('j',$dt);
        $month = date('m',$dt);
        $year = date('Y',$dt);
        $totalDays = date('t',$dt);
        $weekCnt = 1;
        $retWeek = 0;
        for($i=1;$i<=$totalDays;$i++) {
            $curDay = date("N", mktime(0,0,0,$month,$i,$year));
            if($curDay==7) {
                if($i==$day) {
                    $retWeek = $weekCnt+1;
                }
                $weekCnt++;
            } else {
                if($i==$day) {
                    $retWeek = $weekCnt;
                }
            }
        }
        return $retWeek;
    }

    public function formatPaddingId($id) {
        $length = 6;
        return printf('%0'.$length.'d',$id);
    }


}






?>