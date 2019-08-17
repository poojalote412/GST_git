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

        $data['customer_id'] = $customer_id;
        $data['customer_details'] = $result;
        $data['insert_header_details'] = $result1;
        $data['company_details'] = $result2;
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


        $query_get_customer_name = $this->db->query("select customer_name,customer_address from customer_header_all where customer_id='$customer_id'");
        if ($this->db->affected_rows() > 0) {
            $res = $query_get_customer_name->row();
            $customer_name = $res->customer_name;
            $address = $res->customer_address;

//            $data = '<div style="float:left;">XXth March, 2019 <br>
//                  
//                    <b>Mr. ' . $customer_name . '</b><br>
//                    <b>Managing Director</b> <br>
//                    <b>Company Name: Anand Rathi Finance Private Limited</b> <br>
//                    Address :' . $address . '<br><br>
//                    
//                    </div>';

            $data = '<div style="float:left;margin-left: 30px">
                      <b style="font-size:18px;color:#1d2f66;">1. ABOUT ANAND RATHI GLOBAL FINANCE LTD.</b><br><br><br>';


            $data = '<div style="float:left;">
                      <b style="font-size:18px;color:#1d2f66;">1. ABOUT ANAND RATHI GLOBAL FINANCE LTD.</b><br><br><br>

                      <p>Anand Rathi Global Finance Limited (ARGFL) was incorporated on 3rd February, 1982. The 
                      Company is wholly owned subsidiary of Anand Rathi Financial Services Ltd. The Company is 
                      registered with Reserve Bank of India (RBI) as non-banking finance company (NBFC) and 
                      classified as a Loan company and categorized as "Systemically important non-deposit taking non-/                      banking financial company" (NBFC-ND-SI). The Company is engaged in the business of financial 
                      consultancy, corporate advisory and fund-based activities. The Company has a team of 
                      qualified people having diversified industry exposure. ARGFL had handled various 
                      consultancy projects for reputed companies both in India and abroad.</p>
                      <p>Currently, ARGFL is mainly offering Loan against securities, 
                      Commodities, Mutual Funds, Bonds, ESOPs and other liquid collaterals.
                      ARGFL has ambitious plans to expand its fund-based activities primary 
                      to provide value added products / services to the large client base of
                      the Group.</p>
                      <p>The Products include:</p>
                      <ul>
                      <li>Loan against securities</li>
                      <li>Loan against Demat-Commodities</li>
                      <li>IPO Finance</li>
                      <li>ESOPs Funding</li>
                      <li>Customized Financing</li>
                      <li>Promoter Funding</li>
                      <li>Structured Financing</li>
                      </ul>
                      </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';


            $data .= '<div style="float:left;margin-left: 30px;">
                <b style="font-size:18px;color:#1d2f66;">2. EXECUTIVE SUMMARY</b><br><br><br>
                      Ecovis RKCA was provided with the data of the company  “Anand Rathi
                      Global Finance Ltd.” to evaluate this health check report.<br>    
                      Ecovis RKCA  was also able to access all the information such as:
                

                      1. Sales data month wise.<br>
                      2. GSTR-1 <br>
                      3. GSTR-3B.<br>
                      and  Ecovis RKCA. Uses this data to provide them with GST insights in form of:<br>
                      1. Management Report<br>
                      2. Compliance Report<br>
                      3. Internal control Reports<br>
                      4. Mismatch Reports<br>
                      5. Deviation Reports<br>
                      6. CFO Dashboard<br>
                      This will help the company immensely for their development.<br>
                      	We also evaluated some areas of improvement.
                     </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';

//            
//            $data .= '<div style="float:left">
//                      <b style="font-size:18px"><u>ABBREVIATION/GLOSSARY OF TERMS:</u></b><br>
//                      1. GST- Goods and Services Tax. <br>
//                      2. GSTR- Goods and Services Tax Return.<br>
//                      3. ITC- Input Tax Credit.<br>
//                      4. GSTIN- Goods and Services Tax Identification Number.<br>
//                      5. IGST- Integrated Goods and Services Tax.<br>
//                      6. CGST- Centre Goods and Services Tax.<br>
//                      7. SGST/UTGST- State Goods and Services Tax/Union Territory Goods and Services Tax.<br>
//                      8. B2B Supply- Supply made to registered person.<br>
//                      9. B2C Supply- Supply made to unregistered person.<br>
//                      10. POS- Place Of Supply<br>
//                      11. RCM- Reverse Charge Mechanism.<br>
//                    </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
//            $data .= '<div>
//                      <b style="font-size:18px">Contents</b><br>  
//                      <div class="row">
//                      <div class="col-md-4"><p style="border: 2px;padding:6px;background:#D3D3D3"><b>About Client&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;pg.05</b></p></div>
//                      <div class="col-md-4"><p style="border: 2px;background:#002366;padding:6px;color:white"><b>Executive Summary</b></p></div>
//                      </div>
//                      <div class="row">
//                      <div class="col-md-4"><p style="border: 2px;background:#002366;padding:10px;color:white"><b>GST Components And Overview</b></p></div>
//                      <div class="col-md-4"><p style="border: 2px;padding:10px;background:#D3D3D3"><b>GST Framework&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;pg.05</b></p></div>
//                      </div>
//                      <div class="row">
//                      <div class="col-md-4"><p style="border: 2px;padding:10px;background:#D3D3D3"><b>Details of GST Reports & Insightst&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;pg.05</b></p></div>
//                      <div class="col-md-4"><p style="border: 2px;padding:10px;color:white;background:#D3D3D3"><b>Issue Matrix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;pg.05</b></p></div>
//                      
//                      </div>
//                      <div class="row">
//                      <div class="col-md-4"><p style="border: 2px;background:#002366;padding:10px;color:white"><b>Rating Card</b></p></div>
//                      <div class="col-md-4"><p style="border: 2px;padding:10px;background:#D3D3D3"><b>Conclusion&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;pg.05</b></p></div>
//                      </div>
//                      <div class="row">
//                      <div class="col-md-8"><p style="border: 2px;padding:4px;background:#D3D3D3"><b>Disclaimer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;pg.05</b></p></div>
//                      </div>
//                      <div class="row">
//                      <div class="col-md-8"><p style="border: 2px;background:#002366;padding:4px;color:white"><b>About R Kabra & Co.</b></p></div>
//                      </div>
//                      </div><br><br><br><br><br><br><br><br><br><br>';
//            
//            
//            $data .= '<div> 
//                       <b><p style="font-size:18px;text-align:center;background:#002366;color:white;padding:3px;border: 1px solid;">3. GST COMPONENTS AND OVERVIEW</p></b><br><br><br>  
//                       <div class="row">
//                      <div class="col-md-6">
//                      <p>
//                      This report’s insights will help the Business owners,
//                      CFO’s, Analysts, marketing researchers with the
//                      growth of the company and proper functioning of 
//                      business as in this report you will find various insights 
//                      with graphical representations of data which will not 
//                      only help you to find out the profitability and loss areas
//                      of the business but also provide you with the clarity of
//                      growth areas.<br>
//                      The output reports will give you following insights:<br>
//                      </p>
//                      </div>
//                      
//                      </div><br><br>
//                      <div class="row">
//                      <div class="col-md-4" style="border:1px solid;padding:2px">
//                      <p style="text-align:center"><b><u>DATA INSIGHTS</u></b></p><br>
//                      <b>MANAGEMENT REPORT</b>
//                      <ul>
//                      <li>Graphical Insights</li>
//                      <li>Sales Health Index</li>
//                      <li>Profit/Loss Health Index</li>
//                      </ul>
//                      <b>COMPARISON & DEVIATION REPORT</b>
//                      <ul>
//                      <li>Graphical Insights</li>
//                      <li>Working Capital loss</li>
//                      <li>Output Tax Liability Reconciliation- Comparison of GSTR-3B & 1</li>
//                      <li>ITC Reconciliation- Comparison of GSTR-3B & 2A</li>
//                      </ul>
//                      </div>
//                      <div class="col-md-8"></div>
//                      </div><br>
//                      <div class="row">
//                      <div class="col-md-4" style="border:1px solid;padding:2px">
//                      <p style="text-align:center"><b><u>VALUE DASHBOARD</u></b></p><br>
//                      <b>CFO DASHBOARD/TAX LIABILITY BAROMETER</b>
//                      <ul>
//                      <li>Overview of Turnover</li>
//                      <li>Turnover v/s Tax Liability</li>
//                      <li>Overview of Tax Liability</li>
//                      <li>GST payable v/s Cash</li>
//                      <li>Eligible and Ineligible Credit</li>
//                      </ul>
//                      </div>
//                      <div class="col-md-8"></div>
//                      </div>
//                      <div class="row">
//                      <div class="col-md-4" style="border:1px solid !important;padding:2px;margin-left: 460px !important;margin-top: -439px !important;">
//                      <p style="text-align:center"><b><u>    INFORMATION COMPARISON</u></b></p><br>
//                      <b>COMPLIANCE REPORT</b>
//                      <ul>
//                      <li>Period</li>
//                      <li>Due-date of Filing</li>
//                      <li>Actual Filing date</li>
//                      <li>Penalty</li>
//                      </ul>
//                      <b>INTERNAL CONTROL REPORT</b>
//                      <ul>
//                      <li>Invoices amended in other than original period</li>
//                      <li>Invoices not included in GSTR-1</li>
//                      </ul>
//                      <ul>
//                      <b>MISMATCH REPORT</b>
//                      <li>Invoices not present in GSTR-2A</li>
//                      <li>Invoices not present in Records</li>
//                      <li>POS, Invoice no., Period, Taxable value and Tax Value mismatch.</li>
//                      </ul>
//                      </div>
//                      <div class="col-md-8"></div>
//                      </div>
//                       </div>';

            $respose['data'] = $data;
            $respose['message'] = "success";
        } else {
            $respose['message'] = "";
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
            $bg_clr1 = "#74D56F";
        } elseif ($time_over_run3 > 6 && $time_over_run3 <= 11) {
            $bg_clr1 = "#D8D824";
        } else {
            $bg_clr1 = "#eb5c3d";
        }
        if ($internal_control3 > 0 && $internal_control3 <= 6) {
            $bg_clr2 = "#74D56F";
        } elseif ($internal_control3 > 6 && $internal_control3 <= 11) {
            $bg_clr2 = "#D8D824";
        } else {
            $bg_clr2 = "#eb5c3d";
        }
        if ($transaction_mismatch3 > 0 && $transaction_mismatch3 <= 6) {
            $bg_clr3 = "#74D56F";
        } elseif ($transaction_mismatch3 > 6 && $time_over_run3 <= 11) {
            $bg_clr3 = "#D8D824";
        } else {
            $bg_clr3 = "#eb5c3d";
        }
        if ($deviation_itc3 > 0 && $deviation_itc3 <= 6) {
            $bg_clr4 = "#74D56F";
        } elseif ($deviation_itc3 > 6 && $deviation_itc3 <= 11) {
            $bg_clr4 = "#D8D824";
        } else {
            $bg_clr4 = "#eb5c3d";
        }
//        echo $deviation_output3;
        if ($deviation_output3 > 0 && $deviation_output3 <= 6) {
            $bg_clr5 = "#74D56F";
        } elseif ($deviation_output3 > 6 && $deviation_output3 <= 11) {
            $bg_clr5 = "#D8D824";
        } else {
            $bg_clr5 = "#eb5c3d";
        }
        if ($gst_payable3 > 0 && $gst_payable3 <= 6) {
            $bg_clr6 = "#74D56F";
        } elseif ($gst_payable3 > 6 && $gst_payable3 <= 11) {
            $bg_clr6 = "#D8D824";
        } else {
            $bg_clr6 = "#eb5c3d";
        }
        return array($bg_clr1, $bg_clr2, $bg_clr3, $bg_clr4, $bg_clr5, $bg_clr6);
    }

}

?>