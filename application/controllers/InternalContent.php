<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InternalContent extends CustomBaseStep {
    private $access_control;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ghInternalContent');
        $this->load->library('LibText', null, 'libText');
    }

    public function pageIncomeRule(){
        $data['content'] = $this->ghInternalContent->getFirstByContentKey('page_income_rule');

        /*--- Load View ---*/
        $this->load->view('components/header');
        $this->load->view('internal-content/page-income-rule', $data);
        $this->load->view('components/footer');
    }

    public function show(){
        $data['list_content'] = $this->ghInternalContent->get();

        $data['libText'] = $this->libText;


        if($this->session->has_userdata('fast_notify')) {
            $data['flash_mess'] = $this->session->flashdata('fast_notify')['message'];
            $data['flash_status'] = $this->session->flashdata('fast_notify')['status'];
            unset($_SESSION['fast_notify']);
        }

        /*--- Load View ---*/
        $this->load->view('components/header');
        $this->load->view('internal-content/show', $data);
        $this->load->view('components/footer');
    }

    public function create() {

        $data = $this->input->post();
        if(!empty($data['content_key'])) {
            $finder = $this->ghInternalContent->getFirstByContentKey(trim($data['content_key']));
            if($finder) {
                $this->session->set_flashdata('fast_notify', [
                    'message' => 'Key đã tồn tại! Vui Lòng Chọn Key Khác',
                    'status' => 'danger'
                ]);
                return redirect('admin/list-internal-content');
            }

            $result = $this->ghInternalContent->insert($data);
            $this->session->set_flashdata('fast_notify', [
                'message' => 'Tạo CONTENT ' . $data['content_key'] .' thành công',
                'status' => 'success'
            ]);
            return redirect('admin/list-internal-content');

        }
    }

    public function updateEditable() {
        $district_id = $this->input->post('pk');
        $field_name = $this->input->post('name');
        $field_value = $this->input->post('value');

        if(!empty($district_id) and !empty($field_value)) {
            $data = [
                $field_name => $field_value
            ];

            $old_district = $this->ghInternalContent->getFirstByContentKey(trim($district_id));
            $old_log = json_encode($old_district[0]);

            $result = $this->ghInternalContent->updateByContentKey($district_id, $data);

            $modified_district = $this->ghInternalContent->getFirstByContentKey($district_id);
            $modified_log = json_encode($modified_district);

            $log = [
                'table_name' => 'gh_internal_content',
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