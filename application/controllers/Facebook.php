<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facebook extends CI_Controller {
    private $access_control;
    public function __construct()
    {
    }

    public function sendApi(){
        /* validate verify token needed for setting up web hook */
        if (isset($_GET['hub.verify_token'])) {
            if ($_GET['hub.verify_token'] === 'IUzI1NiIsInR5cCI6IkpXVCJ9') {
                echo $_GET['hub.challenge'];
                return;
            } else {
                echo 'Invalid Verify Token';
                return;
            }
        }

        /* receive and send messages */
        $input = json_decode(file_get_contents('php://input'), true);
        if (isset($input['entry'][0]['messaging'][0]['sender']['id'])) {

            $sender = $input['entry'][0]['messaging'][0]['sender']['id']; //sender facebook id
            $message = $input['entry'][0]['messaging'][0]['message']['text']; //text that user sent
            $token = "EAAcaufZAIHOABAN7V9Wkq2ihPhiQ1G6nWw28LLPTaUZAyMaXbXYTdwZCirZAt7eePsVQgzZBr8ITcTyhPZCW12hMLUYt0VjC86ywDo2QiDDaSdXG9VnLMik5M468jGLXHa0UZBJ4XCfaKDZAbf5ZBOXFfTrHPNZCDdh7c8SBKh5NlQnLDpSC34GQ2U";
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