<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image extends CustomBaseStep {
    public function __construct()
	{
		parent::__construct();
		$this->load->model('ghDistrict');
		$this->load->model('ghApartment');
		$this->load->model('ghRoom');
		$this->load->model('ghImage');
		$this->load->library('LibRoom', null, 'libRoom');
		$this->load->library('LibBaseRoomType', null, 'libBaseRoomType');
		$this->load->library('LibBasePrice', null, 'libBasePrice');
    }
    
    public function show() {
        $data = [];
        $apartment_id = $this->input->get('apartment-id');
        $room_id = $this->input->post('room_id');
        
        if(!isset($apartment_id) and empty($apartment_id)) {
            redirect('notfound');
        }
       
        $apartment_model = $this->ghApartment->getById($apartment_id);
        $data['apartment_model'] = $apartment_model[0];
        
        $data['cb_room_code'] = $this->libRoom->cbCodeByApartmentId($apartment_id, $room_id);         


        $submit_upload = $this->input->post('fileSubmit');
        $errorUploadType = $statusMsg = '';
        
        if(isset($submit_upload) and $submit_upload == 'UPLOAD') {
            // File upload configuration 
            $uploadPath = 'media/apartment/'; 
            $config['upload_path'] = $uploadPath; 
            $config['allowed_types'] = 'jpg|jpeg|png|gif'; 
            //$config['max_size']    = '100'; 
            //$config['max_width'] = '1024'; 
            //$config['max_height'] = '768';
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
                
                $ext = explode(".",$_FILES['files']['name'][$i])[1];
                $file_name = $max_id.'-apartment-'.$apartment_id.'-'.$time.'.'.$ext;

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
                    $uploadData[$i]['room_id'] = $room_id; 
                    $uploadData[$i]['apartment_id'] = $apartment_id; 
                    $uploadData[$i]['user_id'] = $this->auth['account_id']; 
                    $uploadData[$i]['status'] = 'Pending'; 
                    $max_id += 1;
                }
            } 
            
            if(!empty($uploadData)){ 
                $insert = $this->ghImage->insert($uploadData);
            }
        }
        $data['list_img'] = $this->ghImage->getRows($apartment_id);
        $data['list_price'] = $this->ghBasePrice->get(['active' => true]);
        $data['list_room_type'] = $this->ghBaseRoomType->get(['active' => true]);
        $data['list_room_code'] = $this->ghRoom->get(['active' => true, 'apartment_id' => $apartment_id]);

        $this->load->view('components/header', ['menu' => $this->menu]);
        $this->load->view('media/store-apartment/show', $data);
        $this->load->view('components/footer');
    }

    public function handleCb() {
        $type = $this->input->post('type');
        $apartment_id = $this->input->post('apartment_id');
        $floor_number = $this->input->post('floor_number');  
    }

    public function update() {
		$img_id = $this->input->post('img_id');
		$field_value = $this->input->post('field_value');
		$field_name = $this->input->post('field_name');
        // var_dump($this->input->post()); die;
		if(!empty($img_id) and !empty($field_value)) {
			$data = [
				$field_name => $field_value
			];
			$result = $this->ghImage->updateById($img_id, $data);
			echo json_encode(['status' => $result]); die;
		}
		echo json_encode(['status' => false]); die;
	}
}

?>