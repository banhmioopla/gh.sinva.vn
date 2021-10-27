<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use chriskacerguis\RestServer\RestController;
class Apartment extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        $this->load->model('ghApartment');

        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, OPTIONS");
    }

    public function apartment_get()
    {
        // Users from a data store e.g. database
        $list_apm = $this->ghApartment->get(['active' => 'YES', 'id >' => 305]);
        return $this->response( $list_apm, 200 );
    }

    public function apartmentById_get() {
        $users = [
            ['id' => 0, 'name' => 'John', 'email' => 'john@example.com'],
            ['id' => 1, 'name' => 'Jim', 'email' => 'jim@example.com'],
        ];
        $this->response( $users, 200 );
    }


}

/* End of file apartment.php */
/* Location: ./application/controllers/role-manager/apartment.php */