<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Account_report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Account_model');
        $this->load->library('excel');
        $this->load->model('Customer_model');
        $this->load->model('Cfo_model');
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
//        $query_res = $this->Account_model->get_data_account_admin();
        $session_data = $this->session->userdata('login_session');
        $email = ($session_data['customer_email_id']);
        $get_firm_id = $this->Customer_model->get_firm_id($email);
        if ($get_firm_id != FALSE) {
            $firm_id = $get_firm_id;
        } else {
            $firm_id = "";
        }
        $query_get_data = $this->Cfo_model->get_data_cfo_admin($firm_id);
        if ($query_get_data !== FALSE) {
            $data['account_data'] = $query_get_data;
        } else {
            $data['account_data'] = "";
        }
        $this->load->view('admin/Account', $data);
    }
    
    function index_hq() {//to load the view page data
//        $data['result'] = $result;
//        $query_res = $this->Account_model->get_data_account_admin();
        $session_data = $this->session->userdata('login_session');
        $email = ($session_data['customer_email_id']);
        $get_firm_id = $this->Customer_model->get_firm_id($email);
        if ($get_firm_id != FALSE) {
            $firm_id = $get_firm_id;
        } else {
            $firm_id = "";
        }
        $query_get_data = $this->Cfo_model->get_data_cfo_admin($firm_id);
        if ($query_get_data !== FALSE) {
            $data['account_data'] = $query_get_data;
        } else {
            $data['account_data'] = "";
        }
        $this->load->view('hq_admin/Account', $data);
    }

    public function get_graph() {
        $customer_id = $this->input->post("customer_id");
//        $insert_id = $this->input->post("insert_id");

        $query = $this->db->query("SELECT month,late_fees,due_date,filling_date FROM 3b_offset_summary_all WHERE customer_id='$customer_id'");
        $data = ""; //view observations
        $data1 = ""; //view Table name
        if ($query->num_rows() > 0) {

            $result = $query->result();
            $months = array();
            $data .= ' <h4 style="color:#1d2f66"><b>1. GSTR-3B:</b></h4>';
            $data .= '<table id="" class="table-bordered table-striped" width="700">
                                <thead style="background-color: #516b22;padding:3px;color:white">
                                    <tr style="padding:3px">
                                        <th>No.</th>
                                        <th>Month</th>
                                        <th>Status</th>
                                        <th>Late Fees</th>
                                        <th>Due Date</th>
                                        <th>Filing Date</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>';
            $k = 1;
            foreach ($result as $row) {
                $months = $row->month;
                $late_fees = $row->late_fees;
                $due_date = $row->due_date;
                $filling_date = $row->filling_date;

                $originalDate = $filling_date;
                $filling_date1 = date("d-m-Y", strtotime($originalDate));

                $originalDate1 = $due_date;
                $due_date1 = date("d-m-Y", strtotime($originalDate1));


                $status = '';
                $data .= '<tr>' .
                        '<td>' . $k . '</td>' .
                        '<td>' . $months . '</td>';
                if (strtotime($filling_date1) > strtotime($due_date1)) {
                    $data .= '<td style="background-color:#e31e25; color:#e31e25;">Filed</td>';
//                    $data .= '<td ><button type="button" style="background-color:#e31e25 ;border: none;color: white;padding: 7px 25px 7px 25px;display: inline-block; border-radius:5px;"></button></td>';
                    
                } else {
                    $data .= '<td style="background-color:#84ab32; color:#84ab32;">Filed</td>';
                    //$data .= '<td ><button type="button" style="background-color: #84ab32;border: none;color: white;padding: 7px 25px 7px 25px;display: inline-block; border-radius:5px;"></button></td>';
                }

                $data .= '<td>' . round($late_fees) . '</td>' .
                        '<td>' . round($due_date1) . '</td>' .
                        '<td>' . $filling_date1 . '</td>' .
                        '</tr>';
                $k++;
            }


            $respose['data'] = $data;
            $respose['data1'] = $data1;
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

        $query = $this->db->query("SELECT period,status,filling_date,acknowledge_no FROM return_filled_gstr1_summary WHERE customer_id='$customer_id' ");
        $data = ""; //view observations
        $data1 = ""; //view observations
        if ($query->num_rows() > 0) {

            $result = $query->result();
            $period = array();
            $data1 .= '<br><br><h4 style="color:#1d2f66"><b>2. GSTR-1:</b></h4>';
            $data .= '<table id="example2" class="table-bordered table-striped" width="700">
                                <thead style="background-color: #516b22 ;color:white">
                                    <tr>
                                        <th>No.</th>
                                        <th>Period</th>
                                        <th>Status</th>
                                        <th>Filing Date</th>
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
                $data .= '<tr>' .
                        '<td>' . $k . '</td>' .
                        '<td>' . $period . '</td>';
                if ($status == 'Filed') {
                    $data .= '<td style="background-color:#e31e25; color:#e31e25;">Filed</td>';
                } else {
                    $data .= '<td style="background-color:#84ab32; color:#84ab32;">Filed</td>';
                }
                $data .= '<td>' . $filling_date . '</td>' .
                        '<td>' . $acknowledge_no . '</td>' .
                        '</tr>';
                $k++;
            }

            $respose['data'] = $data;
            $respose['data1'] = $data1;
            $respose['message'] = "success";
        } else {
            $respose['data'] = "";
            $respose['message'] = "fail";
        }
        echo json_encode($respose);
    }

    public function test() {
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

    
     public function hq_view_customer($firm_id = '') {

       $session_data = $this->session->userdata('login_session');
        $email = ($session_data['customer_email_id']);
        $query_get_data = $this->Cfo_model->get_data_cfo_admin($firm_id);
        if ($query_get_data !== FALSE) {
            $data['account_data'] = $query_get_data;
        } else {
            $data['account_data'] = "";
        }
        $this->load->view('hq_admin/Account', $data);
      
     }
}

?>