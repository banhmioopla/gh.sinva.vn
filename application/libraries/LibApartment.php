<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibApartment {
    public $CI;
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('ghApartment');
        $this->CI->load->model('ghRoom');
        $this->CI->load->library('LibDistrict', null, 'libDistrict');
    }


    public function getFullAddress($apm_object){
        if(is_array($apm_object)){
            $district = " " . $this->CI->libDistrict->getNameByCode($apm_object['district_code']);
            return $apm_object['address_street'] . ", phường ". $apm_object['address_ward'] . ", quận ". $district;
        }
        return "[warning] need object apm!!!";
    }

    public function sortByKey($your_data, $key) {
        return usort($your_data, function($a, $b)
        {
            return $a['num_days'] >  $b['num_days'];
        });
    }
    public function completeInfoRate($apartment_id) {
        $rate = 0;
        $apartment =  $this->CI->ghApartment->getFirstById($apartment_id);
        $info = $this->listInfoComplete();
        $counter = count($info);
        $total_room = 0;
        $current = 0;
        $info_key = array_keys($info);
        if($apartment) {
            foreach ($apartment as $k => $v) {
                if(in_array($k, $info_key) &&  empty($v)) {
                    $current++;

                }
            }
        }
        return ["rate" => round((double)($counter- $current)/$counter,3)*100, "counter" => ($counter- $current) . '/' . $counter];

    }

    public function listInfoComplete() {
        $info = [
            'description' => "mô tả dự án",
            'electricity' => "điện",
            'water' => "nước",
            'internet' => "internet",
            'elevator' => "thang máy",
            'washing_machine' => "máy giặt",
            'room_cleaning' => "dọn phòng",
            'parking' => "giữ xe",
            'deposit' => "cọc",
            'number_of_people' => "số người ở",
            'kitchen' => "bếp",
            'car_park' => "bãi xe ô tô",
            'direction' => 'hướng dự án',
            'kt3' => "KT3",
            'pet' => "thú cưng",
            'security' => "bảo vệ",
            'contract_long_term' => "Hợp đồng dài hạn",
            'contract_short_term' => "Hợp đồng ngắn hạn",
            'number_of_floor' => "số lầu",
            'commission_rate' => "hoa hồng 12Th",
            'commission_rate_6m' => "hoa hồng 6Th",
            'commission_rate_9m' => "hoa hồng 9Th",

        ];
        return $info;
    }


    public function getSaleTotalFromApm($apm_id, $from, $to){

        $from_time = strtotime($from);
        $to_time = strtotime($to);

        $list_contract = $this->CI->ghContract->get([
            'time_check_in >=' => $from_time,
            'time_check_in <=' => $to_time +86399,
            'apartment_id' => $apm_id
        ]);
        $total = 0;
        foreach ($list_contract as $ct) {
            $total += $ct['room_price'] * $ct['commission_rate'] / 100;

        }

        return $total;

    }
}

?>