<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibEncrypt {
    public $CI;
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->library('encryption');
    }

    public function encryptPass($pass){
        $config = [
            'hmac_digest' => 'sha256',
        ];

        $encrypt = $this->CI->encryption->encrypt($pass);
        echo "<pre>";
        var_dump($encrypt); die;
        return bin2hex($encrypt);
    }

    public function decryptPass($pass){
        $config = [
            'hmac_digest' => 'sha256',
        ];

        $decrypt = $this->CI->encryption->encrypt(hex2bin($pass), $config);
        return $decrypt;
    }
}
?>