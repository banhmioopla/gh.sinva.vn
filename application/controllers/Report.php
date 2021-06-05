<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CustomBaseStep {

	public function ApartmentUpdating(){
        $this->load->library('LibApartment', null, 'libApartment');
        $this->load->model('ghImage');
	    $list_apartment = $this->ghApartment->get(['active' => 'YES']);
	    $update_rate = [];
	    $update_rate_district = [];
	    $update_rate_imgs = [];
	    foreach ($list_apartment as $apm) {
            $update_rate[$apm['id']] = $this->libApartment->completeInfoRate($apm['id'])['rate']/100;

            if(!isset($update_rate_district[$apm['district_code']])) {
                $update_rate_district[$apm['district_code']] = $update_rate[$apm['id']];
            } else {
                $update_rate_district[$apm['district_code']] += $update_rate[$apm['id']];
            }
            $list_room = $this->ghRoom->get(['apartment_id' => $apm['id'] , 'active' => 'YES']);
            $img_ok = 0;
            foreach ($list_room as $room) {
                $list_img = $this->ghImage->get(['active' => 'YES' , 'room_id' => $room['id']]);
                if(count($list_img) >= 6) {
                    $img_ok++;
                }
            }
            $update_rate_imgs[$apm['id']] = count($list_room) > 0 ? $img_ok / count($list_room) : 0;
        }

        $this->load->view('components/header');
        $this->load->view('report/apartment-updating', [
            'update_rate' => $update_rate,
            'update_rate_district' => $update_rate_district,
            'list_apartment' => $list_apartment,
            'update_rate_imgs' => $update_rate_imgs,
            'ghApartment' => $this->ghApartment
        ]);
        $this->load->view('components/footer');
    }

}

/* End of file Apartment.php */
/* Location: ./application/controllers/role-manager/Apartment.php */