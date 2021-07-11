<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ShAgencyGroupApartment extends CI_Controller {
    private $access_control;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('shareUser');
        $this->load->model('ghApartment');
        $this->load->model('ghDistrict');
        $this->load->model('shareAgencyGroup');
        $this->load->model('shareGroupApartment');
        $this->load->library('encryption');
        $this->load->library('LibDistrict', null, 'libDistrict');
    }

    public function show(){
        $group_uuid = $this->input->get('group-id');


        if(isset($_POST['submit'])){
            $post_data = $this->input->post();
            $this->shareGroupApartment->deleteByGroup($group_uuid);
            foreach ($post_data['apartment_id'] as $apm_id){
                $this->shareGroupApartment->insert([
                    'group_uuid' => $group_uuid,
                    'apartment_id' => $apm_id,
                    'is_active' => 'YES'
                ]);
            }

            $this->session->set_flashdata('fast_notify', [
                'message' => 'Cập nhật Share dự án thành công',
                'status' => 'success'
            ]);
        }


        $list = $this->shareGroupApartment->get(['group_uuid' => $group_uuid]);

        $arr_apm_shared_id = [];
        foreach ($list as $apm_shared){
            $arr_apm_shared_id[] = $apm_shared['apartment_id'];
        }

        $list_apartment = $this->ghApartment->get(['active' => 'YES'], 'length(district_code), district_code, address_street');
        $list_district = $this->ghDistrict->get();




        $this->load->view('components/share-header');
        $this->load->view('sh-agency-group-apartment/show', [
            'list' => $list,
            'arr_apm_shared_id' => $arr_apm_shared_id,
            'list_apartment' => $list_apartment,
            'list_district' => $list_district,
            'libDistrict' => $this->libDistrict,
            'shareAgencyGroup' => $this->shareAgencyGroup,
            'group' => $this->shareAgencyGroup->getFirstByUuid($group_uuid)
        ]);
        $this->load->view('components/footer');
    }


    public function create() {

        $post = $this->input->post();
        $data['group_uuid'] = $post['group_uuid'];
        $data['apartment_id'] = $post['apartment_id'];
        $data['is_active'] = "YES";
        $result = $this->shareGroupApartment->insert($data);

        $this->session->set_flashdata('fast_notify', [
            'message' => 'Chia sẻ Dự Án thành công ',
            'status' => 'success'
        ]);
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