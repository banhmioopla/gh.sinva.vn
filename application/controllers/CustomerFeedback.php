<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CustomerFeedback extends CustomBaseStep {
    private $access_control;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ghPublicCustomerFeedback');
        $this->load->library('LibUser', null, 'libUser');
        $this->load->library('LibRoom', null, 'libRoom');
    }

    public function show(){
        $timeFrom = date('01-m-Y');
        $timeTo = date(cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y')).'-m-Y');

        if($this->input->get('timeFrom')) {
            $timeFrom = $this->input->get('timeFrom');
        }

        if($this->input->get('timeTo')) {
            $timeTo = $this->input->get('timeTo');
        }

        $list_feedback = $this->ghPublicCustomerFeedback->get([
            'time_create >= ' => strtotime($timeFrom),
            'time_create <= ' => strtotime($timeTo) + 86399,
        ]);


        /*--- Load View ---*/
        $this->load->view('components/header');
        $this->load->view('customer-feedback/show', [
            'list_feedback' => $list_feedback,
            'timeFrom' => $timeFrom,
            'timeTo' => $timeTo,
            'libUser' => $this->libUser
        ]);
        $this->load->view('components/footer');
    }

    public function showYour(){
        $data['list_feedback'] = $this->ghPublicCustomerFeedback->get(['user_id' => $this->auth['account_id']]);
        $data['libUser'] = $this->libUser;

        /*--- Load View ---*/
        $this->load->view('components/header');
        $this->load->view('customer-feedback/show-your', $data);
        $this->load->view('components/footer');
    }

    public function detail(){
        /*--- Load View ---*/
        $id = $this->input->get('id');
        $feedback = $this->ghPublicCustomerFeedback->getFirstById($id);
        $this->load->view('components/header');
        $this->load->view('customer-feedback/detail', [
            'feedback' => $feedback,
            'libUser' => $this->libUser
        ]);
        $this->load->view('components/footer');
    }

    public function updateEditable() {
        $district_id = $this->input->post('pk');
        $field_name = $this->input->post('name');
        $field_value = $this->input->post('value');

        if(!empty($district_id) and !empty($field_value)) {
            $data = [
                $field_name => $field_value
            ];

            $old_district = $this->ghDistrict->getById($district_id);
            $old_log = json_encode($old_district[0]);

            $result = $this->ghDistrict->updateById($district_id, $data);

            $modified_district = $this->ghDistrict->getById($district_id);
            $modified_log = json_encode($modified_district[0]);

            $log = [
                'table_name' => 'gh_district',
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
            $old_district = $this->ghDistrict->getById($district_id);

            $log = [
                'table_name' => 'gh_district',
                'old_content' => null,
                'modified_content' => json_encode($old_district[0]),
                'time_insert' => time(),
                'action' => 'delete'
            ];

            // call model
            $tracker = $this->ghActivityTrack->insert($log);
            $result = $this->ghDistrict->delete($district_id);

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