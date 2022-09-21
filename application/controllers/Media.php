<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media extends CustomBaseStep {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ghMedia');
        $this->load->model('ghImage');
        $this->load->model('ghRoom');
        $this->load->model('ghApartment');
        $this->load->model('ghActivityTrack');
        $this->load->model('ghApartmentShaft');
        $this->load->model('ghPublicConsultingPost');
        $this->load->helper('money');

        $this->route_media_apm = '/';
        $this->route_media_contract = '/';
        $this->load->config('label.apartment');
    }

    public function showImgApartment(){
        $data = [];
        $apartment_id = $this->input->get('apartment-id');
        $room_id = $this->input->post('room_id');

        if (!isset($apartment_id) and empty($apartment_id)) {
            redirect('notfound');
        }

        $list_shaft = $this->ghApartmentShaft->get(['apartment_id' => $apartment_id]);
        $list_room = $this->ghRoom->get(['active' => 'YES', 'apartment_id' => $apartment_id], 'code','ASC');
        $has_shaft = false;
        $any_empty_shaft = false;
        if(count($list_shaft)) {
            $has_shaft = true;
            foreach ($list_room as $rrrr) {
                if(empty($rrrr['shaft_id'])) {
                    $any_empty_shaft = true; break;
                }
            }
        }
        $link_has_shaft = "";

        if($has_shaft) {
            $link_has_shaft = "<a href='/admin/apartment/show-image?apartment-id=".$apartment_id."&hasShaft=false'>Ẩn trục phòng</a>";
        }

        if($this->input->get('hasShaft') == 'false') {
            $has_shaft = false;
            $link_has_shaft = "<a href='/admin/apartment/show-image?apartment-id=".$apartment_id."&hasShaft=true'>Hiện trục phòng</a>";
        }


        $data['has_shaft'] = $has_shaft;
        $data['link_has_shaft'] = $link_has_shaft;
        $data['any_empty_shaft'] = $any_empty_shaft;
        $data['list_shaft'] = $list_shaft;




        $apartment = $this->ghApartment->getFirstById($apartment_id);

        $cb_room = [];
        if($apartment) {
            $list_room = $this->ghRoom->get(['apartment_id' => $apartment_id, 'active' => 'YES']);
            foreach ($list_room as $room) {
                $cb_room[] = ['value' => $room['id'], 'text' => $room['code'] . ' - '. number_format($room['price'])];
            }
        }

        $data['cb_room'] = $cb_room;

        $chain_room = [];
        $counter = 0;
        foreach ($list_room as $room) {
            $img_this_room = $this->ghImage->get(['room_id' => $room['id'], 'active' => 'YES']);
            $counter += count($img_this_room);
            $is_available = 'badge-secondary';
            if($room['status'] === 'Available'){
                $is_available  = 'badge-success';
            }

            if(count($img_this_room)) {
                $chain_room[] = [
                    'shaft' => $room['shaft_id'],
                    'value' => $room['id'],
                    'display' => $room['code'] . ' <span class="badge badge-danger badge-pill mr-1">'.count($img_this_room).'</span> ' . ' <span class="float-right badge '.$is_available.'">'.number_format($room['price']/1000).'</span> '];
            } else {
                $chain_room[] = [
                    'shaft' => $room['shaft_id'],
                    'value' => $room['id'], 'display' => $room['code'] . ' <span class="float-right badge '.$is_available.'">'.number_format($room['price']/1000).'</span> '];
            }

        }

        $data['apartment'] = $apartment;
        $list_apm_ready = [];
        $list_apm_temp = $this->ghApartment->get(['active' => 'YES']);
        foreach ($list_apm_temp as $apm ) {
            if(!in_array($apm['district_code'], $this->list_district_CRUD)) {
                continue;
            }

            $list_apm_ready[] = $apm;
        }

        $data['list_apartment'] = $list_apm_ready;
        $data['list_post'] = $this->ghPublicConsultingPost->get(['user_create_id' => $this->auth['account_id']]);
        $data['chain_room'] = $chain_room;
        $data['counter'] = $counter;
        $data['label_apartment'] =  $this->config->item('label.apartment');
        $data['list_img'] = $this->ghImage->get(['room_id' => $room_id, 'active' => 'YES']);

        /*--- Load View ---*/
        $this->load->view('components/header');
        $this->load->view('media/show-image-apartment', $data);
        $this->load->view('components/footer');
    }

    public function ajaxApartmentShowImage(){
        $room_id = $this->input->post('room_id');

        $list_img = $this->ghImage->get([
            'room_id' => $room_id,
            'controller' => "Apartment",
            'active' => 'YES']);
        $result = [];
        foreach ($list_img as $img) {
            $result[] = ['url' => '/media/apartment/'.$img['name'], 'id' => $img['id']];
        }

        echo json_encode($result); die;
    }

    public function ajaxGalleryShowImage(){
        $room_id = $this->input->post('room_id');
        $root_url = "/media/apartment/";
        $video_tag = '<video width="100%" height="80%" class="border"  controls="controls">
                                    <source src="%URL%" type="video/mp4">
                    </video>';
        $img_tag = '<img class="img-fluid" src="%URL%"
                                 alt="%URL%">';

        $html = "";
        $item_html_start = '<div class="carousel-item">';
        $item_html ='
                <div class="col-md-3 mb-3 col-6" id="img-box-%ID_IMG%">
                    <div class="portfolio-masonry-box mt-0">
                    <a href="%URL%" class="image-popup %CLASS_MEDIA%">
                        <div class="portfolio-masonry-img">
                            %MEDIA_TAG%
                        </div></a>
                        <div class="portfolio-masonry-detail">
                            <button class="btn btn-danger btn-delete-img" data-id="%ID_IMG%">Xoá</button>
                        </div>
                    </div>
                </div>';
        $item_html_vid ='
                <div class="col-md-3 mb-3 col-6" id="img-box-%ID_IMG%">
                    <div class="portfolio-masonry-box mt-0">
                    <a href="%URL%" class="image-popup %CLASS_MEDIA%">
                        <div class="portfolio-masonry-img">
                            <video class="img-fluid" controls><source src="%URL%" type="video/mp4"></video>
                        </div></a>
                        <div class="portfolio-masonry-detail">
                            <button class="btn btn-danger btn-delete-img" data-id="%ID_IMG%">Xoá</button>
                        </div>
                    </div>
                </div>';
        $item_html_end = '</div>';
        $list_img = $this->ghImage->get(['room_id' => $room_id, "controller" => "Apartment", 'active' => 'YES']);
        $result = []; $html = ""; $num = 4; $index = 1;

        foreach ($list_img as $i =>  $img) {
            if(!file_exists(substr($root_url.$img['name'],1))){
                continue;
            }

            $media_tag = $img_tag; $media_class = "app-image";
            if(in_array(strtolower($img['file_type']),['mov', 'mp4'])){
                $media_tag = $video_tag; $media_class = "app-video";
            }
            if($index === 1 || (($index-1)%$num ===0 )) {
                $html .= $item_html_start;
            }
            if($this->isVideo($img) === false){
                $item_img = str_replace("%MEDIA_TAG%", $media_tag, $item_html);
            }else{
                $item_img = str_replace("%MEDIA_TAG%", $media_tag, $item_html_vid);
            }

            $item_img = str_replace("%URL%", $root_url.$img['name'], $item_img);
            $item_img = str_replace("%ID_IMG%", $img['id'], $item_img);
            $item_img = str_replace("%CLASS_MEDIA%", $media_class, $item_img);

            $html .= $item_img;
            if($index % $num === 0 || $i+1 === count($list_img)){
                $html .= $item_html_end;
            }

            $index++;
        }

        echo json_encode([
            'html' => $html
        ]); die;
    }

    public function ajaxGalleryShowImageService(){
        $root_url = "/media/service-apartment/";

        $html = "";
        $item_html_start = '<div class="carousel-item">';
        $item_html ='
                <div class="col-md-3 mb-3 col-6" id="img-box-%ID_IMG%">
                    <div class="portfolio-masonry-box mt-0">
                    <a href="%URL%" class="image-popup">
                        <div class="portfolio-masonry-img">
                            <img class="img-fluid" src="%URL%"
                                 alt="%URL%">
                        </div></a>
                        <div class="portfolio-masonry-detail">
                            <button class="btn btn-danger btn-delete-img" data-id="%ID_IMG%">Xoá</button>
                        </div>
                    </div>
                </div>';

        $item_html_vid ='
                <div class="col-md-3 mb-3 col-6" id="img-box-%ID_IMG%">
                    <div class="portfolio-masonry-box mt-0">
                    <a href="%URL%" class="image-popup mfp-iframe">
                        <div class="portfolio-masonry-img">
                            <video class="img-fluid" controls><source src="%URL%" type="video/mp4"></video>
                        </div></a>
                        <div class="portfolio-masonry-detail">
                            <button class="btn btn-danger btn-delete-img" data-id="%ID_IMG%">Xoá</button>
                        </div>
                    </div>
                </div>';

        $item_html_end = '</div>';
        $list_img = $this->ghImage->get([
            'apartment_id' => $this->input->post('apartment_id'),
            'controller' => 'ServiceApartment',
            'active' => 'YES']);
        $result = []; $html = ""; $num = 4; $index = 1;

        foreach ($list_img as $i =>  $img) {
            if(!file_exists(substr($root_url.$img['name'],1))){
                continue;
            }
            if($index === 1 || (($index-1)%$num ===0 )) {
                $html .= $item_html_start;
            }
            if($this->isVideo($img) === false){
                $item_img = str_replace("%URL%", $root_url.$img['name'], $item_html);
                $item_img = str_replace("%ID_IMG%", $img['id'], $item_img);
            }else{
                $item_img = str_replace("%URL%", $root_url.$img['name'], $item_html_vid);
                $item_img = str_replace("%ID_IMG%", $img['id'], $item_img);
            }

            $html .= $item_img;
            if($index % $num === 0 || $i+1 === count($list_img)){
                $html .= $item_html_end;
            }

            $index++;
        }

        echo json_encode([
            'html' => $html
        ]); die;
    }

    private function isVideo($item){
        if(in_array(strtoupper($item['file_type']), ["MP4", "MOV"])){
            return true;
        }
        return false;
    }

    public function uploadImgService(){
        $apartment_id = $this->input->post('apartment_id');
        $apartment = $this->ghApartment->getFirstById($apartment_id);
        $cb_room = [];
        if(!empty($apartment_id))
        {
            $uploadPath = 'media/service-apartment/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|png|gif|mp4|mov';
            $time = time();
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            $filesCount = count($_FILES['files']['name']);
            $max_id = $this->ghImage->getMaxId()[0]['id'];
            $uploadData = [];
            if (empty($max_id)) {
                $max_id = 1;
            }
            if($filesCount == 0) {
                $this->session->set_flashdata('fast_notify', [
                    'message' => 'Vui Lòng chọn Ảnh',
                    'status' => 'danger'
                ]);
                return redirect('/admin/list-apartment?current_apm_id='.$apartment['id']);
            }

            for ($i = 0; $i < $filesCount; $i++) {

                $ext = strtolower(pathinfo($_FILES['files']['name'][$i], PATHINFO_EXTENSION));
                $file_name = $max_id . '-service-' . $apartment_id . '-' . $time . '.' . $ext;

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
                    $uploadData[$i]['controller'] = 'ServiceApartment';
                    $uploadData[$i]['room_id'] = null;
                    $uploadData[$i]['apartment_id'] = $apartment_id;
                    $uploadData[$i]['user_id'] = $this->auth['account_id'];
                    $uploadData[$i]['status'] = 'Pending';
                    $max_id += 1;
                }
            }

            if (!empty($uploadData)) {
                $this->ghImage->insert($uploadData);
                $this->ghApartment->updateById($apartment_id, [
                    'time_update' => $time
                ]);
            }
            $this->session->set_flashdata('fast_notify', [
                'message' => 'Upload <strong>'.$filesCount.'</strong> file(s) thành công ',
                'status' => 'success'
            ]);

            return redirect('/admin/list-apartment?current_apm_id='.$apartment['id'] , "refresh");

        }

        $list_apm_temp = $this->ghApartment->get(['active' => 'YES']);
        $list_apm = [];
        foreach ($list_apm_temp as $apm ) {
            if(!in_array($apm['district_code'], $this->list_district_CRUD)) {
                continue;
            }

            $list_apm[] = $apm;
        }

        $this->load->view('components/header');
        $this->load->view('media/upload-img-apartment', [
            'apartment' => $apartment,
            'list_room' => $list_room,
            'cb_room' => $cb_room,
            'list_apm' => $list_apm
        ]);
        $this->load->view('components/footer');
    }
    public function uploadImgApartment(){
        $apartment_id = $this->input->post('apartment_id');
        $apartment = $this->ghApartment->getFirstById($apartment_id);
        $cb_room = [];
        if($apartment) {
            $list_room = $this->ghRoom->get(['apartment_id' => $apartment_id, 'active' => 'YES']);
            foreach ($list_room as $room) {
                $cb_room[] = ['value' => $room['id'], 'text' => $room['code'] . ' - '. number_format($room['price'])];
            }
        }

        if(isset($_POST) && count($_POST))
        {
            // File upload configuration
            $uploadPath = 'media/apartment/';
            $config['upload_path'] = $uploadPath;
            $config['allowed_types'] = 'jpg|jpeg|png|gif|mp4|mov';
            $time = time();
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $filesCount = count($_FILES['files']['name']);
            $max_id = $this->ghImage->getMaxId()[0]['id'];

            $uploadData = [];
            if (empty($max_id)) {
                $max_id = 1;
            }
            $list_room_id = $this->input->post('room_id');
            if($filesCount == 0) {
                $this->session->set_flashdata('fast_notify', [
                    'message' => 'Vui Lòng chọn Ảnh',
                    'status' => 'danger'
                ]);
                return redirect('/admin/list-apartment?current_apm_id='.$apartment['id'], "refresh");
            }
            foreach ($list_room_id as $room_id) {
                for ($i = 0; $i < $filesCount; $i++) {

                    $ext = strtolower(pathinfo($_FILES['files']['name'][$i], PATHINFO_EXTENSION));
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
                    $this->ghApartment->updateById($apartment_id, [
                        'time_update' => $time
                    ]);
                }
                $this->session->set_flashdata('fast_notify', [
                    'message' => 'Upload <strong>'.$filesCount.'</strong> file(s) thành công ',
                    'status' => 'success'
                ]);

            }

            return redirect('/admin/list-apartment?current_apm_id='.$apartment_id, "refresh");

        }

        $list_apm_temp = $this->ghApartment->get(['active' => 'YES']);
        $list_apm = [];
        foreach ($list_apm_temp as $apm ) {
            if(!in_array($apm['district_code'], $this->list_district_CRUD)) {
                continue;
            }

            $list_apm[] = $apm;
        }

        $this->load->view('components/header');
        $this->load->view('media/upload-img-apartment', [
            'apartment' => $apartment,
            'list_room' => $list_room,
            'cb_room' => $cb_room,
            'list_apm' => $list_apm
        ]);
        $this->load->view('components/footer');
    }

    public function delete(){
        $id = $this->input->post('id');
        if(!empty($id)) {
            $media_obj = $this->ghImage->getFirstById($id);
            if($media_obj) {
                if($media_obj['controller'] === "Apartment"){
                    $media_path = "media/apartment/".$media_obj['name'];
                }
                if($media_obj['controller'] === "ServiceApartment"){
                    $media_path = "media/service-apartment/".$media_obj['name'];;
                }
                if(file_exists($media_path)){
                    if(unlink($media_path) === true) {
                        $this->ghMedia->delete($id);
                    }
                }
            }
        }
        echo json_encode(['status' => true]); die;
    }

}

/* End of file partner.php */
/* Location: ./application/controllers/role-manager/partner.php */