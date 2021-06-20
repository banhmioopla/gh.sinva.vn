<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApartmentRequest extends CustomBaseStep {
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['ghApartment', 'ghDistrict',
            'ghApartmentRequest', 'ghBaseRoomType']);
        $this->load->config('label.apartment');
        $this->load->helper('money');
        $this->load->library('LibDistrict', null, 'libDistrict');
        $this->load->library('LibPartner', null, 'libPartner');
        $this->load->library('LibRoom', null, 'libRoom');
        $this->load->library('LibBaseApartmentType', null, 'libBaseApartmentType');
        $this->load->library('LibBaseRoomType', null, 'libBaseRoomType');
        $this->load->library('LibTag', null, 'libTag');
        $this->load->library('LibUser', null, 'libUser');
        $this->load->library('LibApartment', null, 'libApartment');
        $this->load->library('LibCustomer', null, 'libCustomer');
    }
    public function show(){
        $list_request = $this->ghApartmentRequest->get([
            'status' => 'Pending'
        ]);


        $this->load->view('components/header');
        $this->load->view('apartment-request/show', [
            'list_request' => $list_request,
            'ghApartment' => $this->ghApartment,
            'libDistrict' => $this->libDistrict,
            'libUser' => $this->libUser,
        ]);
        $this->load->view('components/footer');
    }
    public function approveRequest(){}

    public function detail(){
        $id = $this->input->get('id');
        $model = $this->ghApartmentRequest->getFirstById($id);
        $request_data = json_decode($model['request_data']);
        $apartment = $this->ghApartment->getFirstById($model['apartment_id']);

        if(isset($_GET['submit'])) {
            $submit = $this->input->get('submit');
            if($submit == 'YES') {
                $this->ghApartmentRequest->updateById($model['id'],[
                    'status' => 'Success'
                ]);
                $update_data = json_decode($model['request_data'], true);
                $this->ghApartment->updateById($model['apartment_id'], $update_data);
                $this->session->set_flashdata('fast_notify', [
                    'message' => 'Đã UPDATE thông tin DA & duyệt yêu cầu này :> ',
                    'status' => 'success'
                ]);


            }

            if($submit == 'NO') {
                $this->ghApartmentRequest->updateById($model['id'],[
                    'status' => 'Cancel'
                ]);
                $this->session->set_flashdata('fast_notify', [
                    'message' => 'Đã từ chối duyệt yêu cầu này :<',
                    'status' => 'danger'
                ]);
            }
            $model = $this->ghApartmentRequest->getFirstById($id);
        }

        $this->load->view('components/header');
        $this->load->view('apartment-request/detail', [
            'request' => $model,
            'request_data' =>$request_data,
            'apartment' => $apartment,
            'libDistrict' => $this->libDistrict,
            'libUser' => $this->libUser,
            'ghPartner' => $this->ghPartner,
        ]);
        $this->load->view('components/footer');
    }

}