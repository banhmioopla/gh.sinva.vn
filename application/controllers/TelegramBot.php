<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use GuzzleHttp\Client;
include 'simple_html_dom.php';
class TelegramBot extends CustomBaseStep {
    public function __construct()
    {
        parent::__construct();
    }
    public function index(){

    }

    public function show(){
        $input = file_get_contents("php://input");
        try {
            $input_obj = json_decode($input);
            $client = new Client([
                // Base URI is used with relative requests
                "base_uri" => "https://api.telegram.org",
            ]);

            $bot_token = "5736000230:AAFc1tv7FhULVGp71HpJVUpNifyb31Jcv50";

//            $response = $client->request("GET", "/bot$bot_token/getUpdates");
            $chat_id = '-1001850737551';
            echo "<pre>";
            var_dump("https://api.telegram.org"."/bot$bot_token/sendMessage");
            die;
            $msg = "hellow Kid";
            $response = $client->request("GET", "/bot$bot_token/sendMessage",[
                "query" => [
                    "chat_id" => $chat_id,
                    "text" => $msg
                ]
            ]);

            $response = $client->request("GET", "/bot$bot_token/sendMessage",[
                "query" => [
                    "chat_id" => $chat_id,
                    "text" => $msg
                ]
            ]);




        } catch(Exception $e) {
            echo $e->getMessage();
        }


    }


}

/* End of file Apartment.php */
/* Location: ./application/controllers/role-manager/Apartment.php */