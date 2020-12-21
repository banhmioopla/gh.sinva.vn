<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image extends CustomBaseStep
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ghDistrict');
        $this->load->model('ghApartment');
        $this->load->model('ghRoom');
        $this->load->model('ghImage');
        $this->load->model('ghDistrict');
        $this->load->library('LibRoom', null, 'libRoom');
        $this->load->library('LibDistrict', null, 'libDistrict');
        $this->load->library('LibBaseRoomType', null, 'libBaseRoomType');
        $this->load->library('LibBasePrice', null, 'libBasePrice');
    }

    public function show()
    {
        $data = [];
        $apartment_id = $this->input->get('apartment-id');
        $room_id = $this->input->post('room_id');

        if (!isset($apartment_id) and empty($apartment_id)) {
            redirect('notfound');
        }

        $apartment_model = $this->ghApartment->getById($apartment_id);
        $data['apartment_model'] = $apartment_model[0];

        $data['cb_room_code'] = $this->libRoom->cbCodeByApartmentId($apartment_id, $room_id);


        $submit_upload = $this->input->post('fileSubmit');
        $errorUploadType = $statusMsg = '';

        if (isset($submit_upload) and $submit_upload == 'UPLOAD') {
            // File upload configuration 
            $uploadPath = 'media/apartment/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|png|gif|mp4|mov';
            //$config['max_size']    = '100'; 
            //$config['max_width'] = '1024'; 
            //$config['max_height'] = '768';
            $time = time();
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $filesCount = count($_FILES['files']['name']);
            $max_id = $this->ghImage->getMaxId()[0]['id'];
            $uploadData = [];
            if (empty($max_id)) {
                $max_id = 1;
            }
            for ($i = 0; $i < $filesCount; $i++) {

                $ext = pathinfo($_FILES['files']['name'][$i], PATHINFO_EXTENSION);
                $file_name = $max_id . '-apartment-' . $apartment_id . '-' . $time . '.' . $ext;

                $_FILES['file']['name'] = $file_name;
                $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                $_FILES['file']['size'] = $_FILES['files']['size'][$i];

                if ($this->upload->do_upload('file')) {
                    // Uploaded file data 
                    $this->upload->data();
                    $uploadData[$i]['name'] = $file_name;
                    $uploadData[$i]['file_type'] = $ext;
                    $uploadData[$i]['time_insert'] = $time;
                    $uploadData[$i]['controller'] = 'Apartment';
                    $uploadData[$i]['room_id'] = $room_id;
                    $uploadData[$i]['apartment_id'] = $apartment_id;
                    $uploadData[$i]['user_id'] = $this->auth['account_id'];
                    $uploadData[$i]['status'] = 'Pending';
                    $max_id += 1;
                }
            }

            if (!empty($uploadData)) {
                $this->ghImage->insert($uploadData);
            }
            return redirect('/admin/upload-image?apartment-id='.$apartment_id);
        }
        $data['list_img'] = $this->ghImage->getRows($apartment_id);

        $data['list_price'] = $this->ghBasePrice->get(['active' => true]);
        $data['list_room_type'] = $this->ghBaseRoomType->get(['active' => true]);
        $data['list_room_code'] = $this->ghRoom->get(['active' => true, 'apartment_id' => $apartment_id]);

        $this->load->view('components/header', ['menu' => $this->menu]);
        $this->load->view('media/store-apartment/show', $data);
        $this->load->view('components/footer');

    }

    public function showGalleryApartment()
    {
        $data['list_apartment'] = $this->ghApartment->get(['active' => 'YES']);
        $data['ghImage'] = $this->ghImage;
        $data['list_district'] = $this->ghDistrict->get(['active' => 'YES']);
        $data['libDistrict'] = $this->libDistrict;
        $this->load->view('components/header', ['menu' => $this->menu]);
        $this->load->view('media/store-apartment/show-gallery-apartment', $data);
        $this->load->view('components/footer');
    }

    public function searchApartment()
    {
        $q = $this->input->get('q');
        $data = [['id' => 0, 'text' => 'Tìm dự án ... ']];
        if (empty($q)) {
            $apm = $this->ghApartment->get(['active' => 'YES']);
            if ($apm) {
                foreach ($apm as $a) {
                    $data[] = ['id' => $a['id'], 'text' => $a['address_street'] . ' - phường' . $a['address_ward']];
                }
            }

        } else {
            $apm = $this->ghApartment->getLike(['address_street' => $q]);
            if ($apm) {
                foreach ($apm as $a) {
                    $data[] = ['id' => $a['id'], 'text' => $a['address_street'] . ' - phường' . $a['address_ward']];
                }
            }

        }
        echo json_encode($data);
    }

    public function handleCb()
    {
        $type = $this->input->post('type');
        $apartment_id = $this->input->post('apartment_id');
        $floor_number = $this->input->post('floor_number');
    }

    public function update()
    {
        $img_id = $this->input->post('img_id');
        $field_value = $this->input->post('field_value');
        $field_name = $this->input->post('field_name');
        // var_dump($this->input->post()); die;
        if (!empty($img_id) and !empty($field_value)) {
            $data = [
                $field_name => $field_value
            ];
            $result = $this->ghImage->updateById($img_id, $data);
            echo json_encode(['status' => $result]);
            die;
        }
        echo json_encode(['status' => false]);
        die;
    }

    function my_folder_delete($path) {
        if(!empty($path) && is_dir($path) ){
            $dir  = new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS); //upper dirs are not included,otherwise DISASTER HAPPENS :)
            $files = new RecursiveIteratorIterator($dir, RecursiveIteratorIterator::CHILD_FIRST);
            foreach ($files as $f) {if (is_file($f)) {unlink($f);} else {$empty_dirs[] = $f;} } if (!empty($empty_dirs)) {foreach ($empty_dirs as $eachDir) {rmdir($eachDir);}} rmdir($path);
        }
    }

    public function downloadMedia() {
        ini_set('memory_limit', '12024M');

        $list_id = $this->input->post("list_id");

        $this->load->library('zip');
        $rootPath = 'media/apartment/';
        $download_path = 'ImFineThanks/';

        if(is_dir($download_path)){
            $this->my_folder_delete($download_path);
        }
        mkdir($download_path);
        $address = 'KoThongTin';
        foreach ($list_id as $id) {

            $model_img = $this->ghImage->getById($id);
            $room_code = $this->ghRoom->get(['id' => $model_img[0]['room_id']]);



            $room_path = '';

            if($room_code && $room_code[0]['code']) {
                $address = $this->ghApartment->get(['id' => $room_code[0]['apartment_id']])[0]['address_street'];
                $room_path .= $download_path.'['.$room_code[0]['price'].']--MP-' .$room_code[0]['code'].'/';

                if( is_dir($room_path) === false )
                {
                    mkdir($room_path);
                }
            }
            if($model_img) {
                $room_path .= $model_img[0]['name'];
                copy($rootPath.$model_img[0]['name'], $room_path);
                $this->zip->read_file($room_path, true);
            }

        }

        $zipName = '[gh] DA - '.$address.' - Ng. '.date('d-m-Y H.i') . '.zip';
        $this->zip->download($zipName);

        echo json_encode(['status' => 'success']); die;
    }


    public function delete()
    {
        $img_id = $this->input->post('img_id');
        $controller_name = $this->input->post('controller_name');
        $image_name = $this->input->post('img_name');
        if ($controller_name == 'Contract') {
            $this->ghImage->delete($img_id);
            unlink('./media/contract/' . $image_name);
        }
    }
}

?>