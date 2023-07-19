<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PublicGoogleSheet extends CI_Controller
{

	public function __construct()
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		parent::__construct();
		$this->load->model(['ghRoom', 'ghContract', 'ghUser', 'ghCustomer', 'ghContractPartial', 'ghTeamUser', 'ghTeam']);
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
		$this->timeTo = date("05-m-Y", strtotime($this->timeFrom . ' +1 month'));
		if (strtotime(date("d-m-Y")) < strtotime(date("5-m-Y"))) {
			$this->timeFrom = date("06-m-Y", strtotime("-1 month"));
			$this->timeTo = date("05-m-Y");
		}

		$this->view_notfound = "";

	}

	public function getJsonData(){
		$token = $this->input->get('token');
		$data = [];
		$timeFrom = $this->timeFrom;
		$timeTo = $this->timeTo;
		$account_id = 0;

		if(strlen($token) > 20){
			$time_token = explode('_', $token);
			if(count($time_token) > 2){
				$timeFrom = $time_token[0];
				$timeTo = $time_token[1];
				$token = $time_token[2];
				$account_id = isset($time_token[3]) ? $time_token[3] : 0;
			}
		}

		$income_standard_rate = .55;
		if(!empty($token)){
			switch ($token){
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
						$user_support = "-";
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
						$team_name = "-";
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
						// Hợp đồng - mốc tgian
						$data[] = [
							"Source" => "GH",
							"Team" => $team_name ?? "-",
							"ID" => $contract["id"],
							"Sale Chốt" => $user["name"],
							"Dự án" => $apm["address_street"] . ", Phường ". $apm["address_ward"] .", Quận ". ($this->libDistrict->getNameByCode($apm["district_code"])),
							"Mã phòng" => $room["code"],
							"Giá thuê" => $contract["room_price"] > 0 ? $contract["room_price"]: '-',
							"Phí hỗ trợ khách" => $contract["contract_cost"] > 0 ?  $contract["contract_cost"] : '-',
							"Ngày ký" => date("d-m-Y", $contract["time_check_in"]),
							"Số tháng" => $contract["number_of_month"],
							"Hoa hồng" => $contract['commission_rate'] ? round($contract['commission_rate'],2) : "-",
							"Doanh số" => $this->sheet_money_format($this->ghContract->getTotalSaleByContract($contract["id"])),
							"Doanh thu" => $total_partial > 0 ? $this->sheet_money_format($total_partial): "-",
							"Doanh thu sau phí" => ($total_partial-$contract["contract_cost"]) > 0 ? $this->sheet_money_format($total_partial- $contract["contract_cost"]): "-",
							"Số (*)" => $contract["rate_type"],
							"Sale Hỗ trợ" => !empty(trim($user_support)) ? $user_support : "-",
							"Ghi chú" => !empty(trim($contract["note"])) ? $contract["note"] : "-",
							"Người Lấy Dự Án" => $user_collected_id,
							"Khách Hàng" => $customer["name"] ?? "-",
							"Phone" => "-",
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

						$count_contract = $income = $total_sale = $partial_amount_supporter = $partial_amount_consultant = $contract_cost = 0;

						foreach ($list_contract_supporter as $con) {

							$con_partial_amount = $this->ghContractPartial->getTotalByContractId($con['id']);
							if(!empty($con["arr_supporter_id"])){
								$arr = json_decode($con["arr_supporter_id"], true);
								if(in_array($user['account_id'], $arr)){
									$count_contract++;

									if($con['rate_type'] < 1){
										$contract_cost += (1- $con['rate_type'])* $con["contract_cost"];
										$partial_amount_supporter += (1- $con['rate_type']) * $con_partial_amount;
										$total_sale += (1- $con['rate_type']) * $this->ghContract->getTotalSaleByContract($con['id']);
									}
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

						if($count_contract) {
							$teamUser = $this->ghTeamUser->getFirstByUserId($user["account_id"]);
							$team_name = "-";
							if(!empty($teamUser)){
								$team = $this->ghTeam->getFirstById($teamUser['team_id']);
								if(!empty($team)){
									$team_name = $team['name'];
								}
							}

							foreach ($list_contract as $con){
								$contract_cost += $con['rate_type'] * $con["contract_cost"];
								$partial_amount_consultant += $con['rate_type'] * $this->ghContractPartial->getTotalByContractId($con['id']);
								$total_sale += $con['rate_type'] * $this->ghContract->getTotalSaleByContract($con['id']);
							}

							$final_rate = $income_standard_rate;
							if($rate_star < 6){
								$final_rate = 1 - $income_standard_rate;
								$income = $final_rate * ($partial_amount_consultant + $partial_amount_supporter);
							}
							$income = $final_rate * ($partial_amount_consultant + $partial_amount_supporter - $contract_cost);

							// Thu nhập - mốc tgian
							$data[] = [
								"Source" => "GH",
								"Team" => $team_name,
								"Account" => $user["account_id"],
								"Tên" => $user["name"],
								"Ngày vào làm" => date("d-m-Y", $user["time_joined"]),
								"Số (*)" => $this->sheet_money_format($rate_star,1),
								"Hệ số" => (string)($final_rate*100),
								"Số hợp đồng" => $count_contract,
								"Doanh số" => $this->sheet_money_format($total_sale),
								"Doanh thu" => $this->sheet_money_format($partial_amount_consultant + $partial_amount_supporter),
								"Doanh thu trừ phí" => $this->sheet_money_format($partial_amount_consultant + $partial_amount_supporter - $contract_cost),
								"Thu Nhập" => $this->sheet_money_format(round($income,2)),
								"COST" => $contract_cost > 0 ? $contract_cost : '-',
							];
						}

					}
					break;

				case 5: // Loading Thu nhập sale By ID
					$list_contract_supporter = $this->ghContract->get([
						'time_check_in >=' => strtotime($timeFrom),
						'time_check_in <=' => strtotime($timeTo) +86399,
						'arr_supporter_id <>' => null,
						'status' => "Active"
					]);
					$user = $this->ghUser->getFirstByAccountId($account_id);
					$data_contract = [];
					$count_contract = $income = $total_sale = $partial_amount_supporter = $partial_amount_consultant = $contract_cost = 0;
					$teamUser = $this->ghTeamUser->getFirstByUserId($account_id);
					$team_name = "-";
					if(!empty($teamUser)){
						$team = $this->ghTeam->getFirstById($teamUser['team_id']);
						if(!empty($team)){
							$team_name = $team['name'];
						}
					}

					foreach ($list_contract_supporter as $con) {
						$apm = $this->ghApartment->getFirstById($con['apartment_id']);
						$room = $this->ghRoom->getFirstById($con['room_id']);
						$con_partial_amount = $this->ghContractPartial->getTotalByContractId($con['id']);
						if(!empty($con["arr_supporter_id"])){
							$arr = json_decode($con["arr_supporter_id"], true);
							if(in_array($account_id, $arr)){
								if($con['rate_type'] < 1){
									$contract_cost = (1- $con['rate_type'])* $con["contract_cost"];
									$partial_amount_supporter = (1- $con['rate_type']) * $con_partial_amount;
									$total_sale = (1- $con['rate_type']) * $this->ghContract->getTotalSaleByContract($con['id']);

									$data[] = [
										"Source" => "GH",
										"IDHĐ" => $con['id'],
										"Team" => $team_name,
										"SALE.ID" => $account_id,
										"SALE.Tên" => $user["name"],
										"Dự án" => "(".$room['code'].") | ".$this->getFullAddress($apm),
										"***" => $this->sheet_money_format(1- $con['rate_type']),
										"Mô tả" => $this->getDescriptionContract($con,true),
										"Còn lại" => $this->sheet_money_format($this->getIncomePreviewBySale($con,true))
									];
								}
							}
						}
					}

					$list_contract = $this->ghContract->get([
						'time_check_in >=' => strtotime($timeFrom),
						'time_check_in <=' => strtotime($timeTo) +86399,
						'consultant_id' =>$account_id,
						'status' => "Active"
					]);

					$count_contract+= count($list_contract);
					$rate_star = $this->ghContract->getTotalRateStar($account_id, $timeFrom, $timeTo);

					if($count_contract) {

						$team_name = "-";
						if(!empty($teamUser)){
							$team = $this->ghTeam->getFirstById($teamUser['team_id']);
							if(!empty($team)){
								$team_name = $team['name'];
							}
						}

						foreach ($list_contract as $con){

							$apm = $this->ghApartment->getFirstById($con['apartment_id']);
							$room = $this->ghRoom->getFirstById($con['room_id']);
							$con_partial_amount = $this->ghContractPartial->getTotalByContractId($con['id']);

							$contract_cost = $con["contract_cost"];
							$partial_amount = $con['rate_type'] * $con_partial_amount;
							$total_sale = $con['rate_type'] * $this->ghContract->getTotalSaleByContract($con['id']);

							$data[] = [
								"Source" => "GH",
								"IDHĐ" => $con['id'],
								"Team" => $team_name,
								"SALE.ID" => $account_id,
								"SALE.Tên" => $user["name"],
								"Dự án" => "(".$room['code'].") | ".$this->getFullAddress($apm),
								"***" => $this->sheet_money_format($con['rate_type']),
								"Mô tả" => $this->getDescriptionContract($con),
								"Còn lại" => $this->sheet_money_format($this->getIncomePreviewBySale($con))
							];
						}
					}
					break;

				default: //
					echo json_encode(["msg" => "INVALID TOKEN DATA"]); die();

			}

			array_walk_recursive($data, function(&$v) { $v = trim($v); });
			echo json_encode($data); die;
		}
		return false;
	}

	private function sheet_money_format($number,$dec = 2){
		if(empty($number)){
			return "-";
		}
		return number_format($number, $dec, ",", ".");

	}

	private function getDescriptionContract($contract, $is_support=false){
		$des1 = $this->packParentheses(number_format($contract['room_price']/1000) . " x " . $contract['commission_rate'] . "%");
		if(!empty($contract['contract_cost'])){
			$des1 = $this->packParentheses($des1 . " - " . number_format($contract['contract_cost']/1000));
		}

		if($is_support == true){
			return $this->packParentheses($this->packParentheses("1 - ". $contract['rate_type'] ). " x " . $des1);
		}

		return $this->packParentheses($contract['rate_type'] . " x " . $des1);
	}

	private function packParentheses($string){

		return "(".$string.")";
	}

	private function getFullAddress($apm){
		return $apm["address_street"] . ", Phường ". $apm["address_ward"] .", Quận ". ($this->libDistrict->getNameByCode($apm["district_code"]));
	}

	private function getIncomePreviewBySale($contract, $is_support = false){
		if($is_support === true){
			return ((1 - $contract['rate_type']) * ($contract['room_price'] * $contract['commission_rate'] / 100 -  $contract['contract_cost']));
		}
		return ($contract['rate_type'] * ($contract['room_price'] * $contract['commission_rate'] / 100 -  $contract['contract_cost']));
	}
}

