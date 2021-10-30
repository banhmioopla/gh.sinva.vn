<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facebook extends CI_Controller {
    private $access_control;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ghApartment');
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
        file_put_contents(APPPATH.'views/'.'json-content/facebook.json', file_get_contents('php://input'));
        if (isset($input['entry'][0]['messaging'][0]['sender']['id'])) {

            $sender = $input['entry'][0]['messaging'][0]['sender']['id']; //sender facebook id
            $message = $input['entry'][0]['messaging'][0]['message']['text']; //text that user sent
            $token = "EAAcaufZAIHOABANOnGZCljCepucQH2fg4FT9rtnACQmwjin5M1wAMRFnupROCY25ZAqZCtK0JkkEWZCHsNHLshVuz48V5qyZBirA51dmg3G8jC3flGk4KAZA8YUPGHitB32sOqqFY80TZCIlBt5rZCedDM1stAhl1SMhbLZCqP2iEafui5HZCpkK1CO";
            $url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.$token;
            $url12 = "https://graph.facebook.com/v12.0/me/messages?access_token=".$token;
            /*initialize curl*/
            $ch = curl_init($url12);
            /*prepare response*/
            $text = "GH REP: \\n";
            $temp = explode(" ",$message);

            $list_apm = $this->ghApartment->get(["district_code" => "7", 'active' => 'YES']);
            foreach ($list_apm as $apm) {
                if(isset($temp[3])){
                    $text .= $temp[3]. " ∇ {$apm['address_street']}" . " \\n ";
                } else {
                    $text .= "∇ {$apm['address_street']}" . " \\n ";
                }

            }

            $jsonData = '{
                "recipient":{
                    "id":"' . $sender . '"
                    },
                    "message":{
                        "text":"' . $text . '"
                    }
                }';


            $sendData = [
                "recipient" => [
                    "id" => "{$sender}"
                ],
                'message' => [
                    'attachment' => [
                        'type' => 'template',
                        'payload' => [
                            'template_type' => 'button',
                            'text' => 'Hola, Bạn muốn tìm gì trên GH?',
                            'buttons' => [
                                0 => [
                                    'type' => 'postback',
                                    'title' => 'LESS THAN $20',
                                    'payload' => 'GIFT_BUDGET_20_PAYLOAD',
                                ],
                                1 => [
                                    'type' => 'postback',
                                    'title' => '$20 TO $50',
                                    'payload' => 'GIFT_BUDGET_20_TO_50_PAYLOAD',
                                ],
                                2 => [
                                    'type' => 'postback',
                                    'title' => 'MORE THAN $50',
                                    'payload' => 'GIFT_BUDGET_50_PAYLOAD',
                                ],
                            ],
                        ],
                    ],
                ],
            ];
            /* curl setting to send a json post data */
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($sendData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            if (!empty($message)) {
                $result = curl_exec($ch); // user will get the message
                curl_close($ch);
            }
            curl_close($ch);

        }
    }
}