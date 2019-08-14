<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Threeb_vs_twoa extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Threeb_vs_twoa_model');
        $this->load->library('excel');
    }

    function index() {
        $session_data = $this->session->userdata('login_session');
        $customer_id = ($session_data['customer_id']);
        $query_res = $this->Threeb_vs_twoa_model->get_gstr1vs2A_data($customer_id);
        if ($query_res !== FALSE) {
            $data['gstr1_vs_2a_data'] = $query_res;
        } else {
            $data['gstr1_vs_2a_data'] = "";
        }
        $this->load->view('customer/Threeb_vs_twoa', $data);
    }

    function index_admin() {
//        $session_data = $this->session->userdata('login_session');
//        $customer_id = ($session_data['customer_id']);
        $query_res = $this->Threeb_vs_twoa_model->get_gstr1vs2A_data_admin();
        if ($query_res !== FALSE) {
            $data['gstr1_vs_2a_data'] = $query_res;
        } else {
            $data['gstr1_vs_2a_data'] = "";
        }
        $this->load->view('admin/Threeb_vs_twoa', $data);
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
            $compare_id = $this->compare_unique_id();
            $array_id = array(
                'compare_id' => $compare_id,
            );
            if ($object->getActiveSheet()->getCell('A4')->getValue() == "Grand Total" && $object->getActiveSheet()->getCell('A5')->getValue() == "3.1 Details of Outward Supplies") {
                
            } elseif ($object->getActiveSheet()->getCell('A4')->getValue() != "Grand Total" && $object->getActiveSheet()->getCell('A5')->getValue() != "3.1 Details of Outward Supplies") {
                $response['id'] = 'file_ex';
                $response['error'] = 'File is wrong';
                echo json_encode($response);
                exit();
            } else {
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



                        $data1 = array_merge($array_id, $array1, $array2, $array3, $array4);
                        $res = $this->Threeb_vs_twoa_model->insert_GST3Bvs2A($data1);

                        if ($res === TRUE) {
                            $abc++;
                        }
                    }
                }

