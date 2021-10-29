<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facebook extends CI_Controller {
    private $access_control;
    public function __construct()
    {
    }

    public function sendApi(){
        /* validate verify token needed for setting up web hook */
        if (isset($_GET['hub_mode']) && isset($_GET['hub_challenge']) && isset($_GET['hub_verify_token'])) {
            if ($_GET['hub_verify_token'] === 'IUzI1NiIsInR5cCI6IkpXVCJ9') {
                echo $_GET['hub_challenge'];
                http_response_code(200);
                return;
            }
        }

        /* receive and send messages */
        $input = json_decode(file_get_contents('php://input'), true);
        if (isset($input['entry'][0]['messaging'][0]['sender']['id'])) {

            $sender = $input['entry'][0]['messaging'][0]['sender']['id']; //sender facebook id
            $message = $input['entry'][0]['messaging'][0]['message']['text']; //text that user sent
            $token = "EAAcaufZAIHOABAAGthP2YKyhyOZCzY8eo9r0GnCXBnNzrn6nH3uidmIQkQz5PDpgbr9VpbGwGm4zLh0TZAHtZC64J5ZCkZBNNHUD9YWks1EnwHIzGK5kZAgMLnZArnc4MxAVkRu9g3F9eI9Ns2qq9infIlYo62xioDZA0TFQkoH83Uy3S4pcD0ZC3NwzIEfX3MbuZCBIIcovSALhAZDZD";
            $url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.$token;

            /*initialize curl*/
            $ch = curl_init($url);
            /*prepare response*/
            $jsonData = '{
                "recipient":{
                    "id":"' . $sender . '"
                    },
                    "message":{
                        "text":"You said, ' . $message . '"
                    }
                }';
            /* curl setting to send a json post data */
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            if (!empty($message)) {
                $result = curl_exec($ch); // user will get the message
            }
        }
    }
}