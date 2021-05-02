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
        $this->load->model('ghPublicCustomerFeedback');
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


    public function create(){
        $post = $this->input->post();

        $block_answer = [
            "customer" => [
                "name" => $post['name'],
                "email" => $post['email'],
                "phone" => $post['phone'],
            ],
            "feedback" => [
                'suit' => [
                    "question" => "Anh/chị cảm thấy trang phục của nhân viên Sinvahome như thế nào? *",
                    "answer" => $post['suit']
                ],
                'attitude' => [
                    "question" => "Anh/chị cảm thấy thái độ tiếp đón của nhân viên Sinvahome như thế nào?",
                    "answer" => $post['attitude']
                ],
                'problem_solving' => [
                    "question" => "Tinh thần giải quyết vấn đề cho anh/chị của nhân viên Sinvahome như thế nào? *",
                    "answer" => $post['problem_solving']
                ],
                'solution' => [
                    "question" => "Anh/chị cảm thấy thế nào về cách nhân viên Sinvahome giải quyết vấn đề cho anh/chị? *",
                    "answer" => $post['solution']
                ],
                'feel_to_be_supported' => [
                    "question" => "Anh/chị cảm thấy thế nào khi được nhân viên Sinvahome hỗ trợ? *",
                    "answer" => $post['feel_to_be_supported']
                ],
                'understanding_score' => [
                    "question" => "Nhân viên Sinvahome hiểu nhu cầu của anh/chị ở mức độ nào? (chấm theo thang điểm 10) *",
                    "answer" => $post['understanding_score']
                ],
                'room_score' => [
                    "question" => "Anh/chị đánh giá căn phòng này được bao nhiêu điểm?(chấm theo thang điểm 10) *",
                    "answer" => $post['room_score']
                ],
                'room_requirement' => [
                    "question" => "Theo Anh/chị, căn phòng này cần có thêm yếu tố gì để hoàn hảo? *",
                    "answer" => $post['room_requirement']
                ],
                'consultant_requirement' => [
                    "question" => "Anh/chị kì vọng thêm điều gì về nhân viên của Sinvahome?",
                    "answer" => $post['consultant_requirement']
                ],
                'additional_feedback' => [
                    "question" => "Anh/chị có đánh giá gì thêm không?",
                    "answer" => $post['additional_feedback']
                ],
            ],
        ];
        $data_insert = [
            "answer" => json_encode($block_answer),
            "user_id" => $post['user_id'],
            "time_create" => time()
        ];

        $this->ghPublicCustomerFeedback->insert($data_insert);
        $this->session->set_flashdata('fast_notify', [
            'message' => 'Tạo <strong>'.$data['name'].'<strong> thành công ',
            'status' => 'success'
        ]);
        return redirect('/public/customer-feedback/show?account-id='.$post['user_id']);
    }

}

/* End of file BaseRoomType.php */
/* Location: ./application/controllers/role-manager/BaseRoomType.php */