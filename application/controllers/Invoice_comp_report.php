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
        $session_data = $this->session->userdata('login_session');
        $customer_id = ($session_data['customer_id']);
        $query_get_cfo_data = $this->Invoice_comp_report_model->get_data($customer_id);
        if ($query_get_cfo_data !== FALSE) {
            $data['not_in_2a_data'] = $query_get_cfo_data;
        } else {
            $data['not_in_2a_data'] = "";
        }
        $this->load->view('admin/Not_in_2a', $data);
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
        $session_data = $this->session->userdata('login_session');
        $customer_id = ($session_data['customer_id']);
        $query_get_cfo_data = $this->Invoice_comp_report_model->get_data($customer_id);
        if ($query_get_cfo_data !== FALSE) {
            $data['not_in_rec_data'] = $query_get_cfo_data;
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
        $query = $this->Invoice_comp_report_model->get_company($customer_id);
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
        $query = $this->Invoice_comp_report_model->get_company_not_in_rec($customer_id);
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

//get company data for partial match data
    public function get_table_company_partially_match() { //get companies who having not in 2a
        $customer_id = $this->input->post("customer_id");
        $query = $this->Invoice_comp_report_model->get_company_partial($customer_id);
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

}

?>