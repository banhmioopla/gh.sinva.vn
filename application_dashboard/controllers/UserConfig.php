<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserConfig extends CustomBaseStep {
    private $access_control;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ghUserConfig');
    }
    // Ajax
    public function update() {
        $account_id = $this->input->post('account_id');
        $keyword = $this->input->post('keyword');
        $value = $this->input->post('value');
        $checker = $this->ghUserConfig->getFirstByKeywordAndUser($keyword, $account_id);
        if($checker){
            $this->ghUserConfig->delete($checker['id']);
        }

        $this->ghUserConfig->insert([
            'user_account_id' => $account_id,
            'keyword' => $keyword,
            'value' => $value
        ]);
        $this->session->set_userdata([$keyword => $value]);
        echo json_encode(['status' => true, 'msg' => 'Cập nhật thành công']); die;
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