<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customer_admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
//        $this->load->model('Customer_model');
        $this->load->database();
        $this->load->model('Customer_model');
    }

//
    function index() {
//        $data['result'] = $result;
//         $result = $this->Customer_model->display_customers($customer_id);

        $query = $this->db->query("SELECT customer_header_all.customer_id,customer_header_all.created_on,customer_header_all.customer_contact_number,customer_header_all.customer_name,customer_header_all.customer_email_id,insert_header_all.insert_id"
                . " FROM insert_header_all INNER JOIN customer_header_all ON customer_header_all.customer_id=insert_header_all.customer_id");
        if ($query->num_rows() > 0) {
            $record = $query->result();
            $data['result'] = $record;
        } else {
            $data['result'] = "";
        }
        $this->load->view('admin/Customer_details', $data);
    }

    function add_customer() {
//       
        $this->load->view('admin/add_customer');
    }

}

?>