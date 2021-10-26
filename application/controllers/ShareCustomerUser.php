<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ShareCustomerUser extends CustomBaseStep {
    private $access_control;
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['ghShareCustomerUser', 'ghUser', 'ghCustomer']);
        $this->load->library('LibUser', null, 'libUser');
        $this->load->library('LibCustomer', null, 'libCustomer');
        $this->load->config('label.apartment');
    }

    public function show(){
        $data['list_share'] = [];
        $data['type'] = '';
        if($this->input->get('user') > 0) {
            $data['list_share'] = $this->ghShareCustomerUser->get(['user_id' => $this->input->get('user')]);
            $data['type'] = 'customer';
        }
        if($this->input->get('customer') > 0) {
            $data['list_share'] = $this->ghShareCustomerUser->get(['customer_id' =>
                $this->input->get('customer')]);
            $data['type'] = 'user';
        }

        $data['list_user'] = $this->ghUser->get(['active' => 'YES', 'account_id >=' =>
            171020000]);

        $data['list_customer'] = $this->ghCustomer->get();

        $data['libCustomer'] = $this->libCustomer;
        $data['libUser'] = $this->libUser;

        /*--- Load View ---*/
        $this->load->view('components/header');
        $this->load->view('sharecustomeruser/show', $data);
        $this->load->view('components/footer');
    }

    public function showCreate() {
        $data['list_user'] = $this->ghUser->get(['active' => 'YES', 'account_id >=' =>
            171020000]);

        $data['list_customer'] = $this->ghCustomer->get();
        $data['libCustomer'] = $this->libCustomer;
        $data['libUser'] = $this->libUser;
        $data['label'] =  $this->config->item('label.apartment');

        $this->load->view('components/header');
        $this->load->view('sharecustomeruser/show-create', $data);
        $this->load->view('components/footer');
    }

    public function create() {

        $data = $this->input->post();
        foreach ($data['user'] as $u) {
            foreach ($data['customer'] as $c) {
                $check = $this->ghShareCustomerUser->get(['user_id' => $u, 'customer_id' => $c]);
                if(count($check) == 0) {
                    $this->ghShareCustomerUser->insert([
                        'user_id' => $u,
                        'customer_id' => $c
                    ]);
                }
            }
        }
        return redirect('admin/list-share-customer-user');
    }

    public function delete(){
        $room_id = $this->input->post('id');
        if(!empty($room_id)) {
            $old_room = $this->ghShareCustomerUser->getById($room_id);

            $log = [
                'table_name' => 'gh_share_customer_user',
                'old_content' => null,
                'modified_content' => json_encode($old_room[0]),
                'time_insert' => time(),
                'action' => 'delete',
                'user_id' => $this->auth['account_id']
            ];

            // call model
            $tracker = $this->ghActivityTrack->insert($log);
            $result = $this->ghShareCustomerUser->delete($room_id);

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