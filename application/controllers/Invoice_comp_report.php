<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Invoice_comp_report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Invoice_comp_report_model');
        $this->load->model('Cfo_model');
    }

    function index() {
//        $data['result'] = $result;
        $this->load->view('customer/Invoice_comp_report ');
    }

    public function invoice_not_included_index_admin() { //function to load view page
//        $query_get_cfo_data = $this->Invoice_comp_report_model->get_data_admin();
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
            $data['invoice_notinclu_data'] = $query_get_data;
        } else {
            $data['invoice_notinclu_data'] = "";
        }
        $this->load->view('admin/Invoce_not_included', $data);
    }

    function not_in_2a_index() { //function to load page of not in 2a
        $session_data = $this->session->userdata('login_session');
        $customer_id = ($session_data['customer_id']);
        $query_get_cfo_data = $this->Invoice_comp_report_model->get_data($customer_id);
        if ($query_get_cfo_data !== FALSE) {
            $data['not_in_2a_data'] = $query_get_cfo_data;
        } else {
            $data['not_in_2a_data'] = "";
        }
        $this->load->view('customer/Not_in_2a', $data);
    }

    function not_in_2a_index_admin() { //function to load page of not in 2a
//        $query_get_cfo_data = $this->Invoice_comp_report_model->get_data_admin();
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
            $data['not_in_2a_data'] = $query_get_data;
        } else {
            $data['not_in_2a_data'] = "";
        }
        $this->load->view('admin/Not_in_2a', $data);
    }

    function invoice_amendment_index() { //function to load page of invoice amendment
        $query_get_cfo_data = $this->Invoice_comp_report_model->get_data_admin();
        if ($query_get_cfo_data !== FALSE) {
            $data['invoice_amend_data'] = $query_get_cfo_data;
        } else {
            $data['invoice_amend_data'] = "";
        }
        $this->load->view('admin/invoice_amendment', $data);
    }

    function not_in_record_index() { //function to load page of not in records
        $session_data = $this->session->userdata('login_session');
        $customer_id = ($session_data['customer_id']);
        $query_get_cfo_data = $this->Invoice_comp_report_model->get_data($customer_id);
        if ($query_get_cfo_data !== FALSE) {
            $data['not_in_rec_data'] = $query_get_cfo_data;
        } else {
            $data['not_in_rec_data'] = "";
        }
        $this->load->view('customer/Not_in_records', $data);
    }

    function not_in_record_index_admin() { //function to load page of not in records
//        $query_get_cfo_data = $this->Invoice_comp_report_model->get_data_admin();
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
            $data['not_in_rec_data'] = $query_get_data;
        } else {
            $data['not_in_rec_data'] = "";
        }
        $this->load->view('admin/Not_in_records', $data);
    }

    public function import_notin2a_excel() { //function to import and insert data of reconciliation file 
        if (isset($_FILES["file_ex"]["name"])) {
            $path = $_FILES["file_ex"]["tmp_name"];
            $this->load->library('excel');
            $object = PHPExcel_IOFactory::load($path);
            $worksheet = $object->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            $value_insert_nrc = 1;
            $value_insert = 1;
            $value_insert_p_match = 1;
            for ($i = 0; $i <= $highestRow; $i++) {
                if ($object->getActiveSheet()->getCell("B" . $i)->getValue() == "Not in 2A") { //get records of not in 2a
                    $period = $object->getActiveSheet()->getCell("C" . $i)->getValue();
                    $invoice_no = $object->getActiveSheet()->getCell("D" . $i)->getValue();
                    $pos = $object->getActiveSheet()->getCell("E" . $i)->getValue();
                    $invoice_date_old = $object->getActiveSheet()->getCell("F" . $i)->getValue();
                    $old_date_timestamp = strtotime($invoice_date_old);
                    $invoice_date = date('Y-m-d', $old_date_timestamp);
                    $invoce_value = $object->getActiveSheet()->getCell("G" . $i)->getValue();
                    $taxable_value = $object->getActiveSheet()->getCell("H" . $i)->getValue();
                    $tax = $object->getActiveSheet()->getCell("I" . $i)->getValue();
                    $x = 1;

                    for ($j = $i; $j > 1; $j--) {
                        if ($object->getActiveSheet()->getCell("A" . $j)->getValue() == "As per Records") {
                            $prev_row = $j - 1;
                            $company_name_old = $object->getActiveSheet()->getCell("F" . $prev_row)->getValue();
                            $company_name = substr($company_name_old, 0, -20);
                            $x++;
                        } else {
                            
                        }
                        if ($x > 1) {
                            break;
                        }
                    }
                    $data = array(
                        'customer_id' => 'cust_1001',
                        'insert_id' => 'insert_1001',
                        'status' => 'not_in_2a',
                        'period' => $period,
                        'invoice_no' => $invoice_no,
                        'place_of_supply' => $pos,
                        'invoice_date' => $invoice_date,
                        'invoice_value' => $invoce_value,
                        'taxable_value' => $taxable_value,
                        'company_name' => $company_name,
                        'tax' => $tax,
                    );

                    $qr = $this->db->insert('gstr_2a_reconciliation_all', $data);
                    if ($this->db->affected_rows() > 0) {
                        $value_insert++;
                    }
                }
                if ($object->getActiveSheet()->getCell("B" . $i)->getValue() == "Not in Rec") { //get records of not in records
                    $x = 1;
                    $period = $object->getActiveSheet()->getCell("Q" . $i)->getValue();
                    $invoice_no = $object->getActiveSheet()->getCell("R" . $i)->getValue();
                    $pos = $object->getActiveSheet()->getCell("S" . $i)->getValue();
                    $invoice_date_old = $object->getActiveSheet()->getCell("T" . $i)->getValue();
                    $old_date_timestamp = strtotime($invoice_date_old);
                    $invoice_date = date('Y-m-d', $old_date_timestamp);
                    $invoce_value = $object->getActiveSheet()->getCell("U" . $i)->getValue();
                    $taxable_value = $object->getActiveSheet()->getCell("V" . $i)->getValue();
                    $tax = $object->getActiveSheet()->getCell("W" . $i)->getValue();
                    for ($j1 = $i; $j1 > 1; $j1--) {
                        if ($object->getActiveSheet()->getCell("A" . $j1)->getValue() == "As per Records") {
                            $prev_row = $j1 - 1;
                            $company_name_old = $object->getActiveSheet()->getCell("F" . $prev_row)->getValue();
                            $company_name = substr($company_name_old, 0, -20);
                            $x++;
                        } else {
                            
                        }
                        if ($x > 1) {
                            break;
                        }
                    }
                    $data_notin_rec = array(
                        'customer_id' => 'cust_1001',
                        'insert_id' => 'insert_1001',
                        'status' => 'not_in_rec',
                        'period' => $period,
                        'invoice_no' => $invoice_no,
                        'place_of_supply' => $pos,
                        'invoice_date' => $invoice_date,
                        'invoice_value' => $invoce_value,
                        'taxable_value' => $taxable_value,
                        'company_name' => $company_name,
                        'tax' => $tax,
                    );
                    $qr = $this->db->insert('gstr_2a_reconciliation_all', $data_notin_rec);
                    if ($this->db->affected_rows() > 0) {
                        $value_insert_nrc++;
                    }
                }
                if ($object->getActiveSheet()->getCell("B" . $i)->getValue() == "Partly Mat") { //get records of not in records
                    $x1 = 1;
                    //as per records data
                    $period_apr = $object->getActiveSheet()->getCell("C" . $i)->getValue();
                    $invoice_no_apr = $object->getActiveSheet()->getCell("D" . $i)->getValue();
                    $pos_apr = $object->getActiveSheet()->getCell("E" . $i)->getValue();
                    //as per GSTR-2A
                    $period_ap2a = $object->getActiveSheet()->getCell("Q" . $i)->getValue();
                    $invoice_no_ap2a = $object->getActiveSheet()->getCell("R" . $i)->getValue();
                    $pos_ap2a = $object->getActiveSheet()->getCell("S" . $i)->getValue();

                    //difference data
                    $taxable_value_diff = $object->getActiveSheet()->getCell("AJ" . $i)->getValue();
                    $tax_diff = $object->getActiveSheet()->getCell("AK" . $i)->getValue();

                    for ($j2 = $i; $j2 > 1; $j2--) {
                        if ($object->getActiveSheet()->getCell("A" . $j2)->getValue() == "As per Records") {
                            $prev_row = $j2 - 1;
                            $company_name_old = $object->getActiveSheet()->getCell("F" . $prev_row)->getValue();
                            $company_name = substr($company_name_old, 0, -20);
                            $x1++;
                        } else {
                            
                        }
                        if ($x1 > 1) {
                            break;
                        }
                    }
                    if ($taxable_value_diff == "") {
                        $taxable_value_diff = 0;
                    } else {
                        $taxable_value_diff = $taxable_value_diff;
                    }
                    if ($tax_diff == "") {
                        $tax_diff = 0;
                    } else {
                        $tax_diff = $tax_diff;
                    }

                    $data_partially_match = array(
                        'customer_id' => 'cust_1001',
                        'insert_id' => 'insert_1001',
                        'status' => 'Partly_Mat',
                        'period_apr' => $period_apr,
                        'invoice_no_apr' => $invoice_no_apr,
                        'place_of_supply_apr' => $pos_apr,
                        'period_2a' => $period_ap2a,
                        'invoice_no_2a' => $invoice_no_ap2a,
                        'place_of_supply_2a' => $pos_ap2a,
                        'taxable_value' => $taxable_value_diff,
                        'company_name' => $company_name,
                        'tax' => $tax_diff,
                    );
                    $qr = $this->db->insert('gstr_2a_reconciliation_partially_match_summary', $data_partially_match);
                    if ($this->db->affected_rows() > 0) {
                        $value_insert_p_match++;
                    }
                }
            }

            if ($value_insert > 1 || $value_insert_nrc > 1 || $value_insert_p_match > 1) {
                $response['message'] = "success";
                $response['status'] = true;
                $response['code'] = 200;
            } else {
                $response['message'] = "";
                $response['status'] = FALSE;
                $response['code'] = 204;
            }echo json_encode($response);
        } else {
            
        }
    }

    public function get_table_company() { //get companies who having not in 2a
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $query = $this->Invoice_comp_report_model->get_company($customer_id, $insert_id);
        $data = "";
        if ($query != FALSE) {
            $data .= '<div class="row">
                    <div class="col-md-12">
                        <div class="">
                         <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Company_name</th>
                                        <th>View Records</th>
                                    </tr>
                                </thead>
                                <tbody>';
            foreach ($query as $row) {

                $data .= '<tr>' .
                        '<td>' . $row->company_name . '</td>'
                        . '<td><button type="button" name="get_records" id="get_records" data-toggle="modal" data-customer_id="' . $row->customer_id . '" data-insert_id="' . $row->insert_id . '"data-company_name="' . $row->company_name . '" data-target="#not_in_2a_data_modal"class="btn btn-outline-primary" >View</button></td>' .
                        '</tr>';
            }
            $data .= '</tbody></table></div></div></div>';
            $response['data'] = $data;
            $response['message'] = "success";
            $response['status'] = true;
            $response['code'] = 200;
        } else {
            $response['message'] = "";
            $response['status'] = FALSE;
            $response['code'] = 204;
        }echo json_encode($response);
    }

    public function get_table_company_not_in_rec() { //get companies who having not in records
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $query = $this->Invoice_comp_report_model->get_company_not_in_rec($customer_id, $insert_id);
        $data = "";
        if ($query != FALSE) {
            $data .= '<div class="row">
                    <div class="col-md-12">
                        <div class="">
                         <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Company_name</th>
                                        <th>View Records</th>
                                    </tr>
                                </thead>
                                <tbody>';
            foreach ($query as $row) {

                $data .= '<tr>' .
                        '<td>' . $row->company_name . '</td>'
                        . '<td><button type="button" name="get_records" id="get_records" data-toggle="modal" data-customer_id="' . $row->customer_id . '" data-insert_id="' . $row->insert_id . '" data-company_name="' . $row->company_name . '" data-target="#not_in_rec_data_modal"class="btn btn-outline-primary" >View</button></td>' .
                        '</tr>';
            }
            $data .= '</tbody></table></div></div></div>';
            $response['data'] = $data;
            $response['message'] = "success";
            $response['status'] = true;
            $response['code'] = 200;
        } else {
            $response['message'] = "";
            $response['status'] = FALSE;
            $response['code'] = 204;
        }echo json_encode($response);
    }

    public function get_not_in2a_records() { //get not in 2A data of perticular company wise
        $company_name = $this->input->post("company_name");
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $query = $this->Invoice_comp_report_model->get_notin2a_records($company_name, $customer_id, $insert_id);
        $data = "";
        if ($query != FALSE) {
            $data .= '<div class="row">
                <div class="col-md-12">
               <center><h4 style="color:green"> <i class="fa fa-fw fa-bank"></i>  ' . $company_name . ' </h4></center><br>
                </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="">
                         <table id="example3" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Period</th>
                                        <th>Invoice No</th>
                                        <th>Place Of Supply</th>
                                        <th>Invoice Date</th>
                                        <th>Invoice Value</th>
                                        <th>Taxable Value</th>
                                        <th>Tax</th>
                                    </tr>
                                </thead>
                                <tbody>';

            $invoice_value = array();
            $taxable_value = array();
            $tax = array();
            $i = 1;
            foreach ($query as $row) {

                $invoice_value[] = $row->invoice_value;
                $taxable_value[] = $row->taxable_value;
                $tax[] = $row->tax;

                $data .= '<tr>' .
                        '<td>' . $i . '</td>' .
                        '<td>' . $row->period . '</td>' .
                        '<td>' . $row->invoice_no . '</td>' .
                        '<td>' . $row->place_of_supply . '</td>' .
                        '<td>' . $row->invoice_date . '</td>' .
                        '<td>' . $row->invoice_value . '</td>' .
                        '<td>' . $row->taxable_value . '</td>' .
                        '<td>' . $row->tax . '</td>' .
                        '</tr>';
                $i++;
            }
            $data .= '<tr>' .
                    '<td>' . "<b>Total</b>" . '</td>' .
                    '<td>' . "" . '</td>' .
                    '<td>' . "" . '</td>' .
                    '<td>' . "" . '</td>' .
                    '<td>' . "" . '</td>' .
                    '<td>' . "<b>" . array_sum($invoice_value) . "</b>" . '</td>' .
                    '<td>' . "<b>" . array_sum($taxable_value) . "</b>" . '</td>' .
                    '<td>' . "<b>" . array_sum($tax) . "</b>" . '</td>' .
                    '</tr>';

            $data .= '</tbody></table></div></div></div>';
            $response['data'] = $data;
            $response['message'] = "success";
            $response['status'] = true;
            $response['code'] = 200;
        } else {
            $response['message'] = "";
            $response['status'] = FALSE;
            $response['code'] = 204;
        }echo json_encode($response);
    }

    //function for get all not in 2a records with company details

    public function get_not_in2a_records_details() { //get not in 2A data of perticular company wise
        $company_name = $this->input->post("company_name");
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $query = $this->Invoice_comp_report_model->get_notin2a_records_all($customer_id, $insert_id);
        $data = "";
        $data1 = "";
        if ($query != FALSE) {
            $data .= '<h4 style="color:#0e385e"><b>1.Not in GSTR-2A,but recorderd under purchasers book:</b></h4>';

            $records = count($query);
            $show = $records / 24;
            $table = ceil($show);
            $min_value = 1;


            for ($i = 0, $k = 1; $i < $table; $i++) {

                if ($i == 0) {
                    $mrgin = "margin-top:5%;";
                    $pg_brk = "page-break-after:always;";
                    if ($table == 1) {
                        $mrgin1 = "margin-bottom:5%;";
                        $pg_brk = "page-break-after:avoid;";
                    } else {
                        $mrgin1 = "margin-bottom:10%;";
                    }
                } elseif ($i == ($table - 1)) {
                    $pg_brk = "page-break-after:avoid;";
                    $mrgin = "margin-top:7%;";
                    $mrgin1 = "margin-bottom:4%;";
                } else {
                    $pg_brk = "page-break-after:always;";
                    $mrgin = "margin-top:7%;";
                    $mrgin1 = "margin-bottom:10%;";
                }
                $data .= '<table id="not_in2a_data" class=" table-bordered table-striped" width="800" style="' . $mrgin . $mrgin1 . ';' . $pg_brk . '">
                                <thead style="background-color: #0e385e;color:white">
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Period</th>
                                        <th>Invoice No</th>
                                        <th>Place Of Supply</th>
                                        <th>Invoice Date</th>
                                        <th>Invoice Value</th>
                                        <th>Taxable Value</th>
                                        <th>Tax</th>
                                    </tr>
                                </thead>
                                <tbody>';

                $invoice_value = array();
                $taxable_value = array();
                $tax = array();
                $query2 = $this->db->query("select * from gstr_2a_reconciliation_all where status='not_in_2a' and customer_id='$customer_id'and insert_id='$insert_id' LIMIT $min_value,24");
                $result = $query2->result();
                foreach ($result as $row) {

                    $invoice_value[] = $row->invoice_value;
                    $taxable_value[] = $row->taxable_value;
                    $tax[] = $row->tax;

                    $data .= '<tr>' .
                            '<td>' . $row->company_name . '</td>' .
                            '<td>' . $row->period . '</td>' .
                            '<td>' . $row->invoice_no . '</td>' .
                            '<td>' . $row->place_of_supply . '</td>' .
                            '<td>' . $row->invoice_date . '</td>' .
                            '<td>' . $row->invoice_value . '</td>' .
                            '<td>' . $row->taxable_value . '</td>' .
                            '<td>' . $row->tax . '</td>' .
                            '</tr>';
                    $k++;
                }
                $data .= '</tbody></table>';
                $min_value = $min_value + 24;
                $response['data'] = $data;
                $response['message'] = "success";
                $response['status'] = true;
                $response['code'] = 200;
            }
            $data1 = "<h4><b>Observation:</b></h4>";
            $data1 .= "<span>Follow up from the above clients' needs to be done as the business is facing the risk of loss "
                    . "of input tax credit of Rs. " . array_sum($tax) . ". The situation of non-reconciliation may lead to interest liability or GST notices. </span>";
            $data1 .= "<h5><b>Note:</b>For details & consolidated summary.Please see section 8</h5>";
            $response['data1'] = $data1;
        } else {
            $response['message'] = "";
            $response['status'] = FALSE;
            $response['code'] = 204;
        }echo json_encode($response);
    }

    public function get_not_in2a_records_details1() { //get not in 2A data of perticular company wise
        $company_name = $this->input->post("company_name");
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $query = $this->Invoice_comp_report_model->get_notin2a_records_all($customer_id, $insert_id);
        $data = "";
        if ($query != FALSE) {
            $data .= '
                <div class="row">
                    <div class="col-md-12">
                        <div class="">
                         <table id="example_not_in_2a" class="table table-bordered table-striped">
                                <thead style="background-color: #00008B;color:white">
                                    <tr>
                                        <th>No.</th>
                                        <th>Company Name</th>
                                        <th>Period</th>
                                        <th>Invoice No</th>
                                        <th>Place Of Supply</th>
                                        <th>Invoice Date</th>
                                        <th>Invoice Value</th>
                                        <th>Taxable Value</th>
                                        <th>Tax</th>
                                    </tr>
                                </thead>
                                <tbody>';

            $invoice_value = array();
            $taxable_value = array();
            $tax = array();
            $i = 1;
            foreach ($query as $row) {

                $invoice_value[] = $row->invoice_value;
                $taxable_value[] = $row->taxable_value;
                $tax[] = $row->tax;

                $data .= '<tr>' .
                        '<td>' . $i . '</td>' .
                        '<td>' . $row->company_name . '</td>' .
                        '<td>' . $row->period . '</td>' .
                        '<td>' . $row->invoice_no . '</td>' .
                        '<td>' . $row->place_of_supply . '</td>' .
                        '<td>' . $row->invoice_date . '</td>' .
                        '<td>' . $row->invoice_value . '</td>' .
                        '<td>' . $row->taxable_value . '</td>' .
                        '<td>' . $row->tax . '</td>' .
                        '</tr>';
                $i++;
            }
            $data .= '<tr>' .
                    '<td>' . "<b>Total</b>" . '</td>' .
                    '<td>' . "" . '</td>' .
                    '<td>' . "" . '</td>' .
                    '<td>' . "" . '</td>' .
                    '<td>' . "" . '</td>' .
                    '<td>' . "" . '</td>' .
                    '<td>' . "" . '</td>' .
                    '<td>' . "<b>" . array_sum($invoice_value) . "</b>" . '</td>' .
                    '<td>' . "<b>" . array_sum($taxable_value) . "</b>" . '</td>' .
                    '<td>' . "<b>" . array_sum($tax) . "</b>" . '</td>' .
                    '</tr>';

            $data .= '</tbody></table></div></div></div>';
            $data .= "<hr><h4><b>Observation:</b></h4>";
            $data .= "<span>Follow up from the above clients' needs to be done as the business is facing the risk of loss "
                    . "of input tax credit of Rs. " . array_sum($tax) . ". The situation of non-reconciliation may lead to interest liability or GST notices. </span>";
            $response['data'] = $data;
            $response['message'] = "success";
            $response['status'] = true;
            $response['code'] = 200;
        } else {
            $response['message'] = "";
            $response['status'] = FALSE;
            $response['code'] = 204;
        }echo json_encode($response);
    }

    public function get_not_inrec_records() { //get not in records data of perticular company wise
        $company_name = $this->input->post("company_name");
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $query = $this->Invoice_comp_report_model->get_notinrec_records($company_name, $customer_id, $insert_id);
        $data = "";
        if ($query != FALSE) {
            $data .= '
                <div class="row">
                <div class="col-md-12">
               <center><h4 style="color:green"> <i class="fa fa-fw fa-bank"></i>  ' . $company_name . ' </h4></center><br>
                </div>
                </div>
            <div class="row">
                    <div class="col-md-12">
                        <div class="">
                         <table id="example3" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Period</th>
                                        <th>Invoice No</th>
                                        <th>Place Of Supply</th>
                                        <th>Invoice Date</th>
                                        <th>Invoice Value</th>
                                        <th>Taxable Value</th>
                                        <th>Tax</th>
                                    </tr>
                                </thead>
                                <tbody>';

            $invoice_value = array();
            $taxable_value = array();
            $tax = array();
            $i = 1;
            foreach ($query as $row) {

                $invoice_value[] = $row->invoice_value;
                $taxable_value[] = $row->taxable_value;
                $tax[] = $row->tax;

                $data .= '<tr>' .
                        '<td>' . $i . '</td>' .
                        '<td>' . $row->period . '</td>' .
                        '<td>' . $row->invoice_no . '</td>' .
                        '<td>' . $row->place_of_supply . '</td>' .
                        '<td>' . $row->invoice_date . '</td>' .
                        '<td>' . $row->invoice_value . '</td>' .
                        '<td>' . $row->taxable_value . '</td>' .
                        '<td>' . $row->tax . '</td>' .
                        '</tr>';
                $i++;
            }
            $data .= '<tr>' .
                    '<td>' . "<b>Total</b>" . '</td>' .
                    '<td>' . "" . '</td>' .
                    '<td>' . "" . '</td>' .
                    '<td>' . "" . '</td>' .
                    '<td>' . "" . '</td>' .
                    '<td>' . "<b>" . array_sum($invoice_value) . "</b>" . '</td>' .
                    '<td>' . "<b>" . array_sum($taxable_value) . "</b>" . '</td>' .
                    '<td>' . "<b>" . array_sum($tax) . "</b>" . '</td>' .
                    '</tr>';

            $data .= '</tbody></table></div></div></div>';
            $response['data'] = $data;
            $response['message'] = "success";
            $response['status'] = true;
            $response['code'] = 200;
        } else {
            $response['message'] = "";
            $response['status'] = FALSE;
            $response['code'] = 204;
        }echo json_encode($response);
    }

    //function to get all not in records with company details on report

    public function get_not_inrec_records_all() { //get not in records data of perticular company wise
        $company_name = $this->input->post("company_name");
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $query = $this->Invoice_comp_report_model->get_notinrec_records_all($customer_id, $insert_id);
        $data = "";
        $data1 = "";
//        $i = 1;

        if ($query != FALSE) {
            $records = count($query);
            $show = $records / 24;
            $table = ceil($show);
            $min_value = 1;
            $data .= '<h4 style="color:#0e385e"><b>2.Not in records,but recorded under GSTR-2A:</b></h4>';
            for ($i = 0, $k = 1; $i < $table; $i++) {
                $invoice_value = array();
                $taxable_value = array();
                $tax = array();
//            $TotalNoOfRecords = count($data);
                //query logics
                if ($i == 0) {
                    $mrgin = "margin-top:5%;";

                    $pg_brk = "page-break-after:always;";
                    if ($table == 1) {
                        $mrgin1 = "margin-bottom:5%;";
                        $pg_brk = "page-break-after:avoid;";
                    } else {
                        $mrgin1 = "margin-bottom:30%;";
                    }
                } elseif ($i == ($table - 1)) {
                    $mrgin = "margin-top:7%;";
                    $mrgin1 = "margin-bottom:5%;";
                    $pg_brk = "page-break-after:Avoid;";
                } else {
                    $mrgin = "margin-top:7%;";
                    $mrgin1 = "margin-bottom:30%;";
                    $pg_brk = "page-break-after:always;";
                }
                $data .= '
                         <table id="not_record_data" class="table-bordered table-striped" width="800" style="' . $mrgin . $mrgin1 . ';' . $pg_brk . '">
                                <thead style="background-color: #0e385e;color:white">
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Period</th>
                                        <th>Invoice No</th>
                                        <th>Place Of Supply</th>
                                        <th>Invoice Date</th>
                                        <th>Invoice Value</th>
                                        <th>Taxable Value</th>
                                        <th>Tax</th>
                                    </tr>
                                </thead>
                                <tbody>';
                $query2 = $this->db->query("select * from gstr_2a_reconciliation_all where status='not_in_rec' and customer_id='$customer_id'and insert_id='$insert_id' LIMIT $min_value,24 ");
                $result = $query2->result();
                foreach ($result as $row) {
//                    $invoice_value[] = $row->invoice_value;
//                    $taxable_value[] = $row->taxable_value;
//                    $tax[] = $row->tax;
                    $data .= '<tr>' .
                            '<td>' . $row->company_name . '</td>' .
                            '<td>' . $row->period . '</td>' .
                            '<td>' . $row->invoice_no . '</td>' .
                            '<td>' . $row->place_of_supply . '</td>' .
                            '<td>' . $row->invoice_date . '</td>' .
                            '<td>' . $row->invoice_value . '</td>' .
                            '<td>' . $row->taxable_value . '</td>' .
                            '<td>' . $row->tax . '</td>' .
                            '</tr>';
                    $k++;
                }
                $data .= '</table>';
                $response['data'] = $data;
//                $response['data1'] = $data1;
                $response['message'] = "success";
                $response['status'] = true;
                $response['code'] = 200;

                //query logics
                $min_value = $min_value + 24;
//                $max_value = ($max_value ) + 15;
            }
            $data1 = "<h4><b>Observation:</b></h4>"
                    . "<span>Accounting system & Invoice processing for GST Claim and reconciliation need to be reviewed.
                        There is a risk of losing the credit if prompt action has not been taken.</span>";
            $data1 .= "<h5><b>Note:</b>For details & consolidated summary.Please see section 8</h5>";
            $response['data1'] = $data1;
        } else {
            $response['message'] = "";
            $response['status'] = FALSE;
            $response['code'] = 204;
        }echo json_encode($response);
    }

    //function to load partial match data
    public function partial_match_index() {
        $session_data = $this->session->userdata('login_session');
        $customer_id = ($session_data['customer_id']);
        $query_get_data = $this->Cfo_model->get_data_cfo($customer_id);
        if ($query_get_data !== FALSE) {
            $data['partial_data'] = $query_get_data;
        } else {
            $data['partial_data'] = "";
        }
        $this->load->view('customer/partially_match_records', $data);
    }

    //function to load partial match data
    public function partial_match_index_admin() {
        $query_get_data = $this->Cfo_model->get_data_cfo_admin();
        if ($query_get_data !== FALSE) {
            $data['partial_data'] = $query_get_data;
        } else {
            $data['partial_data'] = "";
        }
        $this->load->view('admin/partially_match_records', $data);
    }

