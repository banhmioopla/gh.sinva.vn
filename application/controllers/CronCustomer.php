<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CronCustomer extends CustomBaseStep {
	private $access_control;
	public function __construct()
	{
		parent::__construct();
		
	}
	public function index()
	{
        require_once APPPATH."/libraries/SimpleXlsx.php";
        $this->load->model('ghCustomer');
        if ( $xlsx = SimpleXLSX::parse('./documents/DSKH-SINVA-2020.xlsx') ) {
            // echo "<pre>"; print_r( $xlsx->rows() );
            $data = [];
            foreach($xlsx->rows() as $index => $row) {
                if($index == 0) continue;
                $data['name'] = $row[1];
                $data['birthdate'] = $row[2] ? strtotime($row[2]):0;
                $data['gender'] = empty($row[3]) ? (($row[3] == 'Nam')? 'male':'female'):null;
                $data['phone'] = trim($row[5]);
                $data['email'] = trim($row[8]);
                $data['note'] = trim($row[17]);
                $data['status'] = 'sinva-rented';
                $this->ghCustomer->insert($data);
                // echo "<pre>"; print_r($data);
            }
           
        } else {
            echo SimpleXLSX::parseError();
        }
    }


}

/* End of file Apartment.php */
/* Location: ./application/controllers/role-manager/Apartment.php */