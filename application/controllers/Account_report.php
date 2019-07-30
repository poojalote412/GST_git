<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Account_report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Account_model');
        $this->load->library('excel');
    }

    function index_customer() { //to load the view page data
//        $data['result'] = $result;
        $session_data = $this->session->userdata('login_session');
        $customer_id = ($session_data['customer_id']);
        $query_res = $this->Account_model->get_data_account($customer_id);
        if ($query_res !== FALSE) {
            $data['account_data'] = $query_res;
        } else {
            $data['account_data'] = "";
        }
        $this->load->view('customer/Account', $data);
    }

    function index_admin() {//to load the view page data
//        $data['result'] = $result;
       
        $query_res = $this->Account_model->get_data_account_admin();
        if ($query_res !== FALSE) {
            $data['account_data'] = $query_res;
        } else {
            $data['account_data'] = "";
        }
        $this->load->view('admin/Account', $data);
    }

    public function get_graph() {
        $customer_id = $this->input->post("customer_id");
//        $insert_id = $this->input->post("insert_id");

        $query = $this->db->query("SELECT month,late_fees,due_date,filling_date FROM 3b_offset_summary_all WHERE customer_id='$customer_id' order by id desc");
        $data = ""; //view observations
        if ($query->num_rows() > 0) {

            $result = $query->result();
//            $late_fees = array();
//            $due_date = array();
//            $filling_date = array();

            $months = array();
            $data .= '<div class="row">
                    <div class="col-md-12">
                        <div class="">
                         <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Month</th>
                                        <th>Late Fees</th>
                                        <th>Due Date</th>
                                        <th>Filling Date</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>';
            $k = 1;
            foreach ($result as $row) {
                $months = $row->month;
                $late_fees = $row->late_fees;
                $due_date = $row->due_date;
                $filling_date = $row->filling_date;


//                //arrays
//                $late_fees[] = $late_fees;
//                $due_date[] = $due_date;
//                $filling_date[] = $filling_date;
//                $months[] = $row->month;

                $data .= '<tr>' .
                        '<td>' . $k . '</td>' .
                        '<td>' . $months . '</td>' .
                        '<td>' . $late_fees . '</td>' .
                        '<td>' . $due_date . '</td>' .
                        '<td>' . $filling_date . '</td>' .
                        '</tr>';
                $k++;
                '</tbody></table></div></div></div>';
            }


            $respose['data'] = $data;
            $respose['message'] = "success";
        } else {
            $respose['data'] = "";
            $respose['message'] = "fail";
        }
        echo json_encode($respose);
    }
    
    //function for get data of GSTR1 return filled summary
    
    public function get_gstr1_details() {
        $customer_id = $this->input->post("customer_id");
//        $insert_id = $this->input->post("insert_id");

        $query = $this->db->query("SELECT period,status,filling_date,acknowledge_no FROM return_filled_gstr1_summary WHERE customer_id='$customer_id' order by id desc");
        $data = ""; //view observations
        if ($query->num_rows() > 0) {

            $result = $query->result();
            $period = array();
            $data .= '<div class="row">
                    <div class="col-md-12">
                        <div class="">
                         <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Period</th>
                                        <th>Status</th>
                                        <th>Filling Date</th>
                                        <th>Acknowledge No</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>';
            $k = 1;
            foreach ($result as $row) {
                $period = $row->period;
                $status = $row->status;
                $filling_date = $row->filling_date;
                $acknowledge_no = $row->acknowledge_no;


//                //arrays
//                $late_fees[] = $late_fees;
//                $due_date[] = $due_date;
//                $filling_date[] = $filling_date;
//                $months[] = $row->month;

                $data .= '<tr>' .
                        '<td>' . $k . '</td>' .
                        '<td>' . $period . '</td>' .
                        '<td>' . $status . '</td>' .
                        '<td>' . $filling_date . '</td>' .
                        '<td>' . $acknowledge_no . '</td>' .
                        '</tr>';
                $k++;
                '</tbody></table></div></div></div>';
                
            }


            $respose['data'] = $data;
            $respose['message'] = "success";
        } else {
            $respose['data'] = "";
            $respose['message'] = "fail";
        }
        echo json_encode($respose);
    }
    
    public function test(){
        $query = $this->db->query("SELECT * FROM `customer_header_all` where user_type='2'");

        $query = $this->db->query("SELECT customer_header_all.customer_id,customer_header_all.created_on,customer_header_all.customer_contact_number,customer_header_all.customer_name,customer_header_all.customer_email_id,insert_header_all.insert_id"
                . " FROM insert_header_all INNER JOIN customer_header_all ON customer_header_all.customer_id=insert_header_all.customer_id");

        if ($query->num_rows() > 0) {
            $record = $query->result();
            $data['result'] = $record;
        } else {
            $data['result'] = "";
        }
        $this->load->view('customer/Account', $data);
    }
    

    public function import() {
        if (isset($_FILES["file_ex"]["name"])) {
            $path = $_FILES["file_ex"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            $x = "A";

            $data = '';
            $worksheet = $object->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            $i = 1;
            $abc = 0;
            for ($row = 7; $row <= $highestRow; $row++) {
//                $row_next = $row + 1;
//                $row_prev = $row - 1;

                if ($object->getActiveSheet()->getCell('R' . 5)->getValue() !== "Due Date") {

                    $outward = array();
                    for ($l = 7; $l <= 18; $l++) {
                        $val = $object->getActiveSheet()->getCell('R' . $l)->getValue();
//                         $val1 = $object->getActiveSheet()->getCell('S' . $l)->getValue();
                        $outward[] = $val;
                    }
                    $outward1 = array();
                    for ($l = 7; $l <= 18; $l++) {
                        $val = $object->getActiveSheet()->getCell('S' . $l)->getValue();
//                         $val1 = $object->getActiveSheet()->getCell('S' . $l)->getValue();
                        $outward1[] = $val;
                    }
                } else {
                    $data .= "";
                }


                if ($object->getActiveSheet()->getCell('B' . 5)->getValue() == "Filling Date" && $object->getActiveSheet()->getCell('R' . 5)->getValue() == "Month") {
                    $reverse_charge = array();
                    for ($p = 24; $p <= 35; $p++) {
                        $val_a = $object->getActiveSheet()->getCell('R' . $p)->getValue();
                        $val1 = $object->getActiveSheet()->getCell('S' . $l)->getValue();
                        $reverse_charge[] = $val_a + $val1;
                    }
                } else {
                    $data .= "";
                }



//            
            }

            $quer = $this->db->query("insert into 3b_offset_summary (`filling_date`,`due_date`,`late_fees`)"
                    . " values ('$outward[$t]','$outward1[$t]','$reverse_charge[$t]') ");



//           
        }
    }

}

?>