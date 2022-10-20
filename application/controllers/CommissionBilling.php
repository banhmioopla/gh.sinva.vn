<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CommissionBilling extends CustomBaseStep
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(["ghContract" , "ghApartment"]);
        $this->load->library('LibDistrict', null, 'libDistrict');
    }

    public function show(){
        $timeFrom = $this->input->get("timeFrom");
        $timeTo = $this->input->get("timeTo");

        if(empty($timeFrom)){
            $timeFrom = $this->timeFrom;
        }

        if(empty($timeTo)){
            $timeTo = $this->timeTo;
        }
        $billing = ""; $list_apartment = $arr_apm_id = $public_url =  [];
        $list_contract = $this->ghContract->get([
            'time_check_in >=' => strtotime($timeFrom),
            'time_check_in <=' => strtotime($timeTo)+86399,
            'status <>' => 'Cancel'
        ]);

        foreach ($list_contract as $contract) {
            if(!in_array($contract["apartment_id"],$arr_apm_id)){
                $arr_apm_id[] = $contract["apartment_id"];
                $apartment = $this->ghApartment->getFirstById($contract["apartment_id"]);
                if($apartment){
                    $list_apartment[] = $apartment;
                    $public_url[$contract["apartment_id"]] = "/sinva/commission-billing/detail?cbid=".$contract["apartment_id"]."&fromDate=".$timeFrom."&toDate=".$timeTo;
                }
            }
        }

        /*--- Load View ---*/
        $this->load->view('components/header');
        $this->load->view('commission-billing/show', [
            "list_apartment" => $list_apartment,
            "public_url" => $public_url,
            "timeFrom" => $timeFrom,
            "timeTo" => $timeTo,
        ]);
        $this->load->view('components/footer');
    }
}
