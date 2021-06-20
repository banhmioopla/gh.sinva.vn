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
		$this->load->config('label.apartment');
	}

	public function showYour(){
	    $data['list_contract'] = $this->ghContract->get(['consultant_id' => $this->auth['account_id']]);

        $data['libCustomer'] = $this->libCustomer;
        $data['libUser'] = $this->libUser;
        $data['ghApartment'] = $this->ghApartment;
        $data['ghRoom'] = $this->ghRoom;
        $data['ghImage'] = $this->ghImage;
        $data['libRoom'] = $this->libRoom;
        $data['label_apartment'] =  $this->config->item('label.apartment');
        $data['flash_mess'] = "";
        $data['flash_status'] = "";
        if($this->session->has_userdata('fast_notify')) {
            $data['flash_mess']= $this->session->flashdata('fast_notify')['message'];
            $data['flash_status']= $this->session->flashdata('fast_notify')['status'];
            unset($_SESSION['fast_notify']);
        }

        $this->load->view('components/header',['menu' =>$this->menu]);
        $this->load->view('contract/show-your', $data);
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
        $time_from = null;
        $time_to = null;
        if($this->input->get('timeCheckInFrom')) {
            $timeCheckInFrom = $this->input->get('timeCheckInFrom');
            $params['time_check_in >='] = strtotime($timeCheckInFrom);
        }


        if($this->input->get('timeCheckInTo')) {
            $timeCheckInTo = $this->input->get('timeCheckInTo');
            $params['time_check_in <='] = strtotime($timeCheckInTo)+86399;
        }

        if($this->input->get('timeExpireFrom')) {
            $timeCheckInFrom = $this->input->get('timeExpireFrom');
            $params['time_expire >='] = strtotime($timeCheckInFrom);
        }

        if($this->input->get('timeExpireTo')) {
            $timeCheckInTo = $this->input->get('timeExpireTo');
            $params['time_expire <='] = strtotime($timeCheckInTo)+86399;
        }

		$data['list_contract'] = $this->ghContract->getBySearch($params);
		$data['list_notification'] = $this->ghNotification->get(['is_approve' => 'NO']);
		
		$data['libCustomer'] = $this->libCustomer;
		$data['libUser'] = $this->libUser;
		$data['ghApartment'] = $this->ghApartment;
		$data['ghRoom'] = $this->ghRoom;
		$data['ghImage'] = $this->ghImage;
		$data['ghContractPartial'] = $this->ghContractPartial;
		$data['libRoom'] = $this->libRoom;
		$data['label_apartment'] =  $this->config->item('label.apartment');
		/*--- Load View ---*/
        $data['time_from'] = $time_from;
        $data['time_to'] = $time_to;
		$this->load->view('components/header',['menu' =>$this->menu]);
		$this->load->view('contract/show-all', $data);
		$this->load->view('components/footer');
	}

	public function createShow(){
		$room_id = $this->input->get('room-id');
		$data['room'] = $this->ghRoom->get(['id' =>$room_id])[0];
		$data['apartment'] = $this->ghApartment->get(['id' =>$data['room']['apartment_id']])[0];
		$data['select_customer'] = $this->libCustomer->cb();
		$data['select_user'] = $this->libUser->cb(0,'YES');
		$data['libDistrict'] = $this->libDistrict;
		
		/*--- Load View ---*/
		$this->load->view('components/header',['menu' =>$this->menu]);
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
        $data['label'] =  $this->config->item('label.apartment');
		$data['ghImage'] = $this->ghImage;
		$data['label'] =  $this->config->item('label.apartment');
		$data['list_partial'] = $this->ghContractPartial->get(['contract_id' => $contract_id]);
        $current_partial_amount = 0;
		foreach ($data['list_partial'] as $item) {
            $current_partial_amount += $item['amount'];
        }
		$data['remaining_amount'] = $model['room_price'] - $current_partial_amount;
		$this->load->view('components/header',['menu' =>$this->menu]);
		$this->load->view('contract/detail-show', $data);
		$this->load->view('components/footer');
	}

	public function createTemp() {
        if($this->input->get('controller-name') =='Contract') {
            $this->uploadFile($this->input->get('contract-id'));
            return redirect($_SERVER['HTTP_REFERER']);
        }
		$post = $this->input->post();
		
		if($post['time_open']) {
			$dt = DateTime::createFromFormat('d/m/Y', $post['time_open']);
			$post['time_open'] = $dt->getTimestamp();
		} else {
			$post['time_open'] = 0;
		}

		if($post['time_expire']) {
			$dt = DateTime::createFromFormat('d/m/Y', $post['time_expire']);
			$post['time_expire'] = $dt->getTimestamp();
		} else {
			$post['time_expire'] = 0;
		}

		if(isset($post['customer_name_new']) and !empty($post['customer_name_new'])) {
			$birth_date_new = $post['birthdate_new'] ? strtotime(str_replace('/', '-', $post['birthdate_new'])) : 0;
			
			$new_customer_data = [
				'name' => $post['customer_name_new'],
				'gender' => $post['gender_new'],
				'birthdate' => $birth_date_new,
				'phone' => $post['phone_new'],
				'email' => $post['email_new'],
				'ID_card' => $post['ID_card_new'],
				'status' => $this->ghCustomer::CUSTOMER_STATUS_SINVA_RENTED,
				'source' => $post['source_new'],
				'user_insert_id' => $this->auth['account_id'],
				'time_insert' => time()
			];
		
			$customer_id = $this->ghCustomer->insert($new_customer_data);
		} else {
			$customer_id = $post['customer_name'];
			$update_customer = ['status' => $this->ghCustomer::CUSTOMER_STATUS_SINVA_RENTED];
			$customer_model = $this->ghCustomer->updateById($customer_id, $update_customer);
		}
		
		$service_set = $this->ghApartment->get(['id' =>$post['apartment_id']])[0];

		$contract_room_price = $post['room_price'] > 0 ? 
		(int) filter_var($post["room_price"], FILTER_SANITIZE_NUMBER_INT) 
			: $service_set['price'];

		$status_contract = $post['status'];
		if($this->isYourPermission('Contract', 'pendingForApprove')) {
			$status_contract = 'Pending';
		}
		$contract = [
			'customer_id' => $customer_id,
			'room_id' => $post['room_id'],
			'apartment_id' => $service_set['id'],
			'consultant_id' => $post['consultant_id'],
			'room_price' => $contract_room_price,
			'time_check_in' => $post['time_open'],
			'time_expire' => $post['time_expire'],
			'number_of_month' => $post['number_of_month'],
			'service_set' => json_encode($service_set), // apartment data
			'status' => $status_contract,
			'note' => $post['note'],
			'room_code' => $post['room_code'],
			'commission_rate' => $post['commission_rate'],
			'user_create_id' => $this->auth['account_id'],
			'time_insert' => time(),
		];
		
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
            'message' => 'Tạo hợp đồng thành công ',
            'status' => 'success'
        ]);
        return redirect('admin/list-contract');
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

		$contract_room_price = $post['room_price'] > 0 ?
		(int) filter_var($post["room_price"], FILTER_SANITIZE_NUMBER_INT)
			: $service_set['price'];

		$status_contract = $post['status'];
		if($this->isYourPermission('Contract', 'pendingForApprove')) {
			$status_contract = 'Pending';
		}

		$contract = [
			'customer_id' => $customer_id,
			'consultant_support_id' => $post['consultant_support_id'],
			'room_id' => $post['room_id'],
			'apartment_id' => $service_set['id'],
			'consultant_id' => $post['consultant_id'],
			'room_price' => $contract_room_price,
			'time_check_in' => strlen($post['time_check_in']) ? strtotime($post['time_check_in']) : null,
			'time_expire' => strlen($post['time_expire']) ? strtotime($post['time_expire']) :null ,
			'number_of_month' => $post['number_of_month'],
			'service_set' => json_encode($service_set), // apartment data
			'status' => $status_contract,
			'note' => $post['note'],
			'room_code' => $post['room_code'],
			'commission_rate' => $post['commission_rate'],
			'user_create_id' => $this->auth['account_id'],
			'time_insert' => time(),
		];

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

}

/* End of file Apartment.php */
/* Location: ./application/controllers/role-manager/Apartment.php */