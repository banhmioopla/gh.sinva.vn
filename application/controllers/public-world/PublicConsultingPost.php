<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PublicConsultingPost extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['ghRoom', 'ghContract', 'ghUser','ghCustomer']);
        $this->load->model('ghApartment');
        $this->load->model('ghImage');
        $this->load->model('ghApartment');
        $this->load->model('ghRoom');
        $this->load->model('ghPublicConsultingPost');
        $this->load->library('LibBaseRoomType', null, 'libBaseRoomType');
        $this->public_dir = 'public-world/';
    }

    public function detailShow(){
        $post_id = $this->input->get('id');
        $this_post = $this->ghPublicConsultingPost->getFirstById($post_id);
        $this_post_img = json_decode($this_post['image_set'], true);
        $room = $this->ghRoom->getFirstById($this_post['room_id']);
        $user = $this->ghUser->getFirstByAccountId($this_post['user_create_id']);
        $apartment = null;
        if($room) {
            $apartment = $this->ghApartment->getFirstById($room['apartment_id']);
        }

        $list_img = [];
        if($this_post_img && count($this_post_img)) {
            foreach ($this_post_img as $img_id) {
                $img_model = $this->ghImage->getFirstById($img_id);
                if($img_model) {
                    $list_img[] = $img_model;
                }
            }
        }

        $this->load->view($this->public_dir.'components/header', [
            'title_page' => "Sinva Home - Dự Án ". $this_post['title'],
            'post_title' => $this_post['title'],
        ]);
        $this->load->view($this->public_dir.'consulting-post/detail-show', [
            'list_img' => $list_img,
            'apartment' => $apartment,
            'room' => $room,
            'post' => $this_post,
            'user' => $user,
            'libBaseRoomType' => $this->libBaseRoomType
        ]);
        $this->load->view($this->public_dir.'components/footer');

    }

    public function exportToGoogleSheet(){
        $token = $this->input->get('token');
        $data = [];
        $timeFrom = date("01-m-Y");
        $timeTo = date("d-m-Y",strtotime('last day of this month', time()));

        $income_standard_rate = .55;


        if(!empty($token)){
            switch ($token){

                case 1: // danh sách thành viên
                        $list_user = $this->ghUser->get(['active' => 'YES']);
                        foreach ($list_user as $user) {
                            $rate_star = $count_contract = $income = 0;

                            $list_contract = $this->ghContract->get([
                                'time_check_in >=' => $timeFrom,
                                'time_check_in <=' => $timeTo +86399,
                                'consultant_support_id' => $timeTo +86399,
                            ]);
                            $count_contract+= count($list_contract);
                            foreach ($list_contract as $con) {
                                $rate_star += $con['rate_type'];
                            }

                            $list_contract = $this->ghContract->get([
                                'time_check_in >=' => $timeFrom,
                                'time_check_in <=' => $timeTo +86399,
                                'consultant_id' => $timeTo +86399,
                            ]);
                            $count_contract+= count($list_contract);
                            foreach ($list_contract as $con) {
                                $rate_star += $con['rate_type'];
                            }


                            if($rate_star >= 6){
                                foreach ($list_contract as $con){
                                    $income += $con['commission_rate']*$con['room_price']/100 * $income_standard_rate;
                                }
                            } else {
                                foreach ($list_contract as $con){
                                    $income += $con['commission_rate']*$con['room_price']/100 * (1-$income_standard_rate);
                                }
                            }

                            $data[] = [
                                "Source" => "GH",
                                "Account" => $user["account_id"],
                                "Tên" => $user["name"],
                                "Ngày vào làm" => date("d-m-Y", $user["time_joined"]),
                                "Số (*)" => $rate_star,
                                "Số hợp đồng" => $count_contract,
                                "Thu nhập" => $income
                            ];
                        }
                    break;
                default: // Hợp đồng tháng hiện tại
                    $list_contract = $this->ghContract->get([
                        "time_check_in >=" => strtotime($timeFrom),
                        "time_check_in <=" => strtotime($timeTo)+86399,
                    ]);
                    foreach ($list_contract as $contract){
                        $apm = $this->ghApartment->getFirstById($contract['apartment_id']);
                        $room = $this->ghRoom->getFirstById($contract['room_id']);
                        $user = $this->ghUser->getFirstByAccountId($contract['consultant_id']);
                        $user_support = $this->ghUser->getFirstByAccountId($contract['consultant_support_id']);
                        $customer = $this->ghCustomer->getFirstById($contract['customer_id']);
                        $data[] = [
                            "Source" => "GH",
                            "ID" => $contract["id"],
                            "Dự án" =>$apm["address_street"] . ", Phường ". $apm["address_ward"],
                            "Mã phòng" => $room["code"],
                            "Giá thuê" => $contract["room_price"],
                            "Giá cọc" => $contract["deposit_price"],
                            "Ngày ký" => date("d-m-Y", $contract["time_check_in"]),
                            "Số tháng" => $contract["number_of_month"],
                            "Hết Hạn" => date("d-m-Y", $contract["time_expire"]),
                            "Hoa hồng" => $contract['commission_rate'],
                            "Doanh thu" => $contract['room_price']*$contract['commission_rate']/100,
                            "Số (*)" => $contract["rate_type"],
                            "Sale Chốt" => $user["name"],
                            "Sale Hỗ trợ" => $user_support["name"],
                            "Khách Hàng" => $customer["name"],
                            "Phone" => $customer["phone"],
                        ];
                    }
            }

            echo json_encode($data); die;
        }
        return false;
    }

}

/* End of file BaseRoomType.php */
/* Location: ./application/controllers/role-manager/BaseRoomType.php */