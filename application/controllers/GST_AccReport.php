<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class GST_AccReport extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {
//        $data['result'] = $result;
        $this->load->view('GST_Account');
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
                $row_next = $row + 1;
                $row_prev = $row - 1;

                if ($object->getActiveSheet()->getCell('B' . 5)->getValue() == "Month" && $object->getActiveSheet()->getCell('R' . 5)->getValue() !== "Due Date") {

                    $outward = array();
                    for ($l = 7; $l <= 18; $l++) {
                        $val = $object1->getActiveSheet()->getCell('R' . $l)->getValue();
                         $val1 = $object1->getActiveSheet()->getCell('S' . $l)->getValue();
                        $outward[] = $val+$val1;
                    }
                } else {
                    $data .= "";
                }
                if ($object->getActiveSheet()->getCell('B' . 5)->getValue() == "Filling Date" && $object->getActiveSheet()->getCell('R' . 5)->getValue() == "Month") {
                     $reverse_charge = array();
                for ($p = 24; $p <= 35; $p++) {
                    $val_a = $object1->getActiveSheet()->getCell('R' . $p)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('S' . $l)->getValue();
                    $reverse_charge[] = $val_a+$val1;
                }
                    
                } else {
                    $data .= "";
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
                    $cumm_diff = $IGST_cumm_diff + $CGST_cumm_diff + $SGST_cumm_diff;
                    $data .= '<td>' . $cumm_diff . '<input type="hidden" name="cumm_diff' . $i . '" id="cumm_diff' . $i . '" value="' . $cumm_diff . '"></td>';

                    $data .= '</tr>';
                    $i++;
                    $array4 = array(
                        'cumu_difference' => $cumm_diff,
                    );
                    $count = $i;
                    $i++;


                    $data1 = array_merge($array1, $array2, $array3, $array4);
                    $res = $this->GST_3BVs2AModel->insert_GST3Bvs2A($data1);

                    if ($res === TRUE) {
                        $abc++;
                    }
                }


//            
            }
//            echo $abc;
            if ($abc > 0) {
                $respose['message'] = "success";
                $respose['status'] = true;
                $response['code'] = 200;
            } else {
//                    $data .= "";
                $respose['message'] = "";
                $respose['status'] = false;
                $response['code'] = 204;
            }echo json_encode($respose);


            if ($x !== $highestColumn) {
                $x++;
            }

            $data .= '</table>';
            $data .= '<input type="hidden" name="count" id="count" value="' . $count . '">';
//            echo $data;
        } else {
            echo 'Data Not Imported';
        }
    }

}

?>