<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    public function index($customer_id = '', $insert_id = '') {
//       $query_get_customer_name=fdjk;
        
        $data['customer_id'] = $customer_id;
        $data['insert_id'] = $insert_id;
        $this->load->view('admin/Generate_report', $data);
    }

//     public function edit_customer() {
//     $customer_id = $this->input->post('customer_id');
//     $data = array(
////            'customer_id' => $customer_id,
//            'customer_id' => $customer_id,
//        );
//     
//     }
}

?>