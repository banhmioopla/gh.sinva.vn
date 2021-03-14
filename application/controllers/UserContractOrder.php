<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserContractOrder extends CustomBaseStep {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ghUser');
        $this->load->model('ghUserIncomeDetail');
        $this->load->model('ghUserContractOrder');
        $this->load->library('LibRole', null, 'libRole');
        $this->load->library('LibUser', null, 'libUser');
    }

    public function showCreate(){
        if($this->input->get('uid')){
            $user_id = $this->input->get('uid');
            $last_date = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));

            $income_detail = $this->ghUserIncomeDetail->get([
                'user_id' => $user_id,
                "apply_time >= " => strtotime(date('01-m-Y')),
                "apply_time <=" => strtotime(date($last_date.'-m-Y')) + 86399
            ]);

            $total_income = 0;
            if(count($income_detail)){
                foreach ($income_detail as $income) {
                    $total_income += $income['contract_income_total'];
                }
            }


            $order = $this->ghUserContractOrder->get([
                'user_id' => $user_id,
                "time_create >= " => strtotime(date('01-m-Y')),
                "time_create <=" => strtotime(date($last_date.'-m-Y')) + 86399
            ]);
            $total_order = 0;
            if(count($order)){
                foreach ($order as $item) {
                    $total_order += $item['amount'];
                }
            }

            $remain = $total_income - $total_order;

        }
        $data['libRole'] = $this->libRole;
        $data['libUser'] = $this->libUser;
        $data['total_order'] = $total_order;
        $data['total_income'] = $total_income;
        $data['list_income_detail'] = $income_detail;
        $data['list_order'] = $order;
        $data['remain'] = $remain;
        if(count($this->input->post())) {
            $post_data = $this->input->post();
            $post_data['time_create'] = strtotime($post_data['time_create']);
            $this->load->model('ghUserContractOrder');
            $this->ghUserContractOrder->insert($post_data);
            return redirect('/admin/user-contract-order?uid='.$user_id);
        }

        /*--- Load View ---*/
        $this->load->view('components/header', ['menu' => $this->menu]);
        $this->load->view('usercontractorder/show-create', $data);
        $this->load->view('components/footer');
    }

    public function create() {
        $post = $this->input->post();
        $result = $this->ghUser->insert($data);
        $this->session->set_flashdata('fast_notify', [
            'message' => 'Cập Nhật Order Thành Công!',
            'status' => 'success'
        ]);
        return redirect('');
    }

    public function updateEditable() {
        $user_id = $this->input->post('pk');
        $field_name = $this->input->post('name');
        $field_value = $this->input->post('value');

        if(!empty($user_id) and !empty($field_name)) {
            if($field_name == 'authorised_user_id') {
                if(empty($field_value)) {
                    $field_value = null;
                } else {
                    $field_value = $this->auth['account_id'];
                }
            }

            if($field_name == 'date_of_birth' || $field_name == 'time_joined') {
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
            $old_user = $this->ghUser->getById($user_id);
            $old_log = json_encode($old_user[0]);

            $result = $this->ghUser->updateById($user_id, $data);

            $modified_user = $this->ghUser->getById($user_id);
            $modified_log = json_encode($modified_user[0]);

            $log = [
                'table_name' => 'gh_user',
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

    public function getRole() {
        $list_role = $this->ghRole->getAll();
        $result = [];
        foreach($list_role as $role) {
            $result[] = ["value" => $role['code'], "text" => $role["name"]];
        }
        $pk = $this->input->post('pk');
        if(isset($pk)) {
            return die($this->updateEditable());
        }
        echo json_encode($result); die;
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


    public function getSelectUser(){
        $list = $this->ghUser->get(['account_id >=' => 171020000, 'name <>' => "", "active" => "YES"]);
        $result = [];
        foreach($list as $item) {
            $result[] = ["value" => $item['account_id'], "text" => $item["name"]];
        }
        echo json_encode($result); die;
    }

}

/* End of file role.php */
/* Location: ./application/controllers/role-manager/role.php */