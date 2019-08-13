<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    public function index($customer_id = '', $insert_id = '', $cust_name = '') {
//       $query_get_customer_name=fdjk;
//         $cust_name = $this->input->post("cust_name");
        $data['customer_id'] = $customer_id;
        $data['insert_id'] = $insert_id;
        $data['cust_name'] = $cust_name;
        $this->load->view('admin/Generate_report', $data);
    }

    public function load_pg() {
        $this->load->view('admin/dummy_report');
    }

    public function enter_detail_fun($customer_id = '', $insert_id = '') {
        $data['customer_id'] = $customer_id;
        $data['insert_id'] = $insert_id;
        $query = $this->db->query("select * from customer_header_all where customer_id='$customer_id'");
        $result = $query->row();
        $data['cust_result'] = $result;

        
        $this->load->view('admin/client_details', $data);
    }

    public function get_year_id() {
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");


        $query_get_customer_name = $this->db->query("select year_id from insert_header where insert_id='$insert_id' and customer_id='$customer_id'");
        if ($this->db->affected_rows() > 0) {
            $res = $query_get_customer_name->row();
            $insert_id = $res->insert_id;

            $respose['data'] = $res;
            $respose['message'] = "success";
        } else {
            $respose['message'] = "";
        }echo json_encode($respose);

        $this->load->view('admin/Generate_report', $data);
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
            
            $data = '<div style="float:left;background:#002366;color:white;padding:20px">
                      <b style="font-size:18px;margin-left: 150px;">1. ABOUT ANAND RATHI GLOBAL FINANCE LTD.</b><br><br><br>
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
            
            $data .= '<div style="float:left;">
                      <b><p style="font-size:18px;text-align:center;background:#002366;color:white;padding:3px;border: 1px solid;">2. EXECUTIVE SUMMARY</p></b><br><br><br>  
                      <ul>
                      <li>Ecovis RKCA was provided with the data of the company  “Anand Rathi
                      Global Finance Ltd.” to evaluate this health check report.</li>
                      <li>Ecovis RKCA  was also able to access all the information such as:</li>
                      </ul>
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
                      <ul><li>	We also evaluated some areas of improvement.</li></ul>
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

}

?>