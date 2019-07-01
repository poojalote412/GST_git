<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Internal_acc_report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Internal_acc_report_model');
    }

    function index() {
//        $data['result'] = $result;
        $query_get_data = $this->Internal_acc_report_model->get_data_taxliability();
        if ($query_get_data !== FALSE) {
            $data['tax_data'] = $query_get_data;
        } else {
            $data['tax_data'] = "";
        }
        $this->load->view('customer/Internal_acc_report', $data);
    }

    public function import_excel() {

        if (isset($_FILES["file_ex1"]["name"]) && isset($_FILES["file_ex"]["name"])) {

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
                            var_dump($arr);
                        }
                    }
                } else {
                    
                }
            }

            //Second Excel Sheet Data

            $path1 = $_FILES["file_ex"]["tmp_name"];
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

//                 $count=count($month);
//                 for($m=0;$m<=$count;$m++)
//                 {
//                      $month[$m];
//                      $liability_on_outward[$m];
//                      $rcm_liability[$m];
//                      $itc_ineligible[$m];
//                      $net_rtc[$m];
//                      $paid_in_credit[$m];
//                      $paid_in_cash[$m];
//                      $interest_late_fees[$m];
//                      
//                 }
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


                $quer = $this->db->query("insert into tax_liability (`tax_libility_id`,`month`,`outward_liability`,`rcb_liablity`,`ineligible_itc`,`net_itc`,`paid_in_credit`,`paid_in_cash`,`interest_late_fee`,`debit`,`debit_net_itc`)"
                        . " values ('$tax_libility_id','$month[$m]','$liability_on_outward[$m]','$rcm_liability[$m]','$itc_ineligible[$m]','$net_rtc[$m]','$paid_in_credit[$m]','$paid_in_cash[$m]','$interest_late_fees[$m]','$arr[$m]]','$array_debit')");

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
            $turn_id = str_pad( ++$turn_id, 5, '0', STR_PAD_LEFT);
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
        $tax_id = $this->input->post("tax_id");
        $query = $this->db->query("SELECT * FROM tax_liability where tax_libility_id='$tax_id'");
//         $query = $this->db->query("SELECT tax_liability_id,month,outward_liability,rcb_liability,ineligible_itc,paid_in_credit,paid_in_cash,interest_late_fee,debit_net_itc FROM tax_liability");
        if ($query->num_rows() > 0) {
            $result_outward = $query->result();
//            $arry_net_rtc_new=array();
            foreach ($result_outward as $row) {
                $liabilityoutward[] = $row->outward_liability;
                $rcm_liability[] = $row->rcb_liablity;
                $itc_ineligible[] = $row->ineligible_itc;
                $paid_credit[] = $row->paid_in_credit;
                $paid_cash[] = $row->paid_in_cash;
                $late_fee[] = $row->interest_late_fee;
                $net_rtc[] = $row->net_itc;
                $debit_value[] = $row->debit;
            }
            $count = count($debit_value);
            $new_net_rtc = array();
            for ($m = 0; $m < $count; $m++) {
                $new_net_rtc[] = $net_rtc[$m] - $debit_value[$m] . '<br>';
            }

            $abc = array();
            for ($o = 0; $o < sizeof($liabilityoutward); $o++) {
                $abc[] = $liabilityoutward[$o];
                $aa = settype($abc[$o], "integer");
            }
            $abc2 = array();
            for ($o1 = 0; $o1 < sizeof($rcm_liability); $o1++) {
                $abc2[] = $rcm_liability[$o1];
                $aa1 = settype($abc2[$o1], "integer");
            }
            $abc3 = array();
            for ($o2 = 0; $o2 < sizeof($itc_ineligible); $o2++) {
                $abc3[] = $itc_ineligible[$o2];
                $aa1 = settype($abc3[$o2], "integer");
            }
            $abc4 = array();
            for ($o3 = 0; $o3 < sizeof($new_net_rtc); $o3++) {
                $abc4[] = $new_net_rtc[$o3];
                $aa1 = settype($abc4[$o3], "integer");
            }
            $abc5 = array();
            for ($o3 = 0; $o3 < sizeof($paid_credit); $o3++) {
                $abc5[] = $paid_credit[$o3];
                $aa1 = settype($abc5[$o3], "integer");
            }
            $abc6 = array();
            for ($o3 = 0; $o3 < sizeof($paid_cash); $o3++) {
                $abc6[] = $paid_cash[$o3];
                $aa1 = settype($abc6[$o3], "integer");
            }
            $abc7 = array();
            for ($o3 = 0; $o3 < sizeof($late_fee); $o3++) {
                $abc7[] = $late_fee[$o3];
                $aa1 = settype($abc7[$o3], "integer");
            }
            $respose['message'] = "success";
            $respose['data_outward'] = $abc;
            $respose['data_rcb'] = $abc2;
            $respose['data_inelligible'] = $abc3;
            $respose['new_net_rtc'] = $abc4;
            $respose['data_paid_credit'] = $abc5;
            $respose['data_paid_cash'] = $abc6;
            $respose['data_late_fee'] = $abc7;
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

}

?>