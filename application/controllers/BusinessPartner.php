<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BusinessPartner extends CustomBaseStep {
    private $access_control;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ghBusinessPartner');
        $this->load->model('ghApartment');
        $this->load->model('ghApartment');
    }

    public function show(){
        $this->load->model('ghBusinessPartner'); // load model ghUser
        $data['list_businesspartner'] = $this->ghBusinessPartner->get();

        /*--- Load View ---*/
        $this->load->view('components/header',['menu' =>$this->menu]);
        $this->load->view('businesspartner/show', $data);
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

    // Ajax
    public function update() {
        $district_id = $this->input->post('district_id');
        $field_value = $this->input->post('field_value');
        $field_name = $this->input->post('field_name');
        if(!empty($district_id) and !empty($field_value)) {
            $data = [
                $field_name => $field_value
            ];
            $result = $this->ghBusinessPartner->updateById($district_id, $data);
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
        $district_id = $this->input->post('district_id');
        if(!empty($district_id)) {
            $old_district = $this->ghBusinessPartner->getById($district_id);

            $log = [
                'table_name' => 'gh_district',
                'old_content' => null,
                'modified_content' => json_encode($old_district[0]),
                'time_insert' => time(),
                'action' => 'delete'
            ];

            // call model
            $tracker = $this->ghActivityTrack->insert($log);
            $result = $this->ghBusinessPartner->delete($district_id);

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