<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PublicConsultingPost extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['ghRoom', 'ghContract', 'ghUser']);
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




        if(!empty($token)){
            switch ($token){

                case "hop_dong_thanh_vien":
                    break;
                default: // hợp đồng - hop_dong
                    $list_contract = $this->ghContract->get([
                        "time_check_in >=" => strtotime($timeFrom),
                        "time_check_in <=" => strtotime($timeTo)+86399,
                    ]);
                    foreach ($list_contract as $contract){
                        $apm = $this->ghApartment->getFirstById($contract['apartment_id']);
                        $room = $this->ghRoom->getFirstById($contract['room_id']);
                        $user = $this->ghUser->getFirstByAccountId($contract['consultant_id']);
                        $data[] = [
                            "ID" => $contract["id"],
                            "Dự án" =>$apm["address_street"] . "Phường". $apm["address_ward"],
                            "Mã phòng" => $room["code"],
                            "Giá thuê" => $contract["room_price"],
                            "Sale" => $user["name"],
                            "Ngày ký" => date("d-m-Y", $contract["time_check_in"]),
                            "Số tháng" => $contract["number_of_month"],
                            "Hết Hạn" => date("d-m-Y", $contract["time_expire"]),
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