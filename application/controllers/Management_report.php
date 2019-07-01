<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Management_report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('CFO_model');
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

        $query_get_cfo_data = $this->CFO_model->get_data_cfo();
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

}

?>