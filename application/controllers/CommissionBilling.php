<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CommissionBilling extends CustomBaseStep
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(["ghContract" , "ghApartment", "ghContractPartial"]);
        $this->load->library('LibDistrict', null, 'libDistrict');
    }

    public function show(){
        $timeFrom = $this->input->get("timeFrom");
        $timeTo = $this->input->get("timeTo");
        $filter = $this->input->get("filter");

        $metric = [
            'total_partial_amount' => 0,
            'total_sale_amount' => 0,
            'total_billing_amount' => 0,
            'contract_count' => 0,
        ];

        if(empty($timeFrom)){
            $timeFrom = $this->timeFrom;
        }

        if(empty($timeTo)){
            $timeTo = $this->timeTo;
        }
        $billing = ""; $list_apartment = $arr_apm_id = $list_con_apm =  $public_url =  [];
        $list_contract = $this->ghContract->get([
            'time_check_in >=' => strtotime($timeFrom),
            'time_check_in <=' => strtotime($timeTo)+86399,
            'status <>' => 'Cancel'
        ]);
        $metric['contract_count'] = count($list_contract);

        foreach ($list_contract as $contract) {
        	if($filter == 'HasContractCost'){
        		if(empty($contract['contract_cost'])){
        			continue;
				}
			}

			if($filter == 'PendingPartial'){
				if($this->ghContractPartial->getTotalByContractId($contract['id']) >= $this->ghContract->getTotalSaleByContract($contract['id'])){
					continue;
				}
			}

            if(!in_array($contract["apartment_id"],$arr_apm_id)){
                $arr_apm_id[] = $contract["apartment_id"];
                $apartment = $this->ghApartment->getFirstById($contract["apartment_id"]);
                if($apartment){
                    $list_apartment[] = $apartment;
					$list_con_apm[$contract["apartment_id"]][] = $contract;
                    $public_url[$contract["apartment_id"]] = "/sinva/commission-billing/detail?cbid=".$contract["apartment_id"]."&fromDate=".$timeFrom."&toDate=".$timeTo."&listContract=";
                }
            }
            $metric['total_sale_amount'] += $this->ghContract->getTotalSaleByContract($contract['id']);
            $metric['total_partial_amount'] += $this->ghContractPartial->getTotalByContractId($contract['id']);

        }

        $metric['total_billing_amount'] = $metric['total_sale_amount'] - $metric['total_partial_amount'];

        /*--- Load View ---*/
        $this->load->view('components/header');
        $this->load->view('commission-billing/show', [
            "list_apartment" => $list_apartment,
            "list_con_apm" => $list_con_apm,
            "public_url" => $public_url,
            "timeFrom" => $timeFrom,
            "timeTo" => $timeTo,
            'filter' => $filter,
            "metric" => $metric
        ]);
        $this->load->view('components/footer');
    }


    public function updateFullContractPartial(){
        $apm_id = $this->input->post('apm_id');
        $timeFrom = $this->input->post('time_from');
        $timeTo = $this->input->post('time_to');
        $apartment = $this->ghApartment->getFirstById($apm_id);
        $list_contract = $this->ghContract->get([
            'time_check_in >=' => strtotime($timeFrom),
            'time_check_in <=' => strtotime($timeTo)+86399,
            'apartment_id' => $apm_id,
            'status <>' => 'Cancel'
        ]);
        $amount = 0;
        foreach ($list_contract as $contract){
            $total_sale = $this->ghContract->getTotalSaleByContract($contract['id']);
            $total_partial = $this->ghContractPartial->getTotalByContractId($contract['id']);

            if($total_sale > $total_partial){
                $data_insert = [
                    'contract_id' => $contract['id'],
                    'amount' => $total_sale - $total_partial,
                    'apply_time' => time(),
                ];
                $amount+= $total_sale - $total_partial;
                $this->ghContractPartial->insert($data_insert);
            }
        }
        echo json_encode([
            'status' => true,
            'amount' => number_format($amount),
            'msg' => "Cập nhật doanh thu ". $apartment['address_street'] . " số tiền ". number_format($amount) . " thành công",
        ]); die;
    }
}
