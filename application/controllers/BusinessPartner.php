<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BusinessPartner extends CustomBaseStep {
    private $access_control;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ghBusinessPartner');
        $this->load->model('ghApartment');
        $this->load->model('ghPartner');
        $this->load->model('ghMergeBusinessApartment');

    }

    public function show(){
        $this->load->model('ghBusinessPartner'); // load model ghUser
        $data['list_businesspartner'] = $this->ghBusinessPartner->get();
        $data['ghMergeBusinessApartment'] = $this->ghMergeBusinessApartment;
        $data['ghApartment'] = $this->ghApartment;
        /*--- Load View ---*/
        $this->load->view('components/header',['menu' =>$this->menu]);
        $this->load->view('businesspartner/show', $data);
        $this->load->view('components/footer');
    }

    public function showDetail(){
        $id = $this->input->get('id');
        $partner = $this->ghBusinessPartner->getById($id)[0];
        $list_business_apartment = $this->ghMergeBusinessApartment->getByBusinessId($id);
        $list_apartment = [];
        if(count($list_business_apartment) > 0) {
            foreach ($list_business_apartment as $item) {
                $apartment = $this->ghApartment->getById($item['apartment_id']);
                if(count($apartment) > 0) {
                    $list_apartment[] = $apartment[0];
                }
            }
        }

        $this->load->view('components/header');
        $this->load->view('businesspartner/show-detail',
            [
                'partner' => $partner,
                'ghApartment' => $this->ghApartment,
                'ghPartner' => $this->ghPartner,
                'list_apartment' => $list_apartment
            ]);
        $this->load->view('components/footer');
    }

    public function create() {

        $data = $this->input->post();
        if(empty($data['active'])) {
            $data['active'] = 'NO';
        }

        if(!empty($data['name'])) {
            $this->ghBusinessPartner->insert($data);
            $this->session->set_flashdata('fast_notify', [
                'message' => 'thêm đối tác: '.$data['name'].' thành công ',
                'status' => 'success'
            ]);
            return redirect('admin/list-business-partner');
        }
    }

    public function createMergeApartment(){
        $post = $this->input->post();
        $business = $this->ghMergeBusinessApartment->get([
            'business_id' => $post['business_id'],
            'apartment_id' => $post['apartment_id'],
        ]);
        if(count($business) == 0) {
            $this->ghMergeBusinessApartment->insert($post);
        }

        return redirect('/admin/business-partner/detail?id='.$post['business_id']);
    }

    // Ajax
    public function update() {
        $id = $this->input->post('district_id');
        $field_value = $this->input->post('field_value');
        $field_name = $this->input->post('field_name');
        if(!empty($id) and !empty($field_value)) {
            $data = [
                $field_name => $field_value
            ];
            $result = $this->ghBusinessPartner->updateById($id, $data);
            echo json_encode(['status' => $result]); die;
        }
        echo json_encode(['status' => false]); die;
    }

    public function updateEditable() {
        $id = $this->input->post('pk');
        $field_name = $this->input->post('name');
        $field_value = $this->input->post('value');

        if(!empty($id) and !empty($field_name)) {
            $data = [
                $field_name => $field_value
            ];

            $old_district = $this->ghBusinessPartner->getById($id);
            $old_log = json_encode($old_district[0]);

            $result = $this->ghBusinessPartner->updateById($id, $data);

            $modified_district = $this->ghBusinessPartner->getById($id);
            $modified_log = json_encode($modified_district[0]);

            $log = [
                'table_name' => 'gh_business_partner',
                'old_content' => $old_log,
                'modified_content' => $modified_log,
                'time_insert' => time(),
                'action' => 'update'
            ];
            $this->ghActivityTrack->insert($log);

            echo json_encode(['status' => $result]); die;
        }
        echo json_encode(['status' => false]); die;
    }

    public function searchApartment(){
        $q = $this->input->get('q');
        $data = [['id' => 0, 'text' => 'Tìm dự án']];
        if(empty($q)) {
            $customer = $this->ghApartment->get(['active' => 'YES']);
            if($customer) {
                foreach($customer as $c){
                    $data[] = ['id' => $c['id'], 'text' => 'Quận '.$c['district_code']
                        .' | '.
                        $c['address_street']];
                }
            }

        } else {
            $customer = $this->ghApartment->getLike(['address_street' => $q]);
            if($customer) {
                foreach($customer as $c){
                    $data[] = ['id' => $c['id'], 'text' => 'Quận '.$c['district_code']
                        .' | '.
                        $c['address_street']];
                }
            }

        }
        echo json_encode($data);
    }

    public function delete(){
        $id = $this->input->post('id');
        if(!empty($id)) {
            $old_district = $this->ghBusinessPartner->getById($id);

            $log = [
                'table_name' => 'gh_business_partner',
                'old_content' => null,
                'modified_content' => json_encode($old_district[0]),
                'time_insert' => time(),
                'action' => 'delete'
            ];

            // call model
            $tracker = $this->ghActivityTrack->insert($log);
            $result = $this->ghBusinessPartner->delete($id);
            $this->ghMergeBusinessApartment->deleteByBusinessId($id);

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