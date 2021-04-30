<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserIncomeDetail extends CustomBaseStep {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ghUser');
        $this->load->model('ghRole');
        $this->load->model('ghUserIncomeDetail');
        $this->load->model('ghApartment');
        $this->load->model('ghRoom');
        $this->load->model('ghContract');
        $this->load->library('LibRole', null, 'libRole');
        $this->load->library('LibUser', null, 'libUser');
    }

    public function show(){
        $data['list'] = $this->ghUserIncomeDetail->get();
        $data['libRole'] = $this->libRole;
        $data['libUser'] = $this->libUser;
        $data['ghContract'] = $this->ghContract;
        $data['ghRoom'] = $this->ghRoom;
        $data['ghApartment'] = $this->ghApartment;

        $contract_qtt = $apartment_qtt = 0;
        foreach ($data['list'] as $item) {
            if($item['type'] == $this->ghUserIncomeDetail::INCOME_TYPE_CONTRACT) {
                $contract_qtt++;
            }

            if($item['type'] == $this->ghUserIncomeDetail::INCOME_TYPE_GET_NEW_APARTMENT) {
                $apartment_qtt++;
            }
        }

        $data['ghUserIncomeDetail'] = $this->ghUserIncomeDetail;

        $data['contract_qtt'] = $contract_qtt;
        $data['apartment_qtt'] = $apartment_qtt;
        /*--- Load View ---*/
        $this->load->view('components/header');
        $this->load->view('user-income-detail/show', $data);
        $this->load->view('components/footer');
    }

    public function create() {

        $post = $this->input->post();
        $data['time_insert'] = $data['time_update'] = time();
        $data['password'] = $data['account_id'] = $post['account_id'];
        $data['role_code'] = 'consultant';
        $data['name'] = $post['name'];
        $data['phone_number'] = $post['phone_number'];

        if($post['date_of_birth']) {
            if(empty($post['date_of_birth'])) {
                $post['date_of_birth'] = null;
            } else {
                $post['date_of_birth'] = str_replace('/', '-', $post['date_of_birth']);
                $post['date_of_birth'] = strtotime((string)$post['date_of_birth']);
            }
        }
        if($post['time_joined']) {
            if(empty($post['time_joined'])) {
                $post['time_joined'] = null;
            } else {
                $post['time_joined'] = str_replace('/', '-', $post['time_joined']);
                $post['time_joined'] = strtotime((string)$post['time_joined']);
            }
        }
        $data['time_joined'] = $post['time_joined'];
        $data['date_of_birth'] = $post['date_of_birth'];
        $data['time_insert'] = time();
        $data['user_refer_id'] = $post['user_refer_id'] > 0 ? $post['user_refer_id']:null;
        $result = $this->ghUser->insert($data);
        $this->session->set_flashdata('fast_notify', [
            'message' => 'Tạo thành viên: <strong>'.$data['account_id'].'<strong> thành công ',
            'status' => 'success'
        ]);
        return redirect('admin/list-user');
    }
    public function updateEditable() {
        $id = $this->input->post('pk');
        $field_name = $this->input->post('name');
        $field_value = $this->input->post('value');

        if(!empty($id) and !empty($field_name)) {

            $data = [
                $field_name => $field_value
            ];
            $old_user = $this->ghUserIncomeDetail->getFirstById($id);
            $old_log = json_encode($old_user);

            $result = $this->ghUserIncomeDetail->updateById($id, $data);

            $modified_user = $this->ghUserIncomeDetail->getFirstById($id);
            $modified_log = json_encode($modified_user);

            $log = [
                'table_name' => 'gh_user_income_detail',
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