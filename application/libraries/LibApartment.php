<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibApartment {
    public $CI;
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('ghApartment');
        $this->CI->load->model('ghRoom');
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
            'map_longitude' => "Bản đồ - Kinh độ",
            'map_latitude' => "Bản đồ - Vĩ Độ",
        ];
        return $info;
    }
}

?>