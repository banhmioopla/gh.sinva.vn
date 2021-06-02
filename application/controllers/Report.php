<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CustomBaseStep {

	public function ApartmentUpdating(){
        $this->load->library('LibApartment', null, 'libApartment');

	    $list_apartment = $this->ghApartment->get(['active' => 'YES']);
	    $update_rate = [];
	    $update_rate_district = [];
	    foreach ($list_apartment as $apm) {
            $update_rate[$apm['id']] = $this->libApartment->completeInfoRate($apm['id'])['rate']/100;

            if(!isset($update_rate_district[$apm['district_code']])) {
                $update_rate_district[$apm['district_code']] = $update_rate[$apm['id']];
            } else {
                $update_rate_district[$apm['district_code']] += $update_rate[$apm['id']];
            }
        }

        $this->load->view('components/header');
        $this->load->view('report/apartment-updating', [
            'update_rate' => $update_rate,
            'update_rate_district' => $update_rate_district,
            'list_apartment' => $list_apartment,
            'ghApartment' => $this->ghApartment
        ]);
        $this->load->view('components/footer');
    }

}

/* End of file Apartment.php */
/* Location: ./application/controllers/role-manager/Apartment.php */