<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class GST_3BVs2A extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('GST_3BVs2AModel');
        $this->load->library('excel');
    }

    function index() {
//        $data['result'] = $result;
        $this->load->view('customer/GST_CompDevi3B2A');
    }

    public function import() {
        if (isset($_FILES["file_ex"]["name"])) {
            $path = $_FILES["file_ex"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            $x = "A";
//            $data = '
//		
//		<table class="table table-striped table-bordered" border="1">
//			<tr>
//                                
//				<th>MONTH</th>
//				<th>GSTR-3B</th>
//				<th>GSTR-2A</th>
//				<th>Difference</th>
//				<th>Cumulative Difference</th>
//				
//			</tr>
//		';
            $data = '';
            $worksheet = $object->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            $i = 1;
            $abc = 0;
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
                    $gstr_3b = $IGST_gstr3b + $CGST_gstr3b + $SGST_gstr3b;
                    $row_month = $row - 8;
                    $month_name = $object->getActiveSheet()->getCell($x . $row_month)->getValue();
                    $data .= '<tr>';

                    $data .= '<td>' . $month_name . '<input type="hidden" name="month' . $i . '" id="month' . $i . '" value="' . $month_name . '"></td>';
                    $data .= '<td>' . $gstr_3b . '<input type="hidden" name="gstr3b' . $i . '" id="gstr3b' . $i . '" value="' . $gstr_3b . '"></td>';

                    $array1 = array(
                        'month' => $month_name,
                        'gstr_tb' => $gstr_3b,
                    );
                } else {
                    $data .= "";
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
                    $gstr_2a = $IGST_gstr2a + $CGST_gstr2a + $SGST_gstr2a;
                    $data .= '<td>' . $gstr_2a . '<input type="hidden" name="gstr2a' . $i . '" id="gstr2a' . $i . '" value="' . $gstr_2a . '"></td>';

                    $array2 = array(
                        'gstr2a' => $gstr_2a,
                    );
                } else {
                    $data .= "";
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
                    $gstr_Difference = $IGST_Difference + $CGST_Difference + $SGST_Difference;
//                    $data .= '<td>' . $gstr_Difference . '<input type="hidden" name="gstr_difference' . $i . '" id="gstr_difference' . $i . '" value="' . $gstr_Difference . '"></td>';
                    $array3 = array(
                        'difference' => $gstr_Difference,
                    );
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

    public function get_graph() {

        $query = $this->db->query("SELECT gstr_tb FROM gstr_compare 
WHERE gstr2a !=''");
        if ($query->num_rows() > 0) {
            $result_gstr3b = $query->result();
            foreach ($result_gstr3b as $row) {
                $gstr_tb[] = $row->gstr_tb;
            }
            $abc = array();
            for ($o = 0; $o < sizeof($gstr_tb); $o++) {
                $abc[] = $gstr_tb[$o];
                $aa = settype($abc[$o], "integer");
            }


//             $query_difference = $this->db->query("SELECT gstr2a from gstr_compare");
//            if ($query_difference->num_rows() > 0) {
//                $result_difference = $query_difference->result();
//                foreach ($result_difference as $row_difference) {
//                    $difference[] = $row_difference->difference;
//                }
//                $abc2 = array();
//                for ($o1 = 0; $o1 < sizeof($difference); $o1++) {
//                    $abc2[] = $difference[$o1];
//                    $aa1 = settype($abc2[$o1], "integer");
//                }
//            } else {
//                $abc2[] = "";
//            }


            $query_difference = $this->db->query("SELECT difference FROM gstr_compare 
WHERE gstr2a !=''");
            if ($query_difference->num_rows() > 0) {
                $result_difference = $query_difference->result();
                foreach ($result_difference as $row_difference) {
                    $difference[] = $row_difference->difference;
                }
                $abc3 = array();
                for ($o1 = 0; $o1 < sizeof($difference); $o1++) {
                    $abc3[] = $difference[$o1];
                    $aa1 = settype($abc3[$o1], "integer");
                }
            } else {
                $abc3[] = "";
            }

            $query_cumu_difference = $this->db->query("SELECT cumu_difference FROM gstr_compare WHERE gstr2a !=''");
            if ($query_cumu_difference->num_rows() > 0) {
                $result_cumu_difference = $query_cumu_difference->result();
                foreach ($result_cumu_difference as $row_cumu_difference) {
                    $cumu_difference[] = $row_cumu_difference->cumu_difference;
                }
                $abc4 = array();
                for ($o1 = 0; $o1 < sizeof($cumu_difference); $o1++) {
                    $abc4[] = $cumu_difference[$o1];
                    $aa1 = settype($abc4[$o1], "integer");
                }
            } else {
                $abc4[] = "";
            }


            $query_gstr2a = $this->db->query("SELECT gstr2a FROM gstr_compare WHERE gstr2a !=''");
            if ($query_gstr2a->num_rows() > 0) {
                $result_gstr2a = $query_gstr2a->result();
                foreach ($result_gstr2a as $row_gstr2a) {
                    $gstr2a_difference[] = $row_gstr2a->gstr2a;
                }
                $abc5 = array();
                for ($o1 = 0; $o1 < sizeof($gstr2a_difference); $o1++) {
                    $abc5[] = $gstr2a_difference[$o1];
//                    echo($abc5);
                    $aa1 = settype($abc5[$o1], "integer");
                }
            } else {
                $abc5[] = "";
            }

            $quer_range = $this->db->query("SELECT MAX(gstr_tb) as gstrtb_max FROM gstr_compare where gstr2a !=''");
            $gstr3b_max = $quer_range->row();
            $gstrtbmax = $gstr3b_max->gstrtb_max;
            $quer_range1 = $this->db->query("SELECT MAX(gstr2a) as gstr2a_max FROM gstr_compare where gstr2a !=''");
            $gstr1_max = $quer_range1->row();
            $gstr1max = $gstr1_max->gstr2a_max;
            $max_value = (max($gstrtbmax, $gstr1max));
            
            
            $respose['message'] = "success";
            $respose['data_gstr3b'] = $abc;
            $respose['max'] = $max_value;
//            $respose['data_gstr2a'] = $abc2;
//            $respose['data_gstr_one_ammend'] = $abc2;
            $respose['difference'] = $abc3;
            $respose['cumu_difference'] = $abc4;
            $respose['gstr2a_difference'] = $abc5;
        } else {
            $respose['message'] = "fail";
            $respose['data_gstr3b'] = "";
//            $respose['data_gstr1'] = "";
//            $respose['data_gstr_one_ammend'] = "";
            $respose['difference'] = "";
            $respose['cumu_difference'] = "";
            $respose['gstr2a_difference'] = "";
        }
        echo json_encode($respose);
    }

}

?>