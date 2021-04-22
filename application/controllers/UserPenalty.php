<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserPenalty extends CustomBaseStep {
    private $access_control;
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['ghUserPenalty', 'ghPenalty']);
        $this->load->library('LibUser', null, 'libUser');
        $this->load->library('LibPenalty', null, 'libPenalty');
        $this->load->library('LibTime', null, 'libTime');
    }

    public function show(){
        $this->load->model('ghUserPenalty'); // load model ghUser

        if(empty($this->input->get('month'))) {
            $from_time = strtotime(date('01-m-Y'));
            $to_time =  strtotime($this->libTime->calDayInMonthThisYear((int)date('m')) . '-'.date('m') . '-2021');
        } else {
            $from_time = strtotime($this->input->get('month'));
            $month = date('m', $from_time);
            $to_time =  strtotime($this->libTime->calDayInMonthThisYear((int)$month) . '-'.$month . '-2021');
        }
        $sql = "(time_insert >= ".$from_time." AND time_insert <= ".$to_time.")";
        $data['list_userpenalty'] = $this->ghUserPenalty->get($sql);
        $data['list_penalty'] = $this->ghPenalty->get();
        $data['libUser'] = $this->libUser;
        $data['libPenalty'] = $this->libPenalty;
        $data['ghPenalty'] = $this->ghPenalty;
        $data['month'] = $from_time;

        /*--- Load View ---*/
        $this->load->view('components/header',['menu' =>$this->menu]);
        $this->load->view('user-penalty/show', $data);
        $this->load->view('components/footer');
    }

    public function create() {

        $data = $this->input->post();
        if($data['time_insert']) {
            $data['time_insert'] = strtotime($data['time_insert']);
        }
        $data['user_create_id'] = $this->auth['account_id'];

        $this->ghUserPenalty->insert($data);
        $this->session->set_flashdata('fast_notify', [
            'message' => 'Tạo Vi Phạm '.$data['name'].' thành công ',
            'status' => 'success'
        ]);
        return redirect('admin/list-userpenalty');
    }

    // Ajax
    public function update() {
        $district_id = $this->input->post('userpenalty_id');
        $field_value = $this->input->post('field_value');
        $field_name = $this->input->post('field_name');
        if(!empty($district_id) and !empty($field_name)) {
            $data = [
                $field_name => $field_value
            ];
            $result = $this->ghUserPenalty->updateById($district_id, $data);
            echo json_encode(['status' => $result]); die;
        }
        echo json_encode(['status' => false]); die;
    }

    public function updateEditable() {
        $district_id = $this->input->post('pk');
        $field_name = $this->input->post('name');
        $field_value = $this->input->post('value');

        if(!empty($district_id) and !empty($field_name)) {
            if($field_name == 'time_insert') {
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

            $old_district = $this->ghUserPenalty->getById($district_id);
            $old_log = json_encode($old_district[0]);

            $result = $this->ghUserPenalty->updateById($district_id, $data);

            $modified_district = $this->ghUserPenalty->getById($district_id);
            $modified_log = json_encode($modified_district[0]);

            $log = [
                'table_name' => 'gh_user_penalty',
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
        $district_id = $this->input->post('district_id');
        if(!empty($district_id)) {
            $old_district = $this->ghUserPenalty->getById($district_id);

            $log = [
                'table_name' => 'gh_user_penalty',
                'old_content' => null,
                'modified_content' => json_encode($old_district[0]),
                'time_insert' => time(),
                'action' => 'delete'
            ];

            // call model
            $tracker = $this->ghActivityTrack->insert($log);
            $result = $this->ghUserPenalty->delete($district_id);

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