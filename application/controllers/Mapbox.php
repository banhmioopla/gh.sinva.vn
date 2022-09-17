<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapbox extends CustomBaseStep {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['ghApartment','ghNotification', 'ghDistrict', 'ghTag', 'ghApartmentComment', 'ghConsultantBooking']);
        $this->load->config('label.apartment');
        $this->load->helper('money');
        $this->load->library('LibDistrict', null, 'libDistrict');
        $this->load->library('LibPartner', null, 'libPartner');
        $this->load->library('LibRoom', null, 'libRoom');
        $this->load->library('LibBaseApartmentType', null, 'libBaseApartmentType');
        $this->load->library('LibBaseRoomType', null, 'libBaseRoomType');
        $this->load->library('LibTag', null, 'libTag');
        $this->load->library('LibUser', null, 'libUser');
    }
    public function show(){
        /*--- Load View ---*/

        $list_apm = $this->ghApartment->get(['active' => 'YES']);
        $data['map_data'] = [];
        foreach ($list_apm as $item) {
            if(!$item['map_longitude'] || !$item['map_latitude']) continue;
            $data['map_data'][] = [
                'type' => 'Feature',
                'geometry' => [
                    'type' => 'Point',
                    'coordinates' => [$item['map_latitude'], $item['map_longitude']]
                ],
                'properties' => [
                    'title' => $item['address_street'],
                    'description' => $item['note']
                ]
            ];
        }
        $data['map_data'] = json_encode($data['map_data']);

        $this->load->view('components/header');
        $this->load->view('mapbox/show', $data);
        $this->load->view('components/footer');
    }

    private function callAPI($method, $url, $data = false)
    {
        $curl = curl_init();

        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }
}