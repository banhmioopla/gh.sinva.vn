<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SystemIncomeRunning extends CustomBaseStep
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['ghActivityTrack', "ghContract",
            'ghUser', 'ghNotification', 'ghUserDistrict', 'ghApartment', 'ghRole', 'ghConfig', 'ghTeam']);
        $this->load->library('LibTime', null, 'libTime');
    }



    public function show(){
        $list_user = $this->ghUser->get([
            'active' => 'YES'
        ]);
        $from_date = date("01-m-Y");
        $to_month = date("m");
        $to_year = date("Y");

        $day_last = cal_days_in_month(CAL_GREGORIAN, $to_month, $to_year);
        $to_date = $day_last."-".$to_month."-".$to_year;

        if($this->input->get("timeFrom")){
            $from_date = $this->input->get("timeFrom");
        }

        if($this->input->get("timeTo")){
            $to_date = $this->input->get("timeTo");
        }
        $data = [
            "team" => [],
            "user" => [],
            'sinva' => [
                'share_with_sinva' => 0
            ]
        ];
        $list_team = $this->ghTeam->get();
        foreach ($list_team as $team) {
            $data["team"][] = [
                "name" => $team["name"],
                "total" => $this->ghContract->getTotalSaleByTeam($team['id'], $from_date, $to_date)
            ];
        }

        foreach ($list_user as $user){
            $share_with_sinva = 0;

            if(empty($user['user_refer_id'])){
                $share_with_sinva = $this->ghContract->getSaleRefByContract($user['account_id'])["sinva"];
                $data['sinva']['share_with_sinva'] += $share_with_sinva;
            }


            $data["user"][] = [
                "account_id" => $user["account_id"],
                "name" => $user["name"],
                "total" => $this->ghContract->getTotalSaleByUser($user['account_id'], $from_date, $to_date),
                "share_with_sinva" => $share_with_sinva,
                "list_sale_item" => $this->ghContract->getListSaleItemByUser($user['account_id'], $from_date, $to_date),
            ];

        }

        $list_contract = $this->ghContract->get([
            'time_check_in >= ' => strtotime($from_date),
            'time_check_in <= ' => strtotime($to_date)+86399,
        ]);

        $sinva = [
            'total_sale' => 0,
            'share_sale_by_ref' =>$data['sinva']['share_with_sinva'],
            'remain_sale' => 0
        ];
        foreach ($list_contract as $con){
            $sinva['total_sale'] += $this->ghContract->getTotalSaleByContract($con['id']);
        }

        $sinva['remain_sale'] = $sinva['total_sale'] - $sinva['share_sale_by_ref'];



        $this->load->view('components/header');
        $this->load->view('system-income-running/show',[
            "data" => $data,
            "timeFrom" => $from_date,
            "timeTo" => $to_date,
            "sinva" => $sinva
        ]);
        $this->load->view('components/footer');
    }

    public function chartData(){

        $from_date = date("01-m-Y");
        $to_month = date("m");
        $to_year = date("Y");

        $day_last = cal_days_in_month(CAL_GREGORIAN, $to_month, $to_year);
        $to_date = $day_last."-".$to_month."-".$to_year;

        if($this->input->post("timeFrom")){
            $from_date = $this->input->post("timeFrom");
        }

        if($this->input->post("timeTo")){
            $to_date = $this->input->post("timeTo");
        }
        if($this->input->post("mode") === "USER_WITH_SALE"){
            $res = [];
            $res[] = ["T.v", "Doanh Số", "HD"];

            $list_user = $this->ghUser->get([
                'active' => 'YES'
            ]);



            foreach ($list_user as $user){
                $count = count($list_con = $this->ghContract->get([
                    'consultant_id' => $user['account_id'],
                    'time_check_in >=' => strtotime($from_date),
                    'time_check_in <=' => strtotime($to_date)+86399,
                ]));
                if($count > 0) {
                    $sale = $this->ghContract->getTotalSaleByUser($user['account_id'], $from_date, $to_date);

                    $name = explode(" ", $user["name"]);
                    $res[] = [
                        $name[count($name)-1],
                        round($sale/1000000,2),
                        $count
                    ];
                }

            }
            echo json_encode($res); die;
        }
    }
}