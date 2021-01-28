<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include 'simple_html_dom.php';
class Crawler extends CustomBaseStep {
    public function __construct()
    {
        parent::__construct();
    }

    public function show(){
        $url = 'https://nha.chotot.com/tp-ho-chi-minh/quan-7/thue-nha-dat';
        // Create DOM from URL or file
        $html = file_get_html($url);

// Find all images
        $data = [];
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
                'title' => $title,
                'price' => $price,
                'bottom' =>$last_time
            ];
        }

        echo "<pre>";
        var_dump($data);
        die;



    }


}

/* End of file Apartment.php */
/* Location: ./application/controllers/role-manager/Apartment.php */