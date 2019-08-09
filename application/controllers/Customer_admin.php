<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customer_admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
//        $this->load->model('Customer_model');
        $this->load->database();
        $this->load->model('Customer_model');
    }

//
    function index() {



        $query = $this->db->query("SELECT customer_header_all.customer_id,customer_header_all.created_on,customer_header_all.customer_contact_number,customer_header_all.customer_name,customer_header_all.customer_email_id,insert_header_all.insert_id"
                . " FROM customer_header_all INNER JOIN insert_header_all ON customer_header_all.customer_id=insert_header_all.customer_id");

        if ($query->num_rows() > 0) {
            $record = $query->result();
            $data['result'] = $record;
        } else {
            $data['result'] = "";
        }


        $this->load->view('admin/Customer_details', $data);
    }

    public function page_diversion() {
        $customer_id = $this->input->post('customer_id');
        $insert_id = $this->input->post('insert_id');
        $get_report_data = $this->db->query("Select report_id from report_header_all where customer_id='$customer_id' and insert_id='$insert_id'");
        if ($this->db->affected_rows() > 0) {
            $response['report_sts'] = '1';
        } else {
            $response['report_sts'] = '0';
        }echo json_encode($response);
    }

    function add_customer() {
//       
        $this->load->view('admin/add_customer');
    }

    public function create_customer() {

        $customer_id = $this->getCustomerId();
        $date = date('y-m-d h:i:s');
        $customer_name = $this->input->post('customer_name');
        $customer_address = $this->input->post('customer_address');
        $customer_city = $this->input->post('customer_city');
        $customer_state = $this->input->post('customer_state');
        $customer_country = $this->input->post('customer_country');
        $customer_no = $this->input->post('customer_contact_number');
        $customer_email = $this->input->post('customer_email_id');
//        $active_status = $this->input->post('activity_status');
        $gst_no = $this->input->post('gst_no');
        $pincode = $this->input->post('pincode');
        $pan_no = $this->input->post('pan_no');
        $user_type = 2;

        if (empty($customer_name)) {
            $response['id'] = 'customer_name';
            $response['error'] = 'Enter Proper Name';
            echo json_encode($response);
            exit;
        } elseif (!preg_match("/^[A-Za-zéåäöÅÄÖ\s\ ]*$/", $customer_name)) {
            $response['id'] = 'customer_name';
            $response['error'] = 'Enter  Customer Name';
        } elseif (empty($customer_address)) {
            $response['id'] = 'customer_address';
            $response['error'] = 'Enter customer_address';
            echo json_encode($response);
            exit;
        } elseif (empty($customer_city)) {
            $response['id'] = 'customer_city';
            $response['error'] = 'Enter city';
            echo json_encode($response);
            exit;
        } elseif (empty($customer_email)) {
            $response['id'] = 'customer_email_id';
            $response['error'] = 'Enter Customer Email Id';
            echo json_encode($response);
            exit;
        } elseif (!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
            $response['id'] = 'customer_email_id';
            $response['error'] = "Invalid email format";
            echo json_encode($response);
            exit;
        } elseif (empty($customer_no)) {
            $response['id'] = 'customer_contact_number';
            $response['error'] = 'Enter Customer Contact No.';
            echo json_encode($response);
            exit;
        } elseif (empty($customer_state)) {
            $response['id'] = 'customer_state';
            $response['error'] = 'Enter Customer State.';
            echo json_encode($response);
            exit;
        } elseif (empty($customer_country)) {
            $response['id'] = 'customer_country_number';
            $response['error'] = 'Enter Customer Country.';
            echo json_encode($response);
            exit;
        } elseif (empty($gst_no)) {
            $response['id'] = 'gst_no';
            $response['error'] = 'Enter GST.';
            echo json_encode($response);
            exit;
        } else {
            $array1 = array(
                'customer_id' => $customer_id,
                'created_on' => $date,
                'user_type' => $user_type,
                'customer_name' => $customer_name,
                'customer_address' => $customer_address,
                'customer_city' => $customer_city,
                'customer_state' => $customer_state,
                'customer_country' => $customer_country,
                'customer_contact_number' => $customer_no,
                'customer_email_id' => $customer_email,
                'gst_no' => $gst_no,
                'pincode' => $pincode,
                'pan_no' => $pan_no
            );
//         $res = $this->db->insert('customer_header_all',$array1);
//           $this->db->query($res);
            $record1 = $this->Customer_model->add_customer($array1);

            if ($record1 === TRUE) {
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

    //function for delete customer by admin

    public function del_customer() {
        $customer_id = $this->input->post('customer_id');
//        $query4 = $this->db->query("delete from designation_header_all where designation_id='$designation_id'");
        $record1 = $this->Customer_model->delete_customer($customer_id);
        if ($record1) {

            $response['message'] = 'success';
            $response['code'] = 200;
            $response['status'] = true;
        } else {
            $response['message'] = 'No data to display';
            $response['code'] = 204;
            $response['status'] = false;
        }

        echo json_encode($response);
    }

    public function edit_customer_details($cust_id) {
//        $cust_id = $this->input->post('customer_id');

        $data['prev_title'] = "";
        $data['page_title'] = "Edit Customer";
        $record = $this->Customer_model->display_customers($cust_id);
        if ($record) {
            $data['record'] = $record->row();
            $response['message'] = 'success';
            $response['code'] = 200;
            $response['status'] = true;
        } else {
            $response['message'] = 'No data to display';
            $response['code'] = 204;
            $response['status'] = false;
        }

        echo json_encode($response);
        $this->load->view('admin/edit_customer', $data);
    }

    public function edit_customer_details_file($cust_id) {

        $record = $this->Customer_model->display_customers($cust_id);
        if ($record) {
            $data['record'] = $record->row();
            $response['message'] = 'success';
            $response['code'] = 200;
            $response['status'] = true;
        } else {
            $response['message'] = 'No data to display';
            $response['code'] = 204;
            $response['status'] = false;
        }

        echo json_encode($response);
        $this->load->view('admin/edit_customer_files', $data);
    }

    public function edit_customer() {
        $date = date('y-m-d h:i:s');
        $customer_id = $this->input->post('cust_id');
        $customer_name = $this->input->post('customer_name');
        $customer_address = $this->input->post('customer_address');
        $customer_city = $this->input->post('customer_city');
        $customer_state = $this->input->post('customer_state');
        $customer_country = $this->input->post('customer_country');
        $customer_no = $this->input->post('customer_contact_number');
        $customer_email = $this->input->post('customer_email_id');
//        $active_status = $this->input->post('activity_status');
        $gst_no = $this->input->post('gst_no');
        $pincode = $this->input->post('pincode');
        $pan_no = $this->input->post('pan_no');
//        
        if (empty($customer_name)) {
            $response['id'] = 'customer_name';
            $response['error'] = 'Enter Proper Name';
        }
//        elseif (!preg_match("/^[A-Za-zéåäöÅÄÖ\s\ ]*$/", $customer_name)) {
//            $response['id'] = 'customer_name';
//            $response['error'] = 'Enter  Customer Name';
//        } 
        elseif (empty($customer_address)) {
            $response['id'] = 'customer_address';
            $response['error'] = 'Enter customer_address';
            echo json_encode($response);
            exit;
        } elseif (empty($customer_city)) {
            $response['id'] = 'customer_city';
            $response['error'] = 'Enter city';
            echo json_encode($response);
            exit;
        } elseif (!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
            $response['id'] = 'customer_email_id';
            $response['error'] = "Invalid email format";
            echo json_encode($response);
            exit;
        } elseif (empty($customer_no)) {
            $response['id'] = 'customer_contact_number';
            $response['error'] = 'Enter Customer Contact No.';
            echo json_encode($response);
            exit;
        } elseif (empty($customer_state)) {
            $response['id'] = 'customer_state';
            $response['error'] = 'Enter Customer State.';
            echo json_encode($response);
            exit;
        } elseif (empty($customer_country)) {
            $response['id'] = 'customer_country_number';
            $response['error'] = 'Enter Customer Country.';
            echo json_encode($response);
            exit;
        } elseif (empty($gst_no)) {
            $response['id'] = 'gst_no';
            $response['error'] = 'Enter GST.';
            echo json_encode($response);
            exit;
        }


        $data = array(
//            'customer_id' => $customer_id,
            'created_on' => $date,
//            'user_type' => $user_type,
            'customer_name' => $customer_name,
            'customer_address' => $customer_address,
            'customer_city' => $customer_city,
            'customer_state' => $customer_state,
            'customer_country' => $customer_country,
            'customer_contact_number' => $customer_no,
            'customer_email_id' => $customer_email,
            'gst_no' => $gst_no,
            'pincode' => $pincode,
            'pan_no' => $pan_no
        );
//      print_r($data);
//        exit();
//        $data1=array(
//            'customer_id' =>$customer_id
//        );
        $record = $this->Customer_model->update_customer_details($data, $customer_id);

        if ($record == '1') {
            $response['message'] = 'success';
            $response['code'] = 200;
            $response['status'] = true;
        } else {
            $response['message'] = 'No data to display';
            $response['code'] = 204;
            $response['status'] = false;
        }echo json_encode($response);
    }

    //Generate customer id

    public function getCustomerId() {
        $result = $this->db->query('SELECT customer_id FROM `customer_header_all` ORDER BY customer_id DESC LIMIT 0,1');
        if ($result->num_rows() > 0) {
            $data = $result->row();
            $customer_id = $data->customer_id;
//generate user_id
            $customer_id = str_pad(++$customer_id, 5, '0', STR_PAD_LEFT);
            return $customer_id;
        } else {
            $customer_id = 'Cust_1001';
            return $customer_id;
        }
    }

    public function edit_customer_details_files() {
        $this->load->view('admin/edit_customer_files');
    }

    public function save_observation() {
        $created_on = date('y-m-d h:i:s');
        $insert_id = $this->input->post('insert_id');
        $customer_id = $this->input->post('customer_id');
        $company_name = $this->input->post('company_name');
        $m_d_name = $this->input->post('m_d_name');
        $about_company = $this->input->post('about_company');
        $cfo_observation = nl2br($this->input->post('cfo_observation'));
        $rate_wise_observation = nl2br($this->input->post('rate_wise_observation'));
        $monthwise_sale_observation = nl2br($this->input->post('monthwise_sale_observation'));
        $tax_liability_observation = nl2br($this->input->post('tax_liability_observation'));
        $tax_exempt_observation = nl2br($this->input->post('tax_exempt_observation'));
        $tax_turnover_observation = nl2br($this->input->post('tax_turnover_observation'));
        $eligible_ineligible_observation = nl2br($this->input->post('eligible_ineligible_observation'));
        if (empty($company_name)) {
            $response['id'] = 'company_name';
            $response['error'] = 'Enter Proper Company Name';
            echo json_encode($response);
            exit;
        } elseif (empty($m_d_name)) {
            $response['id'] = 'm_d_name';
            $response['error'] = 'Enter Managing Director Name';
            echo json_encode($response);
            exit;
        } elseif (empty($about_company)) {
            $response['id'] = 'about_company';
            $response['error'] = 'Enter Details About Company';
            echo json_encode($response);
            exit;
        }
//         elseif (empty($cfo_observation)) {
//            $response['id'] = 'cfo_observation';
//            $response['error'] = 'Enter CFO Observation';
//            echo json_encode($response);
//            exit;
//        } elseif (($rate_wise_observation) == "") {
//            $response['id'] = 'rate_wise_observation';
//            $response['error'] = 'Enter Observation';
//            echo json_encode($response);
//            exit;
//        } elseif (empty($monthwise_sale_observation)) {
//            $response['id'] = 'monthwise_sale_observation';
//            $response['error'] = 'Enter Observation';
//            echo json_encode($response);
//            exit;
//        } elseif (empty($tax_liability_observation)) {
//            $response['id'] = 'tax_liability_observation';
//            $response['error'] = 'Enter Observation';
//            echo json_encode($response);
//            exit;
//        } elseif (empty($tax_exempt_observation)) {
//            $response['id'] = 'tax_exempt_observation';
//            $response['error'] = 'Enter Observation';
//            echo json_encode($response);
//            exit;
//        } elseif (empty($tax_turnover_observation)) {
//            $response['id'] = 'tax_turnover_observation';
//            $response['error'] = 'Enter Observation';
//            echo json_encode($response);
//            exit;
//        } elseif (empty($eligible_ineligible_observation)) {
//            $response['id'] = 'eligible_ineligible_observation';
//            $response['error'] = 'Enter Observation';
//            echo json_encode($response);
//            exit;
//        }
        else {
            $report_id = $this->report_id();

            $data = array(
                'insert_id' => $insert_id,
                'customer_id' => $customer_id,
                'report_id' => $report_id,
                'company_name' => $company_name,
                'managing_director_name' => $m_d_name,
                'about_company' => $about_company,
                'cfo_observation' => $cfo_observation,
                'rate_wise_observation' => $rate_wise_observation,
                'month_wise_observation' => $monthwise_sale_observation,
                'tax_liability_observation' => $tax_liability_observation,
                'tax_nontax_observation' => $tax_exempt_observation,
                'tax_turnover_observation' => $tax_turnover_observation,
                'eligible_ineligible_observation' => $eligible_ineligible_observation,
                'created_on' => $created_on,
            );


            $record = $this->db->insert('observation_transaction_all', $data);
            $data1 = array(
                'insert_id' => $insert_id,
                'customer_id' => $customer_id,
                'report_id' => $report_id,
                'created_on' => $created_on,
            );
            $record1 = $this->db->insert('report_header_all', $data1);
            if ($record == TRUE && $record1 == TRUE) {
                $response['message'] = 'success';
                $response['code'] = 200;
                $response['status'] = true;
            } else {
                $response['message'] = 'No data to display';
                $response['code'] = 204;
                $response['status'] = false;
            }
        }echo json_encode($response);
    }

    public function report_id() {
        $result = $this->db->query('SELECT report_id FROM `observation_transaction_all` ORDER BY report_id DESC LIMIT 0,1');
        if ($result->num_rows() > 0) {
            $data = $result->row();
            $report_id = $data->report_id;
            //generate turn_id
            $report_id = str_pad( ++$report_id, 5, '0', STR_PAD_LEFT);
            return $report_id;
        } else {
            $report_id = 'report_1001';
            return $report_id;
        }
    }

}

?>