<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Threeb_vs_one extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Threeb_vs_one_model');
        $this->load->library('excel');
    }

    function index() { //load the view page data
        $session_data = $this->session->userdata('login_session');
        $customer_id = ($session_data['customer_id']);
        $query_res = $this->Threeb_vs_one_model->get_gstr1vs3b_data($customer_id);
        if ($query_res !== FALSE) {
            $data['gstr1_vs_3b_data'] = $query_res;
        } else {
            $data['gstr1_vs_3b_data'] = "";
        }
        $this->load->view('customer/Threeb_vs_one', $data);
    }

    function index_admin() { //load the view page data
       
        $query_res = $this->Threeb_vs_one_model->get_gstr1vs3b_data_admin();
        if ($query_res !== FALSE) {
            $data['gstr1_vs_3b_data'] = $query_res;
        } else {
            $data['gstr1_vs_3b_data'] = "";
        }
        $this->load->view('admin/Threeb_vs_one', $data);
    }

    // function to get data from excel file
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

            $cmpr_id = $this->compare_unique_id();
            $array_id = array(
                'compare_id' => $cmpr_id,
            );
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


                    $data1 = array_merge($array_id, $array1, $array2, $array3, $array4, $array5);
                    $res = $this->Threeb_vs_one_model->insert_GST3Bvs1($data1);

                    if ($res === TRUE) {
                        $abc++;
                    }
                }
            }
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

    // function to get graph
    public function get_graph() {
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $query = $this->db->query("SELECT month,gstr1_3B,gstr1,gstr1_ammend,gstr1_difference,gstr1_cummulative from comparison_summary_all where customer_id='$customer_id' "
                . "and insert_id='$insert_id' order by id desc ");
        $data = ""; //view observations
        if ($query->num_rows() > 0) {

            $result = $query->result();
            $gstr_tb1 = array();
            $gstr_one2 = array();
            $gstr_one_ammend3 = array();
            $difference4 = array();
            $cumu_difference5 = array();
            $data .= '<div class="row">
                    <div class="col-md-12">
                        <div class="">
                         <table id="example2" class="table table-bordered table-striped">
                                <thead style="background-color: #00008B;color:white">
                                    <tr>
                                        <th>No.</th>
                                        <th>Month</th>
                                        <th>GSTR-3B</th>
                                        <th>GSTR-1</th>
                                        <th>Difference</th>
                                        <th>Cummulative Difference</th>
                                    </tr>
                                </thead>
                                <tbody>';
            $k = 1;
            foreach ($result as $row) {
                $gstr_tb = $row->gstr1_3B;
                $gstr_one = $row->gstr1;
                $gstr_one_ammend = $row->gstr1_ammend;
                $difference = $row->gstr1_difference;
                $cumu_difference = $row->gstr1_cummulative;
                $month = $row->month;

                $gstr_tb1[] = $gstr_tb;
                $gstr_one2[] = $gstr_one;
                $gstr_one_ammend3[] = $gstr_one_ammend;
                $difference4[] = $difference;
                $cumu_difference5[] = $cumu_difference;
                $months[] = $row->month;

                $data .= '<tr>' .
                        '<td>' . $k . '</td>' .
                        '<td>' . $month . '</td>' .
                        '<td>' . $gstr_tb . '</td>' .
                        '<td>' . $gstr_one . '</td>' .
                        '<td>' . $difference . '</td>' .
                        '<td>' . $cumu_difference . '</td>' .
                        '</tr>';
                $k++;
            }
            $data .= '<tr>' .
                    '<td>' . '<b>Total</b>' . '</td>' .
                    '<td>' . '' . '</td>' .
                    '<td>' . '<b>' . $ttl1 = array_sum($gstr_tb1) . '</b> ' . '</td>' .
                    '<td>' . '<b>' . $ttl2 = array_sum($gstr_one2) . '</b>' . '</td>' .
                    '<td>' . '<b>' . array_sum($difference4) . '</b>' . '</td>' .
                    '<td>' . '<b>' . array_sum($cumu_difference5) . '</b>' . '</td>' .
                    '</tr>';
            $data .= '</tbody></table></div></div></div>';
            
            if ($ttl1 > $ttl2) {
                $data .= "<hr><h4><b>Observation of GSTR-3B vs GSTR-1:</b></h4>";
                $data .= '<span><b>1.</b>Value of GSTR-3B is greater than GSTR-1 ,It may impact your vendor relationshion and they shall not get the input tax credit though you have correctly paid the tax on such sales.<br>';
            } elseif ($ttl2 > $ttl1) {
                $data .= "<hr><h4><b>Observation of GSTR-3B vs GSTR-1:</b></h4>";
                $data .= '<span><b>1.</b> Value of GSTR-1 is greater than GSTR-3B ,Then it mean that output tax liability has not  been paid to govt. in full in comparision to the output tax liability reflected in sales return, this may lead to interest penalties,GST notices & also effect your gst rating leading to adverse GST scrutinies selection.<br>';
            } else {
                $data .= "<hr><h4><b>Observation of GSTR-3B vs GSTR-1:</b></h4>";
                $data .= 'No difference.';
            }
            $abc1 = array();
            $abc2 = array();
            $abc3 = array();
            $abc4 = array();
            $abc5 = array();

            for ($o = 0; $o < sizeof($gstr_tb1); $o++) {
                $abc1[] = $gstr_tb1[$o];
                $aa1 = settype($abc1[$o], "float");

                $abc2[] = $gstr_one2[$o];
                $aa2 = settype($abc2[$o], "float");

                $abc3[] = $gstr_one_ammend3[$o];
                $aa3 = settype($abc3[$o], "float");

                $abc4[] = $difference4[$o];
                $aa4 = settype($abc4[$o], "float");

                $abc5[] = $cumu_difference5[$o];
                $aa5 = settype($abc5[$o], "float");
            }
            //function to get customer name
            $quer2 = $this->db->query("SELECT customer_name from customer_header_all WHERE customer_id='$customer_id'");

            if ($quer2->num_rows() > 0) {
                $res2 = $quer2->row();
                $customer_name = $res2->customer_name;
            }

            $quer_range = $this->db->query("SELECT MAX(gstr1_3B) as gstrtb_max FROM comparison_summary_all WHERE customer_id='$customer_id' and insert_id='$insert_id' order by id desc");
            $gstr3b_max = $quer_range->row();
            $gstrtbmax = $gstr3b_max->gstrtb_max;
            $quer_range1 = $this->db->query("SELECT MAX(gstr1) as gstr1_max FROM comparison_summary_all WHERE customer_id='$customer_id' and insert_id='$insert_id'  order by id desc");
            $gstr1_max = $quer_range1->row();
            $gstr1max = $gstr1_max->gstr1_max;
            $max_value = (max($gstrtbmax, $gstr1max));

            $respose['data'] = $data;
            $respose['message'] = "success";
            $respose['data_gstr3b'] = $abc1;
            $respose['data_gstr1'] = $abc2;
            $respose['max'] = $max_value;
            $respose['data_gstr_one_ammend'] = $abc3;
            $respose['customer_name'] = $customer_name;
            $respose['month_data'] = $months; //months 
            $respose['difference'] = $abc4;
            $respose['cumu_difference'] = $abc5;
        } else {
            $respose['data'] = "";
            $respose['message'] = "fail";
            $respose['data_gstr3b'] = "";
            $respose['data_gstr1'] = "";
            $respose['data_gstr_one_ammend'] = "";
            $respose['difference'] = "";
            $respose['cumu_difference'] = "";
        }
        echo json_encode($respose);
    }

    // generate unique id for compare
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