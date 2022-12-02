<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LibCustomer {
    public $CI;
    public function __construct () {
        $this->CI =& get_instance();
        $this->CI->load->model('ghCustomer');
        $this->CI->load->library('session');
        $auth = $this->CI->session->userdata('auth');
        $this->list_customer_arr_id = $this->CI->ghCustomer->getCustomerOfConsultant($auth['account_id'])["arr_id"];
    }

    public function getNameById($id){
        $customer = $this->CI->ghCustomer->getById($id);

        $name = $customer ? $customer[0]['name'] : '';
        return $name;
    }
    public function getPhoneById($id, $hide = true){
        $list_except = [171020001,171020002,171020095];
        $auth = $this->CI->session->userdata('auth');
        if(!in_array($id, $this->list_customer_arr_id) && !in_array($auth['account_id'], $list_except)){
            return "[đã ẩn sđt]";
        }

        $customer = $this->CI->ghCustomer->getById($id);

        $phone = $customer ? $customer[0]['phone'] : '';
        return $phone;
    }

    public function checkRentedContractByUser($id){
        $customer = $this->CI->ghCustomer->checkRentedContractByUser($id);
        return $customer;
    }

    public function cb($price_id = 0) {
        $list_price = $this->CI->ghCustomer->get();
        $cb = '<option value=0>chọn khách hàng ...</option>';
        if(!empty($list_price)) {
            foreach ($list_price as $price) {
                $selected = '';
                if($price['id'] == $price_id) {
                    $selected = 'selected';
                }

                $cb .= '<option '.$selected.' value='.$price['id'].'>'.$price['name'].'</option>';
            }
        }
        return $cb;
    }
}
?>