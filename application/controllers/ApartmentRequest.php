<?php

use PhpOffice\PhpSpreadsheet\IOFactory;

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
    public function exportApartmentExcel(){

        $apm_id = $this->input->get('id');
        $template_file = 'media/template-export/REPORT-SINVAHOME-BUILDING-INFO.xlsx';

        $spreadsheet = IOFactory::load($template_file);
        $sheet = $spreadsheet->getActiveSheet();

        $apm = $this->ghApartment->getFirstById($apm_id);

        // Quận
        $sheet->setCellValue('B3', $this->libDistrict->getNameByCode($apm['district_code']));


        // Địa chỉ
        $address = $apm['address_street'] . ', phường '.$apm['address_ward'];
        $sheet->setCellValue('B4', $address);

        // THời gian xuất file
        $time = date('Y-m-d | h : i');
        $sheet->setCellValue('B5', $time);

        $list_room = $this->ghRoom->get(['active' => 'YES', 'apartment_id' => $apm_id]);
        $total_room = count($list_room);
        $sheet->setCellValue('A7', $total_room);

        $list_room_avai = $this->ghRoom->get(['active' => 'YES', 'apartment_id' => $apm_id, 'status' => 'Available']);
        $total_room_available = count($list_room_avai);
        $sheet->setCellValue('B7', $total_room_available);

        $ii = 12;
        foreach ($list_room as $room) {
            $sheet->setCellValue('A'.$ii, $room['code']);
            $sheet->setCellValue('B'.$ii, $room['price']);
            $list_type_id = json_decode($room['room_type_id'], true);
            $type_arr = [];
            $text_type_name = "";
            if($list_type_id) {
                $js_list_type = implode(",", $list_type_id);
                if ($list_type_id && count($list_type_id) > 0) {
                    foreach ($list_type_id as $type_id) {
                        $typeModel = $this->ghBaseRoomType->getFirstById($type_id);
                        $type_arr[]= $typeModel['name'];
                    }
                }
            }
            $text_type_name = implode(", ",$type_arr );

            $sheet->setCellValue('C'.$ii, $text_type_name);
            $status = 'Full';
            if($room['status'] == 'Available'){
                $status= 'Trống';
                $sheet->getStyle('D'.$ii)
                    ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('8aff8e');
            }
            $sheet->setCellValue('D'.$ii, $status);

            $ii++;
        }



        $sheet->getStyle('A1:F888')
            ->getAlignment()->setWrapText(true);
        $file_name = date('Y-m-d') . ' - Q.'.$this->libDistrict->getNameByCode($apm['district_code']).' - '. $address;
        $file_name .= '.xlsx';



        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$file_name.'"');
        header('Cache-Control: max-age=0');
        ob_end_clean();
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        return $writer->save('php://output');
        die;

    }
}