//            echo $abc;
                if ($abc > 0) {
                    $response['message'] = "success";
                    $response['status'] = true;
                    $response['code'] = 200;
                } else {
//                    $data .= "";
                    $response['message'] = "no data";
                    $response['status'] = false;
                    $response['code'] = 204;
                }echo json_encode($response);
            }
        } else {
            echo 'Data Not Imported';
        }
    }

    public function get_graph() { //function to get graph
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");

        $query = $this->db->query("SELECT month,gstr2A_3B,gstr2A_difference,gstr2A_cummulative,gstr2A FROM comparison_summary_all WHERE customer_id='$customer_id' AND insert_id='$insert_id' order by id desc");
        $data = ""; //view observations
        if ($query->num_rows() > 0) {

            $result = $query->result();
            $gstr_tb1 = array();
            $difference2 = array();
            $cumu_difference3 = array();
            $gstr2a4 = array();
            $months = array();
            $data .= '<div class="row">
                    <div class="col-md-12">
                        <div class="">
                         <table id="example2" class="table table-bordered table-striped">
                                <thead style="background-color: #00008B;color:white">
                                    <tr>
                                        <th>No.</th>
                                        <th>Month</th>
                                        <th>GSTR-3B</th>
                                        <th>GSTR-2A</th>
                                        <th>Difference</th>
                                        <th>Cummulative Difference</th>
                                    </tr>
                                </thead>
                                <tbody>';
            $k = 1;
            foreach ($result as $row) { //to get values
                $gstr_tb = $row->gstr2A_3B;
                $difference = $row->gstr2A_difference;
                $cumu_difference = $row->gstr2A_cummulative;
                $gstr2a = $row->gstr2A;
                $month = $row->month;

                //arrays
                $gstr_tb1[] = $gstr_tb;
                $difference2[] = $difference;
                $cumu_difference3[] = $cumu_difference;
                $gstr2a4[] = $gstr2a;
                $months[] = $row->month;

                $data .= '<tr>' .
                        '<td>' . $k . '</td>' .
                        '<td>' . $month . '</td>' .
                        '<td>' . $gstr_tb . '</td>' .
                        '<td>' . $gstr2a . '</td>' .
                        '<td>' . $difference . '</td>' .
                        '<td>' . $cumu_difference . '</td>' .
                        '</tr>';
                $k++;
            }
            //to get total values
            $data .= '<tr>' .
                    '<td>' . '<b>Total</b>' . '</td>' .
                    '<td>' . '' . '</td>' .
                    '<td>' . '<b>' . $thb = array_sum($gstr_tb1) . '</b> ' . '</td>' .
                    '<td>' . '<b>' . $twa = array_sum($gstr2a4) . '</b>' . '</td>' .
                    '<td>' . '<b>' . array_sum($difference2) . '</b>' . '</td>' .
                    '<td>' . '<b>' . array_sum($cumu_difference3) . '</b>' . '</td>' .
                    '</tr>';
            $data .= '</tbody></table></div></div></div>';

            $data .= "<div class='col-md-12'><br><br><h4><b>Observation of GSTR-3B vs GSTR-2A:</b></h4>";
            if ($thb > $twa) {
                $data .= '<span>GSTR-3B > 2A, ITC declared and ITC claimed is showing a huge difference as either the company has taken excess credit or vendor has not recorded our purchases in his GSTR 1. '
                        . 'This may lead to interest liability & penalties notices or permanent loss of credit if vendor is not informed and corrective action is not taken by such vendor.</span></div>';
            } elseif ($twa > $thb) {
                $data .= '<span>GSTR-3B < 2A, company need to check the eligibility and ineligibility of credit reflecting in GSTR-2A & prepare a reconciliation statement accordingly. There may be the case where input tax credit has not been taken by the company on its genuine eligible input credit. '
                        . 'This may lead to a huge loss of working Capital & also permanent loss of credit if corrective actions not taken immediately.</span></div>';
            } else {
                $data .= '<span>No difference.</span></div>';
            }
            $abc = array();
            $abc3 = array();
            $abc4 = array();
            $abc5 = array();

            for ($o = 0; $o < sizeof($gstr_tb1); $o++) { //loop to convert string data into integer
                $abc[] = $gstr_tb1[$o];
                $aa1 = settype($abc[$o], "float");

                $abc3[] = $difference2[$o];
                $aa2 = settype($abc3[$o], "float");

                $abc4[] = $cumu_difference3[$o];
                $aa3 = settype($abc4[$o], "float");

                $abc5[] = $gstr2a4[$o];
                $aa4 = settype($abc5[$o], "float");
            }


            $quer_range = $this->db->query("SELECT MAX(gstr2A_3B) as gstrtb_max FROM comparison_summary_all WHERE customer_id='$customer_id' and insert_id='$insert_id' order by id desc");
            $gstr3b_max = $quer_range->row();
            $gstrtbmax = $gstr3b_max->gstrtb_max;
            $quer_range1 = $this->db->query("SELECT MAX(gstr2A) as gstr2a_max FROM comparison_summary_all WHERE customer_id='$customer_id' and insert_id='$insert_id' order by id desc");
            $gstr1_max = $quer_range1->row();
            $gstr1max = $gstr1_max->gstr2a_max;
            $max_value = (max($gstrtbmax, $gstr1max));

            $respose['data'] = $data; //data of observation
            $respose['message'] = "success";
            $respose['gstr_tb'] = $abc; //data of gstr 3b
            $respose['max'] = $max_value; //max values
            $respose['difference'] = $abc3; //difference of 3b and 2a
            $respose['cumu_difference'] = $abc4; //cummulative difference of 3b and 2a
            $respose['gstr2a'] = $abc5; //data of gstr2a
            $respose['month_data'] = $months; //months
        } else {
            $respose['data'] = "";
            $respose['message'] = "fail";
            $respose['gstr_tb'] = "";
            $respose['difference'] = "";
            $respose['cumu_difference'] = "";
            $respose['gstr2a'] = "";
        }
        echo json_encode($respose);
    }

    public function compare_unique_id() {
        $result = $this->db->query('SELECT compare_id FROM `gstr_compare` ORDER BY compare_id DESC LIMIT 0,1');
        if ($result->num_rows() > 0) {
            $data = $result->row();
            $comp_id = $data->compare_id;
            //generate user_id
            $comp_id = str_pad(++$comp_id, 5, '0', STR_PAD_LEFT);
            return $comp_id;
        } else {
            $comp_id = 'cmpr_1001';
            return $comp_id;
        }
    }

}

?>