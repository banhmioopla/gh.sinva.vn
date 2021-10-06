<?php

use PhpOffice\PhpSpreadsheet\IOFactory;

defined('BASEPATH') OR exit('No direct script access allowed');

class ApartmentReport extends CustomBaseStep
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['ghApartment', 'ghDistrict', 'ghNotification',
            'ghApartmentRequest', 'ghBaseRoomType']);
        $this->load->config('label.apartment');
        $this->load->helper('money');
        $this->load->library('LibDistrict', null, 'libDistrict');
        $this->load->library('LibPartner', null, 'libPartner');
        $this->load->library('LibRoom', null, 'libRoom');
        $this->load->library('LibBaseApartmentType', null, 'libBaseApartmentType');
        $this->load->library('LibBaseRoomType', null, 'libBaseRoomType');
        $this->load->library('LibTag', null, 'libTag');
        $this->load->library('LibUser', null, 'libUser');
        $this->load->library('LibApartment', null, 'libApartment');
        $this->load->library('LibCustomer', null, 'libCustomer');


    }

    public function show(){
        $list_noti = $this->ghNotification->get(
            [""]
        );
    }

    public function updateIssueApartmentInfo(){
        $apm = $this->input->post('apm');
        $type_report = $this->input->post('type');
        $content = "";

        $apartment = $this->ghApartment->getFirstById($apm);
        switch ($type_report){
            case 'IssueApmInfo':
                $content = "Thiếu thông tin " . $apartment['address_street'];
                break;
        }
        $data = [
            'create_user_id' => $this->auth['account_id'],
            'time_insert' => time(),
            'is_read' => 'NO',
            'controller' => 'ApartmentReport',
            'message' => $content,
            'is_approve' =>  null,
            'receiver_user_id' => null,
            'object_id' => $apm
        ];

        $this->ghNotification->insert($data);
        echo json_encode([
            'status' => true,
            'content' => ''
        ]); die;
    }

}
