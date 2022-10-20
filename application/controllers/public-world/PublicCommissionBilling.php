<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PublicCommissionBilling extends CI_Controller {

    public function __construct()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        parent::__construct();
        $this->load->model(['ghRoom', 'ghContract', 'ghUser','ghCustomer', 'ghContractPartial', 'ghTeamUser', 'ghTeam']);
        $this->load->model('ghApartment');
        $this->load->model('ghImage');
        $this->load->model('ghApartment');
        $this->load->model('ghRoom');
        $this->load->model('ghPublicConsultingPost');
        $this->load->library('LibBaseRoomType', null, 'libBaseRoomType');
        $this->load->library('LibUser', null, 'libUser');
        $this->public_dir = 'public-world/';

        $this->timeFrom = date("06-m-Y");
        $this->timeTo = date("05-m-Y",strtotime($this->timeFrom.' +1 month'));
        $this->public_dir = 'public-world/';

    }

    public function showDetail(){
        $apm_id = $this->input->get("cbid");
        $timeFrom = $this->input->get("fromDate");
        $timeTo = $this->input->get("toDate");
        $list_contract = $this->ghContract->get([
            'time_check_in >=' => strtotime($timeFrom),
            'time_check_in <=' => strtotime($timeTo)+86399,
            'apartment_id' => $apm_id,
            'status <>' => 'Cancel'
        ]);
        $total_billing_amount = 0;
        foreach ($list_contract as $contract){
            $total_billing_amount += $contract["room_price"]*$contract["commission_rate"]/100;
        }
        /*--- Load View ---*/
        $apartment = $this->ghApartment->getFirstById($apm_id);
        $this->load->view($this->public_dir.'components/header', [
            'title_page' => "Phiếu Thu Hoa Hồng | SINVA",
            "post_title" => ""
        ]);

        $this->load->view($this->public_dir.'commission-billing/detail', [
            "list_contract" => $list_contract,
            "apartment" => $apartment,
            "timeFrom" => $timeFrom,
            "timeTo" => $timeTo,
            "total_billing_amount" => $total_billing_amount,
        ]);
        $this->load->view($this->public_dir.'components/footer');


    }


}

/* End of file BaseRoomType.php */
/* Location: ./application/controllers/role-manager/BaseRoomType.php */