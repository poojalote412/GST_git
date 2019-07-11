<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Invoice_comp_report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Invoice_comp_report_model');
    }

    function index() {
//        $data['result'] = $result;
        $this->load->view('customer/Invoice_comp_report ');
    }

    function not_in_2a_index() {
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

    public function import_notin2a_excel() {
        if (isset($_FILES["file_ex"]["name"])) {
            $path = $_FILES["file_ex"]["tmp_name"];
            $this->load->library('excel');
            $object = PHPExcel_IOFactory::load($path);
            $worksheet = $object->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();

            for ($i = 0; $i <= $highestRow; $i++) {
                if ($object->getActiveSheet()->getCell("B" . $i)->getValue() == "Not in 2A") {

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
                    $value_insert = 1;
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
            }

            if ($value_insert > 1) {
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

    public function get_table_company() {
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

                $data .= 
                        '<tr>'.
                        '<td>' . $row->company_name . '</td>'
                        . '<td><button type="button" name="get_records" id="get_records" onclick="get_records_not_in_2a(' . $row->company_name . ');"class="btn btn-outline-primary" >View</button></td>'.
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

}

?>