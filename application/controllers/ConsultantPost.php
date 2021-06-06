<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ConsultantPost extends CustomBaseStep {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ghPublicConsultingPost');
        $this->load->model('ghRoom');
        $this->load->model('ghApartment');
    }

    public function showYour(){
        $list_post = $this->ghPublicConsultingPost->get(['user_create_id' => $this->auth['account_id']]);
        $this->load->view('components/header');
        $this->load->view('consultant-post/show-your', [
            'list_post' => $list_post,
            'ghRoom' => $this->ghRoom,
            'ghApartment' => $this->ghApartment,
        ]);
        $this->load->view('components/footer');

    }

    public function showDetail(){
        $id = $this->input->get('id');
        $post = $this->ghPublicConsultingPost->getFirstById($id);
        if(!$post) {
            return redirect('/admin/consultant-post/your-list');
        }

        $this->load->view('components/header');
        $this->load->view('contract/show-detail', [
            'post' => $post,
        ]);
        $this->load->view('components/footer');
    }

    // Ajax
    public function update() {
        $contract_id = $this->input->post('contract_id');
        $field_value = $this->input->post('field_value');
        $field_name = $this->input->post('field_name');
        if(!empty($contract_id) and !empty($field_value)) {
            $data = [
                $field_name => $field_value
            ];
            $result = $this->ghContract->updateById($contract_id, $data);
            echo json_encode(['status' => $result]); die;
        }
        echo json_encode(['status' => false]); die;
    }

    public function updateEditable() {
        $contract_id = $this->input->post('pk');
        $field_name = $this->input->post('name');
        $field_value = $this->input->post('value');

        if(!empty($contract_id) and !empty($field_name)) {
            if($field_name == 'time_expire' || $field_name == 'time_check_in' || $field_name == 'time_insert') {
                if(empty($field_value)) {
                    $field_value = null;
                } else {
                    $field_value = str_replace('/', '-', $field_value);
                    $field_value = strtotime((string)$field_value);
                }
            }
            $data = [
                $field_name => $field_value,
                'time_update' => time(),
                'user_update_id' => $this->auth['account_id']
            ];

            $old_contract = $this->ghContract->getById($contract_id);
            $old_log = json_encode($old_contract[0]);

            $result = $this->ghContract->updateById($contract_id, $data);

            $modified_contract = $this->ghContract->getById($contract_id);
            $modified_log = json_encode($modified_contract[0]);

            $log = [
                'table_name' => 'gh_contract',
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
        $contract_id = $this->input->post('contract_id');
        if(!empty($contract_id)) {
            $old_contract = $this->ghContract->getById($contract_id);

            $log = [
                'table_name' => 'gh_contract',
                'old_content' => null,
                'modified_content' => json_encode($old_contract[0]),
                'time_insert' => time(),
                'action' => 'delete'
            ];

            // call model
            $tracker = $this->ghActivityTrack->insert($log);
            $result = $this->ghContract->delete($contract_id);

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