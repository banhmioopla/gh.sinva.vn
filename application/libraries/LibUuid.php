<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibUuid
{
    public $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function createUuid(){
        return $this->guidv4();
    }

    function guidv4() {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);

        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}