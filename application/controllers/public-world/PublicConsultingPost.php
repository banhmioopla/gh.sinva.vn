<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PublicConsultingPost extends CI_Controller {

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
        if(strtotime(date("d-m-Y")) < strtotime(date("5-m-Y"))){
            $this->timeFrom = date("06-m-Y", strtotime("-1 month"));
            $this->timeTo = date("05-m-Y");
        }

        $this->view_notfound = "";

    }

    public function detailEditorial(){
        $post_id = $this->input->get('pid');

        $main_template = 'editorial/templates/detail-show';
        if(empty($post_id)){
            $main_template = $this->view_notfound;
        }

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


        $this->load->view($this->public_dir.'editorial/templates/header', [

        ]);
        $this->load->view($this->public_dir.$main_template, [
            'user' => $user,
            'post' => $this_post,
            'room' => $room,
            'apartment' => $apartment,
            'list_img' => $list_img,
        ]);
        $this->load->view($this->public_dir.'editorial/templates/footer');
    }

    public function exportToGoogleSheet(){
        $token = $this->input->get('token');
        $data = [];
        $timeFrom = $this->timeFrom;
        $timeTo = $this->timeTo;

        if(strlen($token) > 20){
            $time_token = explode('_', $token);
            if(count($time_token) == 3){
                $timeFrom = $time_token[0];
                $timeTo = $time_token[1];
                $token = $time_token[2];
            }
        }

        $income_standard_rate = .55;

        if(!empty($token)){
            switch ($token){

                case 1: // Thu nhập - tháng hiện tại
                        $list_user = $this->ghUser->get(['active' => 'YES']);
                        $list_contract_supporter = $this->ghContract->get([
                            'time_check_in >=' => strtotime($timeFrom),
                            'time_check_in <=' => strtotime($timeTo) +86399,
                            'arr_supporter_id <>' => null,
                            'status' => "Active"
                        ]);
                        foreach ($list_user as $user) {
                            $count_contract = $income = 0;
                            $teamUser = $this->ghTeamUser->getFirstByUserId($user["account_id"]);
                            $team_name = "";
                            if(!empty($teamUser)){
                                $team = $this->ghTeam->getFirstById($teamUser['team_id']);
                                if(!empty($team)){
                                    $team_name = $team['name'];
                                }
                            }

                            foreach ($list_contract_supporter as $con) {
                                if(!empty($con["arr_supporter_id"])){
                                    $arr = json_decode($con["arr_supporter_id"], true);
                                    if(in_array($user['account_id'], $arr)){
                                        $count_contract++;
                                    }
                                }
                            }

                            $list_contract = $this->ghContract->get([
                                'time_check_in >=' => strtotime($timeFrom),
                                'time_check_in <=' => strtotime($timeTo) +86399,
                                'consultant_id' =>$user['account_id'],
                                'status' => "Active"
                            ]);
                            $count_contract+= count($list_contract);
                            $rate_star = $this->ghContract->getTotalRateStar($user['account_id'], $timeFrom, $timeTo);

                            $final_rate = $income_standard_rate;
                            if($rate_star >= 6){
                                foreach ($list_contract as $con){
                                    $income += $con['commission_rate']*$con['room_price']/100 * $income_standard_rate;
                                }
                            } else {
                                $final_rate = 1-$income_standard_rate;
                                foreach ($list_contract as $con){
                                    $income += $con['commission_rate']*$con['room_price']/100 * $final_rate;
                                }
                            }
                            if($count_contract) {

                                $data[] = [
                                    "Source" => "GH",
                                    "Team" => $team_name,
                                    "Account" => $user["account_id"],
                                    "Tên" => $user["name"],
                                    "Ngày vào làm" => date("d-m-Y", $user["time_joined"]),
                                    "Số (*)" => $rate_star,
                                    "Hệ số" => (string)($final_rate*100),
                                    "Số hợp đồng" => $count_contract,
                                    "Doanh số" => $this->ghContract->getTotalSaleByUser($user["account_id"], $timeFrom, $timeTo),
                                    "Thu nhập" => round($income,2)
                                ];
                            }

                        }
                    break;
                case 2: // Hợp đồng tháng hiện tại
                    $list_contract = $this->ghContract->get([
                        "time_check_in >=" => strtotime($timeFrom),
                        "time_check_in <=" => strtotime($timeTo)+86399,
                        'status' => "Active"
                    ],'consultant_id', 'ASC');
                    foreach ($list_contract as $contract){
                        $apm = $this->ghApartment->getFirstById($contract['apartment_id']);
                        $room = $this->ghRoom->getFirstById($contract['room_id']);
                        $user = $this->ghUser->getFirstByAccountId($contract['consultant_id']);
                        $user_support = "";
                        if(!empty($contract["arr_supporter_id"])){
                            $arr = json_decode($contract["arr_supporter_id"], true);
                            $arr_name = [];
                            foreach ($arr as $aid){
                                $arr_name[] = $this->libUser->getNameByAccountid($aid);
                            }
                            $user_support = implode(" ,", $arr_name);
                        }

                        $customer = $this->ghCustomer->getFirstById($contract['customer_id']);
                        $status = "Cọc";
                        if(time() >= $contract["time_check_in"]){
                            $status = "Đã ký";
                        }
                        $teamUser = $this->ghTeamUser->getFirstByUserId($user["account_id"]);
                        $team_name = "";
                        if(!empty($teamUser)){
                            $team = $this->ghTeam->getFirstById($teamUser['team_id']);
                            if(!empty($team)){
                                $team_name = $team['name'];
                            }
                        }
                        $total_partial = $this->ghContractPartial->getTotalByContractId($contract['id']);
                        $data[] = [
                            "Source" => "GH",
                            "Team" => $team_name,
                            "ID" => $contract["id"],
                            "Sale Chốt" => $user["name"],
                            "Dự án" =>$apm["address_street"] . ", Phường ". $apm["address_ward"] .", Quận ". ($this->libDistrict->getNameByCode($apm["district_code"])),
                            "Mã phòng" => $room["code"],
                            "Giá thuê" => $contract["room_price"],
                            "Ngày ký" => date("d-m-Y", $contract["time_check_in"]),
                            "Số tháng" => $contract["number_of_month"],
                            "Hoa hồng" => round($contract['commission_rate'],2),
                            "Doanh số" => $this->sheet_money_format($this->ghContract->getTotalSaleByContract($contract["id"])),
                            "Doanh thu" => $total_partial > 0 ? $this->sheet_money_format($total_partial): "-",
                            "Số (*)" => $contract["rate_type"],
                            "Sale Hỗ trợ" => $user_support ?? "-",
                            "Khách Hàng" => $customer["name"] ?? "-",
                            "Phone" => $customer["phone"] ?? "-",
                        ];
                    }
                    break;
                case 3: // Hợp đồng - mốc tgian

                    $list_contract = $this->ghContract->get([
                        "time_check_in >=" => strtotime($timeFrom),
                        "time_check_in <=" => strtotime($timeTo)+86399,
                        'status' => "Active"
                    ],'consultant_id', 'ASC');

                    foreach ($list_contract as $contract){
                        $apm = $this->ghApartment->getFirstById($contract['apartment_id']);
                        $room = $this->ghRoom->getFirstById($contract['room_id']);
                        $user = $this->ghUser->getFirstByAccountId($contract['consultant_id']);
                        $user_support = "";
                        if(!empty($contract["arr_supporter_id"])){
                            $arr = json_decode($contract["arr_supporter_id"], true);
                            $arr_name = [];
                            foreach ($arr as $aid){
                                $arr_name[] = $this->libUser->getNameByAccountid($aid);
                            }
                            $user_support = implode(" ,", $arr_name);
                        }

                        $customer = $this->ghCustomer->getFirstById($contract['customer_id']);
                        $status = "Cọc";
                        if(time() >= $contract["time_check_in"]){
                            $status = "Đã ký";
                        }
                        $teamUser = $this->ghTeamUser->getFirstByUserId($user["account_id"]);
                        $team_name = "";
                        if(!empty($teamUser)){
                            $team = $this->ghTeam->getFirstById($teamUser['team_id']);
                            if(!empty($team)){
                                $team_name = $team['name'];
                            }
                        }
                        $total_partial = $this->ghContractPartial->getTotalByContractId($contract['id']);
                        $user_collected_id = "-";
                        if($apm['user_collected_id'] == $user['account_id']){
                            $user_collected_id = "YES";
                        }
                        $data[] = [
                            "Source" => "GH",
                            "Team" => $team_name ?? "-",
                            "ID" => $contract["id"],
                            "Sale Chốt" => $user["name"],
                            "Dự án" => $apm["address_street"] . ", Phường ". $apm["address_ward"] .", Quận ". ($this->libDistrict->getNameByCode($apm["district_code"])),
                            "Mã phòng" => $room["code"],
                            "Giá thuê" => $contract["room_price"],
                            "Ngày ký" => date("d-m-Y", $contract["time_check_in"]),
                            "Số tháng" => $contract["number_of_month"],
                            "Hoa hồng" => $contract['commission_rate'] ? round($contract['commission_rate'],2) : "-",
                            "Doanh số" => $this->sheet_money_format($this->ghContract->getTotalSaleByContract($contract["id"])),
                            "Doanh thu" => $total_partial > 0 ? $this->sheet_money_format($total_partial): "-",
                            "Số (*)" => $contract["rate_type"] ?? "-",
                            "Sale Hỗ trợ" => $user_support ?? "-",
                            "Người Lấy Dự Án" => $user_collected_id,
                            "Khách Hàng" => $customer["name"] ?? "-",
                            "Phone" => $customer["phone"] ?? "-",
                        ];
                    }
                    break;

                case 4: // Thu nhập - mốc tgian
                    $list_user = $this->ghUser->get(['active' => 'YES']);
                    $list_contract_supporter = $this->ghContract->get([
                        'time_check_in >=' => strtotime($timeFrom),
                        'time_check_in <=' => strtotime($timeTo) +86399,
                        'arr_supporter_id <>' => null,
                        'status' => "Active"
                    ]);

                    foreach ($list_user as $user) {
                        $count_contract = $income = 0;
                        foreach ($list_contract_supporter as $con) {
                            if(!empty($con["arr_supporter_id"])){
                                $arr = json_decode($con["arr_supporter_id"], true);
                                if(in_array($user['account_id'], $arr)){
                                    $count_contract++;
                                }
                            }
                        }

                        $list_contract = $this->ghContract->get([
                            'time_check_in >=' => strtotime($timeFrom),
                            'time_check_in <=' => strtotime($timeTo) +86399,
                            'consultant_id' =>$user['account_id'],
                            'status' => "Active"
                        ]);
                        $count_contract+= count($list_contract);
                        $rate_star = $this->ghContract->getTotalRateStar($user['account_id'], $timeFrom, $timeTo);

                        $final_rate = $income_standard_rate;
                        if($rate_star >= 6){
                            foreach ($list_contract as $con){
                                $income += $con['commission_rate']*$con['room_price']/100 * $income_standard_rate;
                            }
                        } else {
                            $final_rate = 1-$income_standard_rate;
                            foreach ($list_contract as $con){
                                $income += $con['commission_rate']*$con['room_price']/100 * $final_rate;
                            }
                        }
                        if($count_contract) {
                            $teamUser = $this->ghTeamUser->getFirstByUserId($user["account_id"]);
                            $team_name = "";
                            if(!empty($teamUser)){
                                $team = $this->ghTeam->getFirstById($teamUser['team_id']);
                                if(!empty($team)){
                                    $team_name = $team['name'];
                                }
                            }
                            $total_partial = 0;
                            foreach ($list_contract as $con){
                                $total_partial += $this->ghContractPartial->getTotalByContractId($con['id']);
                            }

                            $data[] = [
                                "Source" => "GH",
                                "Team" => $team_name,
                                "Account" => $user["account_id"],
                                "Tên" => $user["name"],
                                "Ngày vào làm" => date("d-m-Y", $user["time_joined"]),
                                "Số (*)" => $rate_star,
                                "Hệ số" => (string)($final_rate*100),
                                "Số hợp đồng" => $count_contract,
                                "Doanh số" => $this->sheet_money_format($this->ghContract->getTotalSaleByUser($user["account_id"], $timeFrom, $timeTo)),
                                "Doanh thu" => $this->sheet_money_format($total_partial),
                                "Thu Nhập" => $this->sheet_money_format(round($income,2))
                            ];
                        }

                    }
                    break;

                default: //
                    echo json_decode(["msg" => "INVALID TOKEN DATA"]);

            }

            array_walk_recursive($data, function(&$v) { $v = trim($v); });
            echo json_encode($data); die;
        }
        return false;
    }

    private function sheet_money_format($number){
        if(empty($number)){
            return "-";
        }
        return number_format($number, 2, ",", ".");

    }

}

/* End of file BaseRoomType.php */
/* Location: ./application/controllers/role-manager/BaseRoomType.php */