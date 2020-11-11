<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CronCustomer extends CustomBaseStep {
	private $access_control;
	public function __construct()
	{
		parent::__construct();
		
	}
	public function show()
	{
        // require models
        require APPPATH."/libraries/SimpleXLSX.php";
        $this->load->model('ghCustomer');
        $this->load->model('ghApartment');
        $this->load->model('ghRoom');
        $this->load->model('ghContract');
        $file_name = 'DSKH-SINVA-2020.xlsx';
        if ( $xlsx = SimpleXLSX::parse('./documents/'.$file_name) ) {
            // echo "<pre>"; print_r($xlsx->rows()); die;
            echo ' - Sheet Name = '.$xlsx->sheetName(0);
            $customer = [];
            $i  = 0;
            foreach($xlsx->rows() as $index => $row) {
                $i += 1;
                echo " - ii = ".$i. "<br>";
                if($index == 0 or empty($row[1])) {
                    continue;
                }
                // Customer 
                $customer['name'] = $row[1];
                $customer['birthdate'] = $row[2] ? strtotime($row[2]):0;
                $customer['gender'] = !empty($row[3]) ? (($row[3] == 'Nam')? 'male':'female'):null;
                $customer['status'] = 'sinva-rented';
                $customer['phone'] = trim($row[6]);
                $customer['address_street'] = trim($row[5]);
                $customer['email'] = trim($row[8]);
                $customer['note'] = trim($row[18]);
                $customer_id = $this->ghCustomer->insert($customer);
                echo "- customer id = ".$customer_id. "<br>";
                // Contract
                if($customer_id) {
                    $room = $this->ghRoom->get(['id' => $row[4]]);
                    $contract['service_set'] = null;
                    $contract['apartment_id'] = null;
                    if($room) {
                        $room = $room[0];
                        $apartment = $this->ghApartment->get(['id' => $room['apartment_id']]);
                        if($apartment) {
                            $apartment = $apartment[0];
                            $contract['service_set'] = json_encode($apartment);
                            $contract['apartment_id'] = $apartment['id'];
                        }
                    }
                    $contract['room_price'] = $row[10];
                    $contract['consultant_id'] = 0;
                    $contract['room_id'] = $row[4];
                    $contract['status'] = 'Active';
                    $contract['customer_id'] = $customer_id;
                    $contract['time_check_in'] = $row[12] ? strtotime($row[12]):0;
                    $contract['number_of_month'] = (strpos($row[13], 'năm') !== false) ?(int) filter_var($row[13], FILTER_SANITIZE_NUMBER_INT) * 12 :$row[13];
                    $contract['note'] = trim($row[18]);
                    $this->ghContract->insert($contract);
                    
                    // echo "<pre>"; print_r($data);
                }
                
            }
           
        } else {
            echo SimpleXLSX::parseError();
        }
    }

    public function follow() {
        // require models
        require APPPATH."/libraries/SimpleXLSX.php";
        $this->load->model('ghCustomer');
        // $this->load->model('ghApartment');
        // $this->load->model('ghRoom');
        $file_name = 'DSKH-SINVA-2020-follow.xlsx';
        if ( $xlsx = SimpleXLSX::parse('./documents/'.$file_name) ) {
            echo ' - Sheet Name = '.$xlsx->sheetName(0);
            // echo "<pre>"; print_r($xlsx->rows());
            // die;
            $customer = [];
            foreach($xlsx->rows() as $index => $row) {
                if($index == 0 or empty($row[2])) {
                    continue;
                }
                // Customer 
                $customer['name'] = $row[2];
                $customer['birthdate'] = $row[4] ? strtotime($row[4]):0;
                $customer['gender'] = !empty($row[3]) ? (($row[3] == 'Nam')? 'male':'female'):null;
                $customer['status'] = 'sinva-info-form';
                $customer['phone'] = trim($row[5]);
                $customer['address_street'] = trim($row[7]);
                $customer['email'] = trim($row[9]);
                $customer['note'] =($row[0] ? 'TG: '.$row[0] : '').' '.trim($row[10]);
                $customer_id = $this->ghCustomer->insert($customer);
            }
           
        } else {
            echo SimpleXLSX::parseError();
        }
    }


    public function incomeV1(){
        require APPPATH."/libraries/SimpleXLSX.php";
        $this->load->model('ghIncomeContract');
        // $this->load->model('ghApartment');
        // $this->load->model('ghRoom');
        $file_name = 'contract-rate.xlsx';
        if ( $xlsx = SimpleXLSX::parse('./documents/'.$file_name) ) {
            echo ' - Sheet Name = '.$xlsx->sheetName(0);
            $customer = [];
            foreach($xlsx->rows() as $index => $row) {
                if($index < 6 or empty($row[1])) {
                    continue;
                }
                // Customer
                $customer['number_of_month'] = 1;
                $customer['income_unit'] = filter_var($row[0],
                    FILTER_SANITIZE_NUMBER_INT) * 1000;
                $customer['income_final'] = filter_var($row[1],
                        FILTER_SANITIZE_NUMBER_INT) * 1000;
                $customer['active'] = 'YES';
                $customer['role_code'] = 'consultant';

                $customer['role_code'] = 'collaborators';
                $this->ghIncomeContract->insert($customer);
            }

        } else {
            echo SimpleXLSX::parseError();
        }
    }
}

/* End of file Apartment.php */
/* Location: ./application/controllers/role-manager/Apartment.php */