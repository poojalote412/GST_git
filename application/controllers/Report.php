<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    public function index($customer_id = '', $insert_id = '', $cust_name = '') {
        $query_get_customer_name = $this->db->query("SELECT customer_name from customer_header_all where customer_id='$customer_id'");
        $result = $query_get_customer_name->row();
        $query_get_insert_header = $this->db->query("SELECT year_id from insert_header_all where insert_id='$insert_id'");
        $result1 = $query_get_insert_header->row();
        $query_get_company_header = $this->db->query("SELECT * from observation_transaction_all where insert_id='$insert_id' and customer_id='$customer_id'");
        $result2 = $query_get_company_header->row();
        $query_get_report_header = $this->db->query("SELECT * from report_header_all where insert_id='$insert_id' and customer_id='$customer_id'");
        $result3 = $query_get_report_header->row();
        $query_get_client_letter = $this->db->query("select customer_header_all.customer_name,customer_header_all.customer_address,report_header_all.company_name,report_header_all.managing_director_name from customer_header_all INNER JOIN report_header_all on customer_header_all.customer_id= report_header_all.customer_id where customer_header_all.customer_id ='$customer_id' and report_header_all.insert_id ='$insert_id'");
        $result4 = $query_get_client_letter->row();
        
        $data['customer_id'] = $customer_id;
        $data['customer_details'] = $result;
        $data['insert_header_details'] = $result1;
        $data['company_details'] = $result2;
        $data['report_details'] = $result3;
        $data['client_details'] = $result4;
        $data['insert_id'] = $insert_id;
        $data['cust_name'] = $cust_name;
        $this->load->view('admin/Generate_report', $data);
    }

    public function load_pg() {
        $this->load->view('admin/dummy_report');
    }

    public function enter_detail_fun($customer_id = '', $insert_id = '') {
        $customer_id1 = base64_decode($customer_id);
        $insert_id1 = base64_decode($insert_id);
        $data['customer_id'] = base64_decode($customer_id);
        $data['insert_id'] = base64_decode($insert_id);
        $query = $this->db->query("select * from customer_header_all where customer_id='$customer_id1'");
        $result = $query->row();
        $data['cust_result'] = $result;




        $this->load->view('admin/client_details', $data);
    }
    
    public function get_content_pdf1() {
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $query_get_company_header = $this->db->query("SELECT company_name from report_header_all where insert_id='$insert_id' and customer_id='$customer_id'");$query_get_customer_name = $this->db->query("select customer_name,customer_address from customer_header_all where customer_id='$customer_id'");
        if ($this->db->affected_rows() > 0) {
            $res = $query_get_company_header->row();
            $company_name = $res->company_name;
            $data = '<div style="float:left;margin-left: 30px">
                <b style="font-size:18px;color:#1d2f66;">2. EXECUTIVE SUMMARY</b><br><br>
                     <p> Ecovis RKCA was provided with the data of the company  "'.$company_name.'" to evaluate this health check report.</p>    
                      <p>Ecovis RKCA  was also able to access all the information such as:</p>
                      <p>1. Sales data month wise.</p>
                      <p>2. GSTR-1 </p>
                      <p>3. GSTR-3B.</p>
                      <p>And  Ecovis RKCA. Uses this data to provide them with GST insights in form of:</p>
                      <p>1. Management Report</p>
                      <p>2. Compliance Report</p>
                      <p>3. Internal control Reports</p>
                      <p>4. Mismatch Reports</p>
                      <p>5. Deviation Reports</p>
                      <p>6. CFO Dashboard</p>
                      <p>This will help the company immensely for their development.</p>
                      	<p>We also evaluated some areas of improvement.</p>
                     </div>';


            $respose['data'] = $data;
            $respose['message'] = "success";
        } else {
            $respose['message'] = "";
        }echo json_encode($respose);
    }
    
    
    
     public function get_rating_card() {
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $query_get_data = $this->db->query("SELECT time_over_run,internal_control,transaction_mismatch,deviation_itc,deviation_output,gst_payable "
                . "from observation_transaction_all where customer_id='$customer_id' and insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
        $data = "";
//        $data1 = "";
        if ($this->db->affected_rows() > 0) {
            $result_observation1 = $query_get_data->row();

            $t1 = $result_observation1->time_over_run;
            $a1 = explode(",", $t1);
            $time_over_run1 = (1 * $a1[0]);
            $time_over_run2 = (1 * $a1[1]);
            $time_over_run3 = $time_over_run1 * $time_over_run2;
            $t2 = $result_observation1->internal_control;
            $a2 = explode(",", $t2);
            $internal_control1 = (1 * $a2[0]);
            $internal_control2 = (1 * $a2[1]);
            $internal_control3 = $internal_control1 * $internal_control2;
            $t3 = $result_observation1->transaction_mismatch;
            $a3 = explode(",", $t3);
            $transaction_mismatch1 = (1 * $a3[0]);
            $transaction_mismatch2 = (1 * $a3[1]);
            $transaction_mismatch3 = $transaction_mismatch1 * $transaction_mismatch2;
            $t4 = $result_observation1->deviation_itc;
            $a4 = explode(",", $t4);
            $deviation_itc1 = (1 * $a4[0]);
            $deviation_itc2 = (1 * $a4[1]);
            $deviation_itc3 = $deviation_itc1 * $deviation_itc2;
            $t5 = $result_observation1->deviation_output;
            $a5 = explode(",", $t5);
            $deviation_output1 = (1 * $a5[0]);
            $deviation_output2 = (1 * $a5[1]);
            $deviation_output3 = $deviation_output1 * $deviation_output2;
            $t6 = $result_observation1->gst_payable;
            $a6 = explode(",", $t6);
            $gst_payable1 = (1 * $a6[0]);
            $gst_payable2 = (1 * $a6[1]);
            $gst_payable3 = $gst_payable1 * $gst_payable2;


            $final_value = ($time_over_run3) * 10 + ($internal_control1) * 20 + ($transaction_mismatch3) * 20 + ($deviation_output3) * 20 + ($gst_payable3) * 10;
            if ($final_value > 100 && $final_value <= 500) {
                $bg_clr1 = "#009746";
            } elseif ($final_value >= 501 && $final_value <= 1000) {
                $bg_clr1 = "#feed00";
            } else {
                $bg_clr1 = "#e31e25";
            }

            $get_bg_color = $this->get_bg_color_fun($time_over_run3, $internal_control3, $transaction_mismatch3, $deviation_itc3, $deviation_output3, $gst_payable3);
//            $data1 .= '<h3><b>6.Issue Matrix</b></h3>';
            $data .= '<table id="heat_map_tbl_id" class="table-bordered table-striped" width="800">
                                <thead style="color:white">
                                    <tr>
                                        <th bgcolor="#C7273D" height="20">No.</th>
                                        <th bgcolor="#C7273D" height="20">Risk Element</th>
                                        <th bgcolor="#C7273D" height="20">Risk Score</th>
                                        <th bgcolor="#C7273D" height="20">Weightage</th>
                                        <th bgcolor="#C7273D" height="20">Weightage Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                <td>1.</td>
                                <td>Time over-run resulting into penalties.</td>
                                <td bgcolor="' . $get_bg_color[0] . '">' . $time_over_run3 . '</td>
                                <td>10</td>
                                <td>' . ($time_over_run3) * 10 . '</td>
                                </tr>
                                <tr>
                                <td>2.</td>
                                <td>Lack of Internal control management leads to interest penalties GST Notices, inefficient working capital management.</td>
                                <td bgcolor="' . $get_bg_color[1] . '">' . $internal_control1 . '</td>
                                <td>20</td>
                                <td>' . ($internal_control1) * 20 . '</td>
                                </tr>
                                <tr>
                                <td>3.</td>
                                <td>Mismatches of transactions leads to loss of ITC, Interest, Liability or GST Notices</td>
                                <td bgcolor="' . $get_bg_color[2] . '">' . $transaction_mismatch3 . '</td>
                                <td>20</td>
                                <td>' . ($transaction_mismatch3) * 20 . '</td>
                                </tr>
                                <tr>
                                <td>4.</td>
                                <td>Deviation in ITC after comparing GSTR-3B vs 2A</td>
                                <td bgcolor="' . $get_bg_color[3] . '">' . $deviation_itc3 . '</td>
                                <td>20</td>
                                <td>' . ($deviation_itc3) * 20 . '</td>
                                </tr>
                                <tr>
                                <td>5.</td>
                                <td>Deviation in output liability after comparing GSTR-3B vs GSTR-1.</td>
                                <td bgcolor="' . $get_bg_color[4] . '">' . $deviation_output3 . '</td>
                                <td>20</td>
                                <td>' . ($deviation_output3) * 20 . '</td>
                                </tr>
                                <tr>
                                <td>6.</td>
                                <td>GST Payable in cash</td>
                                <td bgcolor="' . $get_bg_color[5] . '">' . $gst_payable3 . '</td>
                                <td>10</td>
                                <td>' . ($gst_payable3) * 10 . '</td>
                                </tr>
                                <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>100</td>
                                <td bgcolor="' . $bg_clr1 . '">' . $final_value . '</td>
                                </tr>
                                </tbody></table>';
            $respose['data'] = $data;
//            $respose['data1'] = $data1;
            $respose['message'] = "success";
        } else {
            $respose['message'] = "";
            $respose['likelihood_impact'] = "";
            $respose['likelihood_risk'] = "";
            $respose['data'] = "";
        }echo json_encode($respose);
    }
    

    public function update_detail_fun($customer_id = '', $insert_id = '') { //function to load update page
        $customer_id1 = base64_decode($customer_id);
        $insert_id1 = base64_decode($insert_id);
        $data['customer_id'] = base64_decode($customer_id);
        $data['insert_id'] = base64_decode($insert_id);
        $query = $this->db->query("select * from customer_header_all where customer_id='$customer_id1'");
        $result = $query->row();
        $data['cust_result'] = $result;

        $query1 = $this->db->query("select * from report_header_all where customer_id='$customer_id1' and insert_id='$insert_id1'");
        if ($this->db->affected_rows() > 0) {
            $result_observation = $query1->row();
        } else {
            $result_observation = '';
        }

        $query2 = $this->db->query("select * from observation_transaction_all where customer_id='$customer_id1' and insert_id='$insert_id1' ORDER BY ID DESC LIMIT 1");
        if ($this->db->affected_rows() > 0) {
            $result_observation1 = $query2->row();
        } else {
            $result_observation1 = '';
        }
        $data['result_observation'] = $result_observation;
        $data['result_observation1'] = $result_observation1;
        $this->load->view('admin/update_report', $data);
    }

    public function get_heat_map() {
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $query_get_data = $this->db->query("SELECT time_over_run,internal_control,transaction_mismatch,deviation_itc,deviation_output,gst_payable "
                . "from observation_transaction_all where customer_id='$customer_id' and insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
        $data = "";
//        $data1 = "";
        if ($this->db->affected_rows() > 0) {
            $result_observation1 = $query_get_data->row();

            $t1 = $result_observation1->time_over_run;
            $a1 = explode(",", $t1);
            $time_over_run1 = (1 * $a1[0]);
            $time_over_run2 = (1 * $a1[1]);
            $time_over_run3 = $time_over_run1 * $time_over_run2;
            $t2 = $result_observation1->internal_control;
            $a2 = explode(",", $t2);
            $internal_control1 = (1 * $a2[0]);
            $internal_control2 = (1 * $a2[1]);
            $internal_control3 = $internal_control1 * $internal_control2;
            $t3 = $result_observation1->transaction_mismatch;
            $a3 = explode(",", $t3);
            $transaction_mismatch1 = (1 * $a3[0]);
            $transaction_mismatch2 = (1 * $a3[1]);
            $transaction_mismatch3 = $transaction_mismatch1 * $transaction_mismatch2;
            $t4 = $result_observation1->deviation_itc;
            $a4 = explode(",", $t4);
            $deviation_itc1 = (1 * $a4[0]);
            $deviation_itc2 = (1 * $a4[1]);
            $deviation_itc3 = $deviation_itc1 * $deviation_itc2;
            $t5 = $result_observation1->deviation_output;
            $a5 = explode(",", $t5);
            $deviation_output1 = (1 * $a5[0]);
            $deviation_output2 = (1 * $a5[1]);
            $deviation_output3 = $deviation_output1 * $deviation_output2;
            $t6 = $result_observation1->gst_payable;
            $a6 = explode(",", $t6);
            $gst_payable1 = (1 * $a6[0]);
            $gst_payable2 = (1 * $a6[1]);
            $gst_payable3 = $gst_payable1 * $gst_payable2;

            $get_bg_color = $this->get_bg_color_fun($time_over_run3, $internal_control3, $transaction_mismatch3, $deviation_itc3, $deviation_output3, $gst_payable3);
//            $data1 .= '<h3><b>6.Issue Matrix</b></h3>';
            $data .= '<table id="heat_map_tbl_id" class="table-bordered table-striped" width="800">
                                <thead style="color:white">
                                    <tr>
                                        <th bgcolor="#C7273D" height="20">No.</th>
                                        <th bgcolor="#C7273D" height="20">Risk Element</th>
                                        <th bgcolor="#C7273D" height="20">Mitigant/Controls</th>
                                        <th bgcolor="#C7273D" height="20">Likelihood</th>
                                        <th bgcolor="#C7273D" height="20">Impact</th>
                                        <th bgcolor="#C7273D" height="20">Risk Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                <td>1.</td>
                                <td>Time over-run resulting into penalties.</td>
                                <td>File GSTR monthly before duedate to avoid any penalties.</td>
                                <td>' . $time_over_run1 . '</td>
                                <td>' . $time_over_run2 . '</td>
                                <td bgcolor="' . $get_bg_color[0] . '">' . $time_over_run3 . '</td>
                                </tr>
                                <tr>
                                <td>2.</td>
                                <td>Lack of Internal control management leads to interest penalties GST Notices, inefficient working capital management.</td>
                                <td>Recording of invoices needs to be reviewed.</td>
                                <td>' . $internal_control1 . '</td>
                                <td>' . $internal_control2 . '</td>
                                <td bgcolor="' . $get_bg_color[1] . '">' . $internal_control1 . '</td>
                                </tr>
                                <tr>
                                <td>3.</td>
                                <td>Mismatches of transactions leads to loss of ITC, Interest, Liability or GST Notices</td>
                                <td>Follow-up with the clients with whom out transactions are mismatched. Also invoice processing for GST Claim & Reconciliation need to be reviewed.</td>
                                <td>' . $transaction_mismatch1 . '</td>
                                <td>' . $transaction_mismatch2 . '</td>
                                <td bgcolor="' . $get_bg_color[2] . '">' . $transaction_mismatch3 . '</td>
                                </tr>
                                <tr>
                                <td>4.</td>
                                <td>Deviation in ITC after comparing GSTR-3B vs 2A</td>
                                <td>Check the eligibility and ineligibility of credit reflecting in GSTR-2A and prepare reconciliation statement accordingly.</td>
                                <td>' . $deviation_itc1 . '</td>
                                <td>' . $deviation_itc2 . '</td>
                                <td bgcolor="' . $get_bg_color[3] . '">' . $deviation_itc3 . '</td>
                                </tr>
                                <tr>
                                <td>5.</td>
                                <td>Deviation in output liability after comparing GSTR-3B vs GSTR-1.</td>
                                <td>Regular follow-ups with the client.</td>
                                <td>' . $deviation_output1 . '</td>
                                <td>' . $deviation_output2 . '</td>
                                <td bgcolor="' . $get_bg_color[4] . '">' . $deviation_output3 . '</td>
                                </tr>
                                <tr>
                                <td>6.</td>
                                <td>GST Payable in cash</td>
                                <td>Analysis of huge payment by cash to be done & accordingly ITC planning should be done.</td>
                                <td>' . $gst_payable1 . '</td>
                                <td>' . $gst_payable2 . '</td>
                                <td bgcolor="' . $get_bg_color[5] . '">' . $gst_payable3 . '</td>
                                </tr>
                                </tbody></table>';
            $likelihood_impact = [[$time_over_run1, $time_over_run2], [$internal_control1, $internal_control2], [$transaction_mismatch1, $transaction_mismatch2],
                [$deviation_itc1, $deviation_itc2], [$deviation_output1, $deviation_output2], [$gst_payable1, $gst_payable2]];
            $likelihood_risk = [[$time_over_run1, $time_over_run3], [$internal_control1, $internal_control3], [$transaction_mismatch1, $transaction_mismatch3],
                [$deviation_itc1, $deviation_itc3], [$deviation_output1, $deviation_output3], [$gst_payable1, $gst_payable3]];
            $respose['likelihood_impact'] = $likelihood_impact;
            $respose['likelihood_risk'] = $likelihood_risk;
            $respose['data'] = $data;
//            $respose['data1'] = $data1;
            $respose['message'] = "success";
        } else {
            $respose['message'] = "";
            $respose['likelihood_impact'] = "";
            $respose['likelihood_risk'] = "";
            $respose['data'] = "";
        }echo json_encode($respose);
    }

    public function get_bg_color_fun($time_over_run3, $internal_control3, $transaction_mismatch3, $deviation_itc3, $deviation_output3, $gst_payable3) {
        if ($time_over_run3 > 0 && $time_over_run3 <= 6) {
            $bg_clr1 = "#009746";
        } elseif ($time_over_run3 > 6 && $time_over_run3 <= 11) {
            $bg_clr1 = "#feed00";
        } else {
            $bg_clr1 = "#e31e25";
        }
        if ($internal_control3 > 0 && $internal_control3 <= 6) {
            $bg_clr2 = "#009746";
        } elseif ($internal_control3 > 6 && $internal_control3 <= 11) {
            $bg_clr2 = "#feed00";
        } else {
            $bg_clr2 = "#e31e25";
        }
        if ($transaction_mismatch3 > 0 && $transaction_mismatch3 <= 6) {
            $bg_clr3 = "#009746";
        } elseif ($transaction_mismatch3 > 6 && $time_over_run3 <= 11) {
            $bg_clr3 = "#feed00";
        } else {
            $bg_clr3 = "#e31e25";
        }
        if ($deviation_itc3 > 0 && $deviation_itc3 <= 6) {
            $bg_clr4 = "#009746";
        } elseif ($deviation_itc3 > 6 && $deviation_itc3 <= 11) {
            $bg_clr4 = "#feed00";
        } else {
            $bg_clr4 = "#e31e25";
        }
//        echo $deviation_output3;
        if ($deviation_output3 > 0 && $deviation_output3 <= 6) {
            $bg_clr5 = "#009746";
        } elseif ($deviation_output3 > 6 && $deviation_output3 <= 11) {
            $bg_clr5 = "#feed00";
        } else {
            $bg_clr5 = "#e31e25";
        }
        if ($gst_payable3 > 0 && $gst_payable3 <= 6) {
            $bg_clr6 = "#009746";
        } elseif ($gst_payable3 > 6 && $gst_payable3 <= 11) {
            $bg_clr6 = "#feed00";
        } else {
            $bg_clr6 = "#e31e25";
        }
        return array($bg_clr1, $bg_clr2, $bg_clr3, $bg_clr4, $bg_clr5, $bg_clr6);
    }

}

?>