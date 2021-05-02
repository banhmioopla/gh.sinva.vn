<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PublicCustomerFeedback extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ghRoom');
        $this->load->model('ghApartment');
        $this->load->model('ghUser');
        $this->load->model('ghImage');
        $this->load->model('ghApartment');
        $this->load->model('ghRoom');
        $this->load->model('ghPublicConsultingPost');
        $this->load->library('LibBaseRoomType', null, 'libBaseRoomType');
        $this->public_dir = 'public-world/';
    }

    public function show(){
        $account_id = $this->input->get('account-id');

        $user = $this->ghUser->getFirstByAccountId($account_id);


        $this->load->view($this->public_dir.'components/header', [
            'title_page' => "Phiếu Đánh Giá KH - {$user['name']} ",
            'post_title' => "Phiếu Đánh Giá KH - {$user['name']}",
        ]);
        $this->load->view($this->public_dir.'customer-feedback/show', [
            'page_title' => "Phiếu Đánh Giá KH - Từ Chuyên Viên: {$user['name']} ",
        ]);
        $this->load->view($this->public_dir.'components/footer');

    }

}

/* End of file BaseRoomType.php */
/* Location: ./application/controllers/role-manager/BaseRoomType.php */