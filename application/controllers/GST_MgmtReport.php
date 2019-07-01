<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class GST_MgmtReport extends CI_Controller {

    public function __construct() {
        parent::__construct();
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
        if (isset($_FILES["file_ex"]["name"])) {
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
//            $n = 0;
//            for ($i1 = 8; $i1 <= $highestRow; $i1++) { //to get third total row
//                if ($object->getActiveSheet()->getCell('B' . $i1)->getValue() == "Total") {
//                    $n++;
//                }
//                if ($n == 3) {
//                    break;
//                }
//            }
//            $value_third_row = $i1; //3rd total row 

            $total_row_num = $i;
            $all_state = array();
            $str="(4) Cr Note Details";
            
            for ($k = 8; $k < $total_row_num; $k++) { //loop get state data
                $all_state[] = $object->getActiveSheet()->getCell('D' . $k)->getValue();
            }
            $states = array_unique($all_state); //unique array of state
            $count = count($states);
            $a1=0;
            for ($m = 0; $m < $count; $m++) {
                if($m<10)
                {
                    $state_new = $states[$m];
                }
                else
                {
                    $state_new = $states[0];
                }
                
                $taxable_value = 0;
                $arr_taxable_value = array();
//                echo $highestRow;
                for ($l = 8; $l <= $highestRow; $l++) { //loop to get data statewise

                    $a2=$object->getActiveSheet()->getCell('A' . $l)->getValue();
                        if($a2=="(4) Cr Note Details")
                        {
                            $a1=1;
                        }
                        else if($a2=="(5) Dr Note Details")
                        {
                            $a1=2;
                        }
                            if ($object->getActiveSheet()->getCell('D' . $l)->getValue() == $state_new) {
                                if($a1==0 or $a1==2)
                                {
                                    $tax_val = $object->getActiveSheet()->getCell('E' . $l)->getValue();
                                    $taxable_value += $tax_val;
                                }
                                else if($a1==1)
                                {
                                    $tax_val = $object->getActiveSheet()->getCell('E' . $l)->getValue();
                                    $taxable_value -= $tax_val;
                                }
                               
                           }

                }
                
                $arr_taxable_value[] = $taxable_value;
                var_dump($arr_taxable_value);
//                break;
            }
            
        }
    }

}

?>