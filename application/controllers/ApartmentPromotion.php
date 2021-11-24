<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApartmentPromotion extends CustomBaseStep {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ghUser');
        $this->load->model('ghRole');

        $this->load->model('ghApartmentPromotion');
        $this->load->model('ghApartment');
        $this->load->model('ghRoom');
        $this->load->model('ghContract');
        $this->load->library('LibRole', null, 'libRole');
        $this->load->library('LibUser', null, 'libUser');
    }

    public function show(){
        $apartment_id = $this->input->get('apartment-id');

        $data['apartment'] = $this->ghApartment->getFirstById($apartment_id);
        $data['list_promotion'] = $this->ghApartmentPromotion->get(['apartment_id' =>$apartment_id, 'end_time >=' => strtotime(date('d-m-Y'))]);
        /*--- Load View ---*/
        $this->load->view('components/header');
        $this->load->view('apartment-promotion/show', $data);
        $this->load->view('components/footer');
    }

    public function showEdit(){
        $id = $this->input->get('id');

        $data['promotion'] = $this->ghApartmentPromotion->getFirstById($id);
        $data['apartment'] = $this->ghApartment->getFirstById($data['promotion']['apartment_id']);
        if(isset($_POST['submit'])){
            $description = $this->input->post('description');
            $title = $this->input->post('title');
            $test = $this->ghApartmentPromotion->updateById($id, [
                'description' => $description,
                'title' => $title,
            ]);

            $data['promotion'] = $this->ghApartmentPromotion->getFirstById($id);
            $this->session->set_flashdata('fast_notify', [
                'message' => 'Cập Nhật Ưu Đãi Thành Công',
                'status' => 'success'
            ]);
        }

        /*--- Load View ---*/
        $this->load->view('components/header');
        $this->load->view('apartment-promotion/show-edit', $data);
        $this->load->view('components/footer');
    }

    public function create() {

        $post = $this->input->post();
        $data = [
            'title' => $post['title'],
            'description' => $post['description'],
            'start_time' => strlen($post['start_time']) ?  strtotime($post['start_time']) : null,
            'end_time' => strlen($post['end_time']) ?  strtotime($post['end_time']) : null,
            'apartment_id' => $post['apartment_id'],
            'insert_time' => time(),
        ];
        $result = $this->ghApartmentPromotion->insert($data);
        $this->session->set_flashdata('fast_notify', [
            'message' => 'Tạo ưu đãi : <strong>'.$post['title'].'<strong> thành công ',
            'status' => 'success'
        ]);
        return redirect('/admin/profile-apartment?id='.$post['apartment_id'], 'refresh');
    }
    public function updateEditable() {
        $id = $this->input->post('pk');
        $field_name = $this->input->post('name');
        $field_value = $this->input->post('value');

        if(!empty($id) and !empty($field_name)) {

            if($field_name === 'start_time' || $field_name === 'end_time') {
                $field_value = str_replace('/', '-', $field_value);
                $field_value = strtotime((string)$field_value);
            }
            $data = [
                $field_name => $field_value
            ];

            $old_user = $this->ghApartmentPromotion->getFirstById($id);
            $old_log = json_encode($old_user);

            $result = $this->ghApartmentPromotion->updateById($id, $data);

            $modified_user = $this->ghApartmentPromotion->getFirstById($id);
            $modified_log = json_encode($modified_user);

            $log = [
                'table_name' => 'gh_apartment_promotion',
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
        $this->ghApartmentPromotion->delete($this->input->post('id'));
        echo json_encode(['status' => true]); die;
    }
}

/* End of file role.php */
/* Location: ./application/controllers/role-manager/role.php */