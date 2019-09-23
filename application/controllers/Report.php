<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    public function file_location_upload() {
        $customer_id = $this->input->post('customer_id');
        $insert_id = $this->input->post('insert_id');
        $report_id = $this->input->post('report_id');
        $file_upload1 = $this->upload_file();
//        $get_observation = $this->db->query("select file_location,id from observation_transaction_all where customer_id='$customer_id' and insert_id='$insert_id' and report_id='$report_id' ORDER BY ID DESC LIMIT 1");
        $get_observation = $this->db->query("select file_location,id from observation_transaction_all where customer_id='$customer_id' and insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
        $res = $get_observation->row();
          $id = $res->id;
          
        $page_numbers = $file_upload1;
        // var_dump($page_numbers);
        $data = array('file_location' => $page_numbers);

        $this->db->where('insert_id', $insert_id);
            $this->db->where('customer_id', $customer_id);
            $this->db->where('id', $id);
        $query = $this->db->update('observation_transaction_all', $data);

      
        if ($query == TRUE) {
            $response['message'] = 'success';
            $response['code'] = 200;
            $response['status'] = true;
            
        } else {
            $response['message'] = 'No data to display';
            $response['code'] = 204;
            $response['status'] = false;
        }echo json_encode($response);
    }

    public function upload_file() {
        $response = array();
//        $user_id = $due_date_id; // session or user_id   
        if (isset($_FILES['file_upload'])) :
            $files = $_FILES;
//            $count = count($_FILES['file_upload']['name']); // count element 
//            for ($i = 0; $i < $count; $i++):
            $_FILES['file_upload']['name'] = $files['file_upload']['name'];
            $_FILES['file_upload']['type'] = $files['file_upload']['type'];
            $_FILES['file_upload']['tmp_name'] = $files['file_upload']['tmp_name'];
            $_FILES['file_upload']['error'] = $files['file_upload']['error'];
            $_FILES['file_upload']['size'] = $files['file_upload']['size'];
            $config['upload_path'] = 'images/';
            $target_path = 'images/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|xlsx|ppt|pptx';
            $config['max_size'] = '500000';    //limit 10000=1 mb
            $config['remove_spaces'] = true;
            $config['overwrite'] = false;
//                $config['max_width'] = '1024'; // image max width 
//                $config['max_height'] = '768';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $fileName = $_FILES['file_upload']['name'];
            $fileName = str_replace(' ', '_', $fileName);
            $fileName = preg_replace('/\s+/', '_', $fileName);
            $data = array('upload_data' => $this->upload->data());

            if (empty($fileName)) {
                return false;
            } else {
                $file = $this->upload->do_upload('file_upload');
                if (!$file) {
                    $error = array('upload_error' => $this->upload->display_errors());
                    $response['error'] = $files['file_upload']['name'] . ' ' . $error['upload_error'];
                    $response = "invalid";
                    return $response;
                } else {
                    // echo $target_path;
                    $base_url = base_url();
                    return $base_url . $target_path . $fileName;
// resize code
                    $path = $data['upload_data']['full_path'];
                    $q['name'] = $data['upload_data']['file_name'];
                    $configi['image_library'] = 'gd2';
                    $configi['source_image'] = $path;
                    $configi['new_image'] = $target_path;
                    $configi['create_thumb'] = TRUE;
                    $configi['maintain_ratio'] = TRUE;
                    $configi['width'] = 75; // new size
                    $configi['height'] = 50;
                    $this->load->library('image_lib');
                    $this->image_lib->clear();
                    $this->image_lib->initialize($configi);
                    $this->image_lib->resize();
                    $images[] = $fileName;
                }
            }
//            endfor;
        endif;
    }

    public function do_upload() {
        $config['upload_path'] = './images/';
        $config['allowed_types'] = 'gif|jpg|png|pdf';
        $config['max_size'] = 10000;
        $config['max_width'] = 1024;
        $config['max_height'] = 768;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file_upload')) {
            $error = array('error' => $this->upload->display_errors());

            $this->load->view('hq_admin/report_with_page_num', $error);
        } else {
            $data = array('upload_data' => $this->upload->data());

            $this->load->view('hq_admin/report_with_page_num', $error);
        }
    }

    public function insert_page_number($customer_id = '', $insert_id = '') {

        $customer_id1 = base64_decode($customer_id);
        $insert_id1 = base64_decode($insert_id);
        $data['insert_id'] = $insert_id1;
        $data['customer_id'] = $customer_id1;
        $this->load->view('admin/add_page_numbers', $data);
    }
    
    public function insert_page_number_hq($customer_id = '', $insert_id = '') {

        $customer_id1 = base64_decode($customer_id);
        $insert_id1 = base64_decode($insert_id);
        $data['insert_id'] = $insert_id1;
        $data['customer_id'] = $customer_id1;
        $this->load->view('hq_admin/add_page_numbers', $data);
    }

    public function report_with_page_num($customer_id = '', $insert_id = '') {
        $customer_id1 = base64_decode($customer_id);
        $insert_id1 = base64_decode($insert_id);
        $data['insert_id'] = $insert_id1;
        $data['customer_id'] = $customer_id1;

        $query_get_customer_name = $this->db->query("SELECT customer_name from customer_header_all where customer_id='$customer_id1'");
        $result = $query_get_customer_name->row();
        $query_get_insert_header = $this->db->query("SELECT year_id from insert_header_all where insert_id='$insert_id1'");
        $result1 = $query_get_insert_header->row();
        $query_get_company_header = $this->db->query("SELECT * from observation_transaction_all where insert_id='$insert_id1' and customer_id='$customer_id1' ORDER BY ID DESC LIMIT 1");
        $result2 = $query_get_company_header->row();
        $query_get_report_header = $this->db->query("SELECT * from report_header_all where insert_id='$insert_id1' and customer_id='$customer_id1'");
        $result3 = $query_get_report_header->row();
        $query_get_client_letter = $this->db->query("select customer_header_all.customer_name,customer_header_all.customer_address,report_header_all.company_name,report_header_all.managing_director_name from customer_header_all INNER JOIN report_header_all on customer_header_all.customer_id= report_header_all.customer_id where customer_header_all.customer_id ='$customer_id1' and report_header_all.insert_id ='$insert_id1'");
        $result4 = $query_get_client_letter->row();


        $data['customer_details'] = $result;
        $data['insert_header_details'] = $result1;
        $data['company_details'] = $result2;
        $data['report_details'] = $result3;
        $data['client_details'] = $result4;
        $this->load->view('admin/report_with_page_num', $data);
    }
    
     public function report_with_page_num_hq($customer_id = '', $insert_id = '') {
        $customer_id1 = base64_decode($customer_id);
        $insert_id1 = base64_decode($insert_id);
        $data['insert_id'] = $insert_id1;
        $data['customer_id'] = $customer_id1;

        $query_get_customer_name = $this->db->query("SELECT customer_name from customer_header_all where customer_id='$customer_id1'");
        $result = $query_get_customer_name->row();
        $query_get_insert_header = $this->db->query("SELECT year_id from insert_header_all where insert_id='$insert_id1'");
        $result1 = $query_get_insert_header->row();
        $query_get_company_header = $this->db->query("SELECT * from observation_transaction_all where insert_id='$insert_id1' and customer_id='$customer_id1' ORDER BY ID DESC LIMIT 1");
        $result2 = $query_get_company_header->row();
        $query_get_report_header = $this->db->query("SELECT * from report_header_all where insert_id='$insert_id1' and customer_id='$customer_id1'");
        $result3 = $query_get_report_header->row();
        $query_get_client_letter = $this->db->query("select customer_header_all.customer_name,customer_header_all.customer_address,report_header_all.company_name,report_header_all.managing_director_name from customer_header_all INNER JOIN report_header_all on customer_header_all.customer_id= report_header_all.customer_id where customer_header_all.customer_id ='$customer_id1' and report_header_all.insert_id ='$insert_id1'");
        $result4 = $query_get_client_letter->row();


        $data['customer_details'] = $result;
        $data['insert_header_details'] = $result1;
        $data['company_details'] = $result2;
        $data['report_details'] = $result3;
        $data['client_details'] = $result4;
        $this->load->view('hq_admin/report_with_page_num', $data);
    }

    public function save_page_numbers() {
        $customer_id = $this->input->post('customer_id');
        $insert_id = $this->input->post('insert_id');
        $about_client = $this->input->post('about_client');
        $exe_sum = $this->input->post('exe_sum');
        $gst_cmp_overview = $this->input->post('gst_cmp_overview');
        $gst_framework = $this->input->post('gst_framework');
        $gst_report_insight = $this->input->post('gst_report_insight');
        $issue_matrix = $this->input->post('issue_matrix');
        $report_card = $this->input->post('report_card');
        $conclusion = $this->input->post('conclusion');
        $gst_approach = $this->input->post('gst_approach');
        $disclaimer = $this->input->post('disclaimer');
        $about_ecovis = $this->input->post('about_ecovis');
        if (empty($about_client)) {
            $response['id'] = 'about_client';
            $response['error'] = 'Enter Page Number';
            echo json_encode($response);
            exit;
        } elseif (empty($exe_sum)) {
            $response['id'] = 'about_client';
            $response['error'] = 'Enter Page Number';
            echo json_encode($response);
            exit;
        } elseif (empty($gst_cmp_overview)) {
            $response['id'] = 'gst_cmp_overview';
            $response['error'] = 'Enter Page Number';
            echo json_encode($response);
            exit;
        } elseif (empty($gst_framework)) {
            $response['id'] = 'gst_framework';
            $response['error'] = 'Enter Page Number';
            echo json_encode($response);
            exit;
        } elseif (empty($gst_approach)) {
            $response['id'] = 'gst_approach';
            $response['error'] = 'Enter Page Number';
            echo json_encode($response);
            exit;
        } elseif (empty($gst_report_insight)) {
            $response['id'] = 'gst_report_insight';
            $response['error'] = 'Enter Page Number';
            echo json_encode($response);
            exit;
        } elseif (empty($issue_matrix)) {
            $response['id'] = 'issue_matrix';
            $response['error'] = 'Enter Page Number';
            echo json_encode($response);
            exit;
        } elseif (empty($report_card)) {
            $response['id'] = 'report_card';
            $response['error'] = 'Enter Page Number';
            echo json_encode($response);
            exit;
        } elseif (empty($conclusion)) {
            $response['id'] = 'conclusion';
            $response['error'] = 'Enter Page Number';
            echo json_encode($response);
            exit;
        } elseif (empty($disclaimer)) {
            $response['id'] = 'disclaimer';
            $response['error'] = 'Enter Page Number';
            echo json_encode($response);
            exit;
        } elseif (empty($about_ecovis)) {
            $response['id'] = 'about_ecovis';
            $response['error'] = 'Enter Page Number';
            echo json_encode($response);
            exit;
        } else {
            $get_observation = $this->db->query("select file_location,id from observation_transaction_all where customer_id='$customer_id' and insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
            $res = $get_observation->row();
            $id = $res->id;
            $page_numbers = $about_client . "," . $exe_sum . "," . $gst_cmp_overview . ","
                    . $gst_framework . "," . $gst_approach . "," . $gst_report_insight . ","
                    . $issue_matrix . "," . $report_card . "," . $conclusion . "," . $disclaimer . "," . $about_ecovis;
            $data = array('page_numbers' => $page_numbers);
            $this->db->where('insert_id', $insert_id);
            $this->db->where('customer_id', $customer_id);
            $this->db->where('id', $id);
            $query = $this->db->update('observation_transaction_all', $data);
            if ($query == TRUE) {
                $response['message'] = 'success';
                $response['code'] = 200;
                $response['status'] = true;
            } else {
                $response['message'] = 'No data to display';
                $response['code'] = 204;
                $response['status'] = false;
            }echo json_encode($response);
        }
    }

    public function save_report_counter() {
        $customer_id = $this->input->post('customer_id');
        $insert_id = $this->input->post('insert_id');
        $get_observation = $this->db->query("select file_location,id from observation_transaction_all where customer_id='$customer_id' and insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
        $res = $get_observation->row();
        $id = $res->id;
        $data = array('file_location' => 1);
        $this->db->where('insert_id', $insert_id);
        $this->db->where('customer_id', $customer_id);
        $this->db->where('id', $id);
        $query = $this->db->update('observation_transaction_all', $data);
        if ($query == TRUE) {
            $response['message'] = 'success';
            $response['code'] = 200;
            $response['status'] = true;
        } else {
            $response['message'] = 'No data to display';
            $response['code'] = 204;
            $response['status'] = false;
        }echo json_encode($response);
    }

    public function index($customer_id = '', $insert_id = '', $cust_name = '') {
        $query_get_customer_name = $this->db->query("SELECT customer_name from customer_header_all where customer_id='$customer_id'");
        $result = $query_get_customer_name->row();
        $query_get_insert_header = $this->db->query("SELECT year_id from insert_header_all where insert_id='$insert_id'");
        $result1 = $query_get_insert_header->row();
        $query_get_company_header = $this->db->query("SELECT * from observation_transaction_all where insert_id='$insert_id' and customer_id='$customer_id' ORDER BY ID DESC LIMIT 1");
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
    
    public function index_hq($customer_id = '', $insert_id = '', $cust_name = '') {
        $query_get_customer_name = $this->db->query("SELECT customer_name from customer_header_all where customer_id='$customer_id'");
        $result = $query_get_customer_name->row();
        $query_get_insert_header = $this->db->query("SELECT year_id from insert_header_all where insert_id='$insert_id'");
        $result1 = $query_get_insert_header->row();
        $query_get_company_header = $this->db->query("SELECT * from observation_transaction_all where insert_id='$insert_id' and customer_id='$customer_id' ORDER BY ID DESC LIMIT 1");
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
        $this->load->view('hq_admin/Generate_report', $data);
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
    
    public function enter_detail_fun_hq($customer_id = '', $insert_id = '') {
        $customer_id1 = base64_decode($customer_id);
        $insert_id1 = base64_decode($insert_id);
        $data['customer_id'] = base64_decode($customer_id);
        $data['insert_id'] = base64_decode($insert_id);
        $query = $this->db->query("select * from customer_header_all where customer_id='$customer_id1'");
        $result = $query->row();
        $data['cust_result'] = $result;
        $this->load->view('hq_admin/client_details', $data);
    }

    public function get_content_pdf1() {
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $data = '';
        $query_get_company_header = $this->db->query("SELECT company_name from report_header_all where insert_id='$insert_id' and customer_id='$customer_id'");
        $query_get_customer_name = $this->db->query("select customer_name,customer_address from customer_header_all where customer_id='$customer_id'");
        $visible_customer_detail = $this->db->query("select visible_customer_detail from observation_transaction_all where insert_id='$insert_id' and customer_id='$customer_id' ORDER BY ID DESC LIMIT 1");
        if ($this->db->affected_rows() > 0) {
            $res = $query_get_company_header->row();
            $res1 = $visible_customer_detail->row();
            $company_name = $res->company_name;
            $visible_detail = $res1->visible_customer_detail;
            if ($visible_detail == 1) {
                $company_name = $company_name;
            } else {
                $company_name = "XXX";
            }
            $data = '<div style="margin-top:15%;margin-left: 5%;margin-right:5%;letter-spacing: 0.5px;font-family:Arial Sans Serif;;">
                <b style="font-size:18px;color:#1d2f66;">2. EXECUTIVE SUMMARY</b><br>
                     <p style="font-size:13px"> Ecovis RKCA was provided with the data of the company 
                     "' . $company_name . '" 
                     to evaluate this health check report.</p>    
                      <p style="font-size:13px">Ecovis RKCA  was also able to access all the information such as:</p>
                      <p style="font-size:13px">1. Sales data month wise.</p>
                      <p style="font-size:13px">2. GSTR-1 </p>
                      <p style="font-size:13px">3. GSTR-3B.</p>
                      <p style="font-size:13px">And  Ecovis RKCA. Uses this data to provide them with GST insights in form of:</p>
                      <p style="font-size:13px">1. Management Report</p>
                      <p style="font-size:13px">2. Compliance Report</p>
                      <p style="font-size:13px">3. Internal control Reports</p>
                      <p style="font-size:13px">4. Mismatch Reports</p>
                      <p style="font-size:13px">5. Deviation Reports</p>
                      <p style="font-size:13px">6. CFO Dashboard</p>
                      <p style="font-size:13px">This will help the company immensely for their development.</p>
                      	<p style="font-size:13px">We also evaluated some areas of improvement.</p>
                     </div>';


            $respose['data'] = $data;
            $respose['message'] = "success";
        } else {
            $respose['message'] = "";
        }echo json_encode($respose);
    }

    public function get_letter_to_clientPDF() {
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $year_id = $this->input->post("year_id");
//        $query_get_company_header = $this->db->query("SELECT company_name from report_header_all where insert_id='$insert_id' and customer_id='$customer_id'");
        $query_get_insert_header = $this->db->query("SELECT year_id from insert_header_all where insert_id='$insert_id'");
        if ($this->db->affected_rows() > 0) {
            $res = $query_get_insert_header->row();
            $year_id = $res->year_id;
            $data = '<div style="margin-top:9%;margin-left: 5%;margin-top:5%;letter-spacing: 0.5px;font-family:Microsoft Sans Serif;width:700px;height:700px">
                
                     <p style="font-size:13px"> Dear Sir,<br><br>
                     We would like to thank you for giving us an opportunity to work for your company. 
                     We refer to our ongoing discussion on assisting (“Company”) in India for GST Health Check Report.<br><br>
                     In this report we have covered the overall perspective of the following:
                     <ul style="margin-left: -0.10%;">
                     <li>Identifying the errors in advance so the risk of levy of Interests and penalties can be mitigated.</li>
                     <li>Analyzing Sales data which will facilitate the area and product wise profitability of business. </li>
                     <li>Identifying the deviation in the GST data through Comparison of GSTR-3B with GSTR-1 & GSTR-2A.</li>
                     <li>Helps in filing GST Annual Returns.</li>
                     <li>Providing Internal control report and Mismatch reports of the company so that the company can improve operations to avoid any working capital loss, interest penalties and future litigations.</li>
                     <li>The CFO dashboard which enables faster, more precise decision making, allowing financial managers to assess, understand, influence, optimize financial & operational performance and identifying accounting mismatches.</li>
                     <li>Providing risk rating card which will reflect the status of the company and enable in determining if it is good going or needs improvement.</li>
                     </ul><br>
                     Moreover, GST Health Check may result in cost savings by identifying tax leakages as well as developing vendor relationship.<br><br>
                     Hope this GST Health Check report will help your company for the better and timely compliances.<br><br>
                     Yours faithfully 
                     
                     </p>
                     </div>';


            $respose['data'] = $data;
            $respose['message'] = "success";
        } else {
            $respose['message'] = "";
        }echo json_encode($respose);
    }
    public function get_content_limited_usage() {
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $year_id = $this->input->post("year_id");
//        $query_get_company_header = $this->db->query("SELECT company_name from report_header_all where insert_id='$insert_id' and customer_id='$customer_id'");
        $query_get_insert_header = $this->db->query("SELECT year_id from insert_header_all where insert_id='$insert_id'");
        if ($this->db->affected_rows() > 0) {
            $res = $query_get_insert_header->row();
            $year_id = $res->year_id;
            $data = '<div style="float:left;margin-left: 5%;margin-top:2%;margin-top:5%;letter-spacing: 0.5px;font-family:Microsoft Sans Serif;width:700px;">
                    <p>This Report is intended solely for the information and internal use of Client and is not intended to be and should not
                    be used by any other person or entity. In case this report has been accessed by any party other than those intended 
                    to, such person/entity shall send it back to the intended party or Ecovis RKCA or destroy the same so as to protect
                    the confidentiality of the contents.  Ecovis RKCA shall submit this report only to the Client and any forward
                    transmission shall not be the responsibility of Ecovis RKCA.
                    This report was prepared on the specific instructions of company solely for the purposes of the internal usage and 
                    should not be used or relied for any other purpose. If unauthorized persons choose to rely on any of the contents of 
                    this report, they may do so at their own risk. This report includes information not available to the public, accordingly, 
                    this report is strictly confidential, and no part thereof may be reproduced or used by any other party other than the 
                    client for its intended use.
                    </p>
                    
                     
                     </div>';


            $respose['data'] = $data;
            $respose['message'] = "success";
        } else {
            $respose['message'] = "";
        }echo json_encode($respose);
    }
    
     public function get_content_disclaimer() {
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $year_id = $this->input->post("year_id");
//        $query_get_company_header = $this->db->query("SELECT company_name from report_header_all where insert_id='$insert_id' and customer_id='$customer_id'");
        $query_get_insert_header = $this->db->query("SELECT year_id from insert_header_all where insert_id='$insert_id'");
        if ($this->db->affected_rows() > 0) {
            $res = $query_get_insert_header->row();
            $year_id = $res->year_id;
            $data = '<div style="float:left;margin-top:9%;margin-top:5%;letter-spacing: 0.5px;font-family:Microsoft Sans Serif;width:700px;height:700px">
                    <ul>
                    <li>The report is generated purely based on the data provided by the client. </li>
                    <li>We are not recommending or suggesting the data to be used in your business decisions nor for use with GST Portal, we are just making an assumption that is generated through the AI and as per expert’s knowledge.</li>
                    </ul><br>
                    <b style="margin-left: 5%">Conditions and major assumptions:</b><br>
                    <ul>
                    <li>We state that this is not a attestation or certification of data. We have no responsibility to modify this report for events and circumstances occurring subsequent to the date of this report.</li>
                    <li>The results by reason of performing this GST Health Check report, is not to be used to give expert testimony nor to be in attendance in court or at any government hearing or any other forum</li>
                    <li>The opinion given in this GST Health Check report is based on information provided in part by the management of the company, other sources as listed in the report. This information is assumed to be accurate and complete; we have not audited or attempted to confirm this information for accuracy or completeness.</li>
                    <li>Now withstanding anything contained in this report, the client agrees that Ecovis RKCA shall not have any liability towards the client or to any other third party (in contract or tort or under statute or otherwise) for any economic loss, financial loss or damage suffered by the client.</li>
                    </ul><br>
                    <b style="margin-left: 5%">Source of Data:</b><br>
                    <ul>
                    <li>Received from company</li>
                    <li>GST Portal</li>
                    </ul>
                    
                     
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
                $color = "white";
            } elseif ($final_value >= 501 && $final_value <= 1000) {
                $bg_clr1 = "#feed00";
                $color = "black";
            } else {
                $bg_clr1 = "#e31e25";
                $color = "white";
            }

            $get_bg_color = $this->get_bg_color_fun($time_over_run3, $internal_control3, $transaction_mismatch3, $deviation_itc3, $deviation_output3, $gst_payable3);
//            $data1 .= '<h3><b>6.Issue Matrix</b></h3>';
            $data .= '<table id="heat_map_tbl_id" class=" table-striped" border="1" width="700">
                                <thead style="color:white">
                                    <tr>
                                        <th bgcolor="#C7273D" height="20">No.</th>
                                        <th bgcolor="#C7273D" height="20">Risk Element</th>
                                        <th bgcolor="#C7273D" height="20">Risk Score</th>
                                        <th bgcolor="#C7273D" height="20">Weightage</th>
                                        <th bgcolor="#C7273D" height="20">Weightage Score</th>
                                    </tr>
                                </thead>
                                <tbody style="font-size: 13px;">
                                <tr>
                                <td>1.</td>
                                <td>Time over-run resulting into penalties.</td>
                                <td bgcolor="' . $get_bg_color[0] . '"style="color:' . $get_bg_color[6] . '">' . $time_over_run3 . '</td>
                                <td>10</td>
                                <td>' . ($time_over_run3) * 10 . '</td>
                                </tr>
                                <tr>
                                <td>2.</td>
                                <td>Lack of Internal control management leads to interest penalties GST Notices, inefficient working capital management.</td>
                                <td bgcolor="' . $get_bg_color[1] . '"style="color:' . $get_bg_color[7] . '">' . $internal_control1 . '</td>
                                <td>20</td>
                                <td>' . ($internal_control1) * 20 . '</td>
                                </tr>
                                <tr>
                                <td>3.</td>
                                <td>Mismatches of transactions leads to loss of ITC, Interest, Liability or GST Notices</td>
                                <td bgcolor="' . $get_bg_color[2] . '"style="color:' . $get_bg_color[8] . '"> ' . $transaction_mismatch3 . '</td>
                                <td>20</td>
                                <td>' . ($transaction_mismatch3) * 20 . '</td>
                                </tr>
                                <tr>
                                <td>4.</td>
                                <td>Deviation in ITC after comparing GSTR-3B vs 2A</td>
                                <td bgcolor="' . $get_bg_color[3] . '" style="color:' . $get_bg_color[9] . '">' . $deviation_itc3 . '</td>
                                <td>20</td>
                                <td>' . ($deviation_itc3) * 20 . '</td>
                                </tr>
                                <tr>
                                <td>5.</td>
                                <td>Deviation in output liability after comparing GSTR-3B vs GSTR-1.</td>
                                <td bgcolor="' . $get_bg_color[4] . '"style="color:' . $get_bg_color[10] . '">' . $deviation_output3 . '</td>
                                <td>20</td>
                                <td>' . ($deviation_output3) * 20 . '</td>
                                </tr>
                                <tr>
                                <td>6.</td>
                                <td>GST Payable in cash</td>
                                <td bgcolor="' . $get_bg_color[5] . '" style="color:' . $get_bg_color[11] . '">' . $gst_payable3 . '</td>
                                <td>10</td>
                                <td>' . ($gst_payable3) * 10 . '</td>
                                </tr>
                                <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>100</td>
                                <td bgcolor="' . $bg_clr1 . '" style="color:' . $color . '">' . $final_value . '</td>
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
    
    public function update_detail_fun_hq($customer_id = '', $insert_id = '') { //function to load update page
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
        $this->load->view('hq_admin/update_report', $data);
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
            $data .= '<table id="heat_map_tbl_id" class=" table-striped"  border="1" width="700">
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
                                <tbody style="font-size: 13px;">
                                <tr>
                                <td>1.</td>
                                <td>Time over-run resulting into penalties.</td>
                                <td>File GSTR monthly before duedate to avoid any penalties.</td>
                                <td>' . $time_over_run1 . '</td>
                                <td>' . $time_over_run2 . '</td>
                                <td bgcolor="' . $get_bg_color[0] . '" style="color:' . $get_bg_color[6] . '">' . $time_over_run3 . '</td>
                                </tr>
                                <tr>
                                <td>2.</td>
                                <td>Lack of Internal control management leads to interest penalties GST Notices, inefficient working capital management.</td>
                                <td>Recording of invoices needs to be reviewed.</td>
                                <td>' . $internal_control1 . '</td>
                                <td>' . $internal_control2 . '</td>
                                <td bgcolor="' . $get_bg_color[1] . '" style="color:' . $get_bg_color[7] . '">' . $internal_control1 . '</td>
                                </tr>
                                <tr>
                                <td>3.</td>
                                <td>Mismatches of transactions leads to loss of ITC, Interest, Liability or GST Notices</td>
                                <td>Follow-up with the clients with whom out transactions are mismatched. Also invoice processing for GST Claim & Reconciliation need to be reviewed.</td>
                                <td>' . $transaction_mismatch1 . '</td>
                                <td>' . $transaction_mismatch2 . '</td>
                                <td bgcolor="' . $get_bg_color[2] . '" style="color:' . $get_bg_color[8] . '">' . $transaction_mismatch3 . '</td>
                                </tr>
                                <tr>
                                <td>4.</td>
                                <td>Deviation in ITC after comparing GSTR-3B vs 2A</td>
                                <td>Check the eligibility and ineligibility of credit reflecting in GSTR-2A and prepare reconciliation statement accordingly.</td>
                                <td>' . $deviation_itc1 . '</td>
                                <td>' . $deviation_itc2 . '</td>
                                <td bgcolor="' . $get_bg_color[3] . '" style="color:' . $get_bg_color[9] . '">' . $deviation_itc3 . '</td>
                                </tr>
                                <tr>
                                <td>5.</td>
                                <td>Deviation in output liability after comparing GSTR-3B vs GSTR-1.</td>
                                <td>Regular follow-ups with the client.</td>
                                <td>' . $deviation_output1 . '</td>
                                <td>' . $deviation_output2 . '</td>
                                <td bgcolor="' . $get_bg_color[4] . '" style="color:' . $get_bg_color[10] . '">' . $deviation_output3 . '</td>
                                </tr>
                                <tr>
                                <td>6.</td>
                                <td>GST Payable in cash</td>
                                <td>Analysis of huge payment by cash to be done & accordingly ITC planning should be done.</td>
                                <td>' . $gst_payable1 . '</td>
                                <td>' . $gst_payable2 . '</td>
                                <td bgcolor="' . $get_bg_color[5] . '" style="color:' . $get_bg_color[11] . '">' . $gst_payable3 . '</td>
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
            $color1 = "white";
        } elseif ($time_over_run3 > 6 && $time_over_run3 <= 11) {
            $bg_clr1 = "#feed00";
            $color1 = "black";
        } else {
            $bg_clr1 = "#e31e25";
            $color1 = "white";
        }
        if ($internal_control3 > 0 && $internal_control3 <= 6) {
            $bg_clr2 = "#009746";
            $color2 = "white";
        } elseif ($internal_control3 > 6 && $internal_control3 <= 11) {
            $bg_clr2 = "#feed00";
            $color2 = "black";
        } else {
            $bg_clr2 = "#e31e25";
            $color2 = "white";
        }
        if ($transaction_mismatch3 > 0 && $transaction_mismatch3 <= 6) {
            $bg_clr3 = "#009746";
            $color3 = "white";
        } elseif ($transaction_mismatch3 > 6 && $time_over_run3 <= 11) {
            $bg_clr3 = "#feed00";
            $color3 = "black";
        } else {
            $bg_clr3 = "#e31e25";
            $color3 = "white";
        }
        if ($deviation_itc3 > 0 && $deviation_itc3 <= 6) {
            $bg_clr4 = "#009746";
            $color4 = "white";
        } elseif ($deviation_itc3 > 6 && $deviation_itc3 <= 11) {
            $bg_clr4 = "#feed00";
            $color4 = "black";
        } else {
            $bg_clr4 = "#e31e25";
            $color4 = "white";
        }
//        echo $deviation_output3;
        if ($deviation_output3 > 0 && $deviation_output3 <= 6) {
            $bg_clr5 = "#009746";
            $color5 = "white";
        } elseif ($deviation_output3 > 6 && $deviation_output3 <= 11) {
            $bg_clr5 = "#feed00";
            $color5 = "black";
        } else {
            $bg_clr5 = "#e31e25";
            $color5 = "white";
        }
        if ($gst_payable3 > 0 && $gst_payable3 <= 6) {
            $bg_clr6 = "#009746";
            $color6 = "white";
        } elseif ($gst_payable3 > 6 && $gst_payable3 <= 11) {
            $bg_clr6 = "#feed00";
            $color6 = "black";
        } else {
            $bg_clr6 = "#e31e25";
            $color6 = "white";
        }
        return array($bg_clr1, $bg_clr2, $bg_clr3, $bg_clr4, $bg_clr5, $bg_clr6, $color1, $color2, $color3, $color4, $color5, $color6);
    }

}

?>