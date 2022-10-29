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
        $this->load->library('LibDistrict', null, 'libDistrict');
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
            "apartment_address_payment" => $this->convert_vi_to_en("quyết toán phí hoa hồng nhà " . $apartment['address_street']),
        ]);
        $this->load->view($this->public_dir.'components/footer');


    }

    function convert_vi_to_en($str) {

        $str = str_replace("/", "_", $str);
        $str = str_replace(",", "", $str);
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", "a", $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", "e", $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", "i", $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", "o", $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", "u", $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", "y", $str);
        $str = preg_replace("/(đ)/", "d", $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", "A", $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", "E", $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", "I", $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", "O", $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", "U", $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", "Y", $str);
        $str = preg_replace("/(Đ)/", "D", $str);
        //$str = str_replace(" ", "-", str_replace("&*#39;","",$str));
        return $str;
    }


}

/* End of file BaseRoomType.php */
/* Location: ./application/controllers/role-manager/BaseRoomType.php */