<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customer extends CI_Controller {

    public function __construct() {
        parent::__construct();
//        $this->load->model('Customer_model');
        $this->load->database();
        $this->db2 = $this->load->database('db2', TRUE);
    }

//
    function index() {
//        $data['result'] = $result;
        $this->load->view('customer/customer');
    }

    public function insert_data() {


        $CustomerName = $this->input->post('cname');
        $Address = $this->input->post('caddress');
        $City = $this->input->post('ccity');
        $array = array(
            'CustomerName' => $CustomerName,
            'Address' => $Address,
            'City' => $City
        );


//            $this->load->database('db2', TRUE);
        $res = $this->db->insert('tbl_customer', $array);
        $res = $this->db2->insert('tbl_customer', $array);

        $this->db->query($res);
//             $this->db2->query($res1);
//            echo "Records Saved Successfully";


        if ($res === TRUE) {
            $respose['message'] = "success";
        } else {
            $respose['message'] = "fail";
        }echo json_encode($respose);
    }

}

?>