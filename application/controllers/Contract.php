<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contract extends CustomBaseStep {
	public function __construct()
	{
		parent::__construct();

		$this->load->model('ghContract');
		$this->load->model('ghRoom');
		$this->load->model('ghApartment');
		$this->load->model('ghCustomer');
		$this->load->model('ghNotification');
		$this->load->model('ghContractPartial');
		$this->load->model('ghImage');
		$this->load->library('LibCustomer', null, 'libCustomer');
		$this->load->library('LibDistrict', null, 'libDistrict');
		$this->load->library('LibUser', null, 'libUser');
		$this->load->library('LibRoom', null, 'libRoom');

		$this->current_query = http_build_query($this->input->get());
	}

	public function showYour(){
	    $timeCheckInFrom = $this->timeFrom;
	    $timeCheckInTo = $this->timeTo;
        $list_contract = $list_contract_supporter = [];
        $count_contract = $partial_total = 0;

	    if(!empty($this->input->get("timeCheckInFrom"))){
            $timeCheckInFrom = $this->input->get("timeCheckInFrom");
        }

        if(!empty($this->input->get("timeCheckInTo"))){
            $timeCheckInTo = $this->input->get("timeCheckInTo");
        }

        $list_contract_supporter = $this->ghContract->get([
            'time_check_in >=' => strtotime($timeCheckInFrom),
            'time_check_in <=' => strtotime($timeCheckInTo)+86399,
            'status <>' => 'Cancel'
        ]);
        foreach ($list_contract_supporter as $item){
            if(!empty($item["arr_supporter_id"])){
                $arr = json_decode($item["arr_supporter_id"], true);
                if(in_array($this->auth['account_id'], $arr)){
                    $count_contract++;
                    $partial_total += (1- $item['rate_type']) * $this->ghContractPartial->getTotalByContractId($item['id']);
                    $list_contract [] = $item;
                }
            }
        }

        $list_contract_consultant = $this->ghContract->get([
	        'consultant_id' => $this->auth['account_id'],
            'time_check_in >=' => strtotime($timeCheckInFrom),
            'time_check_in <=' => strtotime($timeCheckInTo)+86399,
            'status <>' => 'Cancel'
        ]);
        foreach ($list_contract_consultant as $item){
            $list_contract[] = $item;
            $partial_total += $item['rate_type'] * $this->ghContractPartial->getTotalByContractId($item['id']);
        }

        $data['list_contract'] = $list_contract;
        $data['timeCheckInFrom'] = $timeCheckInFrom;
        $data['timeCheckInTo'] = $timeCheckInTo;


        $this->load->view('components/header');
        $this->load->view('contract/show-your', [
            'list_contract' => $list_contract,
            'timeCheckInFrom' => $timeCheckInFrom,
            'timeCheckInTo' => $timeCheckInTo,
            'flash_mess' => "",
            'flash_status' => "",
            'total_partial' => $partial_total,
        ]);
        $this->load->view('components/footer');

	}

	public function isCollapse(){}

	public function syncStatusExpire() {
		$this->ghContract->syncStatusExpire();
		return redirect('/admin/list-contract');
	}

	public function uploadFile($contract_id){
		$uploadPath = 'media/contract/'; 
		$config['upload_path'] = $uploadPath; 
		$config['allowed_types'] = 'jpg|jpeg|png|gif|mp4|mov'; 

		$time = time();
		$this->load->library('upload', $config); 
		$this->upload->initialize($config); 
		$filesCount = count($_FILES['files']['name']);

		$max_id = $this->ghImage->getMaxId()[0]['id'];
		$uploadData = [];
		if(empty($max_id)){
			$max_id = 1;
		}
		for($i = 0; $i < $filesCount; $i++){ 
			
			$ext = explode(".",$_FILES['files']['name'][$i]);
			$ext = $ext[count($ext) -1];
			$file_name = $max_id.'-contract-'.$time.'.'.$ext;

			$_FILES['file']['name']  = $file_name; 
			$_FILES['file']['type']  = $_FILES['files']['type'][$i]; 
			$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i]; 
			$_FILES['file']['error']    = $_FILES['files']['error'][$i]; 
			$_FILES['file']['size'] = $_FILES['files']['size'][$i];
			if($this->upload->do_upload('file')){ 
				// Uploaded file data 
				$fileData = $this->upload->data(); 
				$uploadData[$i]['name'] = $file_name; 
				$uploadData[$i]['file_type'] = $ext; 
				$uploadData[$i]['time_insert'] = $time;
				$uploadData[$i]['controller'] = 'Contract';
				$uploadData[$i]['contract_id'] = $contract_id;
				$uploadData[$i]['user_id'] = $this->auth['account_id']; 
				$uploadData[$i]['status'] = 'Pending'; 
				$max_id += 1;
			}
		}
		if(!empty($uploadData)){ 
			$insert = $this->ghImage->insert($uploadData);
		}
	}

	public function approved(){
		$this->ghContract->approved($this->input->get('id'), $this->input->get('contract-id'));
        $this->session->set_flashdata('fast_notify', [
            'message' => 'Duyệt Hợp Đồng Thành Công!',
            'status' => 'success'
        ]);
		return redirect('/admin/list-contract');
	}

	public function showAllTimeLine(){}

	public function show(){
	    $params = [];
        $time_from = $this->timeFrom;
        $time_to = $this->timeTo;
        $timeCheckInFrom = $time_from;
        $timeCheckInTo = $time_to;

        $params['gh_contract.time_check_in >='] = strtotime($timeCheckInFrom);
        if($this->input->get('timeCheckInFrom')) {
            $params['gh_contract.time_check_in >='] = strtotime($this->input->get('timeCheckInFrom'));
        }

        $params['gh_contract.time_check_in <='] = strtotime($timeCheckInTo);
        if($this->input->get('timeCheckInTo')) {
            $timeCheckInTo = $this->input->get('timeCheckInTo');
            $params['gh_contract.time_check_in <='] = strtotime($this->input->get('timeCheckInTo'))+86399;
        }

        if($this->input->get('timeExpireFrom')) {
            $timeCheckInFrom = $this->input->get('timeExpireFrom');
            $params['time_expire >='] = strtotime($timeCheckInFrom);
        }

        if($this->input->get('timeExpireTo')) {
            $timeCheckInTo = $this->input->get('timeExpireTo');
            $params['time_expire <='] = strtotime($timeCheckInTo)+86399;
        }
        $params['gh_contract.status <>'] = "'Cancel'";

		$data['list_contract'] = $this->ghContract->getBySearch($params);
		$data['list_notification'] = $this->ghNotification->get([
		    'is_approve' => 'NO',
        ]);

		/*view handle*/
        $partialGroup = "contract/table-default";
		if(!empty($this->input->get("partialGroup"))){
		    $partialGroup = $this->input->get("partialGroup");
		    switch ($partialGroup){
                case "consultant":
                    $partialGroup = "contract/group-by-consultant";
                    break;

                case "apartment":
                    $partialGroup = "contract/group-by-apartment";
                    break;

                case "Chart":
                    $partialGroup = "contract/group-by-chart";
                    break;
                default:
                    break;
            }

        }


		$data['libCustomer'] = $this->libCustomer;
		$data['libUser'] = $this->libUser;
		$data['ghApartment'] = $this->ghApartment;
		$data['ghRoom'] = $this->ghRoom;
		$data['ghContractPartial'] = $this->ghContractPartial;
		$data['partialGroup'] = $partialGroup;

		/*--- Load View ---*/
        $data['time_from'] = $time_from;
        $data['time_to'] = $time_to;
        $data['timeCheckInFrom'] = $timeCheckInFrom;
        $data['timeCheckInTo'] = $timeCheckInTo;
		$this->load->view('components/header');
		$this->load->view('contract/show-all', $data);
		$this->load->view('components/footer');
	}

	public function drawChart(){
	    $groupBy = $this->input->post("groupBy");
	    $res = [];
	    switch ($groupBy){
            case "Consultant":
                $res[] = ["Sale", "Doanh số", "Hợp đồng"];
                $list_user = $this->ghUser->get(["active" => "YES"]);
                foreach ($list_user as $user) {
                    $total_sale = $this->ghContract->getTotalSaleByUser($user["account_id"],$this->timeFrom,$this->timeTo);
                    if($total_sale > 0) {
                        $con_counter = $this->ghContract->getCountContractByUser($user["account_id"],$this->timeFrom,$this->timeTo);
                        $res[] = [$user["name"], round($total_sale/1000000,1), $con_counter];
                    }
                }
                break;

                case "District":
                $res[] = ["Quận", "Doanh số", "Hợp đồng"];
                $list_d= $this->ghDistrict->get(["active" => "YES"]);
                foreach ($list_d as $d) {
                    $total_sale = $this->ghContract->getTotalSaleByDistrict($d["code"],$this->timeFrom,$this->timeTo);
                    if($total_sale > 0) {
                        $con_counter = $this->ghContract->getCountContractByDistrict($d["code"],$this->timeFrom,$this->timeTo);
                        $res[] = ["Q.".$d["name"], round($total_sale/1000000,1), $con_counter];
                    }
                }
                break;

                case "TimeLine":
                $res[] = ["Ngày", "Doanh số", "Hợp đồng"];
                $month_end = strtotime("+2month");
                $time_line  = strtotime(date('01-01-Y'));

                while($time_line <= $month_end){
                    $last_day_this_month = strtotime('last day of this month', $time_line);
                    $list = $this->ghContract->get([
                        'time_check_in >=' => $time_line,
                        'time_check_in <=' => $last_day_this_month,
                        'status <>' => 'Cancel'
                    ]);
                    $total_sale = 0;
                    foreach ($list as $contract) {
                        $total_sale += $this->ghContract->getTotalSaleByContract($contract['id']);
                    }

                    $res[] =[date("m/Y",$time_line), $total_sale/1000000, count($list)];

                    $time_line = strtotime("+1month", $time_line);;
                }
                break;
            default:
                break;
        }

        echo json_encode($res);
    }

	public function createShow(){
		$room_id = $this->input->get('room-id');
		$data['room'] = $this->ghRoom->get(['id' =>$room_id])[0];
		$data['apartment'] = $this->ghApartment->get(['id' =>$data['room']['apartment_id']])[0];
		$data['select_customer'] = $this->libCustomer->cb();
		$data['select_user'] = $this->libUser->cb(0,'YES');
		$data['libDistrict'] = $this->libDistrict;
		
		/*--- Load View ---*/
		$this->load->view('components/header');
		$this->load->view('contract/create-show-v2', $data);
		$this->load->view('components/footer');
	}

	public function detailShow(){
		$contract_id = $this->input->get('id');
		$model = $this->ghContract->getFirstById($contract_id);
        $notification = $this->ghNotification->get([
            'is_approve' => 'NO',
            'object_id' => $contract_id
        ]);

        $data['notification_object_id'] = count($notification) ? $notification[0]['object_id'] : "";
		$data['contract'] = $model;
		$data['libCustomer'] = $this->libCustomer;
		$data['libUser'] = $this->libUser;
		$data['ghApartment'] = $this->ghApartment;
		$data['ghCustomer'] = $this->ghCustomer;
		$data['ghRoom'] = $this->ghRoom;
        $data['libUser'] = $this->libUser;
		$data['ghImage'] = $this->ghImage;
		$data['list_partial'] = $this->ghContractPartial->get(['contract_id' => $contract_id]);
        $current_partial_amount = 0;
		foreach ($data['list_partial'] as $item) {
            $current_partial_amount += $item['amount'];
        }
		$data['remaining_amount'] = $model['room_price']*$model["commission_rate"]/100 - $current_partial_amount;

		$main_template = "contract/detail-show";
		if($this->input->get('viewMode') == "confirmPublic"){
            $main_template = "contract/detail-confirm-public";
        }
		$this->load->view('components/header');
		$this->load->view($main_template, $data);
		$this->load->view('components/footer');
	}

	public function createPartial(){
        $post = $this->input->post();

        $data_insert = [
            'contract_id' => $post['contract_id'],
            'amount' => $post['amount'],
            'apply_time' => strlen($post['apply_time']) ? strtotime($post['apply_time']) : null ,
        ];
        $this->ghContractPartial->insert($data_insert);
        return redirect($_SERVER['HTTP_REFERER']);
    }

    public function deletePartial(){
        $id = $this->input->post('id');
        if(!empty($id)) {
            $result = $this->ghContractPartial->delete($id);

            if($result > 0) {
                echo json_encode(['status' => true]); die;
            }

            echo json_encode(['status' => false]); die;
        }
        echo json_encode(['status' => false]); die;
    }

	public function create() {
        if($this->input->get('controller-name') =='Contract') {
            $this->uploadFile($this->input->get('contract-id'));
            return redirect($_SERVER['HTTP_REFERER']);
        }
		$post = $this->input->post();

        $saved_customer = $this->ghCustomer->get(['phone' => $post['phone']]);
        if(count($saved_customer) > 0) {
            $customer_id = $saved_customer[0]['id'];
        } else {
            $new_customer = [
                'name' => $post['name'],
                'gender' => $post['gender'],
                'birthdate' => strlen($post['birthdate']) ? strtotime($post['birthdate']) : null,
                'phone' => $post['phone'],
                'email' => $post['email'],
                'ID_card' => $post['ID_card'],
                'status' => $this->ghCustomer::CUSTOMER_STATUS_SINVA_RENTED,
                'source' => $post['source'],
                'user_insert_id' => $this->auth['account_id'],
                'time_insert' => time()
            ];
            $customer_id = $this->ghCustomer->insert($new_customer);
        }

		$service_set = $this->ghApartment->get(['id' =>$post['apartment_id']])[0];

		$contract_room_price = (int) filter_var($post["room_price"], FILTER_SANITIZE_NUMBER_INT);

        $status_contract = 'Pending';

		$contract = [
			'customer_id' => $customer_id,
			'room_id' => $post['room_id'],
			'apartment_id' => $service_set['id'],
			'consultant_id' => $post['consultant_id'],
			'room_price' => $contract_room_price,
			'deposit_price' =>(int) filter_var($post["deposit_price"],FILTER_SANITIZE_NUMBER_INT),
			'time_check_in' => strlen($post['time_check_in']) ? strtotime($post['time_check_in']) : null,
			'time_expire' => strlen($post['time_expire']) ? strtotime($post['time_expire']) :null ,
			'number_of_month' => $post['number_of_month'],
			'service_set' => json_encode($service_set), // apartment data
			'status' => $status_contract,
            'rate_type' => $post['rate_type'],
			'note' => $post['note'],
			'room_code' => $post['room_code'],
			'commission_rate' => $post['commission_rate'],
			'user_create_id' => $this->auth['account_id'],
			'time_insert' => time(),
		];

        $contract["arr_supporter_id"] = null;
		if(!empty($post['arr_supporter_id']) && is_array($post['arr_supporter_id']) && count($post['arr_supporter_id'])){
            $contract["arr_supporter_id"] = json_encode($post['arr_supporter_id']);
        }

		$result = $this->ghContract->insert($contract);
		$this->uploadFile($result);
		if($this->isYourPermission('Contract', 'pendingForApprove')) {
			$this->ghNotification->insert(
				[
					'message' => '['.$this->auth['name'].'] đã tạo hợp đồng ID = '.$result,
					'create_user_id' => $this->auth['account_id'],
					'time_insert' => time(),
					'controller' => 'Contract',
					'object_id' => $result
				]
			);
		}


        $this->session->set_flashdata('fast_notify', [
            'message' => 'Tạo Hợp Đồng Thành Công',
            'status' => 'success'
        ]);
        return redirect('admin/list-personal-contract');
	}

	public function pendingForApprove() {}

	// Ajax
	public function update() {
		$contract_id = $this->input->post('contract_id');
		$field_value = $this->input->post('field_value');
		$field_name = $this->input->post('field_name');
		if(!empty($contract_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];
			$result = $this->ghContract->updateById($contract_id, $data);
			echo json_encode(['status' => $result]); die;
		}
		echo json_encode(['status' => false]); die;
	}

	public function updateEditable() {
		$contract_id = $this->input->post('pk');
		$field_name = $this->input->post('name');
		$field_value = $this->input->post('value');

		if(!empty($contract_id) and !empty($field_name)) {
			if($field_name == 'time_expire' || $field_name == 'time_check_in' || $field_name == 'time_insert') {
				if(empty($field_value)) {
					$field_value = null;
				} else {
					$field_value = str_replace('/', '-', $field_value);
					$field_value = strtotime((string)$field_value);
				}
			}
			$data = [
				$field_name => $field_value,
                'time_update' => time(),
                'user_update_id' => $this->auth['account_id']
			];

			$old_contract = $this->ghContract->getById($contract_id);
			$old_log = json_encode($old_contract[0]);
			
			$result = $this->ghContract->updateById($contract_id, $data);
			
			$modified_contract = $this->ghContract->getById($contract_id);
			$modified_log = json_encode($modified_contract[0]);
			
			$log = [
				'table_name' => 'gh_contract',
				'old_content' => $old_log,
				'modified_content' => $modified_log,
				'time_insert' => time(),
				'action' => 'update'
			];
			$tracker = $this->ghActivityTrack->insert($log);

			echo json_encode(['status' => $result]); die;
		}
		echo json_encode(['status' => false]); die;
	}

	public function delete(){
		$contract_id = $this->input->post('contract_id');
		if(!empty($contract_id)) {
			$old_contract = $this->ghContract->getById($contract_id);

			$log = [
				'table_name' => 'gh_contract',
				'old_content' => null,
				'modified_content' => json_encode($old_contract[0]),
				'time_insert' => time(),
				'action' => 'delete'
			];

			// call model
			$tracker = $this->ghActivityTrack->insert($log);
			$result = $this->ghContract->delete($contract_id);
			
			if($result > 0) {
				echo json_encode(['status' => true]); die;
			}
			echo json_encode(['status' => false]); die;
		}
		echo json_encode(['status' => false]); die;
	}

	private function sendMailCreate($data){
        $content = '<h1 style="color:darkgreen">Hợp đồng được tạo thành công , chúc mừng <strong>'.$data['consultant_name'].'</strong></h1>';
        $content .= '<ul>';
        $content .= '<ul> <li>Ngày tạo: <strong>'.$data['create_date'].'</strong> </li>';
        $content .= '<li>Dự án: <strong>'.$data['apartment_address'].'</strong> </li> ';
        $content .= '<li>Mã phòng: <strong>'.$data['room_code'].'</strong> </li> ';
        $content .= '<li>Giá thuê: <strong>'.$data['room_price'].'</strong> </li> ';
        $content .= '<li>Số tháng: <strong>'.$data['create_date'].'</strong> </li> ';
        $content .= '<li>Hoa hồng: <strong>'.$data['create_date'].'</strong> </li> ';
        $content .= '<li>Khách hàng: <strong>'.$data['create_date'].'</strong> </li> ';
        $content .= '</ul>';
        $content .= '<p style="margin-top:25px"> <small>Giỏ hàng Sinva home</small></p>';

        $this->libEmail->sendEmailFromServer($data[''], 'QUỐC BÌNH', 'Tạo Account SHARE', $content);
    }

}

/* End of file Apartment.php */
/* Location: ./application/controllers/role-manager/Apartment.php */
