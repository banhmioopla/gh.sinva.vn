<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibPhone {
    public $CI;
    public function formatPhone($phone) {
        // Allow only Digits, remove all other characters.
        $number = preg_replace("/[^\d]/","",$phone);

        // get number length.
        $length = strlen($phone);

        // if number = 10
        if($length == 10) {
            $phone = preg_replace("/^1?(\d{4})(\d{3})(\d{3})$/", "$1 $2 $3", $phone);
        }

        if($length == 11) {
            $phone = preg_replace("/^1?(\d{3})(\d{4})(\d{4})$/", "$1 $2 $3", $phone);
        }

        return $phone;
    }
}
?>