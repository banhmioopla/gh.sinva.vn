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
        foreach ($district as $d) {
            foreach ($page as $p) {
                $url = 'https://nha.chotot.com/tp-ho-chi-minh/quan-'.$d.'/thue-can-ho-chung-cu?page='.$p;
                // Create DOM from URL or file
                $html = file_get_html($url);

                foreach($html->find('.wrapperAdItem___2woJ1') as $element){
                    $title = '';
                    $price = '';
                    $last_time = '';
                    foreach ($element->find('h3') as $x) {
                        $title = $x->plaintext;
                    }

                    foreach ($element->find('.adPriceNormal___puYxd') as $x) {
                        $price =  $x->plaintext;
                    }

                    foreach ($element->find('.text___1ZBGX') as $x) {
                        $last_time =  $x->outertext;
                    }
                    $data[] = [
                        'district' => $d,
                        'page' => $p,
                        'title' => $title,
                        'price' => $price,
                        'bottom' =>$last_time
                    ];

                }
            }
        }


        $this->load->view('components/header');
        $this->load->view('crawler/show', [
            'chotot' => $data
        ]);
        $this->load->view('components/footer');
    }


}

/* End of file Apartment.php */
/* Location: ./application/controllers/role-manager/Apartment.php */