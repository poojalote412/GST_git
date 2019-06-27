<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class GST_3BVs1 extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('GST_3BVs1Model');
        $this->load->library('excel');
    }

    function index() {
//        $query = $this->db->query("SELECT * from gstr_compare");
//        if ($query->num_rows() > 0) {
//            $result = $query->result();
//            foreach ($result as $row) {
//                $month = $row->month;
//                $gstr_tb = $row->gstr_tb;
//                $gstr_one = $row->gstr_one;
//                $gstr_one_ammend = $row->gstr_one_ammend;
//                $difference = $row->difference;
//                $cumu_difference = $row->cumu_difference;
//            }
//        } else {
//            $result = "";
//        }
//        $data['result'] = $result;
//        $data['result'] = $result;
        $result['data']=$this->GST_3BVs1Model->display_GST3Bvs1();
        $this->load->view('customer/GST_ComparisonDevi3Bvs1',$result);
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
            for ($row = 21; $row <= $highestRow; $row++) {

                $row_next = $row + 1;

                if ($object->getActiveSheet()->getCell($x . $row)->getValue() == "GSTR-3B" && $object->getActiveSheet()->getCell($x . $row_next)->getValue() == "GSTR-1") {
                    $ascii = ord($x);
                    $ascii += 2;
                    $col_IGST = chr($ascii);
                    $IGST_gstr3b = $object->getActiveSheet()->getCell($col_IGST . $row)->getValue();

                    $ascii_cgst = ord($x);
                    $ascii_cgst += 3;
                    $col_CGST = chr($ascii_cgst);
                    $CGST_gstr3b = $object->getActiveSheet()->getCell($col_CGST . $row)->getValue();

                    $ascii_sgst = ord($x);
                    $ascii_sgst += 3;
                    $col_SGST = chr($ascii_sgst);
                    $SGST_gstr3b = $object->getActiveSheet()->getCell($col_SGST . $row)->getValue();
                    $gstr_3b = $IGST_gstr3b + $CGST_gstr3b + $SGST_gstr3b;
                    $row_month = $row - 3;
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
                if ($object->getActiveSheet()->getCell($x . $row)->getValue() == "GSTR-1") {
                    $ascii = ord($x);
                    $ascii += 2;
                    $col_IGST = chr($ascii);
                    $IGST_gstr1 = $object->getActiveSheet()->getCell($col_IGST . $row)->getValue();

                    $ascii_cgst = ord($x);
                    $ascii_cgst += 3;
                    $col_CGST = chr($ascii_cgst);
                    $CGST_gstr1 = $object->getActiveSheet()->getCell($col_CGST . $row)->getValue();

                    $ascii_sgst = ord($x);
                    $ascii_sgst += 3;
                    $col_SGST = chr($ascii_sgst);
                    $SGST_gstr1 = $object->getActiveSheet()->getCell($col_SGST . $row)->getValue();
                    $gstr_1 = $IGST_gstr1 + $CGST_gstr1 + $SGST_gstr1;
                    $data .= '<td>' . $gstr_1 . '<input type="hidden" name="gstr1' . $i . '" id="gstr1' . $i . '" value="' . $gstr_1 . '"></td>';

                    $array2 = array(
                        'gstr_one' => $gstr_1,
                    );
                } else {
                    $data .= "";
                }

                if ($object->getActiveSheet()->getCell($x . $row)->getValue() == "GSTR-1 Amend(Difference)") {
                    $ascii = ord($x);
                    $ascii += 2;
                    $col_IGST = chr($ascii);
                    $IGST_gstr1_ammend = $object->getActiveSheet()->getCell($col_IGST . $row)->getValue();

                    $ascii_cgst = ord($x);
                    $ascii_cgst += 3;
                    $col_CGST = chr($ascii_cgst);
                    $CGST_gstr1_ammend = $object->getActiveSheet()->getCell($col_CGST . $row)->getValue();

                    $ascii_sgst = ord($x);
                    $ascii_sgst += 3;
                    $col_SGST = chr($ascii_sgst);
                    $SGST_gstr1_ammend = $object->getActiveSheet()->getCell($col_SGST . $row)->getValue();
                    $gstr_1_ammend = $IGST_gstr1_ammend + $CGST_gstr1_ammend + $SGST_gstr1_ammend;
                    $data .= '<td>' . $gstr_1_ammend . '<input type="hidden" name="gstr1_ammend' . $i . '" id="gstr1_ammend' . $i . '" value="' . $gstr_1_ammend . '"></td>';
                    $array3 = array(
                        'gstr_one_ammend' => $gstr_1_ammend,
                    );
                } else {
                    $data .= "";
                }
                if ($object->getActiveSheet()->getCell($x . $row)->getValue() == "(3B - (GSTR-1 + Amend)) Difference") {
                    $ascii = ord($x);
                    $ascii += 2;
                    $col_IGST = chr($ascii);
                    $IGST_gstr1_ammend_diff = $object->getActiveSheet()->getCell($col_IGST . $row)->getValue();

                    $ascii_cgst = ord($x);
                    $ascii_cgst += 3;
                    $col_CGST = chr($ascii_cgst);
                    $CGST_gstr1_ammend_diff = $object->getActiveSheet()->getCell($col_CGST . $row)->getValue();

                    $ascii_sgst = ord($x);
                    $ascii_sgst += 3;
                    $col_SGST = chr($ascii_sgst);
                    $SGST_gstr1_ammend_diff = $object->getActiveSheet()->getCell($col_SGST . $row)->getValue();
                    $ammend_diff = $IGST_gstr1_ammend_diff + $CGST_gstr1_ammend_diff + $SGST_gstr1_ammend_diff;
                    $data .= '<td>' . $ammend_diff . '<input type="hidden" name="ammend_diff' . $i . '" id="ammend_diff' . $i . '" value="' . $ammend_diff . '"></td>';
                    $array4 = array(
                        'difference' => $ammend_diff,
                    );
                } else {
                    $data .= "";
                }
                if ($object->getActiveSheet()->getCell($x . $row)->getValue() == "Cumulative Difference" && $object->getActiveSheet()->getCell($x . $row_next)->getValue() == "4 Eligible ITC") {
                    $ascii = ord($x);
                    $ascii += 2;
                    $col_IGST = chr($ascii);
                    $IGST_gstr1_ammend_cummu_diff = $object->getActiveSheet()->getCell($col_IGST . $row)->getValue();

                    $ascii_cgst = ord($x);
                    $ascii_cgst += 3;
                    $col_CGST = chr($ascii_cgst);
                    $CGST_gstr1_ammend_cummu_diff = $object->getActiveSheet()->getCell($col_CGST . $row)->getValue();

                    $ascii_sgst = ord($x);
                    $ascii_sgst += 3;
                    $col_SGST = chr($ascii_sgst);
                    $SGST_gstr1_ammend_cummu_diff = $object->getActiveSheet()->getCell($col_SGST . $row)->getValue();
                    $cummulative_diff = $IGST_gstr1_ammend_cummu_diff + $CGST_gstr1_ammend_cummu_diff + $SGST_gstr1_ammend_cummu_diff;
                    $data .= '<td>' . $cummulative_diff . '<input type="hidden" name="cumm_diff' . $i . '" id="cumm_diff' . $i . '" value="' . $cummulative_diff . '"></td>';
                    $data .= '</tr>';
                    $i++;
                    $count = $i - 1;

                    $array5 = array(
                        'cumu_difference' => $cummulative_diff,
                    );


                    $data1 = array_merge($array1, $array2, $array3, $array4, $array5);
                    $res = $this->GST_3BVs1Model->insert_GST3Bvs1($data1);

                    if ($res === TRUE) {
                        $abc++;
                    }
                }
            }
//                echo $abc;
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

        $query = $this->db->query("SELECT gstr_tb from gstr_compare where gstr2a=''");
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
            $query_gstr1 = $this->db->query("SELECT gstr_one from gstr_compare where gstr2a=''");
            if ($query_gstr1->num_rows() > 0) {
                $result_gstr1 = $query_gstr1->result();
                foreach ($result_gstr1 as $row_gstr1) {
                    $gstr_one[] = $row_gstr1->gstr_one;
                }
                $abc1 = array();
                for ($o1 = 0; $o1 < sizeof($gstr_one); $o1++) {
                    $abc1[] = $gstr_one[$o1];
                    $aa1 = settype($abc1[$o1], "integer");
                }
                $query_gstr_one_ammend = $this->db->query("SELECT gstr_one_ammend from gstr_compare where gstr2a=''");
                if ($query_gstr_one_ammend->num_rows() > 0) {
                    $result_gstr_one_ammend = $query_gstr_one_ammend->result();
                    foreach ($result_gstr_one_ammend as $row_gstr_one_ammend) {
                        $gstr_one_ammend[] = $row_gstr_one_ammend->gstr_one_ammend;
                    }
                    $abc2 = array();
                    for ($o1 = 0; $o1 < sizeof($gstr_one_ammend); $o1++) {
                        $abc2[] = $gstr_one_ammend[$o1];
                        $aa1 = settype($abc2[$o1], "integer");
                    }
                } else {
                    $abc2[] = "";
                }

                $sum_of_gstr1_gstr1_ammend = array_map(function () {
                    return array_sum(func_get_args());
                }, $abc1, $abc2);
            } else {
                $abc1[] = "";
            }


            $query_difference = $this->db->query("SELECT difference from gstr_compare where gstr2a=''");
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

            $query_cumu_difference = $this->db->query("SELECT cumu_difference from gstr_compare where gstr2a=''");
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

            $respose['message'] = "success";
            $respose['data_gstr3b'] = $abc;
            $respose['data_gstr1'] = $sum_of_gstr1_gstr1_ammend;
//            $respose['data_gstr_one_ammend'] = $abc2;
            $respose['difference'] = $abc3;
            $respose['cumu_difference'] = $abc4;
        } else {
            $respose['message'] = "fail";
            $respose['data_gstr3b'] = "";
            $respose['data_gstr1'] = "";
            $respose['data_gstr_one_ammend'] = "";
            $respose['difference'] = "";
            $respose['cumu_difference'] = "";
        }
        echo json_encode($respose);
    }

}

?>