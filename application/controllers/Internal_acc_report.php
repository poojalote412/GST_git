<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Internal_acc_report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Internal_acc_report_model');
        $this->load->model('Cfo_model');
    }

    function index() { //load the view page data
//        $data['result'] = $result;
        $session_data = $this->session->userdata('login_session');
        $customer_id = ($session_data['customer_id']);
        $query_get_data = $this->Internal_acc_report_model->get_data_taxliability($customer_id);
        if ($query_get_data !== FALSE) {
            $data['tax_data'] = $query_get_data;
        } else {
            $data['tax_data'] = "";
        }
        $this->load->view('customer/Internal_acc_report', $data);
    }
    
    function index_admin() { //load the view page data
//        $data['result'] = $result;
        $session_data = $this->session->userdata('login_session');
        $customer_id = ($session_data['customer_id']);
        $query_get_data = $this->Internal_acc_report_model->get_data_taxliability($customer_id);
        if ($query_get_data !== FALSE) {
            $data['tax_data'] = $query_get_data;
        } else {
            $data['tax_data'] = "";
        }
        $this->load->view('admin/Internal_acc_report', $data);
    }

    public function import_excel() {
        if (isset($_FILES["file_ex1"]["name"]) && isset($_FILES["file_ex2"]["name"])) {
            //second Excel sheet Data
            $path = $_FILES["file_ex1"]["tmp_name"];
            $this->load->library('excel');
            $object = PHPExcel_IOFactory::load($path);
            $worksheet = $object->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();

            for ($i = 1; $i <= $highestRow; $i++) {

                if ($object->getActiveSheet()->getCell('A' . $i)->getValue() == "(5) Dr Note Details") {
                    for ($j = $i; $j <= $highestRow; $j++) {
                        if ($object->getActiveSheet()->getCell('B' . $j)->getValue() == "Total") {
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
//                               
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
                            $data_arr4 = array();

                            for ($a_dr = 0; $a_dr < $cnt; $a_dr++) {
                                $Dr_values = $values_DR[$a_dr];
                                $data_arr4[] = $values_DR[$a_dr];
                            }

                            $aa = array();
                            for ($a_dr = 1; $a_dr < sizeof($values_DR); $a_dr++) {

                                if ($a_dr % 5 != 0) {

                                    $aa[] = $values_DR[$a_dr];
                                }
                            }

                            $arr = array();
                            for ($k = 0; $k < sizeof($aa); $k = $k + 4) {
                                $arr[] = $aa[$k] + $aa[$k + 1] + $aa[$k + 2] + $aa[$k + 3];
                            }
//                            $cnt1=count($arr);
//                            var_dump($cnt1);
//                            var_dump($arr);
                        }
                    }
                } else {
                    
                }
            }

            //Second Excel Sheet Data
            $path1 = $_FILES["file_ex2"]["tmp_name"];
            $object1 = PHPExcel_IOFactory::load($path1);
            $worksheet1 = $object1->getActiveSheet();
            $highestRow1 = $worksheet1->getHighestRow();
            $highestColumn1 = $worksheet1->getHighestColumn();

            if ($object1->getActiveSheet()->getCell('B' . 3)->getValue() == "F.Y. : 2017-2018") {
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
                    $val = $object1->getActiveSheet()->getCell('S' . $u)->getValue();
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
            $tax_libility_id = $this->tax_liability_id();
            $count = count($month);
            for ($m = 0; $m < $count; $m++) {
                if ($month == "" or $month === NULL) {
                    $month = array();
                    $month[$m] = 0;
                } else {
                    $month = $month;
                }
                if ($liability_on_outward == "" or $liability_on_outward === NULL) {
                    $liability_on_outward = array();
                    $liability_on_outward[$m] = 0;
                } else {
                    $liability_on_outward = $liability_on_outward;
                }
                if ($rcm_liability == "" or $rcm_liability === NULL) {
                    $rcm_liability = array();
                    $rcm_liability[$m] = 0;
                } else {
                    $rcm_liability = $rcm_liability;
                }
                if ($itc_ineligible == "" or $itc_ineligible === NULL) {
                    $itc_ineligible = array();
                    $itc_ineligible[$m] = 0;
                } else {
                    $itc_ineligible = $itc_ineligible;
                }
                if ($net_rtc == "" or $net_rtc === NULL) {
                    $net_rtc = array();
                    $net_rtc[$m] = 0;
                } else {
                    $net_rtc = $net_rtc;
                }
                if ($paid_in_credit == "" or $paid_in_credit === NULL) {
                    $paid_in_credit = array();
                    $paid_in_credit[$m] = 0;
                } else {
                    $paid_in_credit = $paid_in_credit;
                }
                if ($paid_in_cash == "" or $paid_in_cash === NULL) {
                    $paid_in_cash = array();
                    $paid_in_cash[$m] = 0;
                } else {
                    $paid_in_cash = $paid_in_cash;
                }
                if ($interest_late_fees == "" or $interest_late_fees === NULL) {
                    $interest_late_fees = array();
                    $interest_late_fees[$m] = 0;
                } else {
                    $interest_late_fees = $interest_late_fees;
                }
                if ($arr == "" or $arr === NULL) {
                    $arr = array();
                    $arr[$m] = 0;
                } else {
                    $arr = $arr;
                }
                if ($due_date == "" or $due_date === NULL) {
                    $due_date = array();
                    $due_date[$m] = 0;
                } else {
                    $due_date = $due_date;
                }
                if ($filling_date == "" or $filling_date === NULL) {
                    $filling_date = array();
                    $filling_date[$m] = 0;
                } else {
                    $filling_date = $filling_date;
                }
                if ($late_fees == "" or $late_fees === NULL) {
                    $late_fees = array();
                    $late_fees[$m] = 0;
                } else {
                    $late_fees = $late_fees;
                }

                //Get debit value for NET ITC.

                $array_debit = $net_rtc[$m] - $arr[$m];
//                
//                      $month[$m];
//                      $liability_on_outward[$m];
//                      $rcm_liability[$m];
//                      $itc_ineligible[$m];
//                      $net_rtc[$m];
//                      $paid_in_credit[$m];
//                      $paid_in_cash[$m];
//                      $interest_late_fees[$m];


                $quer = $this->db->query("insert into tax_liability (`tax_libility_id`,`month`,`outward_liability`,`rcb_liablity`,`ineligible_itc`,`net_itc`,`paid_in_credit`,`paid_in_cash`,`interest_late_fee`,`debit`,`debit_net_itc`,`late_fees`,`due_date`,`filling_date`)"
                        . " values ('$tax_libility_id','$month[$m]','$liability_on_outward[$m]','$rcm_liability[$m]','$itc_ineligible[$m]','$net_rtc[$m]','$paid_in_credit[$m]','$paid_in_cash[$m]','$interest_late_fees[$m]','$arr[$m]','$array_debit','$late_fees[$m]','$due_date[$m]','$filling_date[$m]')");

//                var_dump($quer);
            }
        }
    }

    //For Unique ID generation

    public function tax_liability_id() {
        $result = $this->db->query('SELECT tax_libility_id FROM `tax_liability` ORDER BY tax_libility_id DESC LIMIT 0,1');
        if ($result->num_rows() > 0) {
            $data = $result->row();
            $turn_id = $data->tax_libility_id;
            //generate user_id
            $turn_id = str_pad(++$turn_id, 5, '0', STR_PAD_LEFT);
            return $turn_id;
        } else {
            $turn_id = 'tax_1001';
            return $turn_id;
        }
    }

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

    //For display graph

    public function get_graph() {
        $customer_id = $this->input->post("customer_id");
        $query = $this->db->query("SELECT * FROM 3b_offset_summary_all where customer_id='$customer_id'");
        $query1 = $this->db->query("SELECT tax_debit FROM monthly_summary_all where customer_id='$customer_id'");
        $data = ""; //view observations
        if ($query->num_rows() > 0 && $query1->num_rows() > 0) {
            $result_outward = $query->result();
            $ress = $query1->result();

            foreach ($ress as $row1) {
                $debit_tax[] = $row1->tax_debit;
            }
            foreach ($result_outward as $row) {
                $month[] = $row->month;
                $liabilityoutward[] = $row->outward_liability;
                $rcm_liability[] = $row->rcb_liablity;
                $itc_ineligible[] = $row->ineligible_itc;
                $paid_credit[] = $row->paid_in_credit;
                $paid_cash[] = $row->paid_in_cash;
                $late_fee[] = $row->interest_late_fee;
                $net_rtc[] = $row->net_itc;
            }
            $count = count($debit_tax);
            $new_net_rtc = array();
            for ($m = 0; $m < $count; $m++) {
                $new_net_rtc[] = $net_rtc[$m] - $debit_tax[$m] . '<br>';
            }

            $data .= '<div class="row">
                    <div class="col-md-12">
                        <div class="">
                         <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Month</th>
                                        <th>Outward Liability</th>
                                        <th>RCM Liability</th>
                                        <th>Ineligible ITC</th>
                                        <th>Net ITC</th>
                                        <th>Paid in Credit</th>
                                        <th>Paid in Cash</th>
                                        <th>Interest Late Fee</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>';
            $k = 1;
            for ($i = 0; $i < $count; $i++) {
                $data .= '<tr>' .
                        '<td>' . $k . '</td>' .
                        '<td>' . $month[$i] . '</td>' .
                        '<td>' . $liabilityoutward[$i] . '</td>' .
                        '<td>' . $rcm_liability[$i] . '</td>' .
                        '<td>' . $itc_ineligible[$i] . '</td>' .
                        '<td>' . $net_rtc[$i] . '</td>' .
                        '<td>' . $paid_credit[$i] . '</td>' .
                        '<td>' . $paid_cash[$i] . '</td>' .
                        '<td>' . $late_fee[$i] . '</td>' .
                        '</tr>';

                $k++;
            }
            $data .= '<tr>' .
                    '<td>' . '<b>Total</b>' . '</td>' .
                    '<td>' . '' . '</td>' .
                    '<td>' . '<b>' . array_sum($liabilityoutward) . '</b> ' . '</td>' .
                    '<td>' . '<b>' . array_sum($rcm_liability) . '</b> ' . '</td>' .
                    '<td>' . '<b>' . array_sum($itc_ineligible) . '</b> ' . '</td>' .
                    '<td>' . '<b>' . array_sum($net_rtc) . '</b> ' . '</td>' .
                    '<td>' . '<b>' . array_sum($paid_credit) . '</b> ' . '</td>' .
                    '<td>' . '<b>' . array_sum($paid_cash) . '</b> ' . '</td>' .
                    '<td>' . '<b>' . array_sum($late_fee) . '</b> ' . '</td>' .
                    '</tr>';
            $data .= '</tbody></table></div></div></div>';
//            $data .= "<hr><h4><b>Observation of Tax Liability:</b></h4>";
            $abc = array();
            $abc2 = array();
            $abc3 = array();
            $abc4 = array();
            $abc5 = array();
            $abc6 = array();
            $abc7 = array();

            for ($o = 0; $o < sizeof($liabilityoutward); $o++) {
                $abc[] = $liabilityoutward[$o];
                $aa1 = settype($abc[$o], "float");

                $abc2[] = $rcm_liability[$o];
                $aa2 = settype($abc2[$o], "float");

                $abc3[] = $itc_ineligible[$o];
                $aa3 = settype($abc3[$o], "float");

                $abc4[] = $paid_credit[$o];
                $aa4 = settype($abc4[$o], "float");

                $abc5[] = $paid_cash[$o];
                $aa5 = settype($abc5[$o], "float");

                $abc6[] = $late_fee[$o];
                $aa6 = settype($abc6[$o], "float");
            }

            //function to get customer name
            $quer21 = $this->db->query("SELECT customer_name from customer_header_all where customer_id='$customer_id'");

            if ($quer21->num_rows() > 0) {
                $res21 = $quer21->row();
                $customer_name = $res21->customer_name;
            }
            //function to get months
            $quer2 = $this->db->query("SELECT month from 3b_offset_summary_all where customer_id='$customer_id'");
            $months = array();
            if ($quer2->num_rows() > 0) {
                $res2 = $quer2->result();
                foreach ($res2 as $row) {
                    $months[] = $row->month;
                }
            }

            $respose['message'] = "success";
            $respose['data_outward'] = $abc;
            $respose['data'] = $data;
            $respose['data_rcb'] = $abc2;
            $respose['data_inelligible'] = $abc3;
            $respose['new_net_rtc'] = $abc4;
            $respose['data_paid_credit'] = $abc5;
            $respose['data_paid_cash'] = $abc6;
            $respose['data_late_fee'] = $abc7;
            $respose['customer_name'] = $customer_name; //customer
            $respose['month_data'] = $months; //months 
        } else {
            $respose['message'] = "fail";
            $respose['data_outward'] = "";
            $respose['data_rcb'] = "";
            $respose['data_inelligible'] = "";
            $respose['new_net_rtc'] = "";
            $respose['data_paid_credit'] = "";
            $respose['data_paid_cash'] = "";
            $respose['data_late_fee'] = "";
        }
        echo json_encode($respose);
    }

    //Graph for tax turnover

    public function tax_turnover() { //load data of view page
//        $data['result'] = $result;
        $session_data = $this->session->userdata('login_session');
        $customer_id = ($session_data['customer_id']);
        $query_get_cfo_data = $this->Cfo_model->get_data_cfo($customer_id);
        if ($query_get_cfo_data !== FALSE) {
            $data['tax_turnover_data'] = $query_get_cfo_data;
        } else {
            $data['tax_turnover_data'] = "";
        }
        $this->load->view('customer/Tax_turnover', $data);
    }
    
    
    public function tax_turnover_admin() { //load data of view page
//        $data['result'] = $result;
        $session_data = $this->session->userdata('login_session');
        $customer_id = ($session_data['customer_id']);
        $query_get_cfo_data = $this->Cfo_model->get_data_cfo($customer_id);
        if ($query_get_cfo_data !== FALSE) {
            $data['tax_turnover_data'] = $query_get_cfo_data;
        } else {
            $data['tax_turnover_data'] = "";
        }
        $this->load->view('admin/Tax_turnover', $data);
    }

    //get graph function for tax turnover

    public function get_graph_tax_turnover() {
        $customer_id = $this->input->post("customer_id");
        $query = $this->db->query("SELECT * from monthly_summary_all where customer_id='$customer_id'");
        if ($query->num_rows() > 0) {
            $result = $query->result();
            $taxable_value = array();
            $tax_value = array();
            $tax_ratio = array();
            $data = ""; //view observations
            $data .= '<div class="row">
                    <div class="col-md-12">
                        <div class="">
                         <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Month</th>
                                        <th>Tax Values</th>
                                        <th>Taxable Values</th>
                                        <th>Tax Ratio</th>
                                    </tr>
                                </thead>
                                <tbody>';
            $k = 1;
            foreach ($result as $row) {
                $inter_state_supply = $row->inter_state_supply;
                $intra_state_supply = $row->intra_state_supply;
                $no_gst_paid_supply = $row->no_gst_paid_supply;
                $debit_value = $row->debit_value;
                $credit_value = $row->credit_value;
                $tax_inter_state = $row->tax_inter_state;
                $tax_intra_state = $row->tax_intra_state;
                $tax_debit = $row->tax_debit;
                $tax_credit = $row->tax_credit;
                $month = $row->month;

                $taxable_val = ($inter_state_supply + $intra_state_supply + $no_gst_paid_supply + $debit_value) - ($credit_value);
                $taxable_value[] = $taxable_val; //taxable value array

                $tax_val = ($tax_inter_state + $tax_intra_state + $tax_debit) - ($tax_credit);
                $tax_value[] = $tax_val; //tax array


                $ratio = ($tax_val / $taxable_val) * 100;
                $tax_ratio[] = round($ratio);
                $tax_ratio1[] = ($ratio);

                $data .= '<tr>' .
                        '<td>' . $k . '</td>' .
                        '<td>' . $month . '</td>' .
                        '<td>' . $tax_val . '</td>' .
                        '<td>' . $taxable_val . '</td>' .
                        '<td>' . round($ratio) . "%" . '</td>' .
                        '</tr>';
                $k++;
            }
            $data .= '<tr>' .
                    '<td>' . '<b>Total</b>' . '</td>' .
                    '<td>' . '' . '</td>' .
                    '<td>' . '<b>' . array_sum($tax_value) . '</b> ' . '</td>' .
                    '<td>' . '<b>' . array_sum($taxable_value) . '</b>' . '</td>' .
                    '<td>' . '<b>' . array_sum($tax_ratio) . "%" . '</b>' . '</td>' .
                    '</tr>';
            $data .= '</tbody></table></div></div></div>';
            $max_ratio = max($tax_ratio);

            $average = array_sum($tax_ratio1) / count($tax_ratio);
            $data .= "<hr><h4><b>Observation of Tax Turnover:</b></h4>"
                    . "<span>The average tax value to turnover is <b>" . round($average, 2) . "%</b>. </span><br>"
                    . "<span>The tax value as <b>" . $max_ratio . "%</b> of taxable value which is higher than the rest.</span>";
            // loop to get graph data as per graph script requirement
            $abc1 = array();
            $abc2 = array();
            $abc3 = array();
            for ($o = 0; $o < sizeof($taxable_value); $o++) {
                $abc1[] = $taxable_value[$o];
                $aa1 = settype($abc1[$o], "float");

                $abc2[] = $tax_value[$o];
                $aa2 = settype($abc1[$o], "float");

                $abc3[] = $tax_ratio[$o];
                $aa3 = settype($abc3[$o], "float");
            }

//             to get max value for range
//            $max_range = max(array($taxable_supply));
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
            $respnose['taxable_value'] = $abc1;  //taxable_supply data
            $respnose['tax_value'] = $abc2; //tax value
            $respnose['tax_ratio'] = $abc3;
            $respnose['month_data'] = $months; //months 
            $respnose['max_range'] = $max_range; //maximum range for graph
            $respnose['customer_name'] = $customer_name; //customer
        } else {
            $respnose['data'] = "";
            $respnose['message'] = "";
            $respnose['taxable_supply_arr'] = "";  //taxable_supply data
        } echo json_encode($respnose);
    }

}

?>