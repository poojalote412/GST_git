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
            foreach ($result as $row) {
                $inter_state_supply = $row->inter_state_supply;
                $intra_state_supply = $row->intra_state_supply;
                $debit_value = $row->debit_value;
                $credit_value = $row->credit_value;
                
                $taxable_supply =($inter_state_supply+$intra_state_supply+$debit_value)-($credit_value);
                $sub_total_non_gst = $row->sub_total_non_gst;
                $sub_total_exempt = $row->sub_total_exempt;
                
                $ratio_taxable_supply=($taxable_supply*100)/($taxable_supply+$sub_total_non_gst+$sub_total_exempt);
                 $ratio_subtotal_nongst=($sub_total_non_gst*100)/($taxable_supply+$sub_total_non_gst+$sub_total_exempt);
                echo $ratio_subtotal_exempt=($sub_total_exempt*100)/($taxable_supply+$sub_total_non_gst+$sub_total_exempt) ."<br>";
            }
        }
    }

}

?>