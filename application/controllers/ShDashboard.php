<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ShDashboard extends CI_Controller {
    private $access_control;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('shareUser');
        $this->load->model('shareAgencyGroup');
        $this->load->model('shareRole');
        $this->load->model('sharePackage');
        $this->load->model('ghApartment');
        $this->load->library('encryption');
        $this->load->library('LibUuid', null, 'libUuid');
        $this->load->library('LibEmail', null, 'libEmail');
        $this->load->library('LibEncrypt', null, 'libEncrypt');
    }

    public function show(){
        $list = $this->shareUser->get();
        $list_role = $this->shareRole->get();
        $list_pack = $this->sharePackage->get();
        $list_agency_group = $this->shareAgencyGroup->get();
        $this->load->view('components/share-header');
        $this->load->view('sh-dashboard/show', [
            'list' => $list,
            'list_role' => $list_role,
            'list_pack' => $list_pack,
            'list_agency_group' => $list_agency_group,
            'shareAgencyGroup' => $this->shareAgencyGroup,
            'shareRole' => $this->shareRole,
        ]);
        $this->load->view('components/footer');
    }

    public function showGroupDetail() {
        $group_id = $this->input->get('id');

        $group = $this->shareAgencyGroup->getFirstById($group_id);
        $list_user = $this->shareUser->get(['group_uuid' => $group['uuid'] ]);
        $list_apartment = $this->ghApartment->get(['group_uuid' => $group['uuid'] ]);
        $this->load->view('components/share-header');
        $this->load->view('sh-dashboard/show-group-detail', [
            'group' => $group,
            'list_user' => $list_user,
            'list_apartment' => $list_apartment,
        ]);
        $this->load->view('components/footer');
    }


    public function create() {

        $post = $this->input->post();
        $data['status'] = $this->shareUser::STATUS_NEW;
        $data['account_id'] = $post['phone_number'];
        $data['phone_number'] = $post['phone_number'];
        $data['password'] = $post['password'];
        $data['name'] = $post['name'];
        $data['email'] = $post['email'];
        $data['type'] = 'Agent';
        $data['role_id'] = $post['role_id'];
        $data['uuid'] = $this->libUuid->createUuid();
        $data['group_uuid'] = $post['group_uuid'];
        $data['is_active'] = 'YES';
        $data['time_create'] = time();
        $data['time_update'] = time();

        $result = $this->shareUser->insert($data);
        if($result){
            $this->session->set_flashdata('fast_notify', [
                'message' => 'Tạo Share User: '.$post['name'].' thành công ',
                'status' => 'success'
            ]);
            $content = '<h1>TẠO TÀI KHOẢN SHARE THÀNH CÔNG CHO CHỦ NHÂN: '.$post['name'].'</h1>';
            $content .= '<ul> <li>Account ID: <strong>'.$data['account_id'].'</strong> </li> <li>Password: <strong>'.$data['password'].'</strong></li></ul>';
            $content .= '<p>Tài khoản được tạo lúc: '.date('d-m-Y',$data['time_create']).'</p>';

            $this->libEmail->sendEmailFromServer('mynameismrbinh@gmail.com', 'QUỐC BÌNH', 'Tạo Account SHARE', $content);

        }

        return redirect($_SERVER["HTTP_REFERER"]);
    }

    // Ajax
    public function update() {
        $tag_id = $this->input->post('tag_id');
        $field_value = $this->input->post('field_value');
        $field_name = $this->input->post('field_name');

        if(!empty($tag_id) and !empty($field_value)) {
            $data = [
                $field_name => $field_value
            ];
            $result = $this->ghTag->updateById($tag_id, $data);
            echo json_encode(['status' => $result]); die;
        }
        echo json_encode(['status' => false]); die;
    }

    public function updateEditable() {
        $tag_id = $this->input->post('pk');
        $field_name = $this->input->post('name');
        $field_value = $this->input->post('value');

        if(!empty($tag_id) and !empty($field_value)) {
            $data = [
                $field_name => $field_value
            ];

            $old_tag = $this->shareUser->getById($tag_id);
            $old_log = json_encode($old_Tag[0]);

            $result = $this->shareUser->updateById($tag_id, $data);

            $modified_tag = $this->shareUser->getFirstById($tag_id);
            $modified_log = json_encode($modified_tag[0]);

            $log = [
                'table_name' => 'share_user',
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
        $tag_id = $this->input->post('tag_id');
        if(!empty($Tag_id)) {
            $old_tag = $this->ghTag->getById($tag_id);

            $log = [
                'table_name' => 'gh_tag',
                'old_content' => null,
                'modified_content' => json_encode($old_tag[0]),
                'time_insert' => time(),
                'action' => 'delete'
            ];

            // call model
            $tracker = $this->ghActivityTrack->insert($log);
            $result = $this->shareUser->delete($tag_id);

            if($result > 0) {
                echo json_encode(['status' => true]); die;
            }
            echo json_encode(['status' => false]); die;
        }
        echo json_encode(['status' => false]); die;
    }

}