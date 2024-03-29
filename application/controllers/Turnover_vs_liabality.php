
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Turnover_vs_liabality extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('excel_import_model');
        $this->load->library('excel');
        
    }

    function index() {


        $this->load->view('Turnover_vs_liability');
    }

    public function import_excel() {

        if (isset($_FILES["file_ex"]["name"]) && isset($_FILES["file_ex1"]["name"])) {
            $path = $_FILES["file_ex"]["tmp_name"];
            $this->load->library('excel');
            $object = PHPExcel_IOFactory::load($path);
            $worksheet = $object->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();



            $x = "G";
            while ($object->getActiveSheet()->getCell($x . 6)->getValue() !== "Grand Tatal") {
                $months[] = $object->getActiveSheet()->getCell($x . 6)->getValue();
                $x++;
            }
            $cnt = count($months);
            $month_data = array();
            for ($a12 = 0; $a12 < $cnt; $a12++) {
                $month = $months[$a12];
                $month_data[] = $months[$a12];

//                $this->db->insert('turnover_vs_tax_liability', $month_data);
                $a12 = ($a12 * 1 + 3);
            }
//            $this->db->insert('turnover_vs_tax_liability', $month_data);
//            var_dump($month_data);


            for ($i = 1; $i <= $highestRow; $i++) {
                $row_prev = $i - 1;

                if ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "Total" && $object->getActiveSheet()->getCell('B' . $row_prev)->getValue() == "Sub Total (B2CS)") {

                    $highestColumn_row = $worksheet->getHighestColumn($i);
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
//                               
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
                        while ($char !== $highest_value_without_GT) {
                            $values[] = $object->getActiveSheet()->getCell($char . $i)->getValue();

                            $char++;
                        }
                        $cnt = count($values);
                        $data_arr1 = array();
                        for ($aa = 0; $aa <= $cnt; $aa++) {
                            $data1 = $values[$aa];
                            $data_arr1[] = $values[$aa];
                            $aa = ($aa * 1 + 3);
                        }
                    } else {
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
                        while ($char !== $highest_value_without_GT) {
                            $values1[] = $object->getActiveSheet()->getCell($char . $i)->getValue();

                            $char++;
                        }
//                        var_dump($values1);
                        $cnt = count($values1);
                        $data_arr2 = array();
                        for ($a12 = 0; $a12 < $cnt; $a12++) {
                            $data2 = $values1[$a12];
                            $data_arr2[] = $values1[$a12];
                            $a12 = ($a12 * 1 + 3);
                        }
                    }
                } elseif ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "Total" && $object->getActiveSheet()->getCell('B' . $row_prev)->getValue() == "Sub Total (NON-GST)") { // no gst data
                    $highestColumn_row_ng = $worksheet->getHighestColumn($i);
                    $char = 'G';
                    while ($char !== $highestColumn_row_ng) {
                        $values_NG[] = $object->getActiveSheet()->getCell($char . $i)->getValue();

                        $char++;
                    }
                    $cnt_ng = count($values_NG);
                    $data_arr3 = array();
                    for ($a12 = 0; $a12 < $cnt_ng; $a12++) {
                        $data_non_gst = $values_NG[$a12];
                        $data_arr3[] = $values_NG[$a12];
                    }
                } elseif ($object->getActiveSheet()->getCell('A' . $i)->getValue() == "(5) Dr Note Details") {
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
                                $a_dr = ($a_dr * 1 + 4);
                            }
                        }
                    }
                } elseif ($object->getActiveSheet()->getCell('A' . $i)->getValue() == "(4) Cr Note Details") {
                    $m = 1;
                    for ($j = $i; $j <= $highestRow; $j++) {
                        if ($object->getActiveSheet()->getCell('B' . $j)->getValue() == "Total") {
                            $m++;
                            $highestColumn_cr = $worksheet->getHighestColumn($j);
                            for ($k = 0; $k < 5; $k++) {
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
//                               
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
                            $data_arr5 = array();
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
                } else {
                    
                }
            }

            // second excel file work start
            $path1 = $_FILES["file_ex1"]["tmp_name"];
            $object1 = PHPExcel_IOFactory::load($path1);
            $worksheet1 = $object1->getActiveSheet();
            $highestRow1 = $worksheet1->getHighestRow();
            $highestColumn1 = $worksheet1->getHighestColumn();
            if ($object->getActiveSheet()->getCell('B' . 3)->getValue() !== "F.Y. : 2017-2018") {
                $outward = array();
                for ($l = 10; $l <= 18; $l++) {
                    $val = $object1->getActiveSheet()->getCell('F' . $l)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('G' . $l)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('H' . $l)->getValue();
                    $outward[] = $val + $val1 + $val2;
                }

                $reverse_charge = array();
                for ($p = 27; $p <= 35; $p++) {
                    $val_a = $object1->getActiveSheet()->getCell('F' . $p)->getValue();
                    $val1_a = $object1->getActiveSheet()->getCell('G' . $p)->getValue();
                    $val2_a = $object1->getActiveSheet()->getCell('H' . $p)->getValue();
                    $reverse_charge[] = $val_a + $val1_a + $val2_a;
                }
            } else {
                $outward = array();
                for ($l = 7; $l <= 18; $l++) {
                    $val = $object1->getActiveSheet()->getCell('F' . $l)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('G' . $l)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('H' . $l)->getValue();
                    $outward[] = $val + $val1 + $val2;
                }

                $reverse_charge = array();
                for ($p = 24; $p <= 35; $p++) {
                    $val_a = $object1->getActiveSheet()->getCell('F' . $p)->getValue();
                    $val1_a = $object1->getActiveSheet()->getCell('G' . $p)->getValue();
                    $val2_a = $object1->getActiveSheet()->getCell('H' . $p)->getValue();
                    $reverse_charge[] = $val_a + $val1_a + $val2_a;
                }
            }

            //second excel file work end
            $uniq_id = $this->turnover_id(); //unique id generation
            $month_data_arr = $month_data; //array of month data
            $inter_state = $data_arr1; //array of inter state supply
            $intra_state = $data_arr2; //array of intra state supply
            $no_gst_paid_supply = $data_arr3; // array of no_gst_paid_supply
            $debit_value = $data_arr4; //array of debit_value
            $credit_value = $data_arr5; //array of credit_value
            $count = count($month_data_arr);
//            $mm = 1;
            for ($t = 0; $t < $count; $t++) {
                $quer = $this->db->query("insert into turnover_vs_tax_liability (`uniq_id`,`month`,`inter_state_supply`,`intra_state_supply`,`no_gst_paid_supply`,`debit_value`,`credit_value`,`liability_on_outward`,`liability_on_reverse_change`)"
                        . " values ('$uniq_id','$month_data[$t]','$inter_state[$t]','$intra_state[$t]','$no_gst_paid_supply[$t]','$debit_value[$t]','$credit_value[$t]','$outward[$t]','$reverse_charge[$t]') ");
                if ($quer->affected_rows() > 0) {
//                    $mm++;
                }
            }
            
        }
    }

    //abhi
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

    public function turnover_id() {
        $result = $this->db->query('SELECT uniq_id FROM `turnover_vs_tax_liability` ORDER BY uniq_id DESC LIMIT 0,1');
        if ($result->num_rows() > 0) {
            $data = $result->row();
            $turn_id = $data->uniq_id;
            //generate user_id
            $turn_id = str_pad(++$turn_id, 5, '0', STR_PAD_LEFT);
            return $turn_id;
        } else {
            $turn_id = 'turn_1001';
            return $turn_id;
        }
    }

    public function get_graph_Turnover_vs_liabality() {
        $quer1 = $this->db->query("SELECT * from turnover_vs_tax_liability");
        if ($quer1->num_rows() > 0) {
            $res = $quer1->result();
            $turnover1 = array();
            $tax_liabality1 = array();
            $ratio_val = array();
            foreach ($res as $row) {
                $turnover = ($row->inter_state_supply + $row->intra_state_supply + $row->no_gst_paid_supply + $row->debit_value) - (1 * $row->credit_value);
                $tax_liabality = $row->liability_on_outward + $row->liability_on_reverse_change;
                $ratio = ($tax_liabality / $turnover) * 100;
                $ratio_val[] = round($ratio);
                $turnover1[] = $turnover;
                $tax_liabality1[] = $tax_liabality;
            }
            $abc = array();
            for ($o = 0; $o < sizeof($turnover1); $o++) {
                $abc[] = $turnover1[$o];
                $aa = settype($abc[$o], "integer");
            }
            $pqr = array();
            for ($o1 = 0; $o1 < sizeof($tax_liabality1); $o1++) {
                $pqr[] = $tax_liabality1[$o1];
                $aa = settype($pqr[$o1], "integer");
            }
            $lmn = array();
            for ($o2 = 0; $o2 < sizeof($ratio_val); $o2++) {
                $lmn[] = $ratio_val[$o2];
                $aa = settype($lmn[$o2], "integer");
            }

            $respose['message'] = "success";
            $respose['data_turn_over'] = $abc;
            $respose['data_liability'] = $pqr;
            $respose['ratio'] = $lmn;
        } else {
            $respose['message'] = "";
            $respose['data_turn_over'] = "";
            $respose['data_liability'] = "";
            $respose['ratio'] = "";
        } echo json_encode($respose);
    }

}
