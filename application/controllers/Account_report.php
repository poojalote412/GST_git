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
        $insert_id = $this->input->post("insert_id");
        $query_get_observation = $this->db->query("SELECT * from observation_transaction_all where customer_id='$customer_id' AND insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
        $query = $this->db->query("SELECT month,late_fees,due_date,filling_date FROM 3b_offset_summary_all WHERE customer_id='$customer_id'");
        $data = ""; //view observations
        $data1 = ""; //view Table name
        $data2 = "";
        $data_gstr3b_name = "";
        $data_gstr3b_observation = "";
        $data_gstr3b_remarks = "";
        $a = "";
        if ($query->num_rows() > 0) {

            $result = $query->result();
            $result1 = $query_get_observation->row();
            $gstr3b_observation = $result1->duedate_gstr2a_observation;

            $gstr3b_remarks = $result1->duedate_gstr2a_remarks;

            $data_gstr3b_name = "Compliance Report";
            $data_gstr3b_observation = $gstr3b_observation;
//            $data_tax_liability_remarks = $tax_liability_remarks;
            $a = $gstr3b_remarks;
            if ($a == '') {
                $data_gstr3b_remarks = 'not given';
            } else {
                $data_gstr3b_remarks = $gstr3b_remarks;
            }
            if($data_gstr3b_observation=='') {
                $data_gstr3b_name = "";
                $data_gstr3b_remarks = "";
            } else {
//                $data_gstr3b_name = "Compliance Report";
            }
            $months = array();
            $data .= ' <h4 style=""><b>1. GSTR-3B:</b></h4>';
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


                // $status = '';
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
                        '<td>' . $due_date1 . '</td>' .
                        '<td>' . $filling_date1 . '</td>' .
                        '</tr>';
                $k++;
            }


            $respose['data'] = $data;
            $respose['data1'] = $data1;
            $respose['data2'] = $data2;
            $respose['data_gstr3b_name'] = $data_gstr3b_name;
            $respose['data_gstr3b_observation'] = $data_gstr3b_observation;
            $respose['data_gstr3b_remarks'] = $data_gstr3b_remarks;
            $respose['message'] = "success";
        } else {
            $respose['data'] = "";
            $respose['message'] = "fail";
        }
        echo json_encode($respose);
    }

    public function get_graph1() {
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $curr_url = $this->input->post("curr_url");
        $query_get_observation = $this->db->query("SELECT * from observation_transaction_all where customer_id='$customer_id' AND insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
        $query = $this->db->query("SELECT month,late_fees,due_date,filling_date FROM 3b_offset_summary_all WHERE customer_id='$customer_id'");
        $data = ""; //view observations
        $data1 = ""; //view Table name
        $data2 = ""; //view Table name
//        $data_gstr3b_name = "";
//        $data_gstr3b_observation = "";
//        $data_gstr3b_remarks = "";
//        $a = "";
        if ($query->num_rows() > 0) {

            $result = $query->result();
//            $result1 = $query_get_observation->row();
//            $gstr3b_observation = $result1->duedate_gstr2a_observation;
//
//            $gstr3b_remarks = $result1->duedate_gstr2a_remarks;
//
//            $data_gstr3b_name = "Compliance Report";
//            $data_gstr3b_observation = $gstr3b_observation;
////            $data_tax_liability_remarks = $tax_liability_remarks;
//            $a = $gstr3b_remarks;
//            if ($a == '') {
//                $data_gstr3b_remarks = 'not given';
//            } else {
//                $data_gstr3b_remarks = $gstr3b_remarks;
//            }

            $months = array();
            $data .= ' <h4 style="color:#1d2f66"><b>1. GSTR-3B:</b></h4>';
            $data .= '<table id="" class="table-bordered table-striped" >
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
                        '<td>' . $due_date1 . '</td>' .
                        '<td>' . $filling_date1 . '</td>' .
                        '</tr>';
                $k++;
            }
            $url = base_url() . "update_detail/" . base64_encode($customer_id) . "/" . base64_encode($insert_id);
            if ($curr_url == $url) {
                $get_observation = $this->db->query("select duedate_gstr2a_observation from observation_transaction_all where customer_id='$customer_id' and insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
                if ($this->db->affected_rows() > 0) {
                    $res = $get_observation->row();
                    $observation = $res->duedate_gstr2a_observation;
                } else {
                    $observation = "";
                }
                if (strtotime($filling_date1) > strtotime($due_date1)) {
                    $data1 .= '<label><h4><b>Observation:</b></h4></label><span class="required" aria-required="true"> </span>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                        <textarea class="form-control" rows="5" id="gstr3b_account_observation" name="gstr3b_account_observation" onkeyup="countWords(this.id);">There is no delay in filing returns</textarea>
                                    </div>
                                    <span class="required" style="color: red" id="gstr3b_account_observation_error"></span> 
                                <br>';
                } else {
                    $data1 .= '<label><h4><b>Observation:</b></h4></label><span class="required" aria-required="true"> </span>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                        <textarea class="form-control" rows="5" id="gstr3b_account_observation" name="gstr3b_account_observation" onkeyup="countWords(this.id);">There is no delay in filing returns</textarea>
                                    </div>
                                    <span class="required" style="color: red" id="gstr3b_account_observation_error"></span> 
                                <br>';
                }
            } else {
                if (strtotime($filling_date1) > strtotime($due_date1)) {
                    $data1 .= '<label><h4><b>Observation:</b></h4></label><span class="required" aria-required="true"> </span>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                        <textarea class="form-control" rows="5" id="gstr3b_account_observation" name="gstr3b_account_observation" onkeyup="countWords(this.id);">There is no delay in filing returns</textarea>
                                    </div>
                                    <span class="required" style="color: red" id="gstr3b_account_observation_error"></span> 
                                <br>';
                } else {
                    $data1 .= '<label><h4><b>Observation:</b></h4></label><span class="required" aria-required="true"> </span>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                        <textarea class="form-control" rows="5" id="gstr3b_account_observation" name="gstr3b_account_observation" onkeyup="countWords(this.id);">There is no delay in filing returns</textarea>
                                    </div>
                                    <span class="required" style="color: red" id="gstr3b_account_observation_error"></span> 
                                <br>';
                }
            }
            $get_observation1 = $this->db->query("select duedate_gstr2a_remarks from observation_transaction_all where customer_id='$customer_id' and insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
            if ($this->db->affected_rows() > 0) {
                $res = $get_observation1->row();
                $duedate_gstr2a_remarks = $res->duedate_gstr2a_remarks;
            } else {
                $duedate_gstr2a_remarks = "";
            }
            $data2 .= "<div class='col-md-12'>
                    <h5 class='box-title' style='margin-left: -3%;'><b>Remarks:</b></h5>
                    <textarea id='editor_duedate_gstr2a' name='editor_duedate_gstr2a' rows='10' style='width: 106%;margin-left: -3%;height: 15%;' onkeyup='final_word_count(this.id);remove_error('editor_duedate_gstr2a')'>" . $duedate_gstr2a_remarks . "</textarea>
                    </div>";

            $respose['data'] = $data;
            $respose['data1'] = $data1;
            $respose['data2'] = $data2;
//            $respose['data_gstr3b_name'] = $data_gstr3b_name;
//            $respose['data_gstr3b_observation'] = $data_gstr3b_observation;
//            $respose['data_gstr3b_remarks'] = $data_gstr3b_remarks;
//            

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

        $query = $this->db->query("SELECT period,status,filling_date,due_date FROM return_filled_gstr1_summary WHERE customer_id='$customer_id' ");
        $data = ""; //view observations
        $data1 = ""; //view observations
        if ($query->num_rows() > 0) {

            $result = $query->result();
            $period = array();
            $data .= '<h4 style="color:#1d2f66"><b>2. GSTR-1:</b></h4>';
            $data .= '<table id="example2" class="table-bordered table-striped">
                                <thead style="background-color: #516b22 ;color:white">
                                    <tr>
                                        <th>No.</th>
                                        <th>Period</th>
                                        <th>Status</th>
                                        <th>Due Date</th>
                                        <th>Filing Date</th>
                                        
                                        
                                    </tr>
                                </thead>
                                <tbody>';
            $k = 1;


            foreach ($result as $row) {
                $period = $row->period;
                $status = $row->status;
                $due_date = $row->due_date;
                $filling_date = $row->filling_date;

                $data .= '<tr>' .
                        '<td>' . $k . '</td>' .
                        '<td>' . $period . '</td>';
                if ($status == 'Filed') {
                    $data .= '<td style="background-color:#e31e25; color:#e31e25;">Filed</td>';
                } else {
                    $data .= '<td style="background-color:#84ab32; color:#84ab32;">Filed</td>';
                }
                $data .= '<td>' . $due_date . '</td>' .
                        '<td>' . $filling_date . '</td>' .
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

    public function get_gstr1_details1() {
        $customer_id = $this->input->post("customer_id");
//        $insert_id = $this->input->post("insert_id");

        $query = $this->db->query("SELECT period,status,filling_date,due_date FROM return_filled_gstr1_summary WHERE customer_id='$customer_id' ");
        $data = ""; //view observations
        $data1 = ""; //view observations
        if ($query->num_rows() > 0) {

            $result = $query->result();
            $period = array();
            $data .= '<br><br><h4 style=""><b>2. GSTR-1:</b></h4>';
            $data .= '<table class="table-bordered table-striped" width="700">
                                <thead style="background-color: #516b22 ;color:white">
                                    <tr>
                                        <th>No.</th>
                                        <th>Period</th>
                                        <th>Status</th>
                                        <th>Due Date</th>
                                        <th>Filing Date</th>
                                        
                                        
                                    </tr>
                                </thead>
                                <tbody>';
            $k = 1;


            foreach ($result as $row) {
                $period = $row->period;
                $status = $row->status;
                $due_date = $row->due_date;
                $filling_date = $row->filling_date;

                $data .= '<tr>' .
                        '<td>' . $k . '</td>' .
                        '<td>' . $period . '</td>';
                if ($status == 'Filed') {
                    $data .= '<td style="background-color:#e31e25; color:#e31e25;">Filed</td>';
                } else {
                    $data .= '<td style="background-color:#84ab32; color:#84ab32;">Filed</td>';
                }
                $data .= '<td>' . $due_date . '</td>' .
                        '<td>' . $filling_date . '</td>' .
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