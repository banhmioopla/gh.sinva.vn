<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApartmentPromotion extends CustomBaseStep {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ghUser');
        $this->load->model('ghRole');
        $this->load->model('ghUserIncomeDetail');
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
        $data['list_promotion'] = $this->ghApartmentPromotion->get(['apartment_id' =>$apartment_id]);
        /*--- Load View ---*/
        $this->load->view('components/header');
        $this->load->view('apartment-promotion/show', $data);
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
        ];
        $result = $this->ghApartmentPromotion->insert($data);
        $this->session->set_flashdata('fast_notify', [
            'message' => 'Tạo Chương Trình : <strong>'.$post['title'].'<strong> thành công ',
            'status' => 'success'
        ]);
        return redirect('admin/list-apartment-promotion?apartment-id='.$post['apartment_id']);
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
        $user_id = $this->input->post('user_id');

        if(!empty($user_id)) {
            $old_user = $this->ghUser->getById($user_id);
            $log = [
                'table_name' => 'gh_user',
                'old_content' => null,
                'modified_content' => json_encode($old_user[0]),
                'time_insert' => time(),
                'action' => 'delete'
            ];

            // call model
            $tracker = $this->ghActivityTrack->insert($log);
            $result = $this->ghUser->delete($user_id);

            if($result > 0) {
                echo json_encode(['status' => true]); die;
            }
            echo json_encode(['status' => false]); die;
        }
        echo json_encode(['status' => false]); die;
    }
}

/* End of file role.php */
/* Location: ./application/controllers/role-manager/role.php */