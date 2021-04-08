<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserDistrict extends CustomBaseStep {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ghUserDistrict');
        $this->load->model('ghDistrict');
        $this->load->model('ghApartment');
        $this->load->library('LibUser', null, 'libUser');
        $this->load->library('LibDistrict', null, 'libDistrict');
    }

    public function show(){
        $current_user = $this->input->get('account-id');
        $list_user_district = $this->ghUserDistrict->get(['user_id' => $current_user]);
        $data['list_district'] = $this->ghDistrict->get(['active' => 'YES']);
        $data['libUser'] = $this->libUser;
        $data['ghApartment'] = $this->ghApartment;

        $list_ud = [];
        $list_apm = [];
        $is_view_only = false;
        foreach ($list_user_district as $item) {
            $list_ud[] = $item['district_code'];
            $list_apm[] = $item['apartment_id'];
            if(!$is_view_only && $item['is_view_only'] === 'YES') {
                $is_view_only = true;
            }
        }
        $data['list_ud'] = $list_ud;
        $data['list_apm'] = $list_apm;
        $data['is_view_only'] = $is_view_only;



        /*--- Load View ---*/
        $this->load->view('components/header', ['menu' => $this->menu]);
        $this->load->view('user-district/show', $data);
        $this->load->view('components/footer');
    }

    public function create() {

        $post = $this->input->post();
        $this->ghUserDistrict->delete(['user_id' => $post['account_id']]);

        $is_view_only = $post['is_view_only'] == "YES" ? "YES":"NO";

        if(count($post['apm'])>0) {
            foreach ($post['apm'] as $apm) {
                $this->ghUserDistrict->insert([
                    'apartment_id' => $apm,
                    'user_id' => $post['account_id'],
                    'is_view_only' => $is_view_only
                ]);
            }
        } else {
            if(count($post['code'])>0) {
                foreach ($post['code'] as $code) {
                    $this->ghUserDistrict->insert([
                        'district_code' => $code,
                        'user_id' => $post['account_id'],
                        'is_view_only' => $is_view_only
                    ]);
                }
            }
        }

        $this->session->set_flashdata('fast_notify', [
            'message' => 'Cập nhật thành công ',
            'status' => 'success'
        ]);

        return redirect('admin/list-user-district?account-id='.$post['account_id']);
    }

}

/* End of file role.php */
/* Location: ./application/controllers/role-manager/role.php */