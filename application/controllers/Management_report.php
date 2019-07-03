<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Management_report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Cfo_model');
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

        $query_get_cfo_data = $this->Cfo_model->get_data_cfo();
        if ($query_get_cfo_data !== FALSE) {
            $data['tax_exempt_data'] = $query_get_cfo_data;
        } else {
            $data['tax_exempt_data'] = "";
        }
        $this->load->view('customer/Sale_tax_nontax_exempt', $data);
    }

    public function get_graph_taxable_nontx_exempt() { //get graph function of taxable nontaxable and exempt
        $turn_id = $this->input->post("turn_id");
        $query = $this->db->query("SELECT * from turnover_vs_tax_liability where uniq_id='$turn_id'");
        if ($query->num_rows() > 0) {
            $result = $query->result();
            $taxable_supply_arr = array();
            $sub_total_non_gst_arr = array();
            $sub_total_exempt_arr = array();
            $ratio_taxable_supply = array();
            $ratio_subtotal_nongst = array();
            $ratio_subtotal_exempt = array();
            foreach ($result as $row) {
                $inter_state_supply = $row->inter_state_supply;
                $intra_state_supply = $row->intra_state_supply;
                $debit_value = $row->debit_value;
                $credit_value = $row->credit_value;

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
            }

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
            $quer2 = $this->db->query("SELECT month from turnover_vs_tax_liability where uniq_id='$turn_id'");
            $months = array();
            if ($quer2->num_rows() > 0) {
                $res2 = $quer2->result();
                foreach ($res2 as $row) {
                    $months[] = $row->month;
                }
            }
            $respnose['message'] = "success";
            $respnose['taxable_supply_arr'] = $abc1;  //taxable_supply data
            $respnose['sub_total_non_gst_arr'] = $abc2; //sub_total_non_gstdata
            $respnose['sub_total_exempt_arr'] = $abc3; //sub_total_exempt data
            $respnose['ratio_taxable_supply'] = $abc4; //ratio_taxable_supply
            $respnose['ratio_subtotal_nongst'] = $abc5; //ratio_subtotal_nongst
            $respnose['ratio_subtotal_exempt'] = $abc6; //ratio_subtotal_exempt
            $respnose['month_data'] = $months; //months 
            $respnose['max_range'] = $max_range; //maximum range for graph
        } else {
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
        $query_get_cfo_data = $this->Cfo_model->get_data_cfo();
        if ($query_get_cfo_data !== FALSE) {
            $data['month_wise_data'] = $query_get_cfo_data;
        } else {
            $data['month_wise_data'] = "";
        }
        $this->load->view('customer/Sales_month_wise', $data);
    }

    public function get_graph_sales_month_wise() { //get graph function of Sales month wise
        $turn_id = $this->input->post("turn_id");
        $query = $this->db->query("SELECT * from turnover_vs_tax_liability where uniq_id='$turn_id'");
        if ($query->num_rows() > 0) {
            $result = $query->result();
            $taxable_supply_arr = array();

            foreach ($result as $row) {
                $inter_state_supply = $row->inter_state_supply;
                $intra_state_supply = $row->intra_state_supply;
                $no_gst_paid_supply = $row->no_gst_paid_supply;
                $debit_value = $row->debit_value;
                $credit_value = $row->credit_value;

                $taxable_supply = ($inter_state_supply + $intra_state_supply + $no_gst_paid_supply + $debit_value) - ($credit_value);
                $taxable_supply_arr[] = $taxable_supply; //taxable supply array
            }

            // loop to get graph data as per graph script requirement
            $abc1 = array();
            $abc2 = array();
            $abc3 = array();
            for ($o = 0; $o < sizeof($taxable_supply_arr); $o++) {
                $abc1[] = $taxable_supply_arr[$o];
                $aa1 = settype($abc1[$o], "float");
            }

//             to get max value for range
            $max_range = max(array($taxable_supply));

            //function to get months
            $quer2 = $this->db->query("SELECT month from turnover_vs_tax_liability where uniq_id='$turn_id'");
            $months = array();
            if ($quer2->num_rows() > 0) {
                $res2 = $quer2->result();
                foreach ($res2 as $row) {
                    $months[] = $row->month;
                }
            }
            $respnose['message'] = "success";
            $respnose['taxable_supply_arr'] = $abc1;  //taxable_supply data
            $respnose['month_data'] = $months; //months 
            $respnose['max_range'] = $max_range; //maximum range for graph
        } else {
            $respnose['message'] = "";
            $respnose['taxable_supply_arr'] = "";  //taxable_supply data
        } echo json_encode($respnose);
    }

    // sale b2b view page function
    public function Sale_b2b_b2c() {
        $this->load->view('customer/B2b_b2c');
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



                $row_prev = $i - 1;
                $s = 0;
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
                        $s++;
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
                        $values = array();
                        while ($char !== $highest_value_without_GT1) {
                            $values[] = $object->getActiveSheet()->getCell($char . $i)->getValue();
                            $char++;
                        }
                        $cnt = count($values);
                        $interstate_b2c = array();
                        for ($aa12 = 0; $aa12 <= $cnt; $aa12++) {
                            $data1 = $values[$aa12];
                            $interstate_b2c[] = $values[$aa12];
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
                        while ($char !== $highest_value_without_GT) {
                            $values1[] = $object->getActiveSheet()->getCell($char . $i)->getValue();
                            $char++;
                        }
                        $cnt = count($values1);
                        $intrastate_b2c = array();
                        for ($a12 = 0; $a12 < $cnt; $a12++) {
                            $data2 = $values1[$a12];
                            $intrastate_b2c[] = $values1[$a12];
                            $a12 = ($a12 * 1 + 3);
                        }
//                        var_dump($intrastate_b2c);
//                        if ($sk > 0) {
//                            exit;
//                        }
                    }
                }
            }
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

}

?>