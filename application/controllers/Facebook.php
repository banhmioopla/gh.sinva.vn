<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facebook extends CI_Controller {
    private $access_control;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ghApartment');
        $this->load->model('ghDistrict');
        $this->load->model('ghRoom');
        $this->load->model('ghBaseRoomType');
    }

    function list_step(){
        return [
            "step1" => [
                'question' => 'PIN của bạn là?'
            ],
            "step2" => [
                'question' => 'Oke! Chọn quận ạ?'
            ],
            "step3" => [
                'question' => 'Oke! Chọn Dự Án (gõ lại ID)'
            ],
            "step4" => [
                'question' => 'Xin cám ơn nhiều'
            ],

        ];
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
            $entry = $input['entry'][0];
            $messaging = $entry['messaging'][0];
            $sender = $messaging['sender']['id']; //sender facebook id
            $message = isset($messaging['message']['text']) ? $messaging['message']['text'] : ""; //text that user sent
            $postback = isset($messaging["postback"]["payload"]) ? $messaging["postback"]["payload"] : "";
            $quickRepPayload = isset($messaging["message"]["quick_reply"]['payload']) ? json_decode($messaging["message"]["quick_reply"]['payload'], true) : null;
            $token = "EAAcaufZAIHOABANOnGZCljCepucQH2fg4FT9rtnACQmwjin5M1wAMRFnupROCY25ZAqZCtK0JkkEWZCHsNHLshVuz48V5qyZBirA51dmg3G8jC3flGk4KAZA8YUPGHitB32sOqqFY80TZCIlBt5rZCedDM1stAhl1SMhbLZCqP2iEafui5HZCpkK1CO";
            $token2 = "EAAcaufZAIHOABAFj0iNIAwLtxZCb98ZBk2i9MN0em1O79bwMZBvCBeHaSFm6e6ZCZBHV0QPkdW6yMVGXaO4EfGb8MW50os3Ub1j1r8sEvPwchITZCs9mbpdIwDXuYvIxFKV4bvWDruLu6fhFDyK5pGpjAjZCrO5gqhg1Hz8xtKv1fMMvjftl8pp9";
            $url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.$token2;
            $url12 = "https://graph.facebook.com/v12.0/me/messages?access_token=".$token2;
            $botName ="SimCon 🐌  \n ";
            /*initialize curl*/
            $ch = curl_init($url12);
            /*prepare response*/

            $list_step = $this->list_step();
            $ready_message = [];
            $ready_message = [
                "recipient" => [
                    "id" => $sender
                ],
                "message" => [
                    "text" => $list_step['step1']['question']
                ]
            ];

            if($message === "1234"){
                /*CHỌN QUẬN*/
                $list_district = $this->ghDistrict->get(['active' => 'YES']);
                $list_quick_district = [];
                $ii = 1;
                foreach ($list_district as $dd){
                    if($ii === 8){
                        break;
                    }
                    $payload = [
                        'd_code' => $dd['code'],
                        'step' => 'step2'
                    ];

                    $list_quick_district[] = [
                        "content_type" => "text",
                        "payload" => json_encode($payload),
                        "title" => "Q {$dd['name']}",
                    ];
                    $ii++;
                }
                $ready_message = [
                    "recipient" => [
                        "id" => "{$sender}"
                    ],
                    'message' => [
                        "text" => $botName.$list_step['step2']['question'],
                        "quick_replies" => $list_quick_district,
                    ],
                ];
            }

            if(!empty($quickRepPayload) && is_array($quickRepPayload)){
                if(isset($quickRepPayload['step'] ) && $quickRepPayload['step'] === 'step2') {
                    $content = "";
                    if(isset($quickRepPayload['d_code'])){
                        $list_apm = $this->ghApartment->get(['active' => 'YES', 'district_code' => $quickRepPayload['d_code']]);
                        foreach ($list_apm as $apm) {
                            $content .= "*{$apm['id']}* ".$apm['address_street'] . " \n ";
                        }
                        $ready_message = [
                            "recipient" => [
                                "id" => $sender
                            ],
                            "message" => [
                                "text" => $content
                            ]
                        ];
                    }
                }
            }

            if(strpos($message, 'da') !== false && $message[0] === 'd'){
                $arr_msg = explode("da", $message);

                if(count($arr_msg) === 2){
                    $apm = $this->ghApartment->getFirstById($arr_msg[1]);
                    $content = $apm['address_street']. " \n";
                    $content .= "=== {$apm['id']} === \n";
                    $list_room = $this->ghRoom->get(['apartment_id' => $arr_msg[1], 'active' => 'YES', 'status' => "Available"]);
                    foreach ($list_room as $room) {
                        $price = number_format($room['price']/1000);
                        $code = $room['code'];
                        $id = $room['id'];

                        $list_type_id = json_decode($room['room_type_id'], true);
                        $js_list_type = "";
                        $text_type_name = "";

                        $type_arr = [];
                        if($list_type_id) {
                            $js_list_type = implode(",", $list_type_id);
                            if ($list_type_id && count($list_type_id) > 0) {
                                foreach ($list_type_id as $type_id) {
                                    $typeModel = $this->ghBaseRoomType->getFirstById($type_id);
                                    $type_arr[]= $typeModel['name'];
                                }
                            }
                        }
                        $text_type_name = implode(", ",$type_arr );


                        $content .= "* Mã {$code} : {$price} | {$text_type_name} \n";
                    }

                    $ready_message = [
                        "recipient" => [
                            "id" => $sender
                        ],
                        "message" => [
                            "text" => $content
                        ]
                    ];
                }
            }

            if(strpos($message, 'dv') !== false && $message[0] === 'd'){
                $arr_msg = explode("dv", $message);
                if(count($arr_msg) === 2){
                    $apm = $this->ghApartment->getFirstById($arr_msg[1]);
                    $content = $apm['address_street']. " \n";
                    $content .= "=== {$apm['id']} === \n";
                    $content = "Điện: ".$apm['electricity'] ." \n";
                    $content .= "Nước: ".$apm['water'] ." \n";
                    $content .= "Internet: ".$apm['internet'] ." \n";
                    $content .= "Thang máy: ".$apm['elevator'] ." \n";

                    $ready_message = [
                        "recipient" => [
                            "id" => $sender
                        ],
                        "message" => [
                            "text" => $content
                        ]
                    ];
                }
            }

            /* curl setting to send a json post data */
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($ready_message));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            if (!empty($message)) {
                $result = curl_exec($ch); // user will get the message
                curl_close($ch);
            }
            curl_close($ch);

        }
    }
}