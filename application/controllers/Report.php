<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    public function index($customer_id = '', $insert_id = '') {
//       $query_get_customer_name=fdjk;

        $data['customer_id'] = $customer_id;
        $data['insert_id'] = $insert_id;
        $this->load->view('admin/Generate_report', $data);
    }

//     public function edit_customer() {
//     $customer_id = $this->input->post('customer_id');
//     $data = array(
////            'customer_id' => $customer_id,
//            'customer_id' => $customer_id,
//        );
//     
//     }
    public function get_content_pdf1() {
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");

        $query_get_customer_name = $this->db->query("select customer_name,customer_address from customer_header_all where customer_id='$customer_id'");
        if ($this->db->affected_rows() > 0) {
            $res = $query_get_customer_name->row();
            $customer_name = $res->customer_name;
            $address = $res->customer_address;

            $data = '<div style="float:left;">XXth March, 2019 <br>
                  
                    <b>Mr. ' . $customer_name . '</b><br>
                    <b>Managing Director</b> <br>
                    <b>Company Name</b> <br>
                    Address :' . $address . '<br><br>
                    <b>Sub :GST Health Check Report</b> <br><br><p>
                    It has been an immense pleasure working for you and thank you for 
                    choosing us to provide you GST insight report for the period – to-. 
                    We are delighted to submit our report based on the data received from you.<br><br>
                    As you are aware, R Kabra & Co. have knowledge of accounting, taxation and ERPs; 
                    is striving to support organizations in transforming their finance and accounting 
                    processes.<br><br>
                    Our observations and recommendations will help your professionals to unlock various 
                    areas of improvement and to overcome the inefficiencies which are making your businesses
                    to bear loss and will help you to improve your working capital position.<br><br>
                    We look forward to receiving your feedback on the report and your time 
                    for discussing the same.Thanking you in advance.<br><br>
                    Yours faithfully <br><br><br>
                    Authorized Signatory
                    </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
                   
            $data .= '<div style="float:left">
                    <b style="font-size:18px">LIMITED USAGE AND NON-DISCLOSURE:</b><br>
                    This Report is intended solely for the information and internal use of 
                    Client and is not intended to be and should not be used by any other 
                    person or entity. In case this report has been accessed by any party 
                    other than those intended to, such person/ entity shall send it back to 
                    the intended party or R Kabra & Co. or destroy the same so as to protect 
                    the confidentiality of the contents.  R Kabra & Co. shall submit this 
                    report only to the Client and any forward transmission shall not be the 
                    responsibility of R Kabra & Co.
                    </div><br><br><br><br><br><br><br><br>';
            
            $data .= '<div style="float:left">
                      <b style="font-size:18px"><u>ABBREVIATION/GLOSSARY OF TERMS:</u></b><br>
                      1. GST- Goods and Services Tax. <br>
                      2. GSTR- Goods and Services Tax Return.<br>
                      3. ITC- Input Tax Credit.<br>
                      4. GSTIN- Goods and Services Tax Identification Number.<br>
                      5. IGST- Integrated Goods and Services Tax.<br>
                      6. CGST- Centre Goods and Services Tax.<br>
                      7. SGST/UTGST- State Goods and Services Tax/Union Territory Goods and Services Tax.<br>
                      8. B2B Supply- Supply made to registered person.<br>
                      9. B2C Supply- Supply made to unregistered person.<br>
                      10. POS- Place Of Supply<br>
                      11. RCM- Reverse Charge Mechanism.<br>
                    </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
            
            $data .= '<div>
                      <b style="font-size:18px">Contents</b><br>  
                      <div class="row">
                      <div class="col-md-4"><p style="border: 2px;padding:6px;background:#D3D3D3"><b>About Client&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;pg.05</b></p></div>
                      <div class="col-md-4"><p style="border: 2px;background:#002366;padding:6px;color:white"><b>Executive Summary</b></p></div>
                      </div>
                      <div class="row">
                      <div class="col-md-4"><p style="border: 2px;background:#002366;padding:10px;color:white"><b>GST Components And Overview</b></p></div>
                      <div class="col-md-4"><p style="border: 2px;padding:10px;background:#D3D3D3"><b>GST Framework&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;pg.05</b></p></div>
                      </div>
                      <div class="row">
                      <div class="col-md-4"><p style="border: 2px;padding:10px;background:#D3D3D3"><b>Details of GST Reports & Insightst&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;pg.05</b></p></div>
                      <div class="col-md-4"><p style="border: 2px;padding:10px;color:white;background:#D3D3D3"><b>Issue Matrix&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;pg.05</b></p></div>
                      
                      </div>
                      <div class="row">
                      <div class="col-md-4"><p style="border: 2px;background:#002366;padding:10px;color:white"><b>Rating Card</b></p></div>
                      <div class="col-md-4"><p style="border: 2px;padding:10px;background:#D3D3D3"><b>Conclusion&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;pg.05</b></p></div>
                      </div>
                      <div class="row">
                      <div class="col-md-8"><p style="border: 2px;padding:4px;background:#D3D3D3"><b>Disclaimer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;pg.05</b></p></div>
                      </div>
                      <div class="row">
                      <div class="col-md-8"><p style="border: 2px;background:#002366;padding:4px;color:white"><b>About R Kabra & Co.</b></p></div>
                      </div>
                      </div><br><br><br><br><br><br><br><br><br><br>';
            
            $data .= '<div style="float:left;background:#002366;color:white;padding:20px">
                      <b style="font-size:18px;margin-left: 150px;">1. ABOUT ANAND RATHI GLOBAL FINANCE LTD.</b><br><br><br>
                      <p>Anand Rathi Global Finance Limited (ARGFL) was incorporated on 3rd February, 1982. The 
                      Company is wholly owned subsidiary of Anand Rathi Financial Services Ltd. The Company is 
                      registered with Reserve Bank of India (RBI) as non-banking finance company (NBFC) and 
                      classified as a Loan company and categorized as "Systemically important non-deposit taking non-
                      banking financial company" (NBFC-ND-SI). The Company is engaged in the business of financial 
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
                      </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
            
            $data .= '<div style="float:left">
                      <b><p style="font-size:18px;text-align:center;background:#002366;color:white;padding:3px;border: 1px solid;">2. EXECUTIVE SUMMARY</p></b><br><br><br>  
                      <ul>
                      <li>R Kabra & Co. was provided with the data of the company “Anand Rathi
                      Global Finance Ltd.” to evaluate this health check report.</li>
                      <li>R Kabra & Co. was also able to access all the information such as:</li>
                      </ul>
                      1. Sales data month wise.<br>
                      2. GSTR-1 <br>
                      3. GSTR-3B.<br>
                      and R Kabra & Co. uses this data to provide them with GST insights in form of:<br>
                      1. Management Report<br>
                      2. Compliance Report<br>
                      3. Internal control Reports<br>
                      4. Mismatch Reports<br>
                      5. Deviation Reports<br>
                      6. CFO Dashboard<br>
                      This will help the company immensely for their development.<br>
                      <ul><li>	We also evaluated some areas of improvement.</li></ul>
                     </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
            
            
             $data .= '<div style="float:left"> 
                       <b><p style="font-size:18px;text-align:center;background:#002366;color:white;padding:3px;border: 1px solid;">3. GST COMPONENTS AND OVERVIEW</p></b><br><br><br>  
                       <div class="row">
                      <div class="col-md-12">
                      <p>
                      This report’s insights will help the Business owners,<br>
                      CFO’s, Analysts, marketing researchers with the<br>
                      growth of the company and proper functioning of <br>
                      business as in this report you will find various insights <br>
                      with graphical representations of data which will not <br>
                      only help you to find out the profitability and loss areas<br>
                      of the business but also provide you with the clarity of<br>
                      growth areas.<br>
                      The output reports will give you following insights:<br>
                      </p>
                      </div>
                      <div class="col-md-6">
                      <p>
                     
                      </p>
                      </div>
                      </div>
                       </div><br>';
                    
            $respose['data'] = $data;
            $respose['message'] = "success";
        } else {
            $respose['message'] = "";
        }echo json_encode($respose);
    }

}

?>