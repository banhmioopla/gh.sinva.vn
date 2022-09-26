<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include 'simple_html_dom.php';
class Crawler extends CustomBaseStep {
    public function __construct()
    {
        parent::__construct();
    }

    public function show(){



        $district = [1,2,3,7];
        $page = [1,2,3];

// Find all images
        $data = [];
        $url = 'https://www.nhatot.com/du-an-tp-ho-chi-minh';
        // Create DOM from URL or file https://docs.flarum.org/install/


        $this->load->view('components/header');
        $this->load->view('crawler/show', [
            'chotot' => $data
        ]);
        $this->load->view('components/footer');
    }


}

/* End of file Apartment.php */
/* Location: ./application/controllers/role-manager/Apartment.php */