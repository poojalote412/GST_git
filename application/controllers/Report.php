<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    public function index() {
        $insert_id = $this->input->post('insert_id');
        print_r($insert_id);
        $query = $this->db->query("select insert_header_all.insert_id,insert_header_all.year_id,customer_header_all.customer_id,customer_header_all.customer_name,customer_header_all.customer_address from insert_header_all INNER JOIN customer_header_all
on insert_header_all.customer_id= customer_header_all.customer_id where insert_header_all.insert_id = 'insert_1001'");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data1['user_name_data'][] = ['customer_id' => $row->customer_id, 'insert_id' => $row->insert_id, 'customer_name' => $row->customer_name, 'year_id' => $row->year_id];
            }
        } else {
            $data1['user_name_data'] = "";
        }
        $data['user_name'] = $data1['user_name_data'];
//        print_r($data);

        if ($data) {
            $response['message'] = 'success';
            $response['code'] = 200;
            $response['status'] = true;
        } else {

            $response['message'] = 'No data to display';
            $response['code'] = 204;
            $response['status'] = false;
        }

        echo json_encode($response);
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