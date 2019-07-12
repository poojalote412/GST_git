<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Test extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Cfo_model');
    }

    function index() {


        $this->load->view('customer/test');
    }

    public function import_excel() {

        $values = 1;
        $vall = 1;
        if (isset($_FILES["file_ex"]["name"])) {
            $path = $_FILES["file_ex"]["tmp_name"];
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
            $month_data = $this->get_months($months);
            $value11 = 0;
            $anew = 0;


            $get_total_non_gst = "";
            $total_taxable_data_interstate = "";
            $total_tax_data_interstate = "";
            $total_taxable_data_intrastate = "";
            $total_tax_data_intrastate = "";
            $get_SUB_total_non_gst = "";
            $get_SUB_total_exempt = "";
            $total_debit_data = "";
            $total_debit_tax_data = "";
            $total_credit_data = "";
            $total_credit_tax_data = "";

            $credit_b2b = "";
            $debit_b2b = "";
            $intrastate_b2c = "";
            $intrastate_b2b = "";
            $total_b2c_interstate = "";
            $total_b2b_interstate = "";
            $get_credit_b2c = "";
            $get_debit_b2c = "";
            for ($i = 1; $i <= $highestRow; $i++) {
                $a_new2 = $object->getActiveSheet()->getCell('A' . $i)->getValue();
                if ($a_new2 == "(2) Total value of supplies on which GST paid (intra-State Supplies [Other than Deemed Export])") {
                    $anew = 1;
                    $anew1 = 1;
                } else if ($a_new2 == "(3) Value of Other Supplies on which no GST paid") {
                    $anew1 = 2;
                    $anew = 2;
                }

                //for get value between credit note and debit note
                $aa2 = $object->getActiveSheet()->getCell('A' . $i)->getValue();
                if ($aa2 == "(4) Cr Note Details") {
                    $value11 = 1;
                } else if ($aa2 == "(5) Dr Note Details") {
                    $value11 = 2;
                }
                //code for monthly data of total taxable and total tax value start
                $row_prev = $i - 1;

                if ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "Total" && $object->getActiveSheet()->getCell('B' . $row_prev)->getValue() == "Sub Total (B2CS)") {
                    $highestColumn_row = $worksheet->getHighestColumn($i);
                    if ($object->getActiveSheet()->getCell($highestColumn_row . $i)->getValue() == "" && $object->getActiveSheet()->getCell($highestColumn_row . $i)->getValue() != '0') {
                        $get_inter_state_total = $this->get_inter_state_total_fun($highestColumn_row, $i, $object); //function to get interstate data
                        $total_taxable_data_interstate = $get_inter_state_total[0]; //taxable value data
                        $total_tax_data_interstate = $get_inter_state_total[1]; //tax value data
                    } else {
                        $highest_value = $worksheet->getHighestColumn($i);
                        $get_intra_state_total = $this->get_intra_state_total($highest_value, $i, $object); //function to get intrastate data
                        $total_taxable_data_intrastate = $get_intra_state_total[0]; //taxable value data
                        $total_tax_data_intrastate = $get_intra_state_total[1]; //tax value data
                    }
                } elseif ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "Total" && $object->getActiveSheet()->getCell('B' . $row_prev)->getValue() == "Sub Total (NON-GST)") { // no gst data
                    $highestColumn_row_ng = $worksheet->getHighestColumn($i);
                    $char = 'G';
                    $get_total_non_gst = $this->get_no_gst_data($highestColumn_row_ng, $char, $object, $i); //function to get non gst data
                } elseif ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "Sub Total (NON-GST)") { // Sub Total (NON-GST) DATA
                    $highestColumn_row_sbng = $worksheet->getHighestColumn($i);
                    $get_SUB_total_non_gst = $this->sub_total_non_gst($highestColumn_row_sbng, $object, $i);
                } elseif ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "Sub Total (EXEMPTED)") { // Sub Total (EXEMPTED) DATA
                    $highestColumn_row_sbng = $worksheet->getHighestColumn($i);
                    $get_SUB_total_exempt = $this->sub_total_non_gst($highestColumn_row_sbng, $object, $i);
                } elseif ($object->getActiveSheet()->getCell('A' . $i)->getValue() == "(5) Dr Note Details") {  // debit note data
                    $get_debit_note_total = $this->get_debit_data($i, $object, $highestRow, $worksheet);
                    $total_debit_data = $get_debit_note_total[0]; //taxable value data of debit note
                    $total_debit_tax_data = $get_debit_note_total[1]; //tax value data of debit note
                } elseif ($object->getActiveSheet()->getCell('A' . $i)->getValue() == "(4) Cr Note Details") {  //credit note data
                    $get_credit_note_total = $this->get_credit_data($i, $object, $highestRow, $worksheet);
                    $total_credit_data = $get_credit_note_total[0]; //taxable value data of credit note
                    $total_credit_tax_data = $get_credit_note_total[1]; //tax value data of credit note
                } else {
                    
                }
                //code for monthly data of total taxable and total tax value end
                //code for monthly B2B and B2Cs values start

                if ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "Sub Total (B2B)") {
                    $highestColumn_row = $worksheet->getHighestColumn($i);
                    if ($object->getActiveSheet()->getCell($highestColumn_row . $i)->getValue() == "" && $object->getActiveSheet()->getCell($highestColumn_row . $i)->getValue() != '0') {
                        $get_inter_state_total_b2b = $this->get_inter_state_total_fun($highestColumn_row, $i, $object); //function to get interstate data
                        $total_b2b_interstate = $get_inter_state_total_b2b[0]; //B2B intersate data 
                    } else {
                        // intra state b2b values
                        if ($anew == 1) {
                            $intrastate_b2b = $this->intrastate_b2b_fun($worksheet, $object, $i); // intra state b2b values
                        } elseif ($value11 == 1) {
                            $credit_b2b = $this->credit_b2b_fun($worksheet, $object, $i); // Credit b2b values
                        } else {
                            $debit_b2b = $this->debit_b2b_fun($worksheet, $object, $i); //Debit b2b values
                        }
                    }
                } elseif ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "Sub Total (B2CS)") { //interstate
                    $highestColumn_row = $worksheet->getHighestColumn($i);
                    if ($object->getActiveSheet()->getCell($highestColumn_row . $i)->getValue() == "" && $object->getActiveSheet()->getCell($highestColumn_row . $i)->getValue() != '0') {

                        $get_inter_state_total_b2c = $this->get_inter_state_total_fun($highestColumn_row, $i, $object); //function to get interstate data
                        $total_b2c_interstate = $get_inter_state_total_b2c[0]; //B2C intersate data 
                    } else {
                        if ($anew == 1) {
                            $intrastate_b2c = $this->intrastate_b2b_fun($worksheet, $object, $i); // intra state b2c values
                        }
                    }
                } elseif ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "(4) Cr Note Details") {
                    for ($j = $i; $j <= $highestRow; $j++) {
                        if ($object->getActiveSheet()->getCell('B' . $j)->getValue() == "Sub Total (B2CS)") {
                            $get_credit_b2c = $this->get_credit_debit_b2c($j, $worksheet, $object); //credit b2c data
                        }
                    }
                } elseif ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "(5) Dr Note Details") {
                    for ($j = $i; $j <= $highestRow; $j++) {
                        if ($object->getActiveSheet()->getCell('B' . $j)->getValue() == "Sub Total (B2CS)") {
                            $get_debit_b2c = $this->get_credit_debit_b2c($j, $worksheet, $object); //debit b2c data
                        }
                    }
                } else {
                    
                }

                //code for monthly B2B and B2Cs values end
            }

            //insert data into database
            $month_data_arr = $month_data; //array of month data
            $count = count($month_data_arr);

            $cusomer_id = 'cust_1002';
            $year_id = 'insert_1002';
            for ($t = 0; $t < $count; $t++) {
                if ($get_debit_b2c == "" or $get_debit_b2c == NULL) {
                    $get_debit_b2c1 = array();
                    $get_debit_b2c1[$t] = 0; //array of inter state supply
                } else {
                    $get_debit_b2c1 = $get_debit_b2c; //array of inter state supply
                }if ($get_credit_b2c == "" or $get_credit_b2c == NULL) {
                    $get_credit_b2c1 = array();
                    $get_credit_b2c1[$t] = 0; //array of inter state supply
                } else {
                    $get_credit_b2c1 = $get_credit_b2c; //array of inter state supply
                }if ($total_taxable_data_interstate == "" or $total_taxable_data_interstate == NULL) {
                    $total_taxable_data_interstate1 = array();
                    $total_taxable_data_interstate1[$t] = 0; //array of inter state supply
                } else {
                    $total_taxable_data_interstate1 = $total_taxable_data_interstate; //array of inter state supply
                }if ($total_taxable_data_intrastate == "" or $total_taxable_data_intrastate == NULL) {
                    $total_taxable_data_intrastate1 = array();
                    $total_taxable_data_intrastate1[$t] = 0; //array of inter state supply
                } else {
                    $total_taxable_data_intrastate1 = $total_taxable_data_intrastate; //array of inter state supply
                }if ($get_total_non_gst == "" or $get_total_non_gst == NULL) {
                    $get_total_non_gst1 = array();
                    $get_total_non_gst1[$t] = 0; //array of inter state supply
                } else {
                    $get_total_non_gst1 = $get_total_non_gst; //array of inter state supply
                }if ($total_debit_data == "" or $total_debit_data == NULL) {
                    $total_debit_data1 = array();
                    $total_debit_data1[$t] = 0; //array of inter state supply
                } else {
                    $total_debit_data1 = $total_debit_data; //array of inter state supply
                }if ($total_credit_data == "" or $total_credit_data == NULL) {
                    $total_credit_data1 = array();
                    $total_credit_data1[$t] = 0; //array of inter state supply
                } else {
                    $total_credit_data1 = $total_credit_data; //array of inter state supply
                }if ($get_SUB_total_non_gst == "" or $get_SUB_total_non_gst == NULL) {
                    $get_SUB_total_non_gst1 = array();
                    $get_SUB_total_non_gst1[$t] = 0; //array of inter state supply
                } else {
                    $get_SUB_total_non_gst1 = $get_SUB_total_non_gst; //array of inter state supply
                }if ($get_SUB_total_exempt == "" or $get_SUB_total_exempt == NULL) {
                    $get_SUB_total_exempt1 = array();
                    $get_SUB_total_exempt1[$t] = 0; //array of inter state supply
                } else {
                    $get_SUB_total_exempt1 = $get_SUB_total_exempt; //array of inter state supply
                }if ($total_tax_data_interstate == "" or $total_tax_data_interstate == NULL) {
                    $total_tax_data_interstate1 = array();
                    $total_tax_data_interstate1[$t] = 0; //array of inter state supply
                } else {
                    $total_tax_data_interstate1 = $total_tax_data_interstate; //array of inter state supply
                }if ($total_tax_data_intrastate == "" or $total_tax_data_intrastate === NULL) {
                    $total_tax_data_intrastate1 = array();
                    $total_tax_data_intrastate1[$t] = 0; //array of inter state supply
                } else {
                    $total_tax_data_intrastate1 = $total_tax_data_intrastate; //array of inter state supply
                }if ($total_debit_tax_data == "" or $total_debit_tax_data == NULL) {
                    $total_debit_tax_data1 = array();
                    $total_debit_tax_data1[$t] = 0; //array of inter state supply
                } else {
                    $total_debit_tax_data1 = $total_debit_tax_data; //array of inter state supply
                }if ($total_credit_tax_data == "" or $total_credit_tax_data == NULL) {
                    $total_credit_tax_data1 = array();
                    $total_credit_tax_data1[$t] = 0; //array of inter state supply
                } else {
                    $total_credit_tax_data1 = $total_credit_tax_data; //array of inter state supply
                }if ($total_b2b_interstate == "" or $total_b2b_interstate == NULL) {
                    $total_b2b_interstate1 = array();
                    $total_b2b_interstate1[$t] = 0; //array of inter state supply
                } else {
                    $total_b2b_interstate1 = $total_b2b_interstate; //array of inter state supply
                }if ($intrastate_b2b == "" or $intrastate_b2b == NULL) {
                    $intrastate_b2b1 = array();
                    $intrastate_b2b1[$t] = 0; //array of inter state supply
                } else {
                    $intrastate_b2b1 = $intrastate_b2b; //array of inter state supply
                }if ($total_b2c_interstate == "" or $total_b2c_interstate == NULL) {
                    $total_b2c_interstate1 = array();
                    $total_b2c_interstate1[$t] = 0; //array of inter state supply
                } else {
                    $total_b2c_interstate1 = $total_b2c_interstate; //array of inter state supply
                }if ($intrastate_b2c == "" or $intrastate_b2c == NULL) {
                    $intrastate_b2c1 = array();
                    $intrastate_b2c1[$t] = 0; //array of inter state supply
                } else {
                    $intrastate_b2c1 = $intrastate_b2c; //array of inter state supply
                }if ($credit_b2b == "" or $credit_b2b == NULL) {
                    $credit_b2b1 = array();
                    $credit_b2b1[$t] = 0; //array of inter state supply
                } else {
                    $credit_b2b1 = $credit_b2b; //array of inter state supply
                }if ($debit_b2b == "" or $debit_b2b == NULL) {
                    $debit_b2b1 = array();
                    $debit_b2b1[$t] = 0; //array of inter state supply
                } else {
                    $debit_b2b1 = $debit_b2b; //array of inter state supply
                }

                $quer = $this->db->query("insert into monthly_summary_all (`customer_id`,`insert_id`,`month`,`inter_state_supply`,`intra_state_supply`,`no_gst_paid_supply`,`debit_value`,"
                        . "`credit_value`,`sub_total_non_gst`,`sub_total_exempt`,`tax_inter_state`,`tax_intra_state`,`tax_debit`,`tax_credit`,`interstate_b2b`,`intrastate_b2b`,`interstate_b2c`,"
                        . "`intrastate_b2c`,`credit_b2b`,`credit_b2c`,`debit_b2b`,`debit_b2c`)"
                        . " values ('$cusomer_id','$year_id','$month_data_arr[$t]','$total_taxable_data_interstate1[$t]','$total_taxable_data_intrastate1[$t]','$get_total_non_gst1[$t]',"
                        . "'$total_debit_data1[$t]','$total_credit_data1[$t]','$get_SUB_total_non_gst1[$t]','$get_SUB_total_exempt1[$t]','$total_tax_data_interstate1[$t]',"
                        . "'$total_tax_data_intrastate1[$t]','$total_debit_tax_data1[$t]','$total_credit_tax_data1[$t]','$total_b2b_interstate1[$t]','$intrastate_b2b1[$t]'"
                        . ",'$total_b2c_interstate1[$t]','$intrastate_b2c1[$t]','$credit_b2b1[$t]','$get_credit_b2c1[$t]','$debit_b2b1[$t]','$get_debit_b2c1[$t]') ");

                if ($this->db->affected_rows() > 0) {
                    $vall++;
                }
            }
        }

        if (isset($_FILES["file_ex1"]["name"])) {
            $path1 = $_FILES["file_ex1"]["tmp_name"];
            $this->load->library('excel');
            $object1 = PHPExcel_IOFactory::load($path1);
            $worksheet1 = $object1->getActiveSheet();
            $highestRow1 = $worksheet1->getHighestRow();
            $highestColumn1 = $worksheet1->getHighestColumn();
            if ($object1->getActiveSheet()->getCell('B' . 3)->getValue() === "F.Y. : 2017-2018") {
                $month = array();
                $liability_on_outward = array();
                for ($l = 10; $l <= 18; $l++) {
                    $month[] = $object1->getActiveSheet()->getCell('B' . $l)->getValue();
                    $val = $object1->getActiveSheet()->getCell('F' . $l)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('G' . $l)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('H' . $l)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('I' . $l)->getValue();
                    $liability_on_outward[] = $val + $val1 + $val2 + $val3;
//                    var_dump($liability_on_outward);
//                    print_r($liability_on_outward);
                }
                $rcm_liability = array();
                for ($m = 27; $m <= 35; $m++) {
                    $val = $object1->getActiveSheet()->getCell('F' . $m)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('G' . $m)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('H' . $m)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('I' . $m)->getValue();
                    $rcm_liability[] = $val + $val1 + $val2 + $val3;
//                     print_r($rcm_liability);
                }

                $itc_ineligible = array();
                for ($n = 44; $n <= 52; $n++) {
                    $val = $object1->getActiveSheet()->getCell('P' . $n)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('Q' . $n)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('R' . $n)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('S' . $n)->getValue();
                    $itc_ineligible[] = $val + $val1 + $val2 + $val3;
//                     print_r($itc_ineligible);
                }

                $net_rtc = array();
                for ($o = 44; $o <= 52; $o++) {
                    $val = $object1->getActiveSheet()->getCell('D' . $o)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('E' . $o)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('F' . $o)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('G' . $o)->getValue();
                    $val4 = $object1->getActiveSheet()->getCell('H' . $o)->getValue();
                    $val5 = $object1->getActiveSheet()->getCell('I' . $o)->getValue();
                    $val6 = $object1->getActiveSheet()->getCell('J' . $o)->getValue();
                    $val7 = $object1->getActiveSheet()->getCell('K' . $o)->getValue();
                    $net_rtc[] = $val + $val1 + $val2 + $val3 + $val4 + $val5 + $val6 + $val7;
//                    print_r($net_rtc);
                }


                $paid_in_credit = array();
                for ($p = 10; $p <= 18; $p++) {
                    $val = $object1->getActiveSheet()->getCell('J' . $p)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('K' . $p)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('L' . $p)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('M' . $p)->getValue();
                    $paid_in_credit[] = $val + $val1 + $val2 + $val3;
//                     print_r($paid_in_credit);
                }


                $paid_in_cash1 = array();
                for ($q = 10; $q <= 18; $q++) {
                    $val = $object1->getActiveSheet()->getCell('N' . $q)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('O' . $q)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('P' . $q)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('Q' . $q)->getValue();
                    $paid_in_cash1[] = $val + $val1 + $val2 + $val3;
//                     print_r($paid_in_cash1);
                }

                $paid_in_cash2 = array();
                for ($r = 27; $r <= 35; $r++) {
                    $val = $object1->getActiveSheet()->getCell('J' . $r)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('K' . $r)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('L' . $r)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('M' . $r)->getValue();
                    $paid_in_cash2[] = $val + $val1 + $val2 + $val3;
                }

                //Sum of above two array
                $paid_in_cash = array_map(function () {
                    return array_sum(func_get_args());
                }, $paid_in_cash1, $paid_in_cash2);


                $interest_late_fees = array();
                for ($s = 27; $s <= 35; $s++) {
                    $val = $object1->getActiveSheet()->getCell('N' . $s)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('O' . $s)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('P' . $s)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('Q' . $s)->getValue();
                    $val4 = $object1->getActiveSheet()->getCell('R' . $s)->getValue();
                    $val5 = $object1->getActiveSheet()->getCell('S' . $s)->getValue();
                    $interest_late_fees[] = $val + $val1 + $val2 + $val3 + $val4 + $val5;
//                    print_r($interest_late_fees);
                }

                $due_date = array();
                for ($t = 10; $t <= 18; $t++) {
                    $val = $object1->getActiveSheet()->getCell('R' . $t)->getValue();
                    $due_date[] = $val;
//                    print_r($due_date);
                }
                $filling_date = array();
                for ($u = 10; $u <= 18; $u++) {
                    $val = $object1->getActiveSheet()->getCell('S' . $u)->getValue();
                    $filling_date[] = $val;
//                    print_r($interest_late_fees);
                }
                $late_fees = array();
                for ($v = 27; $v <= 35; $v++) {
                    $val = $object1->getActiveSheet()->getCell('R' . $v)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('S' . $v)->getValue();
                    $filling_date[] = $val + $val1;
//                    print_r($interest_late_fees);
                }
            } else {
                $liability_on_outward = array();
                for ($l = 7; $l <= 18; $l++) {
//                    $month[];
                    $val = $object1->getActiveSheet()->getCell('F' . $l)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('G' . $l)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('H' . $l)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('I' . $l)->getValue();
                    $liability_on_outward[] = $val + $val1 + $val2 + $val3;
//                    var_dump($liability_on_outward);
//                    print_r($liability_on_outward);
                }

                $rcm_liability = array();
                for ($m = 24; $m <= 35; $m++) {
                    $val = $object1->getActiveSheet()->getCell('F' . $m)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('G' . $m)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('H' . $m)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('I' . $m)->getValue();
                    $rcm_liability[] = $val + $val1 + $val2 + $val3;
//                     print_r($rcm_liability);
                }
                $itc_ineligible = array();
                for ($n = 41; $n <= 52; $n++) {
                    $val = $object1->getActiveSheet()->getCell('P' . $n)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('Q' . $n)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('R' . $n)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('S' . $n)->getValue();
                    $itc_ineligible[] = $val + $val1 + $val2 + $val3;
//                     print_r($itc_ineligible);
                }

                $net_rtc = array();
                for ($o = 41; $o <= 52; $o++) {
                    $val = $object1->getActiveSheet()->getCell('D' . $o)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('E' . $o)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('F' . $o)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('G' . $o)->getValue();
                    $val4 = $object1->getActiveSheet()->getCell('H' . $o)->getValue();
                    $val5 = $object1->getActiveSheet()->getCell('I' . $o)->getValue();
                    $val6 = $object1->getActiveSheet()->getCell('J' . $o)->getValue();
                    $val7 = $object1->getActiveSheet()->getCell('K' . $o)->getValue();
                    $net_rtc[] = $val + $val1 + $val2 + $val3 + $val4 + $val5 + $val6 + $val7;
//                    print_r($net_rtc);
                }

                $paid_in_credit = array();
                for ($p = 7; $p <= 18; $p++) {
                    $val = $object1->getActiveSheet()->getCell('J' . $p)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('K' . $p)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('L' . $p)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('M' . $p)->getValue();
                    $paid_in_credit[] = $val + $val1 + $val2 + $val3;
//                     print_r($paid_in_credit);
                }

                $paid_in_cash1 = array();
                for ($q = 7; $q <= 18; $q++) {
                    $val = $object1->getActiveSheet()->getCell('N' . $q)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('O' . $q)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('P' . $q)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('Q' . $q)->getValue();
                    $paid_in_cash1[] = $val + $val1 + $val2 + $val3;
//                     print_r($paid_in_cash1);
                }

                $paid_in_cash2 = array();
                for ($r = 24; $r <= 35; $r++) {
                    $val = $object1->getActiveSheet()->getCell('N' . $r)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('O' . $r)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('P' . $r)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('Q' . $r)->getValue();
                    $paid_in_cash2[] = $val + $val1 + $val2 + $val3;
                }
//                $c = array_map(function () {
//    return array_sum(func_get_args());
//            }, $paid_in_cash1, $paid_in_cash2);
//               print_r($c); 

                $interest_late_fees = array();
                for ($s = 24; $s <= 35; $s++) {
                    $val = $object1->getActiveSheet()->getCell('N' . $s)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('O' . $s)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('P' . $s)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('Q' . $s)->getValue();
                    $val4 = $object1->getActiveSheet()->getCell('R' . $s)->getValue();
                    $val5 = $object1->getActiveSheet()->getCell('S' . $s)->getValue();
                    $interest_late_fees[] = $val + $val1 + $val2 + $val3 + $val4 + $val5;
//                    print_r($interest_late_fees);
                }

                $due_date = array();
                for ($t = 7; $t <= 18; $t++) {
                    $val = $object1->getActiveSheet()->getCell('R' . $t)->getValue();
                    $due_date[] = $val;
//                    print_r($due_date);
                }

                $filling_date = array();
                for ($u = 7; $u <= 18; $t++) {
                    $val1 = $object1->getActiveSheet()->getCell('S' . $u)->getValue();
                    $old_date_timestamp = strtotime($val1);
                    $val = date('Y-m-d', $old_date_timestamp);
                    $filling_date[] = $val;
//                    print_r($interest_late_fees);
                }

                $late_fees = array();
                for ($v = 24; $v <= 35; $v++) {
                    $val = $object1->getActiveSheet()->getCell('R' . $v)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('S' . $v)->getValue();
                    $filling_date[] = $val + $val1;
//                    print_r($interest_late_fees);
                }
            }
            $count = count($month);
//            var_dump($itc_ineligible);
//            exit;
            for ($m = 0; $m < $count; $m++) {
                if ($month == "" or $month == NULL) {
                    $month = array();
                    $month1[$m] = 0;
                } else {
                    $month1 = $month;
                }
                if ($liability_on_outward == "" or $liability_on_outward == NULL) {
                    $liability_on_outward = array();
                    $liability_on_outward1[$m] = 0;
                } else {
                    $liability_on_outward1 = $liability_on_outward;
                }
                if ($rcm_liability == "" or $rcm_liability == NULL) {
                    $rcm_liability = array();
                    $rcm_liability1[$m] = 0;
                } else {
                    $rcm_liability1 = $rcm_liability;
                }
                if ($itc_ineligible == "" or $itc_ineligible == NULL) {
                    $itc_ineligible = array();
                    $itc_ineligible1[$m] = 0;
                } else {
                    $itc_ineligible1 = $itc_ineligible;
                }
                if ($net_rtc == "" or $net_rtc == NULL) {
                    $net_rtc = array();
                    $net_rtc1[$m] = 0;
                } else {
                    $net_rtc1 = $net_rtc;
                }
                if ($paid_in_credit == "" or $paid_in_credit == NULL) {
                    $paid_in_credit = array();
                    $paid_in_credit1[$m] = 0;
                } else {
                    $paid_in_credit1 = $paid_in_credit;
                }
                if ($paid_in_cash == "" or $paid_in_cash == NULL) {
                    $paid_in_cash = array();
                    $paid_in_cash1[$m] = 0;
                } else {
                    $paid_in_cash1 = $paid_in_cash;
                }
                if ($interest_late_fees == "" or $interest_late_fees == NULL) {
                    $interest_late_fees = array();
                    $interest_late_fees1[$m] = 0;
                } else {
                    $interest_late_fees1 = $interest_late_fees;
                }

                if ($due_date == "" or $due_date == NULL) {
                    $due_date = array();
                    $due_date1[$m] = 0;
                } else {
                    $due_date1 = $due_date;
                }
                if ($filling_date == "" or $filling_date == NULL) {
                    $filling_date = array();
                    $filling_date1[$m] = 0;
                } else {
                    $filling_date1 = $filling_date;
                }
                if ($late_fees == "" or $late_fees == NULL) {
                    $late_fees = array();
                    $late_fees1[$m] = 0;
                } else {
                    $late_fees1 = $late_fees;
                }

                $quer3B_offset = $this->db->query("insert into 3b_offset_summary_all (`month`,`outward_liability`,`rcb_liablity`,`ineligible_itc`,`net_itc`,`paid_in_credit`,`paid_in_cash`,`interest_late_fee`,`late_fees`,`due_date`,`filling_date`)"
                        . " values ('$month1[$m]','$liability_on_outward1[$m]','$rcm_liability1[$m]','$itc_ineligible1[$m]','$net_rtc1[$m]','$paid_in_credit1[$m]','$paid_in_cash1[$m]','$interest_late_fees1[$m]','$late_fees1[$m]','$due_date1[$m]','$filling_date1[$m]')");

                if ($this->db->affected_rows() > 0) {
                    $values++;
                }
            }
        }

        $compare_val = 1;
        if (isset($_FILES["file_ex_compare"]["name"])) {
            $path2 = $_FILES["file_ex_compare"]["tmp_name"];
            $this->load->library('excel');
            $function_compare_summary = $this->compare_summary_function($path2, $compare_val);
        }

        if ($vall > 1 && $values > 1 && $function_compare_summary > 1) {
            $response['message'] = "success";
            $response['status'] = true;
            $response['code'] = 200;
        } else {
            $response['message'] = "";
            $response['status'] = FALSE;
            $response['code'] = 204;
        }
        echo json_encode($response);
    }

    public function compare_summary_function($path2, $compare_val) {
        $x = "A";
        $object = PHPExcel_IOFactory::load($path2);
        $worksheet = $object->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();
        $i = 1;
        $abc = 0;
        $month_name = array();
        $gstr_3b = array();
        $gstr_1 = array();
        $gstr_1_ammend = array();
        $ammend_diff1 = array();
        $cummulative_diff_1 = array();
        $gstr_3b_2a = array();
        $gstr_2a = array();
        $gstr_Difference_2a = array();
        $cumm_diff_2a = array();

        for ($row = 21; $row <= $highestRow; $row++) {

            $row_next = $row + 1;

            if ($object->getActiveSheet()->getCell($x . $row)->getValue() == "GSTR-3B" && $object->getActiveSheet()->getCell($x . $row_next)->getValue() == "GSTR-1") {
                $ascii = ord($x);
                $ascii += 2;
                $col_IGST = chr($ascii);
                $IGST_gstr3b = $object->getActiveSheet()->getCell($col_IGST . $row)->getValue();

                $ascii_cgst = ord($x);
                $ascii_cgst += 3;
                $col_CGST = chr($ascii_cgst);
                $CGST_gstr3b = $object->getActiveSheet()->getCell($col_CGST . $row)->getValue();

                $ascii_sgst = ord($x);
                $ascii_sgst += 3;
                $col_SGST = chr($ascii_sgst);
                $SGST_gstr3b = $object->getActiveSheet()->getCell($col_SGST . $row)->getValue();
                $gstr_3b[] = $IGST_gstr3b + $CGST_gstr3b + $SGST_gstr3b;
                $row_month = $row - 3;
                $month_name[] = $object->getActiveSheet()->getCell($x . $row_month)->getValue();
            } else {
                
            }
            if ($object->getActiveSheet()->getCell($x . $row)->getValue() == "GSTR-1") {
                $ascii = ord($x);
                $ascii += 2;
                $col_IGST = chr($ascii);
                $IGST_gstr1 = $object->getActiveSheet()->getCell($col_IGST . $row)->getValue();

                $ascii_cgst = ord($x);
                $ascii_cgst += 3;
                $col_CGST = chr($ascii_cgst);
                $CGST_gstr1 = $object->getActiveSheet()->getCell($col_CGST . $row)->getValue();

                $ascii_sgst = ord($x);
                $ascii_sgst += 3;
                $col_SGST = chr($ascii_sgst);
                $SGST_gstr1 = $object->getActiveSheet()->getCell($col_SGST . $row)->getValue();
                $gstr_1[] = $IGST_gstr1 + $CGST_gstr1 + $SGST_gstr1;
            } else {
                
            }

            if ($object->getActiveSheet()->getCell($x . $row)->getValue() == "GSTR-1 Amend(Difference)") {
                $ascii = ord($x);
                $ascii += 2;
                $col_IGST = chr($ascii);
                $IGST_gstr1_ammend = $object->getActiveSheet()->getCell($col_IGST . $row)->getValue();

                $ascii_cgst = ord($x);
                $ascii_cgst += 3;
                $col_CGST = chr($ascii_cgst);
                $CGST_gstr1_ammend = $object->getActiveSheet()->getCell($col_CGST . $row)->getValue();

                $ascii_sgst = ord($x);
                $ascii_sgst += 3;
                $col_SGST = chr($ascii_sgst);
                $SGST_gstr1_ammend = $object->getActiveSheet()->getCell($col_SGST . $row)->getValue();
                $gstr_1_ammend[] = $IGST_gstr1_ammend + $CGST_gstr1_ammend + $SGST_gstr1_ammend;
            } else {
                
            }
            if ($object->getActiveSheet()->getCell($x . $row)->getValue() == "(3B - (GSTR-1 + Amend)) Difference") {
                $ascii = ord($x);
                $ascii += 2;
                $col_IGST = chr($ascii);
                $IGST_gstr1_ammend_diff = $object->getActiveSheet()->getCell($col_IGST . $row)->getValue();

                $ascii_cgst = ord($x);
                $ascii_cgst += 3;
                $col_CGST = chr($ascii_cgst);
                $CGST_gstr1_ammend_diff = $object->getActiveSheet()->getCell($col_CGST . $row)->getValue();

                $ascii_sgst = ord($x);
                $ascii_sgst += 3;
                $col_SGST = chr($ascii_sgst);
                $SGST_gstr1_ammend_diff = $object->getActiveSheet()->getCell($col_SGST . $row)->getValue();
                $ammend_diff1[] = $IGST_gstr1_ammend_diff + $CGST_gstr1_ammend_diff + $SGST_gstr1_ammend_diff;
            } else {
                
            }
            if ($object->getActiveSheet()->getCell($x . $row)->getValue() == "Cumulative Difference" && $object->getActiveSheet()->getCell($x . $row_next)->getValue() == "4 Eligible ITC") {
                $ascii = ord($x);
                $ascii += 2;
                $col_IGST = chr($ascii);
                $IGST_gstr1_ammend_cummu_diff = $object->getActiveSheet()->getCell($col_IGST . $row)->getValue();

                $ascii_cgst = ord($x);
                $ascii_cgst += 3;
                $col_CGST = chr($ascii_cgst);
                $CGST_gstr1_ammend_cummu_diff = $object->getActiveSheet()->getCell($col_CGST . $row)->getValue();

                $ascii_sgst = ord($x);
                $ascii_sgst += 3;
                $col_SGST = chr($ascii_sgst);
                $SGST_gstr1_ammend_cummu_diff = $object->getActiveSheet()->getCell($col_SGST . $row)->getValue();
                $cummulative_diff_1[] = $IGST_gstr1_ammend_cummu_diff + $CGST_gstr1_ammend_cummu_diff + $SGST_gstr1_ammend_cummu_diff;

                $i++;
                $count = $i - 1;
            }
        }
        for ($row = 26; $row <= $highestRow; $row++) {
            $row_next = $row + 1;
            $row_prev = $row - 1;
            if ($object->getActiveSheet()->getCell($x . $row)->getValue() == "4 Eligible ITC" && $object->getActiveSheet()->getCell($x . $row_next)->getValue() == "GSTR-3B") {
                $ascii = ord($x);
                $ascii += 2;
                $col_IGST = chr($ascii);

                $IGST_gstr3b = $object->getActiveSheet()->getCell($col_IGST . $row_next)->getValue();

                $ascii_cgst = ord($x);
                $ascii_cgst += 3;
                $col_CGST = chr($ascii_cgst);
                $CGST_gstr3b = $object->getActiveSheet()->getCell($col_CGST . $row_next)->getValue();

                $ascii_sgst = ord($x);
                $ascii_sgst += 3;
                $col_SGST = chr($ascii_sgst);
                $SGST_gstr3b = $object->getActiveSheet()->getCell($col_SGST . $row_next)->getValue();
                $gstr_3b_2a[] = $IGST_gstr3b + $CGST_gstr3b + $SGST_gstr3b;
                $row_month = $row - 8;
                // $month_name = $object->getActiveSheet()->getCell($x . $row_month)->getValue();
            } else {
                
            }

            if ($object->getActiveSheet()->getCell($x . $row)->getValue() == "GSTR-2A") {
                $ascii = ord($x);
                $ascii += 2;
                $col_IGST = chr($ascii);
                $IGST_gstr2a = $object->getActiveSheet()->getCell($col_IGST . $row)->getValue();

                $ascii_cgst = ord($x);
                $ascii_cgst += 3;
                $col_CGST = chr($ascii_cgst);
                $CGST_gstr2a = $object->getActiveSheet()->getCell($col_CGST . $row)->getValue();

                $ascii_sgst = ord($x);
                $ascii_sgst += 3;
                $col_SGST = chr($ascii_sgst);
                $SGST_gstr2a = $object->getActiveSheet()->getCell($col_SGST . $row)->getValue();
                $gstr_2a[] = $IGST_gstr2a + $CGST_gstr2a + $SGST_gstr2a;
            } else {
                
            }

            if ($object->getActiveSheet()->getCell($x . $row)->getValue() == "Difference") {
                $ascii = ord($x);
                $ascii += 2;
                $col_IGST = chr($ascii);
                $IGST_Difference = $object->getActiveSheet()->getCell($col_IGST . $row)->getValue();

                $ascii_cgst = ord($x);
                $ascii_cgst += 3;
                $col_CGST = chr($ascii_cgst);
                $CGST_Difference = $object->getActiveSheet()->getCell($col_CGST . $row)->getValue();

                $ascii_sgst = ord($x);
                $ascii_sgst += 3;
                $col_SGST = chr($ascii_sgst);
                $SGST_Difference = $object->getActiveSheet()->getCell($col_SGST . $row)->getValue();
                $gstr_Difference_2a[] = $IGST_Difference + $CGST_Difference + $SGST_Difference;
            } else {
                
            }
            if ($object->getActiveSheet()->getCell($x . $row)->getValue() == "Cumulative Difference" && $object->getActiveSheet()->getCell($x . $row_prev)->getValue() == "Difference") {
                $ascii = ord($x);
                $ascii += 2;
                $col_IGST = chr($ascii);
                $IGST_cumm_diff = $object->getActiveSheet()->getCell($col_IGST . $row)->getValue();

                $ascii_cgst = ord($x);
                $ascii_cgst += 3;
                $col_CGST = chr($ascii_cgst);
                $CGST_cumm_diff = $object->getActiveSheet()->getCell($col_CGST . $row)->getValue();

                $ascii_sgst = ord($x);
                $ascii_sgst += 3;
                $col_SGST = chr($ascii_sgst);
                $SGST_cumm_diff = $object->getActiveSheet()->getCell($col_SGST . $row)->getValue();
                $cumm_diff_2a[] = $IGST_cumm_diff + $CGST_cumm_diff + $SGST_cumm_diff;

                $count = $i;
                $i++;
            }


//            
        }
        $count = count($month_name);
        for ($i = 0; $i < $count; $i++) {
            $query_insert_compare = $this->db->query("insert into `comparison_summary_all` (`month`,`gstr1_3B`,`gstr1`,`gstr1_ammend`,`gstr1_difference`,`gstr1_cummulative`,"
                    . "`gstr2A_3B`,`gstr2A`,`gstr2A_difference`,`gstr2A_cummulative`) values"
                    . "('$month_name[$i]','$gstr_3b[$i]','$gstr_1[$i]','$gstr_1_ammend[$i]','$ammend_diff1[$i]','$cummulative_diff_1[$i]','$gstr_3b_2a[$i]','$gstr_2a[$i]','$gstr_Difference_2a[$i]','$cumm_diff_2a[$i]') ");

            if ($this->db->affected_rows() > 0) {
                $compare_val++;
            }
        }
        return $compare_val;
        // exit;
//        $gstr_3b_2a;
//        $gstr_2a;
//        $gstr_Difference_2a;
//        $cumm_diff_2a;
//        $month_name;
//        $gstr_3b;
//        $gstr_1;
//        $gstr_1_ammend;
//        $ammend_diff1;
//        $cummulative_diff_1;
    }

    public function debit_b2b_fun($worksheet, $object, $i) {
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
        $cnt1 = count($values_DR);
        $debit_b2b = array();
        for ($a_cr1 = 0; $a_cr1 < $cnt1; $a_cr1++) {
            $Dr_values = $values_DR[$a_cr1];
            $debit_b2b[] = $values_DR[$a_cr1];
            $a_cr1 = ($a_cr1 * 1 + 4);
        }
        return $debit_b2b;
    }

    public function credit_b2b_fun($worksheet, $object, $i) {
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
        return $credit_b2b;
    }

    public function intrastate_b2b_fun($worksheet, $object, $i) {
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
//                $data2 = $values1[$a12];
            $intrastate_b2b[] = $values1[$a12];
            $a12 = ($a12 * 1 + 3);
        }
        return $intrastate_b2b;
    }

    public function get_credit_debit_b2c($j, $worksheet, $object) {
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
        $cnt = count($cr_values);
        $credit_b2c = array();
        for ($a_dr11 = 0; $a_dr11 < $cnt; $a_dr11++) {
            $cr_values1 = $cr_values[$a_dr11];
            $credit_b2c[] = $cr_values[$a_dr11];
            $a_dr11 = ($a_dr11 * 1 + 4);
        }
        return $credit_b2c;
    }

    public function get_credit_data($i, $object, $highestRow, $worksheet) {
        $tax_credit_value = array();
        $data_arr5 = array();
        $m = 1;
        for ($j = $i; $j <= $highestRow; $j++) {
            if ($object->getActiveSheet()->getCell('B' . $j)->getValue() == "Total") {
                $m++;
                $highestColumn_cr = $worksheet->getHighestColumn($j);
                for ($k = 0; $k < 4; $k++) {
                    $a11 = strlen($highestColumn_cr);
                    $index1 = strlen($highestColumn_cr) - 1;
                    $ord1 = ord($highestColumn_cr[$index1]);
                    $a1 = substr($highestColumn_cr, 0, 1);
                    $a2 = substr($highestColumn_cr, 1);
                    if ($a1 != $a2 and $a2 == "A") {
                        $ord = ord($highestColumn_cr[1]);
                        $index = 1;
                        $o1 = ord($a1);
                        $o2 = chr($o1 - 1);
                        $highestColumn_row_pp = $o2 . "Z";
                    } else {
                        $highestColumn_row_pp = $this->getAlpha($highestColumn_cr, $ord1, $a11, $index1);
                    }
                    $highestColumn_cr = $highestColumn_row_pp;
                }
                $highest_value_without_CR = $highestColumn_cr; //hightest cloumn till where we have to find our data
                $char = 'G';
                while ($char !== $highest_value_without_CR) {
                    $values_CR[] = $object->getActiveSheet()->getCell($char . $j)->getValue();
                    $char++;
                }
                $cnt = count($values_CR);

                $data_credit_value = array();

                for ($a_dr = 0; $a_dr < $cnt; $a_dr++) {
                    $Dr_values = $values_CR[$a_dr];
                    $data_credit_value[] = $values_CR[$a_dr];
                }

                $aa3 = array();
                for ($a_dr = 1; $a_dr < $cnt; $a_dr++) {

                    if ($a_dr % 5 != 0) {

                        $aa3[] = $values_CR[$a_dr];
                    }
//                                var_dump($aa2);
                }
                $cntt = count($aa3);
                $a1 = sizeof($aa3);
                $a2 = $a1 % 4;
                $a3 = $a1 - $a2;
                for ($k = 0; $k < $a3; $k = $k + 4) {
                    $tax_credit_value[] = $aa3[$k] + $aa3[$k + 1] + $aa3[$k + 2] + $aa3[$k + 3];
                }

//                                var_dump($cnt);

                for ($a_cr = 0; $a_cr < $cnt; $a_cr++) {
                    $Cr_values = $values_CR[$a_cr];
                    $data_arr5[] = $values_CR[$a_cr];
                    $a_cr = ($a_cr * 1 + 4);
                }
            }
            if ($m > 1) {
                break;
            }
        }
        return array($data_arr5, $tax_credit_value);
    }

    public function get_debit_data($i, $object, $highestRow, $worksheet) {
        $tax_debit_value = array();
        $data_arr4 = array();
        for ($j = $i; $j <= $highestRow; $j++) {
            if ($object->getActiveSheet()->getCell('B' . $j)->getValue() == "Total") {
                $highestColumn_dr = $worksheet->getHighestColumn($j);
                for ($k = 0; $k < 4; $k++) {
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

                //get the value for tax debit value

                $data_debit_value_tax = array();

                for ($a_dr = 0; $a_dr < $cnt; $a_dr++) {
                    $Dr_values = $values_DR[$a_dr];
                    $data_debit_value_tax[] = $values_DR[$a_dr];
                }

                $aa2 = array();
                for ($a_dr = 1; $a_dr < sizeof($values_DR); $a_dr++) {

                    if ($a_dr % 5 != 0) {

                        $aa2[] = $values_DR[$a_dr];
                    }
//                                var_dump($aa2);
                }
                $a1 = sizeof($aa2);
                $a2 = $a1 % 4;
                $a3 = $a1 - $a2;

                for ($k = 0; $k < $a3; $k = $k + 4) {
                    $tax_debit_value[] = $aa2[$k] + $aa2[$k + 1] + $aa2[$k + 2] + $aa2[$k + 3];
                }

                for ($a_dr = 0; $a_dr < $cnt; $a_dr++) {
//                    $Dr_values = $values_DR[$a_dr];
                    $data_arr4[] = $values_DR[$a_dr];
                    $a_dr = ($a_dr * 1 + 4);
                }
            }
        }

        return array($data_arr4, $tax_debit_value);
    }

    public function sub_total_non_gst($highestColumn_row_sbng, $object, $i) { //function to get SUB total NON GST and DATA of Exempt Supply
        $char = 'G';
        while ($char !== $highestColumn_row_sbng) {
            $values_SBNG[] = $object->getActiveSheet()->getCell($char . $i)->getValue();
            $char++;
        }
        $cnt_sbng = count($values_SBNG);
        $data_arr31 = array();
        for ($ar1 = 0; $ar1 < $cnt_sbng; $ar1++) {
//            $data_non_gst = $values_SBNG[$ar1];
            $data_arr31[] = $values_SBNG[$ar1];
        }
        return $data_arr31;
    }

    public function get_no_gst_data($highestColumn_row_ng, $char, $object, $i) { //function to get TOTAL NON GST data
        while ($char !== $highestColumn_row_ng) {
            $values_NG[] = $object->getActiveSheet()->getCell($char . $i)->getValue();

            $char++;
        }
        $cnt_ng = count($values_NG);
        $data_arr3 = array();
        for ($a12 = 0; $a12 < $cnt_ng; $a12++) {
//            $data_non_gst = $values_NG[$a12];
            $data_arr3[] = $values_NG[$a12];
        }
        return $data_arr3;
    }

    public function get_months($months) {
        $cnt = count($months);
        $month_data = array();
        for ($a12 = 0; $a12 < $cnt; $a12++) {
            $month = $months[$a12];
            $month_data[] = $months[$a12];
            $a12 = ($a12 * 1 + 3);
        }
        return $month_data;
    }

    public function get_inter_state_total_fun($highestColumn_row, $i, $object) {
        $tax_inter_state = array();
        $data_arr1 = array();
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
        for ($k = 0; $k < 3; $k++) {
            $a11 = strlen($highest_value);
            $index1 = strlen($highest_value) - 1;
            $ord1 = ord($highest_value[$index1]);
            $highestColumn_row_pp = $this->getAlpha($highest_value, $ord1, $a11, $index1);
            $highest_value = $highestColumn_row_pp;
        }
        $highest_value_without_GT = $highest_value; //hightest cloumn till where we have to find our data
        $char = 'G';
        while ($char !== $highest_value_without_GT) {
            $values[] = $object->getActiveSheet()->getCell($char . $i)->getValue();
            $char++;
        }
        $cnt = count($values);
        //For getting the value for tax inter state 
        $data_arr_inter = array();

        for ($a_dr = 0; $a_dr < $cnt; $a_dr++) {
            $Dr_values = $values[$a_dr];
            $data_arr_inter[] = $values[$a_dr];
        }
        $aa1 = array();
        for ($a_dr = 1; $a_dr < sizeof($values); $a_dr++) {

            if ($a_dr % 2 != 0) {

                $aa1[] = $values[$a_dr];
            }
        }

        $a1 = (sizeof($aa1));
        $a2 = $a1 % 1;
        $a3 = $a1 - $a2;
        for ($k = 0; $k < ($a3); $k = $k + 2) {
            $tax_inter_state[] = $aa1[$k] + $aa1[$k + 1];
        }
//        $cnt = count($values);

        for ($aa = 0; $aa < $cnt; $aa++) {
//            $data1 = $values[$aa];
            $data_arr1[] = $values[$aa];
            $aa = ($aa * 1 + 3);
        }
//        return $tax_inter_state;
        return array($data_arr1, $tax_inter_state);
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

    public function get_intra_state_total($highest_value, $i, $object) {
        $tax_intra_state = array();
        $data_arr2 = array();
        for ($k = 0; $k < 3; $k++) {
            $a11 = strlen($highest_value);
            $index1 = strlen($highest_value) - 1;
            $ord1 = ord($highest_value[$index1]);
            $highestColumn_row_pp = $this->getAlpha($highest_value, $ord1, $a11, $index1);
            $highest_value = $highestColumn_row_pp;
        }
        $highest_value_without_GT = $highest_value; //hightest cloumn till where we have to find our data
        $char = 'G';
        while ($char !== $highest_value_without_GT) {
            $values1[] = $object->getActiveSheet()->getCell($char . $i)->getValue();
            $char++;
        }
        $cnt = count($values1);

        //For getting the tax intra state value
        $data_arr_intra = array();

        for ($a_dr = 0; $a_dr < $cnt; $a_dr++) {
            $Dr_values = $values1[$a_dr];
            $data_arr_intra[] = $values1[$a_dr];
        }
//                          
        $aa1 = array();
//        echo sizeof($values1);
        for ($a_dr = 1; $a_dr <= sizeof($values1); $a_dr++) {

            if ($a_dr % 4 != 0) {

                $aa1[] = $values1[$a_dr];
            }
        }
        $a1 = (sizeof($aa1));
        $a2 = $a1 % 3;
        $a3 = $a1 - $a2;
        for ($k = 0; $k < ($a3); $k = $k + 3) {
            $tax_intra_state[] = $aa1[$k] + $aa1[$k + 1] + $aa1[$k + 2];
        }


        for ($a12 = 0; $a12 < $cnt; $a12++) {
            $data2 = $values1[$a12];
            $data_arr2[] = $values1[$a12];
            $a12 = ($a12 * 1 + 3);
        }
        return array($data_arr2, $tax_intra_state);
    }

}