//get company data for partial match data
    public function get_table_company_partially_match() { //get companies who having not in 2a
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $query = $this->Invoice_comp_report_model->get_company_partial($customer_id, $insert_id);
        $data = "";
        if ($query != FALSE) {
            $data .= '<div class="row">
                    <div class="col-md-12">
                        <div class="">
                         <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Company_name</th>
                                        <th>View Records</th>
                                    </tr>
                                </thead>
                                <tbody>';
            foreach ($query as $row) {

                $data .= '<tr>' .
                        '<td>' . $row->company_name . '</td>'
                        . '<td><button type="button" name="get_records" id="get_records" data-toggle="modal" data-customer_id="' . $row->customer_id . '" data-insert_id="' . $row->insert_id . '"  data-company_name="' . $row->company_name . '" data-target="#partial_records_data_modal"class="btn btn-outline-primary" >View</button></td>' .
                        '</tr>';
            }
            $data .= '</tbody></table></div></div></div>';
            $response['data'] = $data;
            $response['message'] = "success";
            $response['status'] = true;
            $response['code'] = 200;
        } else {
            $response['message'] = "";
            $response['status'] = FALSE;
            $response['code'] = 204;
        }echo json_encode($response);
    }

    public function get_partial_records() { //getrecords ofpartial data
        $company_name = $this->input->post("company_name");
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $query = $this->Invoice_comp_report_model->get_partial_record($company_name, $customer_id, $insert_id);
        $data = "";
        if ($query != FALSE) {
            $data .= '<div class="row">
                <div class="col-md-12">
               <center><h4 style="color:green"> <i class="fa fa-fw fa-bank"></i>  ' . $company_name . ' </h4></center><br>
                </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="">
                         <table id="example3" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Period of as per Records</th>
                                        <th>Invoice No as per Records</th>
                                        <th>Place Of Supply as per Records</th>
                                        <th>Period of as per GSTR-2A</th>
                                        <th>Invoice No as per GSTR-2A</th>
                                        <th>Place Of Supply as per GSTR-2A</th>
                                        <th>Taxable Value Difference</th>
                                        <th>Tax Difference</th>
                                    </tr>
                                </thead>
                                <tbody>';

            $period_apr = array();
            $invoice_no_apr = array();
            $place_of_supply_apr = array();
            $period_2a = array();
            $invoice_no_2a = array();
            $place_of_supply_2a = array();
            $taxable_value = array();
            $tax = array();
            $i = 1;
            foreach ($query as $row) {

                $period_apr[] = $row->period_apr;
                $invoice_no_apr[] = $row->invoice_no_apr;
                $place_of_supply_apr[] = $row->place_of_supply_apr;
                $period_2a[] = $row->period_2a;
                $invoice_no_2a[] = $row->invoice_no_2a;
                $place_of_supply_2a[] = $row->place_of_supply_2a;
                $taxable_value[] = $row->taxable_value;
                $tax[] = $row->tax;

                $data .= '<tr>' .
                        '<td>' . $i . '</td>' .
                        '<td>' . $row->period_apr . '</td>' .
                        '<td>' . $row->invoice_no_apr . '</td>' .
                        '<td>' . $row->place_of_supply_apr . '</td>' .
                        '<td>' . $row->period_2a . '</td>' .
                        '<td>' . $row->invoice_no_2a . '</td>' .
                        '<td>' . $row->place_of_supply_2a . '</td>' .
                        '<td>' . $row->taxable_value . '</td>' .
                        '<td>' . $row->tax . '</td>' .
                        '</tr>';
                $i++;
            }
            $data .= '<tr>' .
                    '<td>' . "<b>Total</b>" . '</td>' .
                    '<td>' . "" . '</td>' .
                    '<td>' . "" . '</td>' .
                    '<td>' . "" . '</td>' .
                    '<td>' . "" . '</td>' .
                    '<td>' . "" . '</td>' .
                    '<td>' . "" . '</td>' .
                    '<td>' . "<b>" . array_sum($taxable_value) . "</b>" . '</td>' .
                    '<td>' . "<b>" . array_sum($tax) . "</b>" . '</td>' .
                    '</tr>';

            $data .= '</tbody></table></div></div></div>';
            $response['data'] = $data;
            $response['message'] = "success";
            $response['status'] = true;
            $response['code'] = 200;
        } else {
            $response['message'] = "";
            $response['status'] = FALSE;
            $response['code'] = 204;
        }echo json_encode($response);
    }

    //get all company partial records data

    public function get_all_partial_records() { //getrecords ofpartial data
        $company_name = $this->input->post("company_name");
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $query = $this->Invoice_comp_report_model->get_company_partial_all_data($customer_id, $insert_id);
        $data = "";
        $data1 = "";
        if ($query != FALSE) {
            $data .= '<h4 style="color:#0e385e"><b>3.Invoice no.,POS and Period mismatch:</b></h4>';
            $records = count($query);
            $show = $records / 20;
            $table = ceil($show);
            $min_value = 1;
            for ($i = 0, $k = 1; $i < $table; $i++) {
                if ($i == 0) {
                    $mrgin = "margin-top:5%;";
                    $pg_brk = "page-break-after:always;";
                    if ($table == 1) {
                        $mrgin1 = "margin-bottom:5%;";
                        $pg_brk = "page-break-after:avoid;";
                    } else {
                        $mrgin1 = "margin-bottom:20%;";
                    }
                } elseif ($i == ($table - 1)) {
                    $mrgin = "margin-top:15%;";
                    $mrgin1 = "margin-bottom:5%;";
                    $pg_brk = "page-break-after:avoid;";
                } else {
                    $mrgin = "margin-top:15%;";
                    $mrgin1 = "margin-bottom:20%;";
                    $pg_brk = "page-break-after:always;";
                }
                $data .= '<table id="example3" class=" table-bordered table-striped" width="800" style="' . $mrgin . $mrgin1 . ';' . $pg_brk . '" >
                                <thead style="background-color: #0e385e;color:white">
                                    <tr>
                                        <th>Company</th>
                                        <th>Period (Records)</th>
                                        <th>Invoice No (Records)</th>
                                        <th>POS (Records)</th>
                                        <th>Period (GSTR-2A)</th>
                                        <th>Invoice No (GSTR-2A)</th>
                                        <th>POS (GSTR-2A)</th>
                                        <th>Taxable Value Difference</th>
                                        <th>Tax Difference</th>
                                    </tr>
                                </thead>
                                <tbody>';

                $company_name = array();
                $period_apr = array();
                $invoice_no_apr = array();
                $place_of_supply_apr = array();
                $period_2a = array();
                $invoice_no_2a = array();
                $place_of_supply_2a = array();
                $taxable_value = array();
                $tax = array();
                $query2 = $this->db->query("select * from gstr_2a_reconciliation_partially_match_summary where customer_id='$customer_id' and insert_id='$insert_id' and status='Partly_Mat' LIMIT $min_value,20 ");
                $result = $query2->result();
                foreach ($result as $row) {

                    $company_name[] = $row->company_name;
                    $period_apr[] = $row->period_apr;
                    $invoice_no_apr[] = $row->invoice_no_apr;
                    $place_of_supply_apr[] = $row->place_of_supply_apr;
                    $period_2a[] = $row->period_2a;
                    $invoice_no_2a[] = $row->invoice_no_2a;
                    $place_of_supply_2a[] = $row->place_of_supply_2a;
                    $taxable_value[] = $row->taxable_value;
                    $tax[] = $row->tax;

                    $data .= '<tr>' .
                            '<td>' . $row->company_name . '</td>' .
                            '<td>' . $row->period_apr . '</td>' .
                            '<td>' . $row->invoice_no_apr . '</td>' .
                            '<td>' . $row->place_of_supply_apr . '</td>' .
                            '<td>' . $row->period_2a . '</td>' .
                            '<td>' . $row->invoice_no_2a . '</td>' .
                            '<td>' . $row->place_of_supply_2a . '</td>' .
                            '<td>' . $row->taxable_value . '</td>' .
                            '<td>' . $row->tax . '</td>' .
                            '</tr>';
                    $k++;
                }
                $data .= '</tbody></table>';
//            $data .= '<tr>' .
//                    '<td>' . "<b>Total</b>" . '</td>' .
//                    '<td>' . "" . '</td>' .
//                    '<td>' . "" . '</td>' .
//                    '<td>' . "" . '</td>' .
//                    '<td>' . "" . '</td>' .
//                    '<td>' . "" . '</td>' .
//                    '<td>' . "" . '</td>' .
//                    '<td>' . "" . '</td>' .
//                    '<td>' . "<b>" . array_sum($taxable_value) . "</b>" . '</td>' .
//                    '<td>' . "<b>" . array_sum($tax) . "</b>" . '</td>' .
//                    '</tr>';


                $min_value = $min_value + 20;
                $response['data'] = $data;
                $response['message'] = "success";
                $response['status'] = true;
                $response['code'] = 200;
            }

            $data1 .= "<h4><b>Observation:</b></h4>"
                    . "<span>Cross check the mismatched invoice no., POS and Period with the client in order to prevent any confusion or else it will effect on your ITC."
                    . " Data master review needs to be done and root-cause analysis will help to minimize this errors.</span>";
            $data1 .= "<h5><b>Note:</b>For details & consolidated summary.Please see section 8</h5>";
            $response['data1'] = $data1;
        } else {
            $response['message'] = "";
            $response['status'] = FALSE;
            $response['code'] = 204;
        }echo json_encode($response);
    }

    public function get_all_partial_records1() { //getrecords ofpartial data
        $company_name = $this->input->post("company_name");
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $query = $this->Invoice_comp_report_model->get_company_partial_all_data($customer_id, $insert_id);
        $data = "";
        $data1 = "";
        if ($query != FALSE) {
            $data1 .= '<h4 style="color:#1d2f66"><b>3.Invoice no.,POS and Period mismatch:</b></h4>';
            $data .= '<div class="row">
                <div class="col-md-12">
               
                </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="">
                         <table id="example3" class="table table-bordered table-striped">
                                <thead style="background-color: #00008B;color:white">
                                    <tr>
                                        <th>No.</th>
                                        <th>Company Name</th>
                                        <th>Period of as per Records</th>
                                        <th>Invoice No as per Records</th>
                                        <th>Place Of Supply as per Records</th>
                                        <th>Period of as per GSTR-2A</th>
                                        <th>Invoice No as per GSTR-2A</th>
                                        <th>Place Of Supply as per GSTR-2A</th>
                                        <th>Taxable Value Difference</th>
                                        <th>Tax Difference</th>
                                    </tr>
                                </thead>
                                <tbody>';

            $company_name = array();
            $period_apr = array();
            $invoice_no_apr = array();
            $place_of_supply_apr = array();
            $period_2a = array();
            $invoice_no_2a = array();
            $place_of_supply_2a = array();
            $taxable_value = array();
            $tax = array();
            $i = 1;
            foreach ($query as $row) {

                $company_name[] = $row->company_name;
                $period_apr[] = $row->period_apr;
                $invoice_no_apr[] = $row->invoice_no_apr;
                $place_of_supply_apr[] = $row->place_of_supply_apr;
                $period_2a[] = $row->period_2a;
                $invoice_no_2a[] = $row->invoice_no_2a;
                $place_of_supply_2a[] = $row->place_of_supply_2a;
                $taxable_value[] = $row->taxable_value;
                $tax[] = $row->tax;

                $data .= '<tr>' .
                        '<td>' . $i . '</td>' .
                        '<td>' . $row->company_name . '</td>' .
                        '<td>' . $row->period_apr . '</td>' .
                        '<td>' . $row->invoice_no_apr . '</td>' .
                        '<td>' . $row->place_of_supply_apr . '</td>' .
                        '<td>' . $row->period_2a . '</td>' .
                        '<td>' . $row->invoice_no_2a . '</td>' .
                        '<td>' . $row->place_of_supply_2a . '</td>' .
                        '<td>' . $row->taxable_value . '</td>' .
                        '<td>' . $row->tax . '</td>' .
                        '</tr>';
                $i++;
            }
            $data .= '<tr>' .
                    '<td>' . "<b>Total</b>" . '</td>' .
                    '<td>' . "" . '</td>' .
                    '<td>' . "" . '</td>' .
                    '<td>' . "" . '</td>' .
                    '<td>' . "" . '</td>' .
                    '<td>' . "" . '</td>' .
                    '<td>' . "" . '</td>' .
                    '<td>' . "" . '</td>' .
                    '<td>' . "<b>" . array_sum($taxable_value) . "</b>" . '</td>' .
                    '<td>' . "<b>" . array_sum($tax) . "</b>" . '</td>' .
                    '</tr>';

            $data .= '</tbody></table></div></div></div>';
            $data .= "<hr><h4><b>Observation:</b></h4>"
                    . "<span>Cross check the mismatched invoice no., POS and Period with the client in order to prevent any confusion or else it will effect on your ITC."
                    . " Data master review needs to be done and root-cause analysis will help to minimize this errors.</span>";
            $response['data'] = $data;
            $response['message'] = "success";
            $response['status'] = true;
            $response['code'] = 200;
        } else {
            $response['message'] = "";
            $response['status'] = FALSE;
            $response['code'] = 204;
        }echo json_encode($response);
    }

    public function import_not_included_excel() {
        if (isset($_FILES["file_ex"]["name"])) {
            $path = $_FILES["file_ex"]["tmp_name"];
            $this->load->library('excel');
            $object = PHPExcel_IOFactory::load($path);
            $worksheet = $object->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            $original_month = array();
            $showing_month = array();
            $category = array();
            $gstin_arr = array();
            $invoice_date = array();
            $invoice_no = array();
            $name = array();
            $invoice_value = array();
            $taxable_value = array();
            $igst = array();
            $cgst = array();
            $sgst = array();
            $cess = array();
            for ($i = 0; $i <= $highestRow; $i++) {
                if ($object->getActiveSheet()->getCell("B" . $i)->getValue() == "Original Month") { //get records of origial month
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $og_mon = $object->getActiveSheet()->getCell("B" . $j)->getValue();
                        $original_month[] = $og_mon;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("C" . $i)->getValue() == "Showing in month") { //get records of Showing month
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $show_mon = $object->getActiveSheet()->getCell("C" . $j)->getValue();
                        $showing_month[] = $show_mon;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("D" . $i)->getValue() == "Category") { //get records of Showing month
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $cat = $object->getActiveSheet()->getCell("D" . $j)->getValue();
                        $category[] = $cat;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("E" . $i)->getValue() == "GSTIN") { //get records of GSTIN
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $gstin = $object->getActiveSheet()->getCell("E" . $j)->getValue();
                        $gstin_arr[] = $gstin;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("F" . $i)->getValue() == "Invoice Date") { //get records of Invoice Date
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $invoiceDate = $object->getActiveSheet()->getCell("F" . $j)->getValue();
                        $invoice_date[] = $invoiceDate;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("G" . $i)->getValue() == "Invoice No") { //get records of Invoice No
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $invoiceno = $object->getActiveSheet()->getCell("G" . $j)->getValue();
                        $invoice_no[] = $invoiceno;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("H" . $i)->getValue() == "Name") { //get records of Names
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $names = $object->getActiveSheet()->getCell("H" . $j)->getValue();
                        $name[] = $names;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("I" . $i)->getValue() == "Invoice Value ") { //get records of Invoice Value 
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $invoice_val = $object->getActiveSheet()->getCell("I" . $j)->getValue();
                        $invoice_value[] = $invoice_val;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("J" . $i)->getValue() == "Taxable Value") { //get records of Showing month
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $tax_val = $object->getActiveSheet()->getCell("J" . $j)->getValue();
                        $taxable_value[] = $tax_val;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("K" . $i)->getValue() == "IGST") { //get records of IGST
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $igst_val = $object->getActiveSheet()->getCell("K" . $j)->getValue();
                        $igst[] = $igst_val;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("L" . $i)->getValue() == "CGST") { //get records of CGST
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $cgst_val = $object->getActiveSheet()->getCell("L" . $j)->getValue();
                        $cgst[] = $cgst_val;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("M" . $i)->getValue() == "SGST") { //get records of SGST
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $sgst_val = $object->getActiveSheet()->getCell("M" . $j)->getValue();
                        $sgst[] = $sgst_val;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("N" . $i)->getValue() == "CESS") { //get records of SGST
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $cess_val = $object->getActiveSheet()->getCell("N" . $j)->getValue();
                        $cess[] = $cess_val;
                    }
                } else {
                    
                }
            }

            $count = count($original_month);
            for ($k = 0; $k < $count; $k++) {

                if ($original_month[$k] == "") {
                    $original_month[$k] = "0";
                }
                if ($showing_month[$k] == "") {
                    $showing_month[$k] = "0";
                }
                if ($category[$k] == "") {
                    $category[$k] = "0";
                }
                if ($gstin_arr[$k] == "") {
                    $gstin_arr[$k] = "0";
                }
                if ($invoice_date[$k] == "") {
                    $invoice_date[$k] = "0";
                }
                if ($invoice_no[$k] == "") {
                    $invoice_no[$k] = "0";
                }
                if ($name[$k] == "") {
                    $name[$k] = "Not Given";
                }
                if ($invoice_value[$k] == "") {
                    $invoice_value[$k] = "0";
                }
                if ($taxable_value[$k] == "") {
                    $taxable_value[$k] = "0";
                }
                if ($igst[$k] == "") {
                    $igst[$k] = "0";
                }
                if ($cgst[$k] == "") {
                    $cgst[$k] = "0";
                }
                if ($sgst[$k] == "") {
                    $sgst[$k] = "0";
                }
                if ($cess[$k] == "") {
                    $cess[$k] = "0";
                }

                $query = ("insert into invoice_not_included_gstr1 (`customer_id`,`insert_id`,`original_month`,`showing_month`,"
                        . "`category`,`gstin_no`,`invoice_date`,`invoice_no`,`name`,`invoice_value`,`taxable_value`,`igst`,`cgst`,`sgst`,`cess`)"
                        . "values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $this->db->query($query, array('cust_1001', 'insert_1001', $original_month[$k], $showing_month[$k], $category[$k], $gstin_arr[$k],
                    $invoice_date[$k], $invoice_no[$k], $name[$k], $invoice_value[$k], $taxable_value[$k], $igst[$k], $cgst[$k], $sgst[$k], $cess[$k]));
                if ($this->db->affected_rows() > 0) {
                    echo'yes';
                } else {
                    echo'no';
                }
            }
        }
    }

    public function get_table_data() {
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $query = $this->Invoice_comp_report_model->get_details_invoice_not_included($customer_id, $insert_id);
        $data = "";
        $data1 = "";
        if ($query != FALSE) {
            $data1 .= '<h4 style="color:#0e385e"><b>2.Invoice not included in GSTR-1:</b></h4>';
            $records = count($query);
            $show = $records / 20;
            $table = ceil($show);
            $min_value = 0;
            for ($i = 0; $i < $table; $i++) {
                if ($i == 0) {
                    $mrgin = "margin-top:5%;";
                    $mrgin1 = "margin-bottom:20%;";
                    if ($table == 1) {
                        $mrgin1 = "margin-bottom:5%;";
                        $pg_brk = "page-break-after:avoid;";
                    } else {
                        $mrgin1 = "margin-bottom:20%;";
                    }
                } elseif ($i == ($table - 1)) {
                    $mrgin = "margin-top:7%;";
                    $mrgin1 = "margin-bottom:5%;";
                } else {
                    $mrgin = "margin-top:7%;";
                    $mrgin1 = "margin-bottom:20%;";
                }
                $data .= '<div class="row">
                    <div class="col-md-12">
                        <div class="">
                         <table id="example_invoice_not_include" class=" table-bordered table-striped" width:"800";style="' . $mrgin . $mrgin1 . '" >
                                <thead style="background-color: #516b22;color:white">
                                    <tr>
                                        <th>Original Month</th>
                                        <th>Showing in month</th>
                                        <th>Category</th>
                                        <th>GSTIN</th>
                                        <th>Invoice Date</th>
                                        <th>Invoice No</th>
                                        <th>Name</th>
                                        <th>Invoice Value</th>
                                        <th>Taxable Value</th>
                                        
                                        <th>Total Tax</th>
                                    </tr>
                                </thead>
                                <tbody>';
                $query2 = $this->db->query("select * from invoice_not_included_gstr1 where customer_id='$customer_id' and insert_id='$insert_id' LIMIT $min_value,20 ");
                $result = $query2->result();
                foreach ($result as $row) {

                    $data .= '<tr>' .
                            '<td>' . $row->original_month . '</td>
                        <td>' . $row->showing_month . '</td>
                        <td>' . $row->category . '</td>
                        <td>' . $row->gstin_no . '</td>
                        <td>' . $row->invoice_date . '</td>
                        <td>' . $row->invoice_no . '</td>
                        <td>' . $row->name . '</td>
                        <td>' . $row->invoice_value . '</td>
                        <td>' . $row->taxable_value . '</td>
                        <td><b>' . ($row->igst + $row->cgst + $row->sgst + $row->cess) . '</b></td>
                        
                        </tr>';
                }
                $data .= '</tbody></table></div></div></div>';
                $min_value = $min_value + 20;
            }
            $get_observation = $this->db->query("select invoice_not_include_observation from observation_transaction_all where customer_id='$customer_id' and insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
            if ($this->db->affected_rows() > 0) {
                $res = $get_observation->row();
                $observation = $res->invoice_not_include_observation;
            } else {
                $observation = "";
            }

            $data .= "<hr><h4><b>Observation :</b></h4><span>" . $observation . "</span>";
            $data .= "<h5><b>Note:</b>For details & consolidated summary.Please see section 8</h5>";

            $response['data'] = $data;
            $response['data1'] = $data1;
            $response['message'] = "success";
            $response['status'] = true;
            $response['code'] = 200;
        } else {
            $response['message'] = "";
            $response['status'] = FALSE;
            $response['code'] = 204;
        }echo json_encode($response);
    }

    public function get_table_data1() {
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $curr_url = $this->input->post("curr_url");
        $query = $this->Invoice_comp_report_model->get_details_invoice_not_included($customer_id, $insert_id);
        $data = "";
        if ($query != FALSE) {
            $data .= '<div class="row">
                    <div class="col-md-12">
                        <div class="">
                         <table id="example_invoice_not_include" class="table table-bordered table-striped" >
                                <thead style="background-color: #00008B;color:white">
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Original Month</th>
                                        <th>Showing in month</th>
                                        <th>Category</th>
                                        <th>GSTIN</th>
                                        <th>Invoice Date</th>
                                        <th>Invoice No</th>
                                        <th>Name</th>
                                        <th>Invoice Value</th>
                                        <th>Taxable Value</th>
                                        <th>IGST</th>
                                        <th>CGST</th>
                                        <th>SGST</th>
                                        <th>CESS</th>
                                        <th>Total Tax</th>
                                    </tr>
                                </thead>
                                <tbody>';
            $k = 1;
            foreach ($query as $row) {

                $data .= '<tr>' .
                        '<td>' . $k . '</td>
                        <td>' . $row->original_month . '</td>
                        <td>' . $row->showing_month . '</td>
                        <td>' . $row->category . '</td>
                        <td>' . $row->gstin_no . '</td>
                        <td>' . $row->invoice_date . '</td>
                        <td>' . $row->invoice_no . '</td>
                        <td>' . $row->name . '</td>
                        <td>' . $row->invoice_value . '</td>
                        <td>' . $row->taxable_value . '</td>
                        <td>' . $row->igst . '</td>
                        <td>' . $row->cgst . '</td>
                        <td>' . $row->sgst . '</td>
                        <td>' . $row->cess . '</td>
                        <td><b>' . ($row->igst + $row->cgst + $row->sgst + $row->cess) . '</b></td>
                        
                        </tr>';
                $k++;
            }
            $data .= '</tbody></table></div></div></div>';
            $curr_url = $this->input->post("curr_url");
            $url = base_url() . "update_detail/" . base64_encode($customer_id) . "/" . base64_encode($insert_id);
            if ($curr_url == $url) {
                $get_observation = $this->db->query("select invoice_not_include_observation from observation_transaction_all where customer_id='$customer_id' and insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
                if ($this->db->affected_rows() > 0) {
                    $res = $get_observation->row();
                    $observation = $res->invoice_not_include_observation;
                } else {
                    $observation = "";
                }
                $data .= '<div class="col-md-12">
                                    <label><h4><b>Observation of CFO:</b></h4></label><span class="required" aria-required="true"> </span>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                        <textarea class="form-control" rows="5" id="invoice_not_observation" name="invoice_not_observation" onkeyup="countWords(this.id);" >' . $observation . '</textarea>
                                    </div>
                                    <span class="required" style="color: red" id="invoice_not_observation_error"></span> 
                                </div><br>';
            } else {
                $data .= '<div class="col-md-12">
                                    <label><h4><b>Observation:</b></h4></label><span class="required" aria-required="true"> </span>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                        <textarea class="form-control" rows="5" id="invoice_not_observation" name="invoice_not_observation" onkeyup="countWords(this.id);">The recording of the invoices need to be reviewed.</textarea>
                                    </div>
                                    <span class="required" style="color: red" id="invoice_not_observation_error"></span> 
                                </div><br>';
            }
            $response['data'] = $data;
            $response['message'] = "success";
            $response['status'] = true;
            $response['code'] = 200;
        } else {
            $response['message'] = "";
            $response['status'] = FALSE;
            $response['code'] = 204;
        }echo json_encode($response);
    }

    public function import_amendment_excel() {
        if (isset($_FILES["file_ex"]["name"])) {
            $path = $_FILES["file_ex"]["tmp_name"];
            $this->load->library('excel');
            $object = PHPExcel_IOFactory::load($path);
            $worksheet = $object->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            $original_month = array();
            $include_month = array();
            $amendment_month = array();
            $category = array();
            $gstin_arr = array();
            $invoice_date = array();
            $invoice_no = array();
            $name = array();
            $invoice_value = array();
            $taxable_value = array();
            $igst = array();
            $cgst = array();
            $sgst = array();
            $cess = array();
            for ($i = 0; $i <= $highestRow; $i++) {
                if ($object->getActiveSheet()->getCell("B" . $i)->getValue() == "Original Month") { //get records of origial month
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $og_mon = $object->getActiveSheet()->getCell("B" . $j)->getValue();
                        $original_month[] = $og_mon;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("C" . $i)->getValue() == "Include in month") { //get records of Showing month
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $show_mon = $object->getActiveSheet()->getCell("C" . $j)->getValue();
                        $include_month[] = $show_mon;
                    }
                } else {
                    
                } if ($object->getActiveSheet()->getCell("D" . $i)->getValue() == "Amendment in month") { //get records of Showing month
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $amend_mon = $object->getActiveSheet()->getCell("D" . $j)->getValue();
                        $amendment_month[] = $amend_mon;
                    }
                } else {
                    
                }

                if ($object->getActiveSheet()->getCell("E" . $i)->getValue() == "Category") { //get records of Showing month
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $cat = $object->getActiveSheet()->getCell("E" . $j)->getValue();
                        $category[] = $cat;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("F" . $i)->getValue() == "GSTIN") { //get records of GSTIN
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $gstin = $object->getActiveSheet()->getCell("F" . $j)->getValue();
                        $gstin_arr[] = $gstin;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("G" . $i)->getValue() == "Invoice Date") { //get records of Invoice Date
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $invoiceDate = $object->getActiveSheet()->getCell("G" . $j)->getValue();
                        $invoice_date[] = $invoiceDate;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("H" . $i)->getValue() == "Invoice No") { //get records of Invoice No
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $invoiceno = $object->getActiveSheet()->getCell("H" . $j)->getValue();
                        $invoice_no[] = $invoiceno;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("I" . $i)->getValue() == "Name") { //get records of Names
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $names = $object->getActiveSheet()->getCell("I" . $j)->getValue();
                        $name[] = $names;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("J" . $i)->getValue() == "Invoice Value ") { //get records of Invoice Value 
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $invoice_val = $object->getActiveSheet()->getCell("J" . $j)->getValue();
                        $invoice_value[] = $invoice_val;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("K" . $i)->getValue() == "Taxable Value") { //get records of Showing month
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $tax_val = $object->getActiveSheet()->getCell("K" . $j)->getValue();
                        $taxable_value[] = $tax_val;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("L" . $i)->getValue() == "IGST") { //get records of IGST
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $igst_val = $object->getActiveSheet()->getCell("L" . $j)->getValue();
                        $igst[] = $igst_val;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("M" . $i)->getValue() == "CGST") { //get records of CGST
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $cgst_val = $object->getActiveSheet()->getCell("M" . $j)->getValue();
                        $cgst[] = $cgst_val;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("N" . $i)->getValue() == "SGST") { //get records of SGST
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $sgst_val = $object->getActiveSheet()->getCell("N" . $j)->getValue();
                        $sgst[] = $sgst_val;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("O" . $i)->getValue() == "CESS") { //get records of SGST
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $cess_val = $object->getActiveSheet()->getCell("O" . $j)->getValue();
                        $cess[] = $cess_val;
                    }
                } else {
                    
                }
            }

            $count = count($original_month);
            for ($k = 0; $k < $count; $k++) {

                if ($original_month[$k] == "") {
                    $original_month[$k] = "0";
                }
                if ($include_month[$k] == "") {
                    $include_month[$k] = "0";
                }
                if ($amendment_month[$k] == "") {
                    $amendment_month[$k] = "0";
                }
                if ($category[$k] == "") {
                    $category[$k] = "0";
                }
                if ($gstin_arr[$k] == "") {
                    $gstin_arr[$k] = "0";
                }
                if ($invoice_date[$k] == "") {
                    $invoice_date[$k] = "0";
                }
                if ($invoice_no[$k] == "") {
                    $invoice_no[$k] = "0";
                }
                if ($name[$k] == "") {
                    $name[$k] = "Not Given";
                }
                if ($invoice_value[$k] == "") {
                    $invoice_value[$k] = "0";
                }
                if ($taxable_value[$k] == "") {
                    $taxable_value[$k] = "0";
                }
                if ($igst[$k] == "") {
                    $igst[$k] = "0";
                }
                if ($cgst[$k] == "") {
                    $cgst[$k] = "0";
                }
                if ($sgst[$k] == "") {
                    $sgst[$k] = "0";
                }
                if ($cess[$k] == "") {
                    $cess[$k] = "0";
                }

                $query = ("insert into invoices_amended_summary_all (`customer_id`,`insert_id`,`original_month`,`included_in_month`,`amendment_month`,"
                        . "`category`,`gstin_no`,`invoice_date`,`invoice_no`,`name`,`invoice_value`,`taxable_value`,`igst`,`cgst`,`sgst`,`cess`)"
                        . "values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)");
                $this->db->query($query, array('cust_1001', 'insert_1001', $original_month[$k], $include_month[$k], $amendment_month[$k], $category[$k], $gstin_arr[$k],
                    $invoice_date[$k], $invoice_no[$k], $name[$k], $invoice_value[$k], $taxable_value[$k], $igst[$k], $cgst[$k], $sgst[$k], $cess[$k]));
                if ($this->db->affected_rows() > 0) {
                    echo'yes';
                } else {
                    echo'no';
                }
            }
        }
    }

    public function get_table_data_ammend() {
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
//        $query = $this->db->query("select * from invoices_amended_summary_all where customer_id='$customer_id' and insert_id='$insert_id'");
        $query = $this->Invoice_comp_report_model->get_details_invoice_ammneded($customer_id, $insert_id);
        $data = "";
        $data1 = "";
        if ($query != FALSE) {
            $data .= '<h4 style="color:#0e385e"><b>1.Invoice amends in other than original period Analysis:</b></h4>';
            $records = count($query);
            $show = $records / 15;
            $table = ceil($show);
            $min_value = 0;
            for ($i = 0; $i < $table; $i++) {
                if ($i == 0) {

                    $mrgin = "margin-top:5%;";

                    $pg_brk = "page-break-after:always;";
                    if ($table == 1) {
                        $mrgin1 = "margin-bottom:5%;";
                    } else {
                        $mrgin1 = "margin-bottom:20%;";
                    }
                } elseif ($i == ($table - 1)) {
                    $mrgin = "margin-top:15%;";
                    $mrgin1 = "margin-bottom:5%;";
                    $pg_brk = "page-break-after:avoid;";
                } else {
                    $mrgin = "margin-top:15%;";
                    $mrgin1 = "margin-bottom:20%;";
                    $pg_brk = "page-break-after:always;";
                }
                $data .= '<div class="row">
                    <div class="col-md-12">
                     <div class="">
                         <table id="example2" class=" table-bordered table-striped" style=" width:800;' . $mrgin . $mrgin1 . ';' . $pg_brk . '">
                                <thead style="background-color: #516b22;color:white">
                                    <tr style="width:2px">
                                        <th>Original Month</th>
                                        <th>Include Month</th>
                                        <th>Amend month</th>
                                        <th>Category</th>
                                        <th>GSTIN</th>
                                        <th>Inv.Date</th>
                                        <th>Inv.No</th>
                                        <th>Name</th>
                                        <th>Inv.Value</th>
                                        <th>Taxable</th>
                                        <th>Total Tax</th>
                                    </tr>
                                </thead>
                                <tbody>';
                $k = 1;
                $query2 = $this->db->query("select * from invoices_amended_summary_all where customer_id='$customer_id' and insert_id='$insert_id' LIMIT $min_value,15 ");
                $result = $query2->result();
                foreach ($result as $row) {
                    $data .= '<tr>' .
                            '<td style="width:100px">' . $row->original_month . '</td>
                        <td>' . $row->included_in_month . '</td>
                        <td>' . $row->amendment_month . '</td>
                        <td>' . $row->category . '</td>
                        <td>' . $row->gstin_no . '</td>
                        <td>' . $row->invoice_date . '</td>
                        <td>' . $row->invoice_no . '</td>
                        <td>' . $row->name . '</td>
                        <td>' . $row->invoice_value . '</td>
                        <td>' . $row->taxable_value . '</td>
                        <td><b>' . ($row->igst + $row->cgst + $row->sgst + $row->cess) . '</b></td>
                        
                        </tr>';
                }
                $data .= '</tbody></table></div></div></div>';
                $min_value = $min_value + 15;
//                $response['data1'] = $data1;
                $response['data'] = $data;
                $response['message'] = "success";
                $response['status'] = true;
                $response['code'] = 200;
            }
            $get_observation = $this->db->query("select amendment_records_observation from observation_transaction_all where customer_id='$customer_id' and insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
            if ($this->db->affected_rows() > 0) {
                $res = $get_observation->row();
                $observation = $res->amendment_records_observation;
            } else {
                $observation = "";
            }

            $data1 = "<div class='col-md-12'><h4><b>Observation :</b></h4><span>" . $observation . "</span></div>";
            $data1 .= "<div class='col-md-12'><h5><b>Note:</b>For details & consolidated summary.Please see section 8</h5></div>";
            $response['data1'] = $data1;
        } else {
            $response['message'] = "";
            $response['status'] = FALSE;
            $response['code'] = 204;
        }echo json_encode($response);
    }

    public function get_table_data_ammend1() {
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $curr_url = $this->input->post("curr_url");
//        $query = $this->db->query("select * from invoices_amended_summary_all where customer_id='$customer_id' and insert_id='$insert_id'");
        $query = $this->Invoice_comp_report_model->get_details_invoice_ammneded($customer_id, $insert_id);
        $data = "";
        if ($query != FALSE) {
            $data .= '<div class="row">
                    <div class="col-md-12">
                    <div class="">
                         <table id="example_ammend" class="table table-bordered table-striped" >
                                <thead style="background-color: #00008B;color:white">
                                    <tr style="width:2px">
                                    <th>Sr No</th>
                                        <th>Original Month</th>
                                        <th>Included In Month</th>
                                        <th>Amendment in month</th>
                                        <th>Category</th>
                                        <th>GSTIN</th>
                                        <th>Invoice Date</th>
                                        <th>Invoice No</th>
                                        <th>Name</th>
                                        <th>Invoice Value</th>
                                        <th>Taxable Value</th>
                                        <th>IGST</th>
                                        <th>CGST</th>
                                        <th>SGST</th>
                                        <th>CESS</th>
                                        <th>Total Tax</th>
                                    </tr>
                                </thead>
                                <tbody>';
            $k = 1;
            foreach ($query as $row) {



                $data .= '<tr>' .
                        '<td>' . $k . '</td>
                        <td>' . $row->original_month . '</td>
                        <td>' . $row->included_in_month . '</td>
                        <td>' . $row->amendment_month . '</td>
                        <td>' . $row->category . '</td>
                        <td>' . $row->gstin_no . '</td>
                        <td>' . $row->invoice_date . '</td>
                        <td>' . $row->invoice_no . '</td>
                        <td>' . $row->name . '</td>
                        <td>' . $row->invoice_value . '</td>
                        <td>' . $row->taxable_value . '</td>
                        <td>' . $row->igst . '</td>
                        <td>' . $row->cgst . '</td>
                        <td>' . $row->sgst . '</td>
                        <td>' . $row->cess . '</td>
                        <td><b>' . ($row->igst + $row->cgst + $row->sgst + $row->cess) . '</b></td>
                        
                        </tr>';
                $k++;
            }
            $data .= '</tbody></table></div></div></div>';
            $url = base_url() . "update_detail/" . base64_encode($customer_id) . "/" . base64_encode($insert_id);
            if ($curr_url == $url) {
                $get_observation = $this->db->query("select amendment_records_observation from observation_transaction_all where customer_id='$customer_id' and insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
                if ($this->db->affected_rows() > 0) {
                    $res = $get_observation->row();
                    $observation = $res->amendment_records_observation;
                } else {
                    $observation = "";
                }
                $data .= '<div class="col-md-12">
                                    <label><h4><b>Observation:</b></h4></label><span class="required" aria-required="true"> </span>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                        <textarea class="form-control" rows="5" id="amend_observation" name="amend_observation" onkeyup="countWords(this.id);">' . $observation . '</textarea>
                                    </div>
                                    <span class="required" style="color: red" id="amend_observation_error"></span> 
                                </div><br>';
            } else {
                $data .= '<div class="col-md-12">
                                    <label><h4><b>Observation :</b></h4></label><span class="required" aria-required="true"> </span>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                        <textarea class="form-control" rows="5" id="amend_observation" name="amend_observation" onkeyup="countWords(this.id);">The recording of the invoices need to be reviewed..</textarea>
                                    </div>
                                    <span class="required" style="color: red" id="amend_observation_error"></span> 
                                </div><br>';
            }
            $response['data'] = $data;
            $response['message'] = "success";
            $response['status'] = true;
            $response['code'] = 200;
        } else {
            $response['message'] = "";
            $response['status'] = FALSE;
            $response['code'] = 204;
        }echo json_encode($response);
    }

}

?>