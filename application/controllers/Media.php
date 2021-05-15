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

        $apartment = $this->ghApartment->getFirstById($apartment_id);
        $list_room = $this->ghRoom->get(['active' => 'YES', 'apartment_id' => $apartment_id]);
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
                $chain_room[] = ['value' => $room['id'], 'display' => $room['code'] . ' <span class="badge badge-danger badge-pill mr-1">'.count($img_this_room).'</span> ' . ' <span class="float-right badge '.$is_available.'">'.number_format($room['price']/1000).'</span> '];
            } else {
                $chain_room[] = ['value' => $room['id'], 'display' => $room['code'] . ' <span class="float-right badge '.$is_available.'">'.number_format($room['price']/1000).'</span> '];
            }

        }

        $data['apartment'] = $apartment;
        $data['list_apartment'] = $this->ghApartment->get(['active' => 'YES']);
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

        $list_img = $this->ghImage->get(['room_id' => $room_id, 'active' => 'YES']);
        $result = [];
        foreach ($list_img as $img) {
            $result[] = ['url' => '/media/apartment/'.$img['name'], 'id' => $img['id']];
        }

        echo json_encode($result); die;
    }

    public function uploadImgApartment(){
        $apartment_id = $this->input->get('apartment_id');
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
            $room_id = $this->input->post('room_id');
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
            }
            $this->session->set_flashdata('fast_notify', [
                'message' => 'Upload <strong>'.$filesCount.'</strong> file(s) thành công ',
                'status' => 'success'
            ]);
        }

        $this->load->view('components/header');
        $this->load->view('media/upload-img-apartment', [
            'apartment' => $apartment,
            'list_room' => $list_room,
            'cb_room' => $cb_room
        ]);
        $this->load->view('components/footer');
    }

    public function create() {

        $data = $this->input->post();
        if(empty($data['active'])) {
            $data['active'] = 'NO';
        }

        if(!empty($data['name'])) {
            $result = $this->ghPartner->insert($data);
            $this->session->set_flashdata('fast_notify', [
                'message' => 'Tạo đối tác: <strong>'.$data['name'].'<strong> thành công ',
                'status' => 'success'
            ]);
            return redirect('admin/list-partner');
        }
    }

    // Ajax
    public function update() {
        $partner_id = $this->input->post('partner_id');
        $field_value = $this->input->post('field_value');
        $field_name = $this->input->post('field_name');

        if(!empty($partner_id) and !empty($field_value)) {
            $data = [
                $field_name => $field_value
            ];
            $result = $this->ghPartner->updateById($partner_id, $data);
            echo json_encode(['status' => $result]); die;
        }
        echo json_encode(['status' => false]); die;
    }

    public function updateEditable() {
        $partner_id = $this->input->post('pk');
        $field_name = $this->input->post('name');
        $field_value = $this->input->post('value');

        if(!empty($partner_id) and !empty($field_value)) {
            $data = [
                $field_name => $field_value
            ];

            $old_partner = $this->ghPartner->getById($partner_id);
            $old_log = json_encode($old_partner[0]);

            $result = $this->ghPartner->updateById($partner_id, $data);

            $modified_partner = $this->ghPartner->getById($partner_id);
            $modified_log = json_encode($modified_partner[0]);

            $log = [
                'table_name' => 'gh_partner',
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
        $partner_id = $this->input->post('partner_id');
        if(!empty($partner_id)) {
            $old_partner = $this->ghPartner->getById($partner_id);

            $log = [
                'table_name' => 'gh_partner',
                'old_content' => null,
                'modified_content' => json_encode($old_partner[0]),
                'time_insert' => time(),
                'action' => 'delete'
            ];

            // call model
            $tracker = $this->ghActivityTrack->insert($log);
            $result = $this->ghPartner->delete($partner_id);

            if($result > 0) {
                echo json_encode(['status' => true]); die;
            }
            echo json_encode(['status' => false]); die;
        }
        echo json_encode(['status' => false]); die;
    }

}

/* End of file partner.php */
/* Location: ./application/controllers/role-manager/partner.php */