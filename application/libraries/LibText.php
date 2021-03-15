<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibText {
    public $CI;
    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function limit100($text) {
        return strlen($text) >= 100 ? substr($text, 0, 99) . ' [...]' : $text;
    }


}
?>