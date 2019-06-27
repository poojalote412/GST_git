<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class GST_AccReport extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {
//        $data['result'] = $result;
        $this->load->view('customer/GST_Account');
    }

    public function import() {
        if (isset($_FILES["file_ex"]["name"])) {
            $path = $_FILES["file_ex"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            $x = "A";

            $data = '';
            $worksheet = $object->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            $i = 1;
            $abc = 0;
            for ($row = 7; $row <= $highestRow; $row++) {
//                $row_next = $row + 1;
//                $row_prev = $row - 1;

                if ($object->getActiveSheet()->getCell('R' . 5)->getValue() !== "Due Date") {

                    $outward = array();
                    for ($l = 7; $l <= 18; $l++) {
                        $val = $object->getActiveSheet()->getCell('R' . $l)->getValue();
//                         $val1 = $object->getActiveSheet()->getCell('S' . $l)->getValue();
                        $outward[] = $val;
                    }
                    $outward1 = array();
                    for ($l = 7; $l <= 18; $l++) {
                        $val = $object->getActiveSheet()->getCell('S' . $l)->getValue();
//                         $val1 = $object->getActiveSheet()->getCell('S' . $l)->getValue();
                        $outward1[] = $val;
                    }
                } else {
                    $data .= "";
                }
                
                
                if ($object->getActiveSheet()->getCell('B' . 5)->getValue() == "Filling Date" && $object->getActiveSheet()->getCell('R' . 5)->getValue() == "Month") {
                     $reverse_charge = array();
                for ($p = 24; $p <= 35; $p++) {
                    $val_a = $object->getActiveSheet()->getCell('R' . $p)->getValue();
                    $val1 = $object->getActiveSheet()->getCell('S' . $l)->getValue();
                    $reverse_charge[] = $val_a+$val1;
                }
                    
                } else {
                    $data .= "";
                }

              

//            
            }
            
               $quer = $this->db->query("insert into 3b_offset_summary (`filling_date`,`due_date`,`late_fees`)"
                        . " values ('$outward[$t]','$outward1[$t]','$reverse_charge[$t]') ");
            
//           
        } 
    }

}

?>