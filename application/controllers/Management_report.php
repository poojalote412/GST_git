<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Management_report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Cfo_model');
        $this->load->model('Management_report_model');
    }

    function index() {
//        $data['result'] = $result;
//        $this->load->view('customer/GST_Management');
    }

    function state_wise_report() {
//        $data['result'] = $result;
        $this->load->view('customer/Sale_state_wise');
    }

    public function import_excel() { //function to get data from excel files
        if (isset($_FILES["file_ex"]["name"]) && isset($_FILES["file_ex1"]["name"])) {
            $path = $_FILES["file_ex"]["tmp_name"];
            $this->load->library('excel');
            $object = PHPExcel_IOFactory::load($path);
            $worksheet = $object->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();


            $j = 0;
            for ($i = 8; $i <= $highestRow; $i++) { // loop to get last row number to get state
                if ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "Total") {
                    $j++;
                }
                if ($j > 0) {
                    break;
                }
            }
            $total_row_num = $i;
            $all_state = array();
            $str = "(4) Cr Note Details";

            for ($k = 8; $k < $total_row_num; $k++) { //loop get state data
                $all_state[] = $object->getActiveSheet()->getCell('D' . $k)->getValue();
            }
            $states = array_unique($all_state); //unique array of state
            $count = count($states);
            $a1 = 0;
            for ($m = 0; $m < $count; $m++) {
                if ($m < 10) {
                    $state_new = $states[$m];
                } else {
                    $state_new = $states[0];
                }

                $taxable_value = 0;
                $arr_taxable_value = array();
//                echo $highestRow;
                for ($l = 8; $l <= $highestRow; $l++) { //loop to get data statewise
                    $a2 = $object->getActiveSheet()->getCell('A' . $l)->getValue();
                    if ($a2 == "(4) Cr Note Details") {
                        $a1 = 1;
                    } else if ($a2 == "(5) Dr Note Details") {
                        $a1 = 2;
                    }
                    if ($object->getActiveSheet()->getCell('D' . $l)->getValue() == $state_new) {
                        if ($a1 == 0 or $a1 == 2) {
                            $tax_val = $object->getActiveSheet()->getCell('E' . $l)->getValue();
                            $taxable_value += $tax_val;
                        } else if ($a1 == 1) {
                            $tax_val = $object->getActiveSheet()->getCell('E' . $l)->getValue();
                            $taxable_value -= $tax_val;
                        }
                    }
                }

                $arr_taxable_value[] = $taxable_value;
            }

            $path1 = $_FILES["file_ex1"]["tmp_name"];
            $this->load->library('excel');
            $object1 = PHPExcel_IOFactory::load($path);
            $worksheet1 = $object1->getActiveSheet();
            $highestRow1 = $worksheet1->getHighestRow();
            $highestColumn1 = $worksheet1->getHighestColumn();

            $a = 'How are you?';

            if (strpos($a, 'is') !== false) {
                echo 'true';
            } else {
                echo 'jkdf';
            }
        }
    }

    // function taxable non taxable and exempt page load
    public function sale_taxable_nontaxable() {
        $session_data = $this->session->userdata('login_session');
        $customer_id = ($session_data['customer_id']);
        $query_get_cfo_data = $this->Cfo_model->get_data_cfo($customer_id);
        if ($query_get_cfo_data !== FALSE) {
            $data['tax_exempt_data'] = $query_get_cfo_data;
        } else {
            $data['tax_exempt_data'] = "";
        }
        $this->load->view('customer/Sale_tax_nontax_exempt', $data);
    }

    public function get_graph_taxable_nontx_exempt() { //get graph function of taxable nontaxable and exempt
        $customer_id = $this->input->post("customer_id");
        $query = $this->db->query("SELECT * from monthly_summary_all where customer_id='$customer_id'");
        $data = ""; //view observations
        if ($query->num_rows() > 0) {
            $result = $query->result();
            $taxable_supply_arr = array();
            $sub_total_non_gst_arr = array();
            $sub_total_exempt_arr = array();
            $ratio_taxable_supply = array();
            $ratio_subtotal_nongst = array();
            $ratio_subtotal_exempt = array();
            $data .= '<div class="row">
                    <div class="col-md-12">
                        <div class="">
                         <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Month</th>
                                        <th>Taxable Supply</th>
                                        <th>Exempt Supply</th>
                                        <th>Non-GST Supply</th>
                                        <th>Ratio of Taxable supply by Total supply</th>
                                        <th>Ratio of Exempt Supply by Total supply</th>
                                        <th>Ratio of Non-GST supply by Total supply</th>
                                    </tr>
                                </thead>
                                <tbody>';
            $k = 1;
            foreach ($result as $row) {
                $inter_state_supply = $row->inter_state_supply;
                $intra_state_supply = $row->intra_state_supply;
                $debit_value = $row->debit_value;
                $credit_value = $row->credit_value;
                $month = $row->month;

                $taxable_supply = ($inter_state_supply + $intra_state_supply + $debit_value) - ($credit_value);
                $taxable_supply_arr[] = $taxable_supply; //taxable supply array

                $sub_total_non_gst = $row->sub_total_non_gst;
                $sub_total_non_gst_arr[] = $sub_total_non_gst; // sub total non gst array

                $sub_total_exempt = $row->sub_total_exempt;
                $sub_total_exempt_arr[] = $sub_total_exempt; // sub total exempt array

                $grand_total = $taxable_supply + $sub_total_non_gst + $sub_total_exempt;
                $ratio_taxable_supply[] = round(($taxable_supply * 100) / ($grand_total));
                $ratio_subtotal_nongst[] = round(($sub_total_non_gst * 100) / ($grand_total));
                $ratio_subtotal_exempt[] = round(($sub_total_exempt * 100) / ($grand_total));
                $data .= '<tr>' .
                        '<td>' . $k . '</td>' .
                        '<td>' . $month . '</td>' .
                        '<td>' . $taxable_supply . '</td>' .
                        '<td>' . $sub_total_exempt . '</td>' .
                        '<td>' . $sub_total_non_gst . '</td>' .
                        '<td>' . (round(($taxable_supply * 100) / ($grand_total))) . "%" . '</td>' .
                        '<td>' . (round(($sub_total_non_gst * 100) / ($grand_total))) . "%" . '</td>' .
                        '<td>' . (round(($sub_total_exempt * 100) / ($grand_total))) . "%" . '</td>' .
                        '</tr>';
                $k++;
            }
            $data .= '<tr>' .
                    '<td>' . '<b>Total</b>' . '</td>' .
                    '<td>' . '' . '</td>' .
                    '<td>' . '<b>' . array_sum($taxable_supply_arr) . '</b> ' . '</td>' .
                    '<td>' . '<b>' . array_sum($sub_total_exempt_arr) . '</b>' . '</td>' .
                    '<td>' . '<b>' . array_sum($sub_total_non_gst_arr) . '</b>' . '</td>' .
                    '<td>' . '<b>' . "" . '</b>' . '</td>' .
                    '<td>' . '<b>' . "" . '</b>' . '</td>' .
                    '<td>' . '<b>' . "" . '</b>' . '</td>' .
                    '</tr>';
            $data .= '</tbody></table></div></div></div>';
            $data .= "<hr><h4><b>Observation of Sales Taxable, non-taxable and Exempt:</b></h4>";
            // loop to get graph data as per graph script requirement
            $abc1 = array();
            $abc2 = array();
            $abc3 = array();
            $abc4 = array();
            $abc5 = array();
            $abc6 = array();
            for ($o = 0; $o < sizeof($taxable_supply_arr); $o++) {
                $abc1[] = $taxable_supply_arr[$o];
                $aa1 = settype($abc1[$o], "float");

                $abc2[] = $sub_total_non_gst_arr[$o];
                $aa2 = settype($abc2[$o], "float");

                $abc3[] = $sub_total_exempt_arr[$o];
                $aa3 = settype($abc3[$o], "float");

                $abc4[] = $ratio_taxable_supply[$o];
                $aa4 = settype($abc4[$o], "float");

                $abc5[] = $ratio_subtotal_nongst[$o];
                $aa5 = settype($abc5[$o], "float");

                $abc6[] = $ratio_subtotal_exempt[$o];
                $aa6 = settype($abc6[$o], "float");
            }

            // to get max value for range
            $arr = array($abc1, $abc2, $abc3);
            $max_range = 0;
            foreach ($arr as $val) {
                foreach ($val as $key => $val1) {
                    if ($val1 > $max_range) {
                        $max_range = $val1;
                    }
                }
            }

            //function to get months
            $quer2 = $this->db->query("SELECT month from  monthly_summary_all where customer_id='$customer_id'");
            $months = array();
            if ($quer2->num_rows() > 0) {
                $res2 = $quer2->result();
                foreach ($res2 as $row) {
                    $months[] = $row->month;
                }
            }

            //function to get customer name
            $quer21 = $this->db->query("SELECT customer_name from customer_header_all where customer_id='$customer_id'");

            if ($quer21->num_rows() > 0) {
                $res2 = $quer21->row();
                $customer_name = $res2->customer_name;
            }
            $respnose['data'] = $data;
            $respnose['message'] = "success";
            $respnose['taxable_supply_arr'] = $abc1;  //taxable_supply data
            $respnose['sub_total_non_gst_arr'] = $abc2; //sub_total_non_gstdata
            $respnose['sub_total_exempt_arr'] = $abc3; //sub_total_exempt data
            $respnose['ratio_taxable_supply'] = $abc4; //ratio_taxable_supply
            $respnose['ratio_subtotal_nongst'] = $abc5; //ratio_subtotal_nongst
            $respnose['ratio_subtotal_exempt'] = $abc6; //ratio_subtotal_exempt
            $respnose['month_data'] = $months; //months 
            $respnose['customer_name'] = $customer_name; //customer
            $respnose['max_range'] = $max_range; //maximum range for graph
        } else {
            $respnose['data'] = "";
            $respnose['message'] = "";
            $respnose['taxable_supply_arr'] = "";  //taxable_supply data
            $respnose['sub_total_non_gst_arr'] = ""; //sub_total_non_gstdata
            $respnose['sub_total_exempt_arr'] = ""; //sub_total_exempt data
            $respnose['ratio_taxable_supply'] = ""; //ratio_taxable_supply
            $respnose['ratio_subtotal_nongst'] = ""; //ratio_subtotal_nongst
            $respnose['ratio_subtotal_exempt'] = ""; //ratio_subtotal_exempt
        } echo json_encode($respnose);
    }

    //Graph generated month wise

    function sale_month_wise() {
//        $data['result'] = $result;
        $session_data = $this->session->userdata('login_session');
        $customer_id = ($session_data['customer_id']);
        $query_get_cfo_data = $this->Cfo_model->get_data_cfo($customer_id);
        if ($query_get_cfo_data !== FALSE) {
            $data['month_wise_data'] = $query_get_cfo_data;
        } else {
            $data['month_wise_data'] = "";
        }
        $this->load->view('customer/Sales_month_wise', $data);
    }

    public function get_graph_sales_month_wise() { //get graph function of Sales month wise
        $customer_id = $this->input->post("customer_id");
        $query = $this->db->query("SELECT * from monthly_summary_all where customer_id='$customer_id'");
        $data = ""; //view observations
        if ($query->num_rows() > 0) {
            $result = $query->result();
            $taxable_supply_arr = array();
            $data .= '<div class="row">
                    <div class="col-md-12">
                        <div class="">
                         <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Month</th>
                                        <th>Sales</th>
                                        <th>Ratio</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>';
            $k = 1;
            $sales_percent_values = array();
            $taxable_supply_arr1 = array();
            foreach ($result as $row1) {
                $inter_state_supply = $row1->inter_state_supply;
                $intra_state_supply = $row1->intra_state_supply;
                $no_gst_paid_supply = $row1->no_gst_paid_supply;
                $debit_value = $row1->debit_value;
                $credit_value = $row1->credit_value;
                $month = $row1->month;

                $taxable_supply1 = ($inter_state_supply + $intra_state_supply + $no_gst_paid_supply + $debit_value) - ($credit_value);
                $taxable_supply_arr1[] = $taxable_supply1; //taxable supply array
            }
            $sum_tax = array_sum($taxable_supply_arr1);
            foreach ($result as $row) {
                $inter_state_supply = $row->inter_state_supply;
                $intra_state_supply = $row->intra_state_supply;
                $no_gst_paid_supply = $row->no_gst_paid_supply;
                $debit_value = $row->debit_value;
                $credit_value = $row->credit_value;
                $month = $row->month;

                $taxable_supply = ($inter_state_supply + $intra_state_supply + $no_gst_paid_supply + $debit_value) - ($credit_value);
                $taxable_supply_arr[] = $taxable_supply; //taxable supply array
                $sale_percent = (($taxable_supply) / ($sum_tax * 100));
                $sales_percent_values1 = round(($sale_percent * 10000), 2);
                $sales_percent_values[] = round(($sale_percent * 10000));

                $data .= '<tr>' .
                        '<td>' . $k . '</td>' .
                        '<td>' . $month . '</td>' .
                        '<td>' . $taxable_supply . '</td>' .
                        '<td>' . $sales_percent_values1 . '%</td>' .
                        '</tr>';

                $k++;
            }
            $data .= '<tr>' .
                    '<td>' . '<b>Total</b>' . '</td>' .
                    '<td>' . '' . '</td>' .
                    '<td>' . '<b>' . array_sum($taxable_supply_arr) . '</b> ' . '</td>' .
                    '<td>' . '<b>' . array_sum($sales_percent_values) . '%</b> ' . '</td>' .
                    '</tr>';
            $data .= '</tbody></table></div></div></div>';
            $max= max($sales_percent_values);
            $min= min($sales_percent_values);
//            echo $variation=($max-$min)/($min*100);
            $data .= "<hr><h4><b>Observation of  Sales month wise:</b></h4>";

            // loop to get graph data as per graph script requirement
            $abc1 = array();
            for ($o = 0; $o < sizeof($taxable_supply_arr); $o++) {

                $abc1[] = $taxable_supply_arr[$o];
                $aa1 = settype($abc1[$o], "float");
            }





//             to get max value for range
            $max_range = max($abc1);

            //function to get months
            $quer2 = $this->db->query("SELECT month from monthly_summary_all where customer_id='$customer_id'");
            $months = array();
            if ($quer2->num_rows() > 0) {
                $res2 = $quer2->result();
                foreach ($res2 as $row) {
                    $months[] = $row->month;
                }
            }
            //function to get customer name
            $quer21 = $this->db->query("SELECT customer_name from customer_header_all where customer_id='$customer_id'");

            if ($quer21->num_rows() > 0) {
                $res21 = $quer21->row();
                $customer_name = $res21->customer_name;
            }
            $respnose['data'] = $data;
            $respnose['message'] = "success";
            $respnose['taxable_supply_arr'] = $abc1;  //taxable_supply data
            $respnose['month_data'] = $months; //months 
            $respnose['max_range'] = $max_range; //maximum range for graph
            $respnose['customer_name'] = $customer_name; //customer
            $respnose['sales_percent_values'] = $sales_percent_values; //sales in percent
        } else {
            $respnose['message'] = "";
            $respnose['taxable_supply_arr'] = "";  //taxable_supply data
        } echo json_encode($respnose);
    }

    // sale b2b view page function
    public function Sale_b2b_b2c() {
        $session_data = $this->session->userdata('login_session');
        $customer_id = ($session_data['customer_id']);
        $query_get_b2b_data = $this->Management_report_model->get_data_b2b($customer_id);
        if ($query_get_b2b_data !== FALSE) {
            $data['b2b_data'] = $query_get_b2b_data;
        } else {
            $data['b2b_data'] = "";
        }
        $this->load->view('customer/B2b_b2c', $data);
    }

    //function to import data from excel and insert into database.
    public function import_excel_b2b() {

        if (isset($_FILES["file_ex_b2b"]["name"])) {
            $path = $_FILES["file_ex_b2b"]["tmp_name"];
            $this->load->library('excel');
            $object = PHPExcel_IOFactory::load($path);
            $worksheet = $object->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            $x = "G";
            //loop to get month data
            while ($object->getActiveSheet()->getCell($x . 6)->getValue() !== "Grand Tatal") {
                $months[] = $object->getActiveSheet()->getCell($x . 6)->getValue();
                $x++;
            }
            $cnt = count($months);
            $month_data = array();
            for ($a12 = 0; $a12 < $cnt; $a12++) {
                $month = $months[$a12];
                $month_data[] = $months[$a12];
                $a12 = ($a12 * 1 + 3);
            }
            for ($i = 1; $i <= $highestRow; $i++) {
                $a_new2 = $object->getActiveSheet()->getCell('A' . $i)->getValue();
                if ($a_new2 == "(2) Total value of supplies on which GST paid (intra-State Supplies [Other than Deemed Export])") {
                    $anew = 1;
                } else if ($a_new2 == "(3) Value of Other Supplies on which no GST paid") {
                    $anew = 2;
                }

                //for get value between credit note and debit note
                $aa2 = $object->getActiveSheet()->getCell('A' . $i)->getValue();
                if ($aa2 == "(4) Cr Note Details") {
                    $value11 = 1;
                } else if ($aa2 == "(5) Dr Note Details") {
                    $value11 = 2;
                }


                $row_prev = $i - 1;
                $sk = 0;
                if ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "Sub Total (B2B)") {
                    $highestColumn_row = $worksheet->getHighestColumn($i);
                    //get first table data in excel
                    if ($object->getActiveSheet()->getCell($highestColumn_row . $i)->getValue() == "" && $object->getActiveSheet()->getCell($highestColumn_row . $i)->getValue() != '0') {
                        $a = strlen($highestColumn_row);
                        $index = strlen($highestColumn_row) - 1;
                        $ord = ord($highestColumn_row[$index]);
                        $a1 = substr($highestColumn_row, 0, 1);
                        $a2 = substr($highestColumn_row, 1);
                        if ($a1 != $a2 and $a2 == "A") {
//                            $index = strlen($a1) - 1;                            
                            $ord = ord($highestColumn_row[1]);
                            $index = 1;
                            $a = $this->getAlpha($a1, $ord, $a, $index);
                            $highestColumn_row = $a . "Z";
                        } else {
                            $highestColumn_row = $this->getAlpha($highestColumn_row, $ord, $a, $index);
                        }
                        $r = 1;
                        $z2 = $object->getActiveSheet()->getCell($highestColumn_row . $i)->getValue();
                        while ($z2 == "") {
                            if ($z2 != "" or $z2 == '0') {
                                $r++;
                            } else {
                                $a = strlen($highestColumn_row);
                                $index = strlen($highestColumn_row) - 1;
                                $ord = ord($highestColumn_row[$index]);
                                $a1 = substr($highestColumn_row, 0, 1);
                                $a2 = substr($highestColumn_row, 1);
                                if ($a1 != $a2 and $a2 == "A") {
                                    $ord = ord($highestColumn_row[1]);
                                    $index = 1;
                                    $o1 = ord($a1);
                                    $o2 = chr($o1 - 1);
                                    $highestColumn_row = $o2 . "Z";
                                } else {
                                    $highestColumn_row = $this->getAlpha($highestColumn_row, $ord, $a, $index);
                                }
                            }
                            $z2 = $object->getActiveSheet()->getCell($highestColumn_row . $i)->getValue();
                            if ($r > 1) {
                                break;
                            }
                            $highest_value_str = substr($highestColumn_row, -2);
                        }
                        $highest_value = $highest_value_str; // got last value here for if
                        for ($k = 0; $k < 4; $k++) {
                            $a11 = strlen($highest_value);
                            $index1 = strlen($highest_value) - 1;
                            $ord1 = ord($highest_value[$index1]);
                            $highestColumn_row_pp = $this->getAlpha($highest_value, $ord1, $a11, $index1);
                            $highest_value = $highestColumn_row_pp;
                        }
                        $highest_value_without_GT = $highest_value; //hightest cloumn till where we have to find our data
                        $char = 'G';
                        $values = array();
                        while ($char !== $highest_value_without_GT) {
                            $values[] = $object->getActiveSheet()->getCell($char . $i)->getValue();
                            $char++;
                        }
                        $cnt = count($values);
                        $interstate_b2b = array();
                        for ($aa11 = 0; $aa11 <= $cnt; $aa11++) {
                            $data1 = $values[$aa11];
                            $interstate_b2b[] = $values[$aa11];
                            $aa11 = ($aa11 * 1 + 3);
                        }
                    } else {
                        if ($anew == 1) {
                            $highest_value = $worksheet->getHighestColumn($i); // got last value here for else
                            for ($k = 0; $k < 4; $k++) {
                                $a11 = strlen($highest_value);
                                $index1 = strlen($highest_value) - 1;
                                $ord1 = ord($highest_value[$index1]);
                                $highestColumn_row_pp = $this->getAlpha($highest_value, $ord1, $a11, $index1);
                                $highest_value = $highestColumn_row_pp;
                            }
                            $highest_value_without_GT = $highest_value; //hightest cloumn till where we have to find our data
                            $char = 'G';
                            $values1 = array();
                            while ($char !== $highest_value_without_GT) {
                                $values1[] = $object->getActiveSheet()->getCell($char . $i)->getValue();
                                $char++;
                            }
                            $cnt = count($values1);
                            $intrastate_b2b = array();
                            for ($a12 = 0; $a12 < $cnt; $a12++) {
                                $data2 = $values1[$a12];
                                $intrastate_b2b[] = $values1[$a12];
                                $a12 = ($a12 * 1 + 3);
                            }
                        } elseif ($value11 == 1) {
                            $highestColumn_dr = $worksheet->getHighestColumn($i);
                            for ($k = 0; $k < 5; $k++) {
                                $a11 = strlen($highestColumn_dr);
                                $index1 = strlen($highestColumn_dr) - 1;
                                $ord1 = ord($highestColumn_dr[$index1]);
                                $a1 = substr($highestColumn_dr, 0, 1);
                                $a2 = substr($highestColumn_dr, 1);
                                if ($a1 != $a2 and $a2 == "A") {
                                    $ord = ord($highestColumn_dr[1]);
                                    $index = 1;
                                    $o1 = ord($a1);
                                    $o2 = chr($o1 - 1);
                                    $highestColumn_row_pp = $o2 . "Z";
                                } else {
                                    $highestColumn_row_pp = $this->getAlpha($highestColumn_dr, $ord1, $a11, $index1);
                                }
                                $highestColumn_dr = $highestColumn_row_pp;
                            }

                            $highest_value_without_DR = $highestColumn_dr; //hightest cloumn till where we have to find our data
                            $char = 'G';
                            $values_CR = array();
                            while ($char !== $highest_value_without_DR) {
                                $values_CR[] = $object->getActiveSheet()->getCell($char . $i)->getValue();
                                $char++;
                            }
                            $cnt = count($values_CR);
                            $credit_b2b = array();
                            for ($a_dr1 = 0; $a_dr1 < $cnt; $a_dr1++) {
                                $Dr_values = $values_CR[$a_dr1];
                                $credit_b2b[] = $values_CR[$a_dr1];
                                $a_dr1 = ($a_dr1 * 1 + 4);
                            }
                        } else {
                            $highestColumn_dr = $worksheet->getHighestColumn($i);
                            for ($k = 0; $k < 5; $k++) {
                                $a11 = strlen($highestColumn_dr);
                                $index1 = strlen($highestColumn_dr) - 1;
                                $ord1 = ord($highestColumn_dr[$index1]);
                                $a1 = substr($highestColumn_dr, 0, 1);
                                $a2 = substr($highestColumn_dr, 1);
                                if ($a1 != $a2 and $a2 == "A") {
                                    $ord = ord($highestColumn_dr[1]);
                                    $index = 1;
                                    $o1 = ord($a1);
                                    $o2 = chr($o1 - 1);
                                    $highestColumn_row_pp = $o2 . "Z";
                                } else {
                                    $highestColumn_row_pp = $this->getAlpha($highestColumn_dr, $ord1, $a11, $index1);
                                }
                                $highestColumn_dr = $highestColumn_row_pp;
                            }

                            $highest_value_without_DR = $highestColumn_dr; //hightest cloumn till where we have to find our data
                            $char = 'G';
                            $values_DR = array();
                            while ($char !== $highest_value_without_DR) {
                                $values_DR[] = $object->getActiveSheet()->getCell($char . $i)->getValue();
                                $char++;
                            }
                            $cnt = count($values_DR);
                            $debit_b2b = array();
                            for ($a_cr1 = 0; $a_cr1 < $cnt; $a_cr1++) {
                                $Dr_values = $values_DR[$a_cr1];
                                $debit_b2b[] = $values_DR[$a_cr1];
                                $a_cr1 = ($a_cr1 * 1 + 4);
                            }
                        }
                    }
                }
                //To get value of Sub Total (B2CS)
                elseif ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "Sub Total (B2CS)") { //interstate
                    $highestColumn_row = $worksheet->getHighestColumn($i);
                    //get first table data in excel
                    if ($object->getActiveSheet()->getCell($highestColumn_row . $i)->getValue() == "" && $object->getActiveSheet()->getCell($highestColumn_row . $i)->getValue() != '0') {

                        $a = strlen($highestColumn_row);
                        $index = strlen($highestColumn_row) - 1;
                        $ord = ord($highestColumn_row[$index]);
                        $a1 = substr($highestColumn_row, 0, 1);
                        $a2 = substr($highestColumn_row, 1);
                        if ($a1 != $a2 and $a2 == "A") {
//                            $index = strlen($a1) - 1;                            
                            $ord = ord($highestColumn_row[1]);
                            $index = 1;
                            $a = $this->getAlpha($a1, $ord, $a, $index);
                            $highestColumn_row = $a . "Z";
                        } else {
                            $highestColumn_row = $this->getAlpha($highestColumn_row, $ord, $a, $index);
                        }
                        $r = 1;
                        $z2 = $object->getActiveSheet()->getCell($highestColumn_row . $i)->getValue();
                        while ($z2 == "") {
                            if ($z2 != "" or $z2 == '0') {
                                $r++;
                            } else {
                                $a = strlen($highestColumn_row);
                                $index = strlen($highestColumn_row) - 1;
                                $ord = ord($highestColumn_row[$index]);
                                $a1 = substr($highestColumn_row, 0, 1);
                                $a2 = substr($highestColumn_row, 1);
                                if ($a1 != $a2 and $a2 == "A") {
                                    $ord = ord($highestColumn_row[1]);
                                    $index = 1;
                                    $o1 = ord($a1);
                                    $o2 = chr($o1 - 1);
                                    $highestColumn_row = $o2 . "Z";
                                } else {
                                    $highestColumn_row = $this->getAlpha($highestColumn_row, $ord, $a, $index);
                                }
                            }
                            $z2 = $object->getActiveSheet()->getCell($highestColumn_row . $i)->getValue();
                            if ($r > 1) {
                                break;
                            }
                            $highest_value_str = substr($highestColumn_row, -2);
                        }
                        $highest_value = $highest_value_str; // got last value here for if
                        for ($k = 0; $k < 4; $k++) {
                            $a11 = strlen($highest_value);
                            $index1 = strlen($highest_value) - 1;
                            $ord1 = ord($highest_value[$index1]);
                            $highestColumn_row_pp = $this->getAlpha($highest_value, $ord1, $a11, $index1);
                            $highest_value = $highestColumn_row_pp;
                        }
                        $highest_value_without_GT1 = $highest_value; //hightest cloumn till where we have to find our data
                        $char = 'G';
                        $values2 = array();
                        while ($char !== $highest_value_without_GT1) {
                            $values2[] = $object->getActiveSheet()->getCell($char . $i)->getValue();
                            $char++;
                        }
                        $cnt = count($values2);
                        $interstate_b2c = array();
                        for ($aa12 = 0; $aa12 <= $cnt; $aa12++) {
                            $data1 = $values2[$aa12];
                            $interstate_b2c[] = $values2[$aa12];
                            $aa12 = ($aa12 * 1 + 3);
                        }
                    } else { //intrastate
                        $sk++;
                        $highest_value = $worksheet->getHighestColumn($i); // got last value here for else
                        for ($k = 0; $k < 4; $k++) {
                            $a11 = strlen($highest_value);
                            $index1 = strlen($highest_value) - 1;
                            $ord1 = ord($highest_value[$index1]);
                            $highestColumn_row_pp = $this->getAlpha($highest_value, $ord1, $a11, $index1);
                            $highest_value = $highestColumn_row_pp;
                        }
                        $highest_value_without_GT = $highest_value; //hightest cloumn till where we have to find our data
                        $char = 'G';
                        $values3 = array();
                        while ($char !== $highest_value_without_GT) {
                            $values3[] = $object->getActiveSheet()->getCell($char . $i)->getValue();
                            $char++;
                        }
                        $cnt = count($values3);
                        $intrastate_b2c = array();
                        for ($a12 = 0; $a12 < $cnt; $a12++) {
                            $data2 = $values3[$a12];
                            $intrastate_b2c[] = $values3[$a12];
                            $a12 = ($a12 * 1 + 3);
                        }
                    }
                } elseif ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "(4) Cr Note Details") {
                    for ($j = $i; $j <= $highestRow; $j++) {
                        if ($object->getActiveSheet()->getCell('B' . $j)->getValue() == "Sub Total (B2CS)") {
                            $highestColumn_dr = $worksheet->getHighestColumn($j);
                            for ($k = 0; $k < 5; $k++) {
                                $a11 = strlen($highestColumn_dr);
                                $index1 = strlen($highestColumn_dr) - 1;
                                $ord1 = ord($highestColumn_dr[$index1]);
                                $a1 = substr($highestColumn_dr, 0, 1);
                                $a2 = substr($highestColumn_dr, 1);
                                if ($a1 != $a2 and $a2 == "A") {
                                    $ord = ord($highestColumn_dr[1]);
                                    $index = 1;
                                    $o1 = ord($a1);
                                    $o2 = chr($o1 - 1);
                                    $highestColumn_row_pp = $o2 . "Z";
                                } else {
                                    $highestColumn_row_pp = $this->getAlpha($highestColumn_dr, $ord1, $a11, $index1);
                                }
                                $highestColumn_dr = $highestColumn_row_pp;
                            }

                            $highest_value_without_DR = $highestColumn_dr; //hightest cloumn till where we have to find our data
                            $char = 'G';
                            $cr_values = array();
                            while ($char !== $highest_value_without_DR) {
                                $cr_values[] = $object->getActiveSheet()->getCell($char . $j)->getValue();
                                $char++;
                            }
                            $cnt = count($values_DR);
                            $credit_b2c = array();
                            for ($a_dr11 = 0; $a_dr11 < $cnt; $a_dr11++) {
                                $cr_values1 = $cr_values[$a_dr11];
                                $credit_b2c[] = $cr_values[$a_dr11];
                                $a_dr11 = ($a_dr11 * 1 + 4);
                            }
                        }
                    }
                } elseif ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "(5) Dr Note Details") {
                    for ($j = $i; $j <= $highestRow; $j++) {
                        if ($object->getActiveSheet()->getCell('B' . $j)->getValue() == "Sub Total (B2CS)") {
                            $highestColumn_dr = $worksheet->getHighestColumn($j);
                            for ($k = 0; $k < 5; $k++) {
                                $a11 = strlen($highestColumn_dr);
                                $index1 = strlen($highestColumn_dr) - 1;
                                $ord1 = ord($highestColumn_dr[$index1]);
                                $a1 = substr($highestColumn_dr, 0, 1);
                                $a2 = substr($highestColumn_dr, 1);
                                if ($a1 != $a2 and $a2 == "A") {
                                    $ord = ord($highestColumn_dr[1]);
                                    $index = 1;
                                    $o1 = ord($a1);
                                    $o2 = chr($o1 - 1);
                                    $highestColumn_row_pp = $o2 . "Z";
                                } else {
                                    $highestColumn_row_pp = $this->getAlpha($highestColumn_dr, $ord1, $a11, $index1);
                                }
                                $highestColumn_dr = $highestColumn_row_pp;
                            }

                            $highest_value_without_DR = $highestColumn_dr; //hightest cloumn till where we have to find our data
                            $char = 'G';
                            while ($char !== $highest_value_without_DR) {
                                $values_DR[] = $object->getActiveSheet()->getCell($char . $j)->getValue();
                                $char++;
                            }
                            $cnt = count($values_DR);
                            $debit_b2c = array();
                            for ($a_dr11 = 0; $a_dr11 < $cnt; $a_dr11++) {
                                $Dr_values = $values_DR[$a_dr11];
                                $debit_b2c[] = $values_DR[$a_dr11];
                                $a_dr11 = ($a_dr11 * 1 + 4);
                            }
                        }
                    }
                } else {
                    $credit_b2c[] = 0;
                    $debit_b2c[] = 0;
                    $debit_b2b[] = 0;
                    $credit_b2b[] = 0;
                    $interstate_b2b[] = 0;
                    $intrastate_b2b[] = 0;
                    $interstate_b2c[] = 0;
                    $intrastate_b2c[] = 0;
                }
            }

            //store b2c values of debit and credi into new variable
            $debit_b2c1 = $debit_b2c;
            $credit_b2c1 = $credit_b2c;


            //code to insert data into database
            $uniq_id = $this->generate_uniq_id(); //unique id generation
            $month_data_arr = $month_data; //array of month data
            $count = count($month_data_arr);
            $vall = 1;
            for ($t = 0; $t < $count; $t++) {
                if ($interstate_b2b == "" or $interstate_b2b === NULL) {
                    $inter_state_b2b = array();
                    $inter_state_b2b[$t] = 0; //array of inter state supply B2B
                } else {
                    $inter_state_b2b = $interstate_b2b; //array of inter state supply B2B
                }
                if ($intrastate_b2b == "" or $intrastate_b2b === NULL) {
                    $intra_state_b2b = array();
                    $intra_state_b2b[$t] = 0; //array of intra state supply B2B
                } else {
                    $intra_state_b2b = $intrastate_b2b; //array of intra state supply B2B
                }
                if ($interstate_b2c == "" or $interstate_b2c === NULL) {
                    $inter_b2c = array();
                    $inter_b2c[$t] = 0; // array of inter state supply B2C
                } else {
                    $inter_b2c = $interstate_b2c; // array of inter state supply B2C
                }
                if ($intrastate_b2c == "" or $intrastate_b2c === NULL) {
                    $intra_b2c = array();
                    $intra_b2c[$t] = 0;   //array of intra state supply B2C
                } else {
                    $intra_b2c = $intrastate_b2c; //array of intra state supply B2C
                }
                if ($debit_b2b == "" or $debit_b2b === NULL) {
                    $debit_b2b_new = array();
                    $debit_b2b_new[$t] = 0;  //array of debit_value B2B
                } else {
                    $debit_b2b_new = $debit_b2b; //array of debit_value B2B
                }
                if ($debit_b2c1 == "" or $debit_b2c1 === NULL) {
                    $debit_b2c_new = array();
                    $debit_b2c_new[$t] = 0;   //array of debit_value B2C
                } else {
                    $debit_b2c_new = $debit_b2c1; //array of debit_value B2C
                }
                if ($credit_b2b == "" or $credit_b2b === NULL) {
                    $credit_b2b_new = array();
                    $credit_b2b_new[$t] = 0;  //array of credit_value B2B
                } else {
                    $credit_b2b_new = $credit_b2b; //array of credit_value B2B
                }
                if ($credit_b2c1 == "" or $credit_b2c1 === NULL) {
                    $credit_b2c_new = array();
                    $credit_b2c_new[$t] = 0;  //array of credit_value B2C
                } else {
                    $credit_b2c_new = $credit_b2c1; //array of credit_value B2C
                }
                //query to insert data into database
                $quer = $this->db->query("insert into b2b_b2c (`unique_id`,`month`,`interstate_b2b`,`interstate_b2c`,`intrastate_b2b`,`intrastate_b2c`,`credit_b2b`,`credit_b2c`,`debit_b2b`,`debit_b2c`)"
                        . " values ('$uniq_id','$month_data[$t]','$inter_state_b2b[$t]','$intra_state_b2b[$t]','$inter_b2c[$t]','$intra_b2c[$t]','$credit_b2b_new[$t]','$credit_b2c_new[$t]','$debit_b2b_new[$t]','$debit_b2c_new[$t]')");

                if ($this->db->affected_rows() > 0) {
                    $vall++;
                }
            }
            if ($vall > 1) {
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

    //to decrement column of excel
    public function getAlpha($highestColumn_row, $ord, $a, $index) {
        if ($ord >= 65) {
            // The final character is still greater than A, decrement
            $highestColumn_row = substr($highestColumn_row, 0, $index) . chr($ord - 1);
        } else {
            if ($a == 2) {
                $highestColumn_row = 'Z';
            } else if ($a == 3) {
                $highestColumn_row = 'ZZ';
            } else if ($a == 1) {
                $highestColumn_row = 'A';
            }
        }
        return $highestColumn_row;
    }

    public function generate_uniq_id() {
        $result = $this->db->query('SELECT unique_id FROM `b2b_b2c` ORDER BY unique_id DESC LIMIT 0,1');
        if ($result->num_rows() > 0) {
            $data = $result->row();
            $uniq_id = $data->unique_id;
            //generate turn_id
            $uniq_id = str_pad( ++$uniq_id, 5, '0', STR_PAD_LEFT);
            return $uniq_id;
        } else {
            $uniq_id = 'btb_1001';
            return $uniq_id;
        }
    }

    //function to get graph function for B2B and B2C.
    public function get_graph_b2b() {
        $customer_id = $this->input->post("customer_id");
        $query_get_graph = $this->Management_report_model->get_graph_query($customer_id);
        $data = ""; //view observations
        if (count($query_get_graph) > 0) {
            $month = array();
            $array_b2b = array();
            $array_b2c = array();
            $array_b2b_ratio = array();
            $array_b2c_ratio = array();
            $data .= '<div class="row">
                    <div class="col-md-12">
                        <div class="">
                         <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Month</th>
                                        <th>Sales B2B</th>
                                        <th>Sales B2C</th>
                                        <th>Ratio of sales B2B to total sales</th>
                                        <th>Ratio of B2C to total sales</th>
                                    </tr>
                                </thead>
                                <tbody>';
            $k = 1;
            foreach ($query_get_graph as $row) {
                $month[] = $row->month;
                $months = $row->month;
                $interstate_b2b = $row->interstate_b2b;
                $interstate_b2c = $row->interstate_b2c;
                $intrastate_b2b = $row->intrastate_b2b;
                $intrastate_b2c = $row->intrastate_b2c;
                $credit_b2b = $row->credit_b2b;
                $credit_b2c = $row->credit_b2c;
                $debit_b2b = $row->debit_b2b;
                $debit_b2c = $row->debit_b2c;

                $b2b_data = ($interstate_b2b + $intrastate_b2b + $debit_b2b) - $credit_b2b;
                $b2c_data = ($interstate_b2c + $intrastate_b2c + $debit_b2c) - $credit_b2c;
                $array_b2b[] = $b2b_data;
                $array_b2c[] = $b2c_data;
                $array_b2b_ratio[] = round(($b2b_data * 100) / ($b2b_data + $b2c_data));
                $array_b2b_ratio1 = round(($b2b_data * 100) / ($b2b_data + $b2c_data));
                $array_b2c_ratio[] = round(($b2c_data * 100) / ($b2b_data + $b2c_data));
                $array_b2c_ratio1 = round(($b2c_data * 100) / ($b2b_data + $b2c_data));
                $data .= '<tr>' .
                        '<td>' . $k . '</td>' .
                        '<td>' . $months . '</td>' .
                        '<td>' . $b2b_data . '</td>' .
                        '<td>' . $b2c_data . '</td>' .
                        '<td>' . $array_b2b_ratio1 . '</td>' .
                        '<td>' . $array_b2c_ratio1 . '</td>' .
                        '</tr>';
                $k++;
            }
            $data .= '<tr>' .
                    '<td>' . '<b>Total</b>' . '</td>' .
                    '<td>' . '' . '</td>' .
                    '<td>' . '<b>' . array_sum($array_b2b) . '</b> ' . '</td>' .
                    '<td>' . '<b>' . array_sum($array_b2c) . '</b>' . '</td>' .
                    '<td>' . '<b>' . array_sum($array_b2b_ratio) . '</b>' . '</td>' .
                    '<td>' . '<b>' . array_sum($array_b2c_ratio) . '</b>' . '</td>' .
                    '</tr>';
            $data .= '</tbody></table></div></div></div>';
            $data .= "<hr><h4><b>Observation of Sales B2B and B2C:</b></h4>";
            $count = count($month);
            $array_b2b1 = array();
            $array_b2c1 = array();
            $array_b2b_ratio1 = array();
            $array_b2c_ratio1 = array();

            for ($i = 0; $i < $count; $i++) {
                $array_b2b1[] = $array_b2b[$i];
                $aa1 = settype($array_b2b1[$i], "float");

                $array_b2c1[] = $array_b2c[$i];
                $aa2 = settype($array_b2c1[$i], "float");

                $array_b2b_ratio1[] = $array_b2b_ratio[$i];
                $aa2 = settype($array_b2b_ratio1[$i], "float");

                $array_b2c_ratio1[] = $array_b2c_ratio[$i];
                $aa2 = settype($array_b2c_ratio1[$i], "float");
            }
            // to get max value for range
            $arr = array($array_b2c1, $array_b2b1);
            $max_range = 0;
            foreach ($arr as $val) {
                foreach ($val as $key => $val1) {
                    if ($val1 > $max_range) {
                        $max_range = $val1;
                    }
                }
            }

            // to get max value for ratio
            $arr1 = array($array_b2b_ratio1, $array_b2b_ratio1);
            $max_ratio = 0;
            foreach ($arr1 as $val1) {
                foreach ($val1 as $key => $val11) {
                    if ($val11 > $max_ratio) {
                        $max_ratio = $val11;
                    }
                }
            }
            //function to get customer name
            $quer2 = $this->db->query("SELECT customer_name from customer_header_all where customer_id='$customer_id'");

            if ($quer2->num_rows() > 0) {
                $res2 = $quer2->row();
                $customer_name = $res2->customer_name;
            }
            $response['data'] = $data;
            $response['message'] = "success";
            $response['array_b2b'] = $array_b2b1;  // B2B data
            $response['array_b2c'] = $array_b2c1;  // B2Cs data
            $response['array_b2b_ratio'] = $array_b2b_ratio1;  // B2Cs data
            $response['array_b2c_ratio'] = $array_b2c_ratio1;  // B2Cs data
            $response['month'] = $month;  // month data
            $response['max_range'] = $max_range;  // Max Range
            $response['max_ratio'] = $max_ratio;  // Max Ratio
            $response['customer_name'] = $customer_name;  // Customer
        } else {
            $response['data'] = "";
            $response['message'] = "";
            $response['array_b2b'] = "";  // B2B data
            $response['array_b2c'] = "";  // B2Cs data
            $response['month'] = "";  // month data
            $response['max_range'] = 0;
        }echo json_encode($response);
    }

}

?>