<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contract extends CustomBaseStep {
	private $access_control;
	public function __construct()
	{
		parent::__construct();

		$this->load->model('ghContract');
		$this->load->model('ghRoom');
		$this->load->model('ghApartment');
		$this->load->model('ghCustomer');
		$this->load->model('ghNotification');
		$this->load->model('ghImage');
		$this->load->library('LibCustomer', null, 'libCustomer');
		$this->load->library('LibDistrict', null, 'libDistrict');
		$this->load->library('LibUser', null, 'libUser');
		$this->load->library('LibRoom', null, 'libRoom');
		$this->load->config('label.apartment');
	}

	public function showYour(){
		return $this->ghContract->get(['user_create_id' => $this->auth['account_id']]);
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
		return redirect('/admin/list-contract');
	}

	public function showAllTimeLine(){}

	public function show(){
		$this->load->model('ghContract'); // load model ghUser
		$data['list_contract'] = $this->ghContract->get();


        $time_from = 0;
        $time_to = strtotime('+4years');
        if($this->isYourPermission($this->current_controller, 'showAllTimeLine')) {
            if($this->input->get('filterTime') == 'ALL'){
                $time_from = 0;
                $time_to = strtotime('+4years');

            }
            if($this->input->get('filterTime') == 'TODAY'){
                $time_from = strtotime(date('d-m-Y'));
                $time_to = $time_from + 86399;
            }

            if($this->input->get('filterTime') == 'NEXT_15D'){
                $time_from = strtotime(date('d-m-Y'));
                $time_to = strtotime('+15days');
            }

            if($this->input->get('filterTime') == 'NEXT_30D'){
                $time_from = strtotime(date('d-m-Y'));
                $time_to = strtotime('+30days');
            }

            if($this->input->get('filterTime') == 'NEXT_60D'){
                $time_from = strtotime(date('d-m-Y'));
                $time_to = strtotime('+60days');
            }

            if($this->input->get('filterTime') == 'NEXT_1Y'){
                $time_from = strtotime(date('d-m-Y'));
                $time_to = strtotime('+1years');
            }

            $data['list_contract'] = $this->ghContract->get(['time_expire <=' => $time_to, 'time_expire >= ' => $time_from]);
            if($this->isYourPermission($this->current_controller, 'showYour')) {
                $data['list_contract'] = $this->showYour();
            }
        }

		$data['list_notification'] = $this->ghNotification->get(['is_approve' => 'NO']);
		
		$data['libCustomer'] = $this->libCustomer;
		$data['libUser'] = $this->libUser;
		$data['ghApartment'] = $this->ghApartment;
		$data['ghRoom'] = $this->ghRoom;
		$data['ghImage'] = $this->ghImage;
		$data['libRoom'] = $this->libRoom;
		$data['label_apartment'] =  $this->config->item('label.apartment');
		/*--- Load View ---*/
		$this->load->view('components/header',['menu' =>$this->menu]);
		$this->load->view('contract/show', $data);
		$this->load->view('components/footer');
	}

	public function createShow(){
		$room_id = $this->input->get('room-id');
		$data['room'] = $this->ghRoom->get(['id' =>$room_id])[0];
		$data['apartment'] = $this->ghApartment->get(['id' =>$data['room']['apartment_id']])[0];
		$data['select_customer'] = $this->libCustomer->cb();
		$data['select_user'] = $this->libUser->cb();
		$data['libDistrict'] = $this->libDistrict;
		
		/*--- Load View ---*/
		$this->load->view('components/header',['menu' =>$this->menu]);
		$this->load->view('contract/create-show', $data);
		$this->load->view('components/footer');
	}

	public function detailShow(){
		$contract_id = $this->input->get('id');
		$model = $this->ghContract->get(['id' => $contract_id])[0];
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
		$this->load->view('components/header',['menu' =>$this->menu]);
		$this->load->view('contract/detail-show', $data);
		$this->load->view('components/footer');
	}

	public function create() {
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
				'status' => 'sinva-rented',
				'source' => $post['source_new'],
				'user_insert_id' => $this->auth['account_id'],
				'time_insert' => time()
			];
			if($this->auth['role_code'] !== 'customer-care') {
				$new_customer_data['test_mode'] = 'YES';
			}
		
			$customer_id = $this->ghCustomer->insert($new_customer_data);
		} else {
			$customer_id = $post['customer_name'];
			$update_customer = ['status' => 'sinva-rented'];
			if($this->auth['role_code'] !== 'customer-care') {
				$update_customer = ['status' => 'sinva-rented', 'test_mode' => '[YES,'.$this->auth['name'].']'];
			}
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
			if($field_name == 'time_expire') {
				if(empty($field_value)) {
					$field_value = null;
				} else {
					$field_value = str_replace('/', '-', $field_value);
					$field_value = strtotime((string)$field_value);
				}
			}
			$data = [
				$field_name => $field_value
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