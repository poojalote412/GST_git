<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Management_report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Cfo_model');
        $this->load->model('Management_report_model');
        $this->load->model('Customer_model');
    }

    function index() {
//        $data['result'] = $result;
//        $this->load->view('customer/GST_Management');
    }

    function state_wise_report() {
        $session_data = $this->session->userdata('login_session');
        $customer_id = ($session_data['customer_id']);
        $query_get_cfo_data = $this->Cfo_model->get_data_cfo($customer_id);
        if ($query_get_cfo_data !== FALSE) {
            $data['loc_data'] = $query_get_cfo_data;
        } else {
            $data['loc_data'] = "";
        }
        $this->load->view('customer/Sale_state_wise', $data);
    }

    function Sale_b2b_b2c_admin() {
//        $query_get_cfo_data = $this->Cfo_model->get_data_cfo_admin();
        $session_data = $this->session->userdata('login_session');
        $email = ($session_data['customer_email_id']);
        $get_firm_id = $this->Customer_model->get_firm_id($email);
        if ($get_firm_id != FALSE) {
            $firm_id = $get_firm_id;
        } else {
            $firm_id = "";
        }
        $query_get_data = $this->Cfo_model->get_data_cfo_admin($firm_id);
        if ($query_get_data !== FALSE) {
            $data['b2b_data'] = $query_get_data;
        } else {
            $data['b2b_data'] = "";
        }
        $this->load->view('admin/B2b_b2c', $data);
    }

    function Sale_b2b_b2c_hq() {
//        $query_get_cfo_data = $this->Cfo_model->get_data_cfo_admin();
        $session_data = $this->session->userdata('login_session');
        $email = ($session_data['customer_email_id']);
        $get_firm_id = $this->Customer_model->get_firm_id($email);
        if ($get_firm_id != FALSE) {
            $firm_id = $get_firm_id;
        } else {
            $firm_id = "";
        }
        $query_get_data = $this->Cfo_model->get_data_cfo_admin($firm_id);
        if ($query_get_data !== FALSE) {
            $data['b2b_data'] = $query_get_data;
        } else {
            $data['b2b_data'] = "";
        }
        $this->load->view('hq_admin/B2b_b2c', $data);
    }

    function state_wise_report_admin() {
//        $query_get_cfo_data = $this->Cfo_model->get_data_cfo_admin();
        $session_data = $this->session->userdata('login_session');
        $email = ($session_data['customer_email_id']);
        $get_firm_id = $this->Customer_model->get_firm_id($email);
        if ($get_firm_id != FALSE) {
            $firm_id = $get_firm_id;
        } else {
            $firm_id = "";
        }
        $query_get_data = $this->Cfo_model->get_data_cfo_admin($firm_id);
        if ($query_get_data !== FALSE) {
            $data['loc_data'] = $query_get_data;
        } else {
            $data['loc_data'] = "";
        }
        $this->load->view('admin/Sale_state_wise', $data);
    }

    function state_wise_report_hq() {
//        $query_get_cfo_data = $this->Cfo_model->get_data_cfo_admin();
        $session_data = $this->session->userdata('login_session');
        $email = ($session_data['customer_email_id']);
        $get_firm_id = $this->Customer_model->get_firm_id($email);
        if ($get_firm_id != FALSE) {
            $firm_id = $get_firm_id;
        } else {
            $firm_id = "";
        }
        $query_get_data = $this->Cfo_model->get_data_cfo_admin($firm_id);
        if ($query_get_data !== FALSE) {
            $data['loc_data'] = $query_get_data;
        } else {
            $data['loc_data'] = "";
        }
        $this->load->view('hq_admin/Sale_state_wise', $data);
    }

    public function sale_exports_fun() {

//        $query_get_cfo_data = $this->Cfo_model->get_data_cfo_admin();
        $session_data = $this->session->userdata('login_session');
        $email = ($session_data['customer_email_id']);
        $get_firm_id = $this->Customer_model->get_firm_id($email);
        if ($get_firm_id != FALSE) {
            $firm_id = $get_firm_id;
        } else {
            $firm_id = "";
        }
        $query_get_data = $this->Cfo_model->get_data_cfo_admin($firm_id);
        if ($query_get_data !== FALSE) {
            $data['exports_data'] = $query_get_data;
        } else {
            $data['exports_data'] = "";
        }
        $this->load->view('admin/sale_exports', $data);
    }

    public function sale_nil_zero_rated_fun() {
        $query_get_cfo_data = $this->Cfo_model->get_data_cfo_admin();
        if ($query_get_cfo_data !== FALSE) {
            $data['nil_n_zero_data'] = $query_get_cfo_data;
        } else {
            $data['nil_n_zero_data'] = "";
        }
        $this->load->view('admin/sale_nil_zero_rated', $data);
    }

    public function sale_rate_wise_fun() {
//        $query_get_cfo_data = $this->Cfo_model->get_data_cfo_admin();
        $session_data = $this->session->userdata('login_session');
        $email = ($session_data['customer_email_id']);
        $get_firm_id = $this->Customer_model->get_firm_id($email);
        if ($get_firm_id != FALSE) {
            $firm_id = $get_firm_id;
        } else {
            $firm_id = "";
        }
        $query_get_data = $this->Cfo_model->get_data_cfo_admin($firm_id);
        if ($query_get_data !== FALSE) {
            $data['rate_wise_data'] = $query_get_data;
        } else {
            $data['rate_wise_data'] = "";
        }
        $this->load->view('admin/sale_rate_wise', $data);
    }

    public function import_excel() { //function to get data from excel files
        if (isset($_FILES["file_ex"]["name"])) {
            $path = $_FILES["file_ex"]["tmp_name"];
            $this->load->library('excel');
            $object = PHPExcel_IOFactory::load($path);
            $worksheet = $object->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();


            $j = 0;
            for ($i = 8; $i <= $highestRow; $i++) { // loop to get last row number to get state
                if ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "Total") {
                    $j++;
                }
                if ($j > 0) {
                    break;
                }
            }
            $total_row_num = $i;
            $all_state = array();
            $str = "(4) Cr Note Details";

            for ($k = 8; $k < $total_row_num; $k++) { //loop get state data
                $all_state[] = $object->getActiveSheet()->getCell('D' . $k)->getValue();
            }
            $states1 = array_unique($all_state); //unique array of state
            $states = array_values($states1); //change array indexes
            $count = count($states);
            $a1 = 0;
            $arr_taxable_value = array();
            for ($m1 = 0; $m1 < $count; $m1++) {
                if ($m1 < ($count)) {
                    $state_new = $states[$m1];
                } else {
                    $state_new = $states[0];
                }

                $taxable_value = 0;

//                echo $highestRow;
                for ($l = 8; $l <= $highestRow; $l++) { //loop to get data statewise
                    $a2 = $object->getActiveSheet()->getCell('A' . $l)->getValue();
                    if ($a2 == "(4) Cr Note Details") {
                        $a1 = 1;
                    } else if ($a2 == "(5) Dr Note Details") {
                        $a1 = 2;
                    }
                    if ($object->getActiveSheet()->getCell('D' . $l)->getValue() == $state_new) {
                        if ($a1 == 0 or $a1 == 2) {
                            $tax_val = $object->getActiveSheet()->getCell('E' . $l)->getValue();
                            $taxable_value += $tax_val;
                        } else if ($a1 == 1) {
                            $tax_val = $object->getActiveSheet()->getCell('E' . $l)->getValue();
                            $taxable_value -= $tax_val;
                        }
                    }
                }

                $arr_taxable_value[] = $taxable_value;
            }
            //insert data of other states

            for ($m = 0; $m < $count; $m++) {

                $quer = $this->db->query("insert into state_wise_summary_all (`customer_id`,`insert_id`,`state_name`,`taxable_value`)values ('cust_1001','insert_1001','$states[$m]','$arr_taxable_value[$m]')");
            }
//            get array for maharashtra.
            $taxable_value_mh = 0;
//            $arr_taxable_value_mh = array();
            for ($l = 8; $l <= $highestRow; $l++) { //loop to get data statewise
                $a2 = $object->getActiveSheet()->getCell('A' . $l)->getValue();
                if ($a2 == "(4) Cr Note Details") {
                    $a1 = 1;
                } else if ($a2 == "(5) Dr Note Details") {
                    $a1 = 2;
                }
                if ($object->getActiveSheet()->getCell('D' . $l)->getValue() == "MAHARASHTRA") {
                    if ($a1 == 0 or $a1 == 2) {
                        $tax_val = $object->getActiveSheet()->getCell('E' . $l)->getValue();
                        $taxable_value_mh += $tax_val;
                    } else if ($a1 == 1) {
                        $tax_val = $object->getActiveSheet()->getCell('E' . $l)->getValue();
                        $taxable_value_mh -= $tax_val;
                    }
                }
            }
            $taxable_value_mh = $taxable_value_mh;
        }
        //insert data of maharashtra

        $quer = $this->db->query("insert into state_wise_summary_all (`customer_id`,`insert_id`,`state_name`,`taxable_value`)values ('cust_1001','insert_1001','MAHARASHTRA','$taxable_value_mh')");
    }

    //functio to get graph state wise
    public function get_graph_state_wise1() {
        $curr_url = $this->input->post("curr_url");
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $query = $this->db->query("SELECT * from state_wise_summary_all where customer_id='$customer_id' AND insert_id='$insert_id'");
        $query_get_observation = $this->db->query("SELECT * from observation_transaction_all where customer_id='$customer_id' AND insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
        $data = ""; //view observations
        $data1 = ""; //view observations
        $data2 = ""; //view observations
        $state_arr = array();
        $taxble_val_arr = array();

        $data_statewise_name = "";
        $data_statewise_observation = "";
        $data_statewise_remarks = "";
        $a = "";

//        if ($query->num_rows() > 0) {
        if ($this->db->affected_rows() > 0) {
            $result = $query->result();
            $result1 = $query_get_observation->row();
            $statewise_wise_observation = $result1->state_wise_observation;
            $statewise_wise_remarks = $result1->state_wise_remarks;


            $data_statewise_name = "Sales State Wise";
            $data_statewise_observation = $statewise_wise_observation;
//            $data_statewise_remarks = $statewise_wise_remarks;
            $a = $statewise_wise_remarks;
            if ($a == '') {
                $data_statewise_remarks = 'not given';
            } else {
                $data_statewise_remarks = $statewise_wise_remarks;
            }

            $data2 .= '<h4><b>3.Sales State Wise</b></h4>';
            $data .= '<div class="row">
                    <div class="col-md-12">
                        <div class="">
                         <table id="example2" class="table table-bordered table-striped">
                                <thead style="background-color: #00008B;color:white">
                                    <tr>
                                        <th>No.</th>
                                        <th>State</th>
                                        <th>Taxable Values</th>
                                    </tr>
                                </thead>
                                <tbody>';
            $k = 1;
            foreach ($result as $row) {
                $state = $row->state_name;
                $state_arr[] = $row->state_name;
                $taxble_val_arr[] = $row->taxable_value;
                $taxble_val = $row->taxable_value;
                $data .= '<tr>' .
                        '<td>' . $k . '</td>' .
                        '<td>' . $state . '</td>' .
                        '<td>' . $taxble_val . '</td>' .
                        '</tr>';
                $k++;
            }

            $data .= '<tr>' .
                    '<td>' . '<b>Total</b>' . '</td>' .
                    '<td>' . '' . '</td>' .
                    '<td>' . '<b>' . array_sum($taxble_val_arr) . '</b> ' . '</td>' .
                    '</tr>';
            $data .= '</tbody></table></div></div></div>';



            //            get highest 3 records
            $qrr = $this->db->query("SELECT * FROM state_wise_summary_all where customer_id='$customer_id' ORDER BY `taxable_value` DESC LIMIT 3 ");
            $resss = $qrr->result();
            $data .= "<div><h4><b>Top Three State: </b></h4>";
            $g = 1;
            $arr = array();
            foreach ($resss as $roww) {
                $data .= $g . ". <b><span style='color:#4D52B0'>" . $roww->state_name . "</span></b> - ₹ " . $roww->taxable_value . "<br></div>";
                $g++;
                $arr[] = $roww->taxable_value;
            }
            $total = array_sum($taxble_val_arr);
            $top3 = array_sum($arr);
            $top_3_state = round(($top3 / $total) * 100, 2);

            $url = base_url() . "enter_detail/" . base64_encode($customer_id) . "/" . base64_encode($insert_id);
            if ($curr_url == $url) {
                $get_observation = $this->db->query("select state_wise_observation from observation_transaction_all where customer_id='$customer_id' and insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
                if ($this->db->affected_rows() > 0) {
                    $res = $get_observation->row();
                    $observation = $res->state_wise_observation;
                } else {
                    $observation = "";
                }
                $data .= '<div class="col-md-12">
                                    <label><h4><b>Observation of Sales State wise:</b></h4></label><span class="required" aria-required="true"> </span>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                        <textarea class="form-control" rows="5" id="statewise_sale_observation" name="statewise_sale_observation" onkeyup="countWords(this.id);" >' . $top_3_state . ' % of total sales comes from top 3 states.</textarea>
                                    </div>
                                    <span class="required" style="color: red" id="statewise_sale_observation_error"></span> 
                                </div><br>';
            } else {
                $data .= "<div class='col-md-12'>
                                    <label><h4><b>Observation :</b></h4></label><span class='required' aria-required='true'> </span>
                                    <div class='input-group'>
                                        <span class='input-group-addon'>
                                            <i class='fa fa-eye'></i>
                                        </span>
                                        <textarea class='form-control' rows='5' id='statewise_sale_observation' name='statewise_sale_observation' onkeyup='countWords(this.id);'>" . $top_3_state . "  % of total sales comes from top 3 states.</textarea>
                                    </div>
                                    <span class='required' style='color: red' id='statewise_sale_observation_error'></span>
                                </div>";
            }
            $get_observation1 = $this->db->query("select state_wise_remarks from observation_transaction_all where customer_id='$customer_id' and insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
            if ($this->db->affected_rows() > 0) {
                $res = $get_observation1->row();
                $state_wise_remarks = $res->state_wise_remarks;
            } else {
                $state_wise_remarks = "";
            }
            $data .= "<div class='col-md-12'>
                    <h5 class='box-title' style='margin-left: 1%;'><b>Remarks:</b></h5>
                    <textarea id='editor_location_data' name='editor_location_data' rows='10' style='width: 96%;margin-left: 1%;height: 15%;' onkeyup='final_word_count(this.id);remove_error('editor_location_data')'>" . $state_wise_remarks . "</textarea>
                    </div>";
//            $data1 .= '<h4><b>Observation:</b></h4>';
//            $data1 .= "<span><b>" . $top_3_state . " </b> % of total sales comes from top 3 states.</span>";
//            $data1 .= "<h5><b>Note:</b>For detailed and consolidated summary refer section-8.</h5>";


            $state = array();
            $taxable_value = array();
            for ($o = 0; $o < sizeof($taxble_val_arr); $o++) {

                $taxable_value[] = $taxble_val_arr[$o];
                $aa2 = settype($taxable_value[$o], "float");
            }
            $max = max($taxable_value);
            //function to get customer name
            $quer21 = $this->db->query("SELECT customer_name from customer_header_all where customer_id='$customer_id' ");

            if ($quer21->num_rows() > 0) {
                $res2 = $quer21->row();
                $customer_name = $res2->customer_name;
            }


            $respnose['customer_name'] = $customer_name; //customer
            $respnose['max'] = $max; //$max
            $respnose['message'] = "success";
            $respnose['taxable_value'] = $taxable_value;  //taxable value data
            $respnose['state'] = $state_arr;  //state data
            $respnose['data'] = $data; //table view data
            $respnose['data1'] = $data1; //table view data
            $respnose['data2'] = $data2; //table view data
            $respnose['data_statewise_name'] = $data_statewise_name; //table view data
            $respnose['data_statewise_observation'] = $data_statewise_observation; //table view data
            $respnose['data_statewise_remarks'] = $data_statewise_remarks; //table view data
        } else {
            $respnose['message'] = "";
            $respnose['taxable_value'] = "";  //taxable value data
            $respnose['state'] = "";  //state data
            $respnose['data'] = "";
        }echo json_encode($respnose);
    }

    public function get_graph_state_wise() {
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $query = $this->db->query("SELECT * from state_wise_summary_all where customer_id='$customer_id' AND insert_id='$insert_id'");
        $data = ""; //view observations
        $state_arr = array();
        $taxble_val_arr = array();

        if ($query->num_rows() > 0) {
            $result = $query->result();

            $data .= '<div class="row">
                    <div class="col-md-12">
                        <div class="">
                         <table id="example2" class="table table-bordered table-striped">
                                <thead style="background-color: #00008B;color:white">
                                    <tr>
                                        <th>No.</th>
                                        <th>State</th>
                                        <th>Taxable Values</th>
                                    </tr>
                                </thead>
                                <tbody>';
            $k = 1;
            foreach ($result as $row) {
                $state = $row->state_name;
                $state_arr[] = $row->state_name;
                $taxble_val_arr[] = $row->taxable_value;
                $taxble_val = $row->taxable_value;
                $data .= '<tr>' .
                        '<td>' . $k . '</td>' .
                        '<td>' . $state . '</td>' .
                        '<td>' . $taxble_val . '</td>' .
                        '</tr>';
                $k++;
            }

            $data .= '<tr>' .
                    '<td>' . '<b>Total</b>' . '</td>' .
                    '<td>' . '' . '</td>' .
                    '<td>' . '<b>' . array_sum($taxble_val_arr) . '</b> ' . '</td>' .
                    '</tr>';
            $data .= '</tbody></table></div></div></div>';
            //            get highest 3 records
            $qrr = $this->db->query("SELECT * FROM state_wise_summary_all where customer_id='$customer_id' ORDER BY `taxable_value` DESC LIMIT 3 ");
            $resss = $qrr->result();
            $data .= "<div><h4><b>Top Three State: </b></h4>";
            $g = 1;
            $arr = array();
            foreach ($resss as $roww) {
                $data .= $g . ". <b><span style='color:#4D52B0'>" . $roww->state_name . "</span></b> - ₹ " . $roww->taxable_value . "<br></div>";
                $g++;
                $arr[] = $roww->taxable_value;
            }
            $total = array_sum($taxble_val_arr);
            $top3 = array_sum($arr);
            $top_3_state = round(($top3 / $total) * 100, 2);
            $data .= "<h4><b>" . $top_3_state . " </b> % of total sales comes from top 3 states.</h4>";
            $data .= "<h5><b>Note:</b>For detailed and consolidated summary refer section-10.</h5>";
            $state = array();
            $taxable_value = array();
            for ($o = 0; $o < sizeof($taxble_val_arr); $o++) {

                $taxable_value[] = $taxble_val_arr[$o];
                $aa2 = settype($taxable_value[$o], "float");
            }
            $max = max($taxable_value);
            //function to get customer name
            $quer21 = $this->db->query("SELECT customer_name from customer_header_all where customer_id='$customer_id' ");

            if ($quer21->num_rows() > 0) {
                $res2 = $quer21->row();
                $customer_name = $res2->customer_name;
            }


            $respnose['customer_name'] = $customer_name; //customer
            $respnose['max'] = $max; //$max
            $respnose['message'] = "success";
            $respnose['taxable_value'] = $taxable_value;  //taxable value data
            $respnose['state'] = $state_arr;  //state data
            $respnose['data'] = $data; //table view data
        } else {
            $respnose['message'] = "";
            $respnose['taxable_value'] = "";  //taxable value data
            $respnose['state'] = "";  //state data
            $respnose['data'] = "";
        }echo json_encode($respnose);
    }

    // function taxable non taxable and exempt page load
    public function sale_taxable_nontaxable() {
        $session_data = $this->session->userdata('login_session');
        $customer_id = ($session_data['customer_id']);
        $query_get_cfo_data = $this->Cfo_model->get_data_cfo($customer_id);
        if ($query_get_cfo_data !== FALSE) {
            $data['tax_exempt_data'] = $query_get_cfo_data;
        } else {
            $data['tax_exempt_data'] = "";
        }
        $this->load->view('customer/Sale_tax_nontax_exempt', $data);
    }

    // function taxable non taxable and exempt page load
    public function Sale_taxable_nontaxable_admin() {
//        $query_get_cfo_data = $this->Cfo_model->get_data_cfo_admin();
        $session_data = $this->session->userdata('login_session');
        $email = ($session_data['customer_email_id']);
        $get_firm_id = $this->Customer_model->get_firm_id($email);
        if ($get_firm_id != FALSE) {
            $firm_id = $get_firm_id;
        } else {
            $firm_id = "";
        }
        $query_get_data = $this->Cfo_model->get_data_cfo_admin($firm_id);
        if ($query_get_data !== FALSE) {
            $data['tax_exempt_data'] = $query_get_data;
        } else {
            $data['tax_exempt_data'] = "";
        }
        $this->load->view('admin/Sale_tax_nontax_exempt', $data);
    }

    public function Sale_taxable_nontaxable_hq() {
//        $query_get_cfo_data = $this->Cfo_model->get_data_cfo_admin();
        $session_data = $this->session->userdata('login_session');
        $email = ($session_data['customer_email_id']);
        $get_firm_id = $this->Customer_model->get_firm_id($email);
        if ($get_firm_id != FALSE) {
            $firm_id = $get_firm_id;
        } else {
            $firm_id = "";
        }
        $query_get_data = $this->Cfo_model->get_data_cfo_admin($firm_id);
        if ($query_get_data !== FALSE) {
            $data['tax_exempt_data'] = $query_get_data;
        } else {
            $data['tax_exempt_data'] = "";
        }
        $this->load->view('hq_admin/Sale_tax_nontax_exempt', $data);
    }

    public function get_graph_taxable_nontx_exempt() { //get graph function of taxable nontaxable and exempt
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $query = $this->db->query("SELECT * from monthly_summary_all where customer_id='$customer_id' and insert_id='$insert_id'");
        $query_get_observation = $this->db->query("SELECT * from observation_transaction_all where customer_id='$customer_id' AND insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
        $data = ""; //view observations
        $data1 = ""; //view observations
        $data2 = ""; //view observations
        $data_tax_nontax_name = "";
        $data_tax_nontax_observation = "";
        $data_tax_nontax_remarks = "";
        $a = "";
//        if ($query->num_rows() > 0) {
        if ($this->db->affected_rows() > 0) {
            $result = $query->result();
            $result1 = $query_get_observation->row();
            $tax_nontax_observation = $result1->tax_nontax_observation;
            $tax_nontax_remarks = $result1->tax_nontax_remarks;

            $data_tax_nontax_name = 'Sales Taxable, Non-taxable & Exempt';
            $data_tax_nontax_observation = $tax_nontax_observation;
//             $data_tax_nontax_remarks=$tax_nontax_remarks;
            $a = $tax_nontax_remarks;
            if ($a == '') {
                $data_tax_nontax_remarks = 'not given';
            } else {
                $data_tax_nontax_remarks = $tax_nontax_remarks;
            }


            $taxable_supply_arr = array();
            $sub_total_non_gst_arr = array();
            $sub_total_exempt_arr = array();
            $ratio_taxable_supply = array();
            $ratio_subtotal_nongst = array();
            $ratio_subtotal_exempt = array();
            $sub_total_nil_rated_arr = array();
            $sub_total_zero_ratedarr = array();
            $ratio_subtotal_nil_rated = array();
            $ratio_subtotal_zero_rated = array();
            $data2 .= '<h4><b>4.Sales Taxable,Non-taxable & Exempt</b></h4>';
            $data .= '<div class="row">
                    <div class="col-md-12">
                        <div class="">
                         <table id="example2" class="table table-bordered table-striped">
                                <thead style="background-color: #00008B;color:white">
                                    <tr>
                                       
                                        <th>Month</th>
                                        <th>Taxable</th>
                                        <th>Exempt</th>
                                        <th>Non-GST</th>
                                        <th>Nil</th>
                                        <th>Zero</th>
                                        <th>Ratio Taxable</th>
                                        <th>Ratio Exempt</th>
                                        <th>Ratio Non-GST</th>
                                        <th>Ratio Nil</th>
                                        <th>Ratio zero</th>
                                    </tr>
                                </thead>
                                <tbody>';
            $k = 1;
            foreach ($result as $row) {
                $inter_state_supply = $row->inter_state_supply;
                $intra_state_supply = $row->intra_state_supply;
                $debit_value = $row->debit_value;
                $credit_value = $row->credit_value;
                $month = $row->month;

                $taxable_supply = ($inter_state_supply + $intra_state_supply + $debit_value) - ($credit_value);
                $taxable_supply_arr[] = $taxable_supply; //taxable supply array

                $sub_total_non_gst = $row->sub_total_non_gst;
                $sub_total_non_gst_arr[] = $sub_total_non_gst; // sub total non gst array

                $sub_total_exempt = $row->sub_total_exempt;
                $sub_total_exempt_arr[] = $sub_total_exempt; // sub total exempt array

                $sub_total_nil_rated = $row->sub_total_nil_rated;
                $sub_total_nil_rated_arr[] = $sub_total_nil_rated; // sub total non gst array

                $sub_total_zero_rated = ($row->total_non_gst_export) + ($row->total_taxable_data_gst_export);
                $sub_total_zero_ratedarr[] = $sub_total_zero_rated; // sub total exempt array

                $grand_total = $taxable_supply + $sub_total_non_gst + $sub_total_exempt + $sub_total_nil_rated + $sub_total_zero_rated;
                if ($grand_total != 0) {
                    $ratio_taxable_supply[] = round(($taxable_supply * 100) / ($grand_total));
                    $ratio_subtotal_nongst[] = round(($sub_total_non_gst * 100) / ($grand_total));
                    $ratio_subtotal_exempt[] = round(($sub_total_exempt * 100) / ($grand_total));
                    $ratio_subtotal_nil_rated[] = round(($sub_total_nil_rated * 100) / ($grand_total));
                    $ratio_subtotal_zero_rated[] = round(($sub_total_zero_rated * 100) / ($grand_total));


                    $ratio1 = (round(($taxable_supply * 100) / ($grand_total)));
                    $ratio2 = (round(($sub_total_non_gst * 100) / ($grand_total)));
                    $ratio3 = (round(($sub_total_exempt * 100) / ($grand_total)));
                    $ratio4 = (round(($sub_total_nil_rated * 100) / ($grand_total)));
                    $ratio5 = (round(($sub_total_zero_rated * 100) / ($grand_total)));
                } else {
                    $ratio_taxable_supply[] = 0;
                    $ratio_subtotal_nongst[] = 0;
                    $ratio_subtotal_exempt[] = 0;
                    $ratio_subtotal_nil_rated[] = 0;
                    $ratio_subtotal_zero_rated[] = 0;
                    $ratio1 = 0;
                    $ratio2 = 0;
                    $ratio3 = 0;
                    $ratio4 = 0;
                    $ratio5 = 0;
                }
                $data .= '<tr>' .
//                        '<td>' . $k . '</td>' .
                        '<td>' . $month . '</td>' .
                        '<td>' . $taxable_supply . '</td>' .
                        '<td>' . $sub_total_exempt . '</td>' .
                        '<td>' . $sub_total_non_gst . '</td>' .
                        '<td>' . $sub_total_nil_rated . '</td>' .
                        '<td>' . $sub_total_zero_rated . '</td>' .
                        '<td>' . $ratio1 . "%" . '</td>' .
                        '<td>' . $ratio2 . "%" . '</td>' .
                        '<td>' . $ratio3 . "%" . '</td>' .
                        '<td>' . $ratio4 . "%" . '</td>' .
                        '<td>' . $ratio5 . "%" . '</td>' .
                        '</tr>';
//                $k++;
            }
            $data .= '<tr>' .
//                    '<td>' . '<b>Total</b>' . '</td>' .
                    '<td>' . '<b>Total</b>' . '</td>' .
                    '<td>' . '<b>' . array_sum($taxable_supply_arr) . '</b> ' . '</td>' .
                    '<td>' . '<b>' . array_sum($sub_total_exempt_arr) . '</b>' . '</td>' .
                    '<td>' . '<b>' . array_sum($sub_total_non_gst_arr) . '</b>' . '</td>' .
                    '<td>' . '<b>' . array_sum($sub_total_nil_rated_arr) . '</b>' . '</td>' .
                    '<td>' . '<b>' . array_sum($sub_total_zero_ratedarr) . '</b>' . '</td>' .
                    '<td>' . '<b>' . "" . '</b>' . '</td>' .
                    '<td>' . '<b>' . "" . '</b>' . '</td>' .
                    '<td>' . '<b>' . "" . '</b>' . '</td>' .
                    '<td>' . '<b>' . "" . '</b>' . '</td>' .
                    '<td>' . '<b>' . "" . '</b>' . '</td>' .
                    '</tr>';
            $data .= '</tbody></table></div></div></div>';
            $get_observation = $this->db->query("select tax_nontax_observation from observation_transaction_all where customer_id='$customer_id' and insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
            if ($this->db->affected_rows() > 0) {
                $res = $get_observation->row();
                $observation = $res->tax_nontax_observation;
            } else {
                $observation = "";
            }

            $data1 .= "<hr><h4><b>Observation :</b></h4><span>" . $observation . "</span>";
            $data1 .= "<h5><b>Note:</b>For detailed and consolidated summary refer section-10.</h5>";
            $abc1 = array();
            $abc2 = array();
            $abc3 = array();
            $abc4 = array();
            $abc5 = array();
            $abc6 = array();
            $abc7 = array();
            $abc8 = array();
            $abc9 = array();
            $abc10 = array();
            // loop to get graph data as per graph script requirement
            for ($o = 0; $o < sizeof($taxable_supply_arr); $o++) {
                $abc1[] = $taxable_supply_arr[$o];
                $aa1 = settype($abc1[$o], "float");

                $abc2[] = $sub_total_non_gst_arr[$o];
                $aa2 = settype($abc2[$o], "float");

                $abc3[] = $sub_total_exempt_arr[$o];
                $aa3 = settype($abc3[$o], "float");

                $abc4[] = $ratio_taxable_supply[$o];
                $aa4 = settype($abc4[$o], "float");

                $abc5[] = $ratio_subtotal_nongst[$o];
                $aa5 = settype($abc5[$o], "float");

                $abc6[] = $ratio_subtotal_exempt[$o];
                $aa6 = settype($abc6[$o], "float");

                $abc7[] = $sub_total_nil_rated_arr[$o];
                $aa2 = settype($abc2[$o], "float");

                $abc8[] = $sub_total_zero_ratedarr[$o];
                $aa3 = settype($abc3[$o], "float");

                $abc9[] = $ratio_subtotal_nil_rated[$o];
                $aa5 = settype($abc5[$o], "float");

                $abc10[] = $ratio_subtotal_zero_rated[$o];
                $aa6 = settype($abc6[$o], "float");
            }

            // to get max value for range
            $arr = array($abc1, $abc2, $abc3);
            $max_range = 0;
            foreach ($arr as $val) {
                foreach ($val as $key => $val1) {
                    if ($val1 > $max_range) {
                        $max_range = $val1;
                    }
                }
            }

            //function to get months
            $quer2 = $this->db->query("SELECT month from  monthly_summary_all where customer_id='$customer_id'and insert_id='$insert_id'");
            $months = array();
            if ($quer2->num_rows() > 0) {
                $res2 = $quer2->result();
                foreach ($res2 as $row) {
                    $months[] = $row->month;
                }
            }

            //function to get customer name
            $quer21 = $this->db->query("SELECT customer_name from customer_header_all where customer_id='$customer_id'");

            if ($quer21->num_rows() > 0) {
                $res2 = $quer21->row();
                $customer_name = $res2->customer_name;
            }
            $respnose['data'] = $data;
            $respnose['data1'] = $data1;
            $respnose['data2'] = $data2;
            $respnose['message'] = "success";
            $respnose['taxable_supply_arr'] = $abc1;  //taxable_supply data
            $respnose['sub_total_non_gst_arr'] = $abc2; //sub_total_non_gstdata
            $respnose['sub_total_exempt_arr'] = $abc3; //sub_total_exempt data
            $respnose['ratio_taxable_supply'] = $abc4; //ratio_taxable_supply
            $respnose['ratio_subtotal_nongst'] = $abc5; //ratio_subtotal_nongst
            $respnose['ratio_subtotal_exempt'] = $abc6; //ratio_subtotal_exempt
            $respnose['sub_total_nil_rate_arr'] = $abc7; //sub_total_nil rated
            $respnose['sub_total_zero_rated_arr'] = $abc8; //sub_total_zero rated 
            $respnose['ratio_nil_rate'] = $abc9; //ratio_subtotal_nil rated
            $respnose['ratio_zero_rated'] = $abc10; //ratio_subtotal_zero rated
            $respnose['month_data'] = $months; //months 
            $respnose['customer_name'] = $customer_name; //customer
            $respnose['max_range'] = $max_range; //maximum range for graph
            $respnose['data_tax_nontax_name'] = $data_tax_nontax_name; //maximum range for graph
            $respnose['data_tax_nontax_observation'] = $data_tax_nontax_observation; //maximum range for graph
            $respnose['data_tax_nontax_remarks'] = $data_tax_nontax_remarks; //maximum range for graph
        } else {
            $respnose['data'] = "";
            $respnose['message'] = "";
            $respnose['taxable_supply_arr'] = "";  //taxable_supply data
            $respnose['sub_total_non_gst_arr'] = ""; //sub_total_non_gstdata
            $respnose['sub_total_exempt_arr'] = ""; //sub_total_exempt data
            $respnose['ratio_taxable_supply'] = ""; //ratio_taxable_supply
            $respnose['ratio_subtotal_nongst'] = ""; //ratio_subtotal_nongst
            $respnose['ratio_subtotal_exempt'] = ""; //ratio_subtotal_exempt
        } echo json_encode($respnose);
    }

    public function get_graph_taxable_nontx_exempt1() { //get graph function of taxable nontaxable and exempt
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $curr_url = $this->input->post("curr_url");
        $query = $this->db->query("SELECT * from monthly_summary_all where customer_id='$customer_id' and insert_id='$insert_id'");
        $data = ""; //view observations
        if ($query->num_rows() > 0) {
            $result = $query->result();
            $taxable_supply_arr = array();
            $sub_total_non_gst_arr = array();
            $sub_total_exempt_arr = array();
            $ratio_taxable_supply = array();
            $ratio_subtotal_nongst = array();
            $ratio_subtotal_exempt = array();
            $sub_total_nil_rated_arr = array();
            $sub_total_zero_ratedarr = array();
            $ratio_subtotal_nil_rated = array();
            $ratio_subtotal_zero_rated = array();
            $data .= '<div class="row">
                    <div class="col-md-12">
                        <div class="">
                         <table id="example2" class="table table-bordered table-striped">
                                <thead style="background-color: #00008B;color:white">
                                    <tr>
                                        <th>No.</th>
                                        <th>Month</th>
                                        <th>Taxable Supply</th>
                                        <th>Exempt Supply</th>
                                        <th>Non-GST Supply</th>
                                        <th>Nil Rated Supply</th>
                                        <th>Zero rated Supply</th>
                                        <th>Ratio of Taxable supply by Total supply</th>
                                        <th>Ratio of Non-GST supply by Total supply</th>
                                        <th>Ratio of Exempt Supply by Total supply</th>
                                        <th>Ratio of Nil Rated supply to total supply</th>
                                        <th>Ratio of zero rated supply to total supply</th>
                                    </tr>
                                </thead>
                                <tbody>';
            $k = 1;
            foreach ($result as $row) {
                $inter_state_supply = $row->inter_state_supply;
                $intra_state_supply = $row->intra_state_supply;
                $debit_value = $row->debit_value;
                $credit_value = $row->credit_value;
                $month = $row->month;

                $taxable_supply = ($inter_state_supply + $intra_state_supply + $debit_value) - ($credit_value);
                $taxable_supply_arr[] = $taxable_supply; //taxable supply array

                $sub_total_non_gst = $row->sub_total_non_gst;
                $sub_total_non_gst_arr[] = $sub_total_non_gst; // sub total non gst array

                $sub_total_exempt = $row->sub_total_exempt;
                $sub_total_exempt_arr[] = $sub_total_exempt; // sub total exempt array

                $sub_total_nil_rated = $row->sub_total_nil_rated;
                $sub_total_nil_rated_arr[] = $sub_total_nil_rated; // sub total non gst array

                $sub_total_zero_rated = ($row->total_non_gst_export) + ($row->total_taxable_data_gst_export);
                $sub_total_zero_ratedarr[] = $sub_total_zero_rated; // sub total exempt array

                $grand_total = $taxable_supply + $sub_total_non_gst + $sub_total_exempt + $sub_total_nil_rated + $sub_total_zero_rated;

                if ($grand_total != 0) {
                    $ratio_taxable_supply[] = round(($taxable_supply * 100) / ($grand_total));
                    $ratio_subtotal_nongst[] = round(($sub_total_non_gst * 100) / ($grand_total));
                    $ratio_subtotal_exempt[] = round(($sub_total_exempt * 100) / ($grand_total));
                    $ratio_subtotal_nil_rated[] = round(($sub_total_nil_rated * 100) / ($grand_total));
                    $ratio_subtotal_zero_rated[] = round(($sub_total_zero_rated * 100) / ($grand_total));

                    $ratio1 = (round(($taxable_supply * 100) / ($grand_total)));
                    $ratio2 = (round(($sub_total_non_gst * 100) / ($grand_total)));
                    $ratio3 = (round(($sub_total_exempt * 100) / ($grand_total)));
                    $ratio4 = (round(($sub_total_nil_rated * 100) / ($grand_total)));
                    $ratio5 = (round(($sub_total_zero_rated * 100) / ($grand_total)));
                } else {
                    $ratio_taxable_supply[] = 0;
                    $ratio_subtotal_nongst[] = 0;
                    $ratio_subtotal_exempt[] = 0;
                    $ratio_subtotal_nil_rated[] = 0;
                    $ratio_subtotal_zero_rated[] = 0;
                    $ratio1 = 0;
                    $ratio2 = 0;
                    $ratio3 = 0;
                    $ratio4 = 0;
                    $ratio5 = 0;
                }
                $data .= '<tr>' .
                        '<td>' . $k . '</td>' .
                        '<td>' . $month . '</td>' .
                        '<td>' . $taxable_supply . '</td>' .
                        '<td>' . $sub_total_exempt . '</td>' .
                        '<td>' . $sub_total_non_gst . '</td>' .
                        '<td>' . $sub_total_nil_rated . '</td>' .
                        '<td>' . $sub_total_zero_rated . '</td>' .
                        '<td>' . $ratio1 . "%" . '</td>' .
                        '<td>' . $ratio2 . "%" . '</td>' .
                        '<td>' . $ratio3 . "%" . '</td>' .
                        '<td>' . $ratio4 . "%" . '</td>' .
                        '<td>' . $ratio5 . "%" . '</td>' .
                        '</tr>';
                $k++;
            }
            $data .= '<tr>' .
                    '<td>' . '<b>Total</b>' . '</td>' .
                    '<td>' . '' . '</td>' .
                    '<td>' . '<b>' . array_sum($taxable_supply_arr) . '</b> ' . '</td>' .
                    '<td>' . '<b>' . array_sum($sub_total_exempt_arr) . '</b>' . '</td>' .
                    '<td>' . '<b>' . array_sum($sub_total_non_gst_arr) . '</b>' . '</td>' .
                    '<td>' . '<b>' . array_sum($sub_total_nil_rated_arr) . '</b>' . '</td>' .
                    '<td>' . '<b>' . array_sum($sub_total_zero_ratedarr) . '</b>' . '</td>' .
                    '<td>' . '<b>' . "" . '</b>' . '</td>' .
                    '<td>' . '<b>' . "" . '</b>' . '</td>' .
                    '<td>' . '<b>' . "" . '</b>' . '</td>' .
                    '</tr>';
            $data .= '</tbody></table></div></div></div>';

            if (empty(array_filter($ratio_taxable_supply))) {
                $variation_taxable = 0;
            } else {
                $max_taxable = max(array_filter($ratio_taxable_supply));
                $min_taxable = min(array_filter($ratio_taxable_supply));
                $variation_taxable = ((($max_taxable - $min_taxable) / $min_taxable) * 100);
            }
            if (empty(array_filter($ratio_subtotal_nongst))) {
                $variation_subtotal_nongst = 0;
            } else {
                $max_subtotal_nongst = max(array_filter($ratio_subtotal_nongst));
                $min_subtotal_nongst = min(array_filter($ratio_subtotal_nongst));
                $variation_subtotal_nongst = ((($max_subtotal_nongst - $min_subtotal_nongst) / $min_subtotal_nongst) * 100);
            }

            if (empty(array_filter($ratio_subtotal_exempt))) {
                $variation_subtotal_exempt = 0;
            } else {
                $max_subtotal_exempt = max(array_filter($ratio_subtotal_exempt));
                $min_subtotal_exempt = min(array_filter($ratio_subtotal_exempt));
                $variation_subtotal_exempt = ((($max_subtotal_exempt - $min_subtotal_exempt) / $min_subtotal_exempt) * 100);
            }
            if (empty(array_filter($ratio_subtotal_nil_rated))) {
                $variation_subtotal_nil_rated = 0;
            } else {
                $max_subtotal_nil_rated = max(array_filter($ratio_subtotal_nil_rated));
                $min_subtotal_nil_rated = min(array_filter($ratio_subtotal_nil_rated));
                $variation_subtotal_nil_rated = ((($max_subtotal_nil_rated - $min_subtotal_nil_rated) / $min_subtotal_nil_rated) * 100);
            }
            if (empty(array_filter($ratio_subtotal_zero_rated))) {
                $variation_subtotal_zero_rated = 0;
            } else {
                $max_subtotal_zero_rated = max(array_filter($ratio_subtotal_zero_rated));
                $min_subtotal_zero_rated = min(array_filter($ratio_subtotal_zero_rated));
                $variation_subtotal_zero_rated = ((($max_subtotal_zero_rated - $min_subtotal_zero_rated) / $min_taxable) * 100);
            }

            if ($variation_taxable != 0) {
                $observation1 = round($variation_taxable) . ' is the % variation of taxable supply. ';
            } else {
                $observation1 = "";
            }
            if ($variation_subtotal_nongst != 0) {
                $observation2 = round($variation_subtotal_nongst) . ' is the % variation of Non GST supply. ';
            } else {
                $observation2 = "";
            }
            if ($variation_subtotal_exempt != 0) {
                $observation3 = round($variation_subtotal_exempt) . ' is the % variation of Exempt supply. ';
            } else {
                $observation3 = "";
            }
            if ($variation_subtotal_nil_rated != 0) {
                $observation4 = round($variation_subtotal_nil_rated) . ' is the % variation of Nil Rated supply. ';
            } else {
                $observation4 = "";
            }
            if ($variation_subtotal_zero_rated != 0) {
                $observation5 = round($variation_subtotal_zero_rated) . ' is the % variation of Zero Rated supply. ';
            } else {
                $observation5 = "";
            }
            $url = base_url() . "update_detail/" . base64_encode($customer_id) . "/" . base64_encode($insert_id);
            if ($curr_url == $url) {
                $get_observation = $this->db->query("select tax_nontax_observation from observation_transaction_all where customer_id='$customer_id' and insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
                if ($this->db->affected_rows() > 0) {
                    $res = $get_observation->row();
                    $observation = $res->tax_nontax_observation;
                } else {
                    $observation = "";
                }
                $data .= '<div class="col-md-12">
                                    <label><h4><b>Observation of CFO:</b></h4></label><span class="required" aria-required="true"> </span>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                        <textarea class="form-control" rows="5" id="tax_exempt_observation" name="tax_exempt_observation" onkeyup="countWords(this.id);" >' . $observation . '</textarea>
                                    </div>
                                    <span class="required" style="color: red" id="tax_exempt_observation_error"></span> 
                                </div><br>';
            } else {
                $data .= "<div class='col-md-12'>
                                    <label><h4><b>Observation </b></h4></label><span class='required' aria-required='true'> </span>
                                    <div class='input-group'>
                                        <span class='input-group-addon'>
                                            <i class='fa fa-eye'></i>
                                        </span>
                                        <textarea class='form-control' rows='5' id='tax_exempt_observation' name='tax_exempt_observation' onkeyup='countWords(this.id);'>" . $observation1 . $observation2 . $observation3 . $observation4 . $observation5 . "</textarea>
                                    </div>
                                    <span class='required' style='color: red' id='tax_exempt_observation_error'></span>
                                </div>";
            }
            $get_observation1 = $this->db->query("select tax_nontax_remarks from observation_transaction_all where customer_id='$customer_id' and insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
            if ($this->db->affected_rows() > 0) {
                $res = $get_observation1->row();
                $tax_nontax_remarks = $res->tax_nontax_remarks;
            } else {
                $tax_nontax_remarks = "";
            }
            $data .= "<div class='col-md-12'>
                <h5 class='box-title' style='margin-left: 1%;'><b>Remarks:</b></h5>
                    <textarea id='editor_tax_ntax_Exempt_data' name='editor_tax_ntax_Exempt_data' rows='10' style='width: 96%;margin-left: 1%;height: 15%;' onkeyup='final_word_count(this.id);remove_error('editor_tax_ntax_Exempt_data')'>" . $tax_nontax_remarks . "</textarea>
                    </div>";
            $abc1 = array();
            $abc2 = array();
            $abc3 = array();
            $abc4 = array();
            $abc5 = array();
            $abc6 = array();
            $abc7 = array();
            $abc8 = array();
            $abc9 = array();
            $abc10 = array();
            // loop to get graph data as per graph script requirement
            for ($o = 0; $o < sizeof($taxable_supply_arr); $o++) {
                $abc1[] = $taxable_supply_arr[$o];
                $aa1 = settype($abc1[$o], "float");

                $abc2[] = $sub_total_non_gst_arr[$o];
                $aa2 = settype($abc2[$o], "float");

                $abc3[] = $sub_total_exempt_arr[$o];
                $aa3 = settype($abc3[$o], "float");

                $abc4[] = $ratio_taxable_supply[$o];
                $aa4 = settype($abc4[$o], "float");

                $abc5[] = $ratio_subtotal_nongst[$o];
                $aa5 = settype($abc5[$o], "float");

                $abc6[] = $ratio_subtotal_exempt[$o];
                $aa6 = settype($abc6[$o], "float");

                $abc7[] = $sub_total_nil_rated_arr[$o];
                $aa2 = settype($abc2[$o], "float");

                $abc8[] = $sub_total_zero_ratedarr[$o];
                $aa3 = settype($abc3[$o], "float");

                $abc9[] = $ratio_subtotal_nil_rated[$o];
                $aa5 = settype($abc5[$o], "float");

                $abc10[] = $ratio_subtotal_zero_rated[$o];
                $aa6 = settype($abc6[$o], "float");
            }

            // to get max value for range
            $arr = array($abc1, $abc2, $abc3);
            $max_range = 0;
            foreach ($arr as $val) {
                foreach ($val as $key => $val1) {
                    if ($val1 > $max_range) {
                        $max_range = $val1;
                    }
                }
            }

            //function to get months
            $quer2 = $this->db->query("SELECT month from  monthly_summary_all where customer_id='$customer_id'and insert_id='$insert_id'");
            $months = array();
            if ($quer2->num_rows() > 0) {
                $res2 = $quer2->result();
                foreach ($res2 as $row) {
                    $months[] = $row->month;
                }
            }

            //function to get customer name
            $quer21 = $this->db->query("SELECT customer_name from customer_header_all where customer_id='$customer_id'");

            if ($quer21->num_rows() > 0) {
                $res2 = $quer21->row();
                $customer_name = $res2->customer_name;
            }
            $respnose['data'] = $data;
            $respnose['message'] = "success";
            $respnose['taxable_supply_arr'] = $abc1;  //taxable_supply data
            $respnose['sub_total_non_gst_arr'] = $abc2; //sub_total_non_gstdata
            $respnose['sub_total_exempt_arr'] = $abc3; //sub_total_exempt data
            $respnose['ratio_taxable_supply'] = $abc4; //ratio_taxable_supply
            $respnose['ratio_subtotal_nongst'] = $abc5; //ratio_subtotal_nongst
            $respnose['ratio_subtotal_exempt'] = $abc6; //ratio_subtotal_exempt
            $respnose['sub_total_nil_rate_arr'] = $abc7; //sub_total_nil rated
            $respnose['sub_total_zero_rated_arr'] = $abc8; //sub_total_zero rated 
            $respnose['ratio_nil_rate'] = $abc9; //ratio_subtotal_nil rated
            $respnose['ratio_zero_rated'] = $abc10; //ratio_subtotal_zero rated
            $respnose['month_data'] = $months; //months 
            $respnose['customer_name'] = $customer_name; //customer
            $respnose['max_range'] = $max_range; //maximum range for graph
        } else {
            $respnose['data'] = "";
            $respnose['message'] = "";
            $respnose['taxable_supply_arr'] = "";  //taxable_supply data
            $respnose['sub_total_non_gst_arr'] = ""; //sub_total_non_gstdata
            $respnose['sub_total_exempt_arr'] = ""; //sub_total_exempt data
            $respnose['ratio_taxable_supply'] = ""; //ratio_taxable_supply
            $respnose['ratio_subtotal_nongst'] = ""; //ratio_subtotal_nongst
            $respnose['ratio_subtotal_exempt'] = ""; //ratio_subtotal_exempt
        } echo json_encode($respnose);
    }

    //function to get data for nil rated and zero rated data
    public function get_graph_nil_zero_rated() {
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $query = $this->db->query("SELECT * from monthly_summary_all where customer_id='$customer_id' and insert_id='$insert_id'");
        $data = ""; //view observations
        if ($query->num_rows() > 0) {
            $result = $query->result();
            $taxable_supply_arr = array();
            $sub_total_nil_rated_arr = array();
            $sub_total_zero_ratedarr = array();
            $ratio_taxable_supply = array();
            $ratio_subtotal_nil_rated = array();
            $ratio_subtotal_zero_rated = array();
            $data .= '<div class="row">
                    <div class="col-md-12">
                        <div class="">
                         <table id="example2" class="table table-bordered table-striped">
                                <thead style="background-color: #00008B;color:white">
                                    <tr>
                                        <th>No.</th>
                                        <th>Month</th>
                                        <th>Taxable Supply</th>
                                        <th>Nil Rated Supply</th>
                                        <th>Zero rated Supply</th>
                                        <th>Ratio of taxable supply to total supply</th>
                                        <th>Ratio of Nil Rated supply to total supply</th>
                                        <th>Ratio of zero rated supply to total supply</th>
                                    </tr>
                                </thead>
                                <tbody>';
            $k = 1;
            foreach ($result as $row) {
                $inter_state_supply = $row->inter_state_supply;
                $intra_state_supply = $row->intra_state_supply;
                $debit_value = $row->debit_value;
                $credit_value = $row->credit_value;
                $month = $row->month;

                $taxable_supply = ($inter_state_supply + $intra_state_supply + $debit_value) - ($credit_value);
                $taxable_supply_arr[] = $taxable_supply; //taxable supply array

                $sub_total_nil_rated = $row->sub_total_nil_rated;
                $sub_total_nil_rated_arr[] = $sub_total_nil_rated; // sub total non gst array

                $sub_total_zero_rated = ($row->total_non_gst_export) + ($row->total_taxable_data_gst_export);
                $sub_total_zero_ratedarr[] = $sub_total_zero_rated; // sub total exempt array

                $grand_total = $taxable_supply + $sub_total_nil_rated + $sub_total_zero_rated;

                if ($grand_total != 0) {
                    $ratio_taxable_supply[] = round(($taxable_supply * 100) / ($grand_total));
                    $ratio_subtotal_nil_rated[] = round(($sub_total_nil_rated * 100) / ($grand_total));
                    $ratio_subtotal_zero_rated[] = round(($sub_total_zero_rated * 100) / ($grand_total));
                } else {
                    $ratio_taxable_supply[] = 0;
                    $ratio_subtotal_nil_rated[] = 0;
                    $ratio_subtotal_zero_rated[] = 0;
                }
                $data .= '<tr>' .
                        '<td>' . $k . '</td>' .
                        '<td>' . $month . '</td>' .
                        '<td>' . $taxable_supply . '</td>' .
                        '<td>' . $sub_total_nil_rated . '</td>' .
                        '<td>' . $sub_total_zero_rated . '</td>' .
                        '<td>' . (round(($taxable_supply * 100) / ($grand_total))) . "%" . '</td>' .
                        '<td>' . (round(($sub_total_nil_rated * 100) / ($grand_total))) . "%" . '</td>' .
                        '<td>' . (round(($sub_total_zero_rated * 100) / ($grand_total))) . "%" . '</td>' .
                        '</tr>';
                $k++;
            }

            $data .= '<tr>' .
                    '<td>' . '<b>Total</b>' . '</td>' .
                    '<td>' . '' . '</td>' .
                    '<td>' . '<b>' . array_sum($taxable_supply_arr) . '</b> ' . '</td>' .
                    '<td>' . '<b>' . array_sum($sub_total_nil_rated_arr) . '</b>' . '</td>' .
                    '<td>' . '<b>' . array_sum($sub_total_zero_ratedarr) . '</b>' . '</td>' .
                    '<td>' . '<b>' . "" . '</b>' . '</td>' .
                    '<td>' . '<b>' . "" . '</b>' . '</td>' .
                    '<td>' . '<b>' . "" . '</b>' . '</td>' .
                    '</tr>';
            $data .= '</tbody></table></div></div></div>';
//            $data .= "<hr><h4><b>Observation of Sales Taxable, non-taxable and Exempt:</b></h4>";
//            $data .= "<span>There is variation in the ratio of sales , give us an oppurtunity to optimise purchase planning , sales incentives planning & efficiency in working capital marketing.</span>";
            $abc1 = array();
            $abc2 = array();
            $abc3 = array();
            $abc4 = array();
            $abc5 = array();
            $abc6 = array();
            // loop to get graph data as per graph script requirement
            for ($o = 0; $o < sizeof($taxable_supply_arr); $o++) {
                $abc1[] = $taxable_supply_arr[$o];
                $aa1 = settype($abc1[$o], "float");

                $abc2[] = $sub_total_nil_rated_arr[$o];
                $aa2 = settype($abc2[$o], "float");

                $abc3[] = $sub_total_zero_ratedarr[$o];
                $aa3 = settype($abc3[$o], "float");

                $abc4[] = $ratio_taxable_supply[$o];
                $aa4 = settype($abc4[$o], "float");

                $abc5[] = $ratio_subtotal_nil_rated[$o];
                $aa5 = settype($abc5[$o], "float");

                $abc6[] = $ratio_subtotal_zero_rated[$o];
                $aa6 = settype($abc6[$o], "float");
            }



            //function to get months
            $quer2 = $this->db->query("SELECT month from  monthly_summary_all where customer_id='$customer_id'and insert_id='$insert_id'");
            $months = array();
            if ($quer2->num_rows() > 0) {
                $res2 = $quer2->result();
                foreach ($res2 as $row) {
                    $months[] = $row->month;
                }
            }

            //function to get customer name
            $quer21 = $this->db->query("SELECT customer_name from customer_header_all where customer_id='$customer_id'");

            if ($quer21->num_rows() > 0) {
                $res2 = $quer21->row();
                $customer_name = $res2->customer_name;
            }
            $respnose['data'] = $data;
            $respnose['message'] = "success";
            $respnose['taxable_supply_arr'] = $abc1;  //taxable_supply data
            $respnose['sub_total_nil_rate_arr'] = $abc2; //sub_total_nil rated
            $respnose['sub_total_zero_rated_arr'] = $abc3; //sub_total_zero rated 
            $respnose['ratio_taxable_supply'] = $abc4; //ratio_taxable_supply
            $respnose['ratio_nil_rate'] = $abc5; //ratio_subtotal_nil rated
            $respnose['ratio_zero_rated'] = $abc6; //ratio_subtotal_zero rated
            $respnose['month_data'] = $months; //months 
            $respnose['customer_name'] = $customer_name; //customer
        } else {
            $respnose['data'] = "";
            $respnose['message'] = "";
            $respnose['taxable_supply_arr'] = "";  //taxable_supply data
            $respnose['sub_total_non_gst_arr'] = ""; //sub_total_non_gstdata
            $respnose['sub_total_exempt_arr'] = ""; //sub_total_exempt data
            $respnose['ratio_taxable_supply'] = ""; //ratio_taxable_supply
            $respnose['ratio_subtotal_nongst'] = ""; //ratio_subtotal_nongst
            $respnose['ratio_subtotal_exempt'] = ""; //ratio_subtotal_exempt
        } echo json_encode($respnose);
    }

    //Graph generated month wise

    function sale_month_wise() { //function to load data
//        $data['result'] = $result;
        $session_data = $this->session->userdata('login_session');
        $customer_id = ($session_data['customer_id']);
        $query_get_cfo_data = $this->Cfo_model->get_data_cfo($customer_id);
        if ($query_get_cfo_data !== FALSE) {
            $data['month_wise_data'] = $query_get_cfo_data;
        } else {
            $data['month_wise_data'] = "";
        }
        $this->load->view('customer/Sales_month_wise', $data);
    }

    function sale_month_wise_admin() { //function to load data
//        $query_get_cfo_data = $this->Cfo_model->get_data_cfo_admin();
        $session_data = $this->session->userdata('login_session');
        $email = ($session_data['customer_email_id']);
        $get_firm_id = $this->Customer_model->get_firm_id($email);
        if ($get_firm_id != FALSE) {
            $firm_id = $get_firm_id;
        } else {
            $firm_id = "";
        }
        $query_get_data = $this->Cfo_model->get_data_cfo_admin($firm_id);
        if ($query_get_data !== FALSE) {
            $data['month_wise_data'] = $query_get_data;
        } else {
            $data['month_wise_data'] = "";
        }
        $this->load->view('admin/Sales_month_wise', $data);
    }

    function sale_month_wise_hq() { //function to load data
//        $query_get_cfo_data = $this->Cfo_model->get_data_cfo_admin();
        $session_data = $this->session->userdata('login_session');
        $email = ($session_data['customer_email_id']);
        $get_firm_id = $this->Customer_model->get_firm_id($email);
        if ($get_firm_id != FALSE) {
            $firm_id = $get_firm_id;
        } else {
            $firm_id = "";
        }
        $query_get_data = $this->Cfo_model->get_data_cfo_admin($firm_id);
        if ($query_get_data !== FALSE) {
            $data['month_wise_data'] = $query_get_data;
        } else {
            $data['month_wise_data'] = "";
        }
        $this->load->view('hq_admin/Sales_month_wise', $data);
    }

    public function get_graph_sales_month_wise() { //get graph function of Sales month wise
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $query = $this->db->query("SELECT * from monthly_summary_all where customer_id='$customer_id' AND insert_id='$insert_id'");
        $query_get_observation = $this->db->query("SELECT * from observation_transaction_all where customer_id='$customer_id' AND insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
        $data = ""; //view observations
        $data1 = "";
        $data2 = "";
        $data_monthwise_name = "";
        $data_month_observation = "";
        $data_month_remarks = "";
        $a = '';
        if ($this->db->affected_rows() > 0) {
            $result = $query->result();
            $result1 = $query_get_observation->row();
            $month_wise_observation = $result1->month_wise_observation;
            $month_wise_remarks = $result1->month_wise_remarks;

//        if ($query->num_rows() > 0) {
//            $result = $query->result();
            $taxable_supply_arr = array();
            $data_monthwise_name = 'Sales Month Wise';
            $data_month_observation = $month_wise_observation;
//            $data_month_remarks = $month_wise_remarks;
            $a = $month_wise_remarks;
            if ($a == '') {
                $data_month_remarks = 'not given';
            } else {
                $data_month_remarks = $month_wise_remarks;
            }
            $data2 .= '<h4><b>1.Sales Month Wise</b></h4>';
            $data .= '<div class="row"><br><br><br>
                    <div class="col-md-12">
                        <div class="">
                         <table id="example2" class="table table-bordered table-striped">
                                <thead style="background-color: #00008B;color:white">
                                    <tr>
                                        <th>No.</th>
                                        <th>Month</th>
                                        <th>Sales</th>
                                        <th>Ratio</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>';
            $k = 1;
            $sales_percent_values = array();
            $taxable_supply_arr1 = array();
            foreach ($result as $row1) {
                $inter_state_supply = $row1->inter_state_supply;
                $intra_state_supply = $row1->intra_state_supply;
                $no_gst_paid_supply = $row1->no_gst_paid_supply;
                $debit_value = $row1->debit_value;
                $credit_value = $row1->credit_value;
                //new changes 
                $total_taxable_advance_no_invoice = $row1->total_taxable_advance_no_invoice;
                $total_taxable_advance_invoice = $row1->total_taxable_advance_invoice;
                $total_taxable_data_gst_export = $row1->total_taxable_data_gst_export;
                $total_non_gst_export = $row1->total_non_gst_export;
                $month = $row1->month;

                $taxable_supply1 = ($inter_state_supply + $intra_state_supply + $no_gst_paid_supply + $debit_value + $total_taxable_advance_no_invoice + $total_taxable_advance_invoice + $total_taxable_data_gst_export + $total_non_gst_export) - ($credit_value);
                $taxable_supply_arr1[] = $taxable_supply1; //taxable supply array
            }
            $sum_tax = array_sum($taxable_supply_arr1);
            foreach ($result as $row) {
                $inter_state_supply = $row->inter_state_supply;
                $intra_state_supply = $row->intra_state_supply;
                $no_gst_paid_supply = $row->no_gst_paid_supply;
                $debit_value = $row->debit_value;
                $credit_value = $row->credit_value;
                $month = $row->month;
                //new changes 
                $total_taxable_advance_no_invoice = $row1->total_taxable_advance_no_invoice;
                $total_taxable_advance_invoice = $row1->total_taxable_advance_invoice;
                $total_taxable_data_gst_export = $row1->total_taxable_data_gst_export;
                $total_non_gst_export = $row1->total_non_gst_export;

                $taxable_supply = ($inter_state_supply + $intra_state_supply + $no_gst_paid_supply + $debit_value + $total_taxable_advance_no_invoice + $total_taxable_advance_invoice + $total_taxable_data_gst_export + $total_non_gst_export) - ($credit_value);
                $taxable_supply_arr[] = $taxable_supply; //taxable supply array
                $sale_percent = (($taxable_supply) / ($sum_tax * 100));
                $sales_percent_values1 = round(($sale_percent * 10000), 2);
                $sales_percent_values[] = round(($sale_percent * 10000));

                $data .= '<tr>' .
                        '<td>' . $k . '</td>' .
                        '<td>' . $month . '</td>' .
                        '<td>' . $taxable_supply . '</td>' .
                        '<td>' . $sales_percent_values1 . '%</td>' .
                        '</tr>';

                $k++;
            }
            $data .= '<tr>' .
                    '<td>' . '<b>Total</b>' . '</td>' .
                    '<td>' . '' . '</td>' .
                    '<td>' . '<b>' . array_sum($taxable_supply_arr) . '</b> ' . '</td>' .
                    '<td>' . '<b>' . array_sum($sales_percent_values) . '%</b> ' . '</td>' .
                    '</tr>';
            $data .= '</tbody></table></div></div></div>';
            $max = max($sales_percent_values);
            $min = min($sales_percent_values);

            $get_observation = $this->db->query("select cfo_observation from observation_transaction_all where customer_id='$customer_id' and insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
            if ($this->db->affected_rows() > 0) {
                $res = $get_observation->row();
                $observation = $res->cfo_observation;
            } else {
                $observation = "";
            }
//            echo $variation=($max-$min)/($min*100);
            $data1 .= "<hr><h4><b>Observation:</b></h4><span >" . $observation . "</span>";
            $data1 .= "<h5><b>Note:</b>For detailed and consolidated summary refer section-10.</h5>";


            // loop to get graph data as per graph script requirement
            $abc1 = array();
            for ($o = 0; $o < sizeof($taxable_supply_arr); $o++) {

                $abc1[] = $taxable_supply_arr[$o];
                $aa1 = settype($abc1[$o], "float");
            }

//             to get max value for range
            $max_range = max($abc1);

            //function to get months
            $quer2 = $this->db->query("SELECT month from monthly_summary_all where customer_id='$customer_id'  AND insert_id='$insert_id'");
            $months = array();
            if ($quer2->num_rows() > 0) {
                $res2 = $quer2->result();
                foreach ($res2 as $row) {
                    $months[] = $row->month;
                }
            }
            //function to get customer name
            $quer21 = $this->db->query("SELECT customer_name from customer_header_all where customer_id='$customer_id'");

            if ($quer21->num_rows() > 0) {
                $res21 = $quer21->row();
                $customer_name = $res21->customer_name;
            }
            $respnose['data'] = $data;
            $respnose['data2'] = $data2;
            $respnose['data1'] = $data1;
            $respnose['data_monthwise_name'] = $data_monthwise_name;
            $respnose['data_month_observation'] = $data_month_observation;
            $respnose['data_month_remarks'] = $data_month_remarks;
            $respnose['message'] = "success";
            $respnose['taxable_supply_arr'] = $abc1;  //taxable_supply data
            $respnose['month_data'] = $months; //months 
            $respnose['max_range'] = $max_range; //maximum range for graph
            $respnose['customer_name'] = $customer_name; //customer
            $respnose['sales_percent_values'] = $sales_percent_values; //sales in percent
        } else {
            $respnose['message'] = "";
            $respnose['taxable_supply_arr'] = "";  //taxable_supply data
        } echo json_encode($respnose);
    }

    public function get_graph_sales_month_wise1() { //get graph function of Sales month wise
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $curr_url = $this->input->post("curr_url");
       // $query_get_observation = $this->db->query("SELECT * from observation_transaction_all where customer_id='$customer_id' AND insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
        $query = $this->db->query("SELECT * from monthly_summary_all where customer_id='$customer_id' AND insert_id='$insert_id'");
        $data = ""; //view observations
//        $data_monthwise_name = "";
//        $data_month_observation = "";
//        $data_month_remarks = "";
//        $a = '';
        if ($this->db->affected_rows() > 0) {
            $result = $query->result();
//            $result1 = $query_get_observation->row();
//            $month_wise_observation = $result1->month_wise_observation;
//            $month_wise_remarks = $result1->month_wise_remarks;

//        if ($query->num_rows() > 0) {
//            $result = $query->result();
           $taxable_supply_arr = array();
//            $data_monthwise_name = 'Sales Month Wise';
//            $data_month_observation = $month_wise_observation;
////            $data_month_remarks = $month_wise_remarks;
//            $a = $month_wise_remarks;
//            if ($a == '') {
//                $data_month_remarks = 'not given';
//            } else {
//                $data_month_remarks = $month_wise_remarks;
//            }
            
            $data .= '<div class="row">
                    <div class="col-md-12">
                        <div class="">
                         <table id="example2" class="table table-bordered table-striped">
                                <thead style="background-color: #00008B;color:white">
                                    <tr>
                                        <th>No.</th>
                                        <th>Month</th>
                                        <th>Sales</th>
                                        <th>Ratio</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>';
            $k = 1;
            $sales_percent_values = array();
            $taxable_supply_arr1 = array();
            foreach ($result as $row1) {
                $inter_state_supply = $row1->inter_state_supply;
                $intra_state_supply = $row1->intra_state_supply;
                $no_gst_paid_supply = $row1->no_gst_paid_supply;
                $debit_value = $row1->debit_value;
                $credit_value = $row1->credit_value;
                //new changes 
                $total_taxable_advance_no_invoice = $row1->total_taxable_advance_no_invoice;
                $total_taxable_advance_invoice = $row1->total_taxable_advance_invoice;
                $total_taxable_data_gst_export = $row1->total_taxable_data_gst_export;
                $total_non_gst_export = $row1->total_non_gst_export;
                $month = $row1->month;

                $taxable_supply1 = ($inter_state_supply + $intra_state_supply + $no_gst_paid_supply + $debit_value + $total_taxable_advance_no_invoice + $total_taxable_advance_invoice + $total_taxable_data_gst_export + $total_non_gst_export) - ($credit_value);
                $taxable_supply_arr1[] = $taxable_supply1; //taxable supply array
            }
            $sum_tax = array_sum($taxable_supply_arr1);
            foreach ($result as $row) {
                $inter_state_supply = $row->inter_state_supply;
                $intra_state_supply = $row->intra_state_supply;
                $no_gst_paid_supply = $row->no_gst_paid_supply;
                $debit_value = $row->debit_value;
                $credit_value = $row->credit_value;
                $month = $row->month;
                //new changes 
                $total_taxable_advance_no_invoice = $row1->total_taxable_advance_no_invoice;
                $total_taxable_advance_invoice = $row1->total_taxable_advance_invoice;
                $total_taxable_data_gst_export = $row1->total_taxable_data_gst_export;
                $total_non_gst_export = $row1->total_non_gst_export;

                $taxable_supply = ($inter_state_supply + $intra_state_supply + $no_gst_paid_supply + $debit_value + $total_taxable_advance_no_invoice + $total_taxable_advance_invoice + $total_taxable_data_gst_export + $total_non_gst_export) - ($credit_value);
                $taxable_supply_arr[] = $taxable_supply; //taxable supply array
                $sale_percent = (($taxable_supply) / ($sum_tax * 100));
                $sales_percent_values1 = round(($sale_percent * 10000), 2);
                $sales_percent_values[] = round(($sale_percent * 10000));
                $sales_percent_values2[] = (($sale_percent * 10000));

                $data .= '<tr>' .
                        '<td>' . $k . '</td>' .
                        '<td>' . $month . '</td>' .
                        '<td>' . $taxable_supply . '</td>' .
                        '<td>' . $sales_percent_values1 . '%</td>' .
                        '</tr>';

                $k++;
            }
            $data .= '<tr>' .
                    '<td>' . '<b>Total</b>' . '</td>' .
                    '<td>' . '' . '</td>' .
                    '<td>' . '<b>' . array_sum($taxable_supply_arr) . '</b> ' . '</td>' .
                    '<td>' . '<b>' . array_sum($sales_percent_values) . '%</b> ' . '</td>' .
                    '</tr>';
            $data .= '</tbody></table></div></div></div>';

            $max = max($sales_percent_values2);
            $min = min($sales_percent_values2);
         //$variation = round(((($max - $min) / ($min))) * 100, 2);
//            $variation = round(((($max - $min) / ($min))) * 100);
            $get_observation = $this->db->query("select month_wise_observation from observation_transaction_all where customer_id='$customer_id' and insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
            if ($this->db->affected_rows() > 0) {
                $res = $get_observation->row();
                $observation = $res->month_wise_observation;
            } else {
                $observation = "";
            }
            $url = base_url() . "update_detail/" . base64_encode($customer_id) . "/" . base64_encode($insert_id);
            if ($curr_url == $url) {

                $data .= '<div class="col-md-12">
                                    <label><h4><b>Observation of CFO:</b></h4></label><span class="required" aria-required="true"> </span>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                        <textarea class="form-control" rows="5" id="monthwise_sale_observation" name="monthwise_sale_observation" onkeyup="countWords(this.id);" >__  is the % variation of maximum & minimum sales per month requiring careful working capital planning in case receivable delay</textarea>
                                    </div>
                                    <span class="required" style="color: red" id="monthwise_sale_observation_error"></span> 
                                </div><br>';
            } else {
                $data .= "<div class='col-md-12'>
                                    <label><h4><b>Observation :</b></h4></label><span class='required' aria-required='true'> </span>
                                    <div class='input-group'>
                                        <span class='input-group-addon'>
                                            <i class='fa fa-eye'></i>
                                        </span>
                                        <textarea class='form-control' rows='5' id='monthwise_sale_observation' name='monthwise_sale_observation' onkeyup='countWords(this.id);'>___  is the % variation of maximum & minimum sales per month requiring careful working capital planning in</textarea>
                                    </div>
                                    <span class='required' style='color: red' id='monthwise_sale_observation_error'></span>
                                </div>";
            }
            $get_observation1 = $this->db->query("select month_wise_remarks from observation_transaction_all where customer_id='$customer_id' and insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
            if ($this->db->affected_rows() > 0) {
                $res = $get_observation1->row();
                $month_wise_remarks = $res->month_wise_remarks;
            } else {
                $month_wise_remarks = "";
            }
            $data .= "<div class='col-md-12'>
                    <h5 class='box-title' style='margin-left: 1%;'><b>Remarks:</b></h5>
                    <textarea id='editor_sales_monthly_data' name='editor_sales_monthly_data' rows='10' style='width: 96%;margin-left: 1%;height: 15%;' onkeyup='final_word_count(this.id);remove_error('editor_sales_monthly_data')'>" . $month_wise_remarks . "</textarea>
                    </div>";


//            $data .= "<hr><h4><b>Observation of  Sales month wise:</b></h4>";
            // loop to get graph data as per graph script requirement
            $abc1 = array();
            for ($o = 0; $o < sizeof($taxable_supply_arr); $o++) {

                $abc1[] = $taxable_supply_arr[$o];
                $aa1 = settype($abc1[$o], "float");
            }

//             to get max value for range
            $max_range = max($abc1);

            //function to get months
            $quer2 = $this->db->query("SELECT month from monthly_summary_all where customer_id='$customer_id'  AND insert_id='$insert_id'");
            $months = array();
            if ($quer2->num_rows() > 0) {
                $res2 = $quer2->result();
                foreach ($res2 as $row) {
                    $months[] = $row->month;
                }
            }
            //function to get customer name
            $quer21 = $this->db->query("SELECT customer_name from customer_header_all where customer_id='$customer_id'");

            if ($quer21->num_rows() > 0) {
                $res21 = $quer21->row();
                $customer_name = $res21->customer_name;
            }
            $respnose['data'] = $data;
//            $respnose['data_monthwise_name'] = $data_monthwise_name;
//            $respnose['data_month_observation'] = $data_month_observation;
//            $respnose['data_month_remarks'] = $data_month_remarks;
            $respnose['message'] = "success";
            $respnose['taxable_supply_arr'] = $abc1;  //taxable_supply data
            $respnose['month_data'] = $months; //months 
            $respnose['max_range'] = $max_range; //maximum range for graph
            $respnose['customer_name'] = $customer_name; //customer
            $respnose['sales_percent_values'] = $sales_percent_values; //sales in percent
        } else {
            $respnose['message'] = "";
            $respnose['taxable_supply_arr'] = "";  //taxable_supply data
        } echo json_encode($respnose);
    }

    public function get_data_rate_wise1() {
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $curr_url = $this->input->post("curr_url");
        //to get total supply
        $query = $this->db->query("SELECT * from rate_wise_summary_all where customer_id='$customer_id' AND insert_id='$insert_id'");
        $data = ""; //view observations
        $data1 = ""; //view observations
        if ($query->num_rows() > 0) {
            $result = $query->result();
            $data .= "<label><h3>Sale Rate Wise:</h3></label>";
            $data .= '<div class="row">
                    <div class="col-md-12">
                        <div class="">
                         <table class="table table-bordered table-striped" width="550">
                                <thead style="background-color: #00008B;color:white">
                                    <tr>
                                        <th>Particulars</th>
                                        <th>0%</th>
                                        <th>5%</th>
                                        <th>12%</th>
                                        <th>18%</th>
                                        <th>28%</th>
                                        
                                        
                                    </tr>
                                </thead>
                                <tbody>';
            foreach ($result as $row) {
                $data .= '<tr>' .
                        '<td>' . 'Sales' . '</td>' .
                        '<td>' . $row->rate_0 . '</td>' .
                        '<td>' . $row->rate_5 . '</td>' .
                        '<td>' . $row->rate_12 . '</td>' .
                        '<td>' . $row->rate_18 . '</td>' .
                        '<td>' . $row->rate_28 . '</td>' .
                        '</tr>';
            }

            $total_value = ($row->rate_0 + $row->rate_5 + $row->rate_12 + $row->rate_18 + $row->rate_28);
            $data .= '<tr>' .
                    '<td>' . '<b>Ratio</b>' . '</td>' .
                    '<td><b>' . round((($row->rate_0) / ($total_value)) * 100) . '%</b></td>' .
                    '<td><b>' . round((($row->rate_5) / ($total_value)) * 100) . '%</b></td>' .
                    '<td><b>' . round((($row->rate_12) / ($total_value)) * 100) . '%</b></td>' .
                    '<td><b>' . round((($row->rate_18) / ($total_value)) * 100) . '%</b></td>' .
                    '<td><b>' . round((($row->rate_28) / ($total_value)) * 100) . '%</b></td>' .
                    '</tr>';
            $data .= "</tbody></table></div></div></div>";
            $array = array("0%" => $row->rate_0, "5%" => $row->rate_5, "12%" => $row->rate_12, "18%" => $row->rate_18, "28%" => $row->rate_28);
            $aa = max($array);
            $k = array_keys($array, $aa);
            $maximum_rate = $k[0];
            $url = base_url() . "update_detail/" . base64_encode($customer_id) . "/" . base64_encode($insert_id);
            if ($curr_url == $url) {
                $get_observation = $this->db->query("select rate_wise_observation from observation_transaction_all where customer_id='$customer_id' and insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
                if ($this->db->affected_rows() > 0) {
                    $res = $get_observation->row();
                    $observation = $res->rate_wise_observation;
                } else {
                    $observation = "";
                }
                $data .= '<div class="col-md-12">
                                    <label><h4><b>Observation</b></h4></label><span class="required" aria-required="true"> </span>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                        <textarea class="form-control" rows="5" id="rate_wise_observation" name="rate_wise_observation" onkeyup="countWords(this.id);" >' . $observation . '</textarea>
                                    </div>
                                    <span class="required" style="color: red" id="rate_wise_observation_error"></span> 
                                </div><br>';
            } else {
                $data .= "<div class='col-md-12'>
                                    <label><h4><b>Observation </b></h4></label><span class='required' aria-required='true'> </span>
                                    <div class='input-group'>
                                        <span class='input-group-addon'>
                                            <i class='fa fa-eye'></i>
                                        </span>
                                        <textarea class='form-control' rows='5' id='rate_wise_observation' name='rate_wise_observation' onkeyup='countWords(this.id);'>Maximum Range of Product falls under the Category of " . $maximum_rate . "</textarea>
                                    </div>
                                    <span class='required' style='color: red' id='rate_wise_observation_error'></span>
                                </div>";
            }
            $get_observation1 = $this->db->query("select rate_wise_remarks from observation_transaction_all where customer_id='$customer_id' and insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
            if ($this->db->affected_rows() > 0) {
                $res = $get_observation1->row();
                $rate_wise_remarks = $res->rate_wise_remarks;
            } else {
                $rate_wise_remarks = "";
            }
            $data .= "<div class='col-md-12'>
                        <b>Remarks:</b></h5><textarea id='editor_rate_wise_data' name='editor_rate_wise_data' rows='10' style='width: 100%;height: 15%;' onkeyup='final_word_count(this.id);remove_error('editor_rate_wise_data')'>" . $rate_wise_remarks . "</textarea>
                      </div>";

            $respnose['data'] = $data;
            $respnose['message'] = "success";
        } else {
            $respnose['data'] = "";
            $respnose['message'] = "";
        } echo json_encode($respnose);
    }

    //function to get data rate wise
    public function get_data_rate_wise() {
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");

        //to get total supply
        $query = $this->db->query("SELECT * from rate_wise_summary_all where customer_id='$customer_id' AND insert_id='$insert_id'");
        $query_get_observation = $this->db->query("SELECT * from observation_transaction_all where customer_id='$customer_id' AND insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
        $data = ""; //view observations
        $data_ratewise_name = "";
        $data_rate_observation = "";
        $data_rate_remarks = "";
        $a = "";
//        if ($query->num_rows() > 0) {
        if ($this->db->affected_rows() > 0) {
            $result = $query->result();
            $result1 = $query_get_observation->row();
            $rate_wise_observation = $result1->rate_wise_observation;

            $rate_wise_remarks = $result1->rate_wise_remarks;

            $data_ratewise_name = 'Sales Tax Rate Wise';
            $data_rate_observation = $rate_wise_observation;

//            $data_rate_remarks = $rate_wise_remarks;
            $a = $rate_wise_remarks;
            if ($a == "") {
                $data_rate_remarks = 'not given';
            } else {
                $data_rate_remarks = $rate_wise_remarks;
            }

            $data .= "<h4><b>2.Sales Tax Rate Wise</b></h4>";
            $data .= '<table class="table-bordered table-striped" width="700">
                                <thead style="background-color: #0e385e;color:white">
                                    <tr>
                                        <th>Particulars</th>
                                        <th>0%</th>
                                        <th>5%</th>
                                        <th>12%</th>
                                        <th>18%</th>
                                        <th>28%</th>
                                        
                                        
                                    </tr>
                                </thead>
                                <tbody>';
            foreach ($result as $row) {
                $data .= '<tr>' .
                        '<td>' . 'Sales' . '</td>' .
                        '<td>' . number_format(round($row->rate_0)) . '</td>' .
                        '<td>' . number_format(round($row->rate_5)) . '</td>' .
                        '<td>' . number_format(round($row->rate_12)) . '</td>' .
                        '<td>' . number_format(round($row->rate_18)) . '</td>' .
                        '<td>' . number_format(round($row->rate_28)) . '</td>' .
                        '</tr>';
            }


            $total_value = ($row->rate_0 + $row->rate_5 + $row->rate_12 + $row->rate_18 + $row->rate_28);
            $data .= '<tr>' .
                    '<td>' . '<b>Ratio</b>' . '</td>' .
                    '<td><b>' . round((($row->rate_0) / ($total_value)) * 100) . '%</b></td>' .
                    '<td><b>' . round((($row->rate_5) / ($total_value)) * 100) . '%</b></td>' .
                    '<td><b>' . round((($row->rate_12) / ($total_value)) * 100) . '%</b></td>' .
                    '<td><b>' . round((($row->rate_18) / ($total_value)) * 100) . '%</b></td>' .
                    '<td><b>' . round((($row->rate_28) / ($total_value)) * 100) . '%</b></td>' .
                    '</tr>';
            $data .= "</tbody></table>";
            $get_observation = $this->db->query("select rate_wise_observation from observation_transaction_all where customer_id='$customer_id' and insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
            if ($this->db->affected_rows() > 0) {
                $res = $get_observation->row();
                $observation = $res->rate_wise_observation;
            } else {
                $observation = "";
            }

            $data .= "<hr><h4><b>Observation:</b></h4><span >" . $observation . "</span>";
            $data .= "<h5><b>Note:</b>For detailed and consolidated summary refer section-10.</h5>";
            $respnose['data'] = $data;
            $respnose['data_ratewise_name'] = $data_ratewise_name;
            $respnose['data_rate_observation'] = $data_rate_observation;
            $respnose['data_rate_remarks'] = $data_rate_remarks;
            $respnose['message'] = "success";
        } else {
            $respnose['data'] = "";
            $respnose['message'] = "";
        } echo json_encode($respnose);
    }

    //function get graphs  of export sale
    public function get_graph_exports() {
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        // "SELECT * from monthly_summary_all where customer_id='$customer_id' AND insert_id='$insert_id'";
        $query = $this->db->query("SELECT * from monthly_summary_all where customer_id='$customer_id' AND insert_id='$insert_id'");
        $data = ""; //view observations
        $data_export_sales_name = "";
        $data_export_sales_observation = "";
        $data_export_sales_remarks = "";
        $a = "";
//        if ($query->num_rows() > 0) {
        $query_get_observation = $this->db->query("SELECT * from observation_transaction_all where customer_id='$customer_id' AND insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
        if ($this->db->affected_rows() > 0) {
             $result = $query->result();
            $result1 = $query_get_observation->row();
            $export_sales_observation = $result1->export_sale_observation;
            $export_sales_remarks = $result1->export_sale_remarks;

            $data_export_sales_name = "Export Sales";
            $data_export_sales_observation = $export_sales_observation;
//            $data_threeb_vs1_remarks = $threeb_vs1_remarks;
            $a = $export_sales_remarks;
            if ($a == '') {
                $data_export_sales_remarks = 'not given';
            } else {
                $data_export_sales_remarks = $export_sales_remarks;
            }
           
            
            $taxable_supply_arr = array();
            $data .= '<div class="row">
                    <div class="col-md-12">
                        <div class="">
                         <table id="example2" class="table table-bordered table-striped">
                                <thead style="background-color: #00008B;color:white">
                                    <tr>
                                        <th>No.</th>
                                        <th>Month</th>
                                        <th>Sales</th>
                                        <th>Ratio</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>';
            $k = 1;
            $sales_percent_values = array();
            $taxable_supply_arr1 = array();
            foreach ($result as $row1) {
                $total_taxable_data_gst_export = $row1->total_taxable_data_gst_export;
                $total_non_gst_export = $row1->total_non_gst_export;


                $taxable_supply1 = ( $total_taxable_data_gst_export + $total_non_gst_export);
                $taxable_supply_arr1[] = $taxable_supply1; //taxable supply array
            }

            $sum_tax = array_sum($taxable_supply_arr1);
            foreach ($result as $row1) {

                $total_taxable_data_gst_export = $row1->total_taxable_data_gst_export;
                $total_non_gst_export = $row1->total_non_gst_export;
                $month = $row1->month;
                $taxable_supply = ($total_taxable_data_gst_export + $total_non_gst_export);
                $taxable_supply_arr[] = $taxable_supply; //taxable supply array
                if ($sum_tax != 0) {
                    $sale_percent = (($taxable_supply) / ($sum_tax * 100));
                } else {
                    $sale_percent = 0;
                }
                $sales_percent_values1 = round(($sale_percent * 10000), 2);
                $sales_percent_values[] = round(($sale_percent * 10000));

                $data .= '<tr>' .
                        '<td>' . $k . '</td>' .
                        '<td>' . $month . '</td>' .
                        '<td>' . $taxable_supply . '</td>' .
                        '<td>' . $sales_percent_values1 . '%</td>' .
                        '</tr>';

                $k++;
            }
            $data .= '<tr>' .
                    '<td>' . '<b>Total</b>' . '</td>' .
                    '<td>' . '' . '</td>' .
                    '<td>' . '<b>' . array_sum($taxable_supply_arr) . '</b> ' . '</td>' .
                    '<td>' . '<b>' . array_sum($sales_percent_values) . '%</b> ' . '</td>' .
                    '</tr>';
            $data .= '</tbody></table></div></div></div>';
            $data .= "<div class='col-md-12'>
                                    <label><h4><b>Observation: </b></h4></label><br>
                                       " . array_sum($sales_percent_values) . " % is the total percentage of export sales done with respect to total sales.
                                    <span class='required' style='color: red' id='export_observation_error'></span>
                                </div>";

//            echo $variation=($max-$min)/($min*100);
//            $data .= "<hr><h4><b>Observation of  Sales month wise:</b></h4>";
            // loop to get graph data as per graph script requirement
            $abc1 = array();
            for ($o = 0; $o < sizeof($taxable_supply_arr); $o++) {

                $abc1[] = $taxable_supply_arr[$o];
                $aa1 = settype($abc1[$o], "float");
            }


            //function to get months
            $quer2 = $this->db->query("SELECT month from monthly_summary_all where customer_id='$customer_id'  AND insert_id='$insert_id'");
            $months = array();
            if ($quer2->num_rows() > 0) {
                $res2 = $quer2->result();
                foreach ($res2 as $row) {
                    $months[] = $row->month;
                }
            }
            //function to get customer name
            $quer21 = $this->db->query("SELECT customer_name from customer_header_all where customer_id='$customer_id'");

            if ($quer21->num_rows() > 0) {
                $res21 = $quer21->row();
                $customer_name = $res21->customer_name;
            }
            $respnose['data'] = $data;
            $respnose['message'] = "success";
            $respnose['taxable_supply_arr'] = $abc1;  //taxable_supply data
            $respnose['month_data'] = $months; //months 
            $respnose['customer_name'] = $customer_name; //customer
            $respnose['sales_percent_values'] = $sales_percent_values; //sales in percent
            $respnose['data_export_sales_name'] = $data_export_sales_name; //sales in percent
            $respnose['data_export_sales_observation'] = $data_export_sales_observation; //sales in percent
            $respnose['data_export_sales_remarks'] = $data_export_sales_remarks; //sales in percent
            
        } else {
            $respnose['message'] = "";
            $respnose['taxable_supply_arr'] = "";  //taxable_supply data
        } echo json_encode($respnose);
    }

    public function get_graph_exports1() {
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        // "SELECT * from monthly_summary_all where customer_id='$customer_id' AND insert_id='$insert_id'";
        $query = $this->db->query("SELECT * from monthly_summary_all where customer_id='$customer_id' AND insert_id='$insert_id'");
        $data = ""; //view observations
        if ($query->num_rows() > 0) {
            $result = $query->result();
           
            $taxable_supply_arr = array();
            $data .= '<div class="row">
                    <div class="col-md-12">
                        <div class="">
                         <table id="example2" class="table table-bordered table-striped">
                                <thead style="background-color: #00008B;color:white">
                                    <tr>
                                        <th>No.</th>
                                        <th>Month</th>
                                        <th>Sales</th>
                                        <th>Ratio</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>';
            $k = 1;
            $sales_percent_values = array();
            $taxable_supply_arr1 = array();
            foreach ($result as $row1) {
                $total_taxable_data_gst_export = $row1->total_taxable_data_gst_export;
                $total_non_gst_export = $row1->total_non_gst_export;


                $taxable_supply1 = ( $total_taxable_data_gst_export + $total_non_gst_export);
                $taxable_supply_arr1[] = $taxable_supply1; //taxable supply array
            }

            $sum_tax = array_sum($taxable_supply_arr1);
            foreach ($result as $row1) {

                $total_taxable_data_gst_export = $row1->total_taxable_data_gst_export;
                $total_non_gst_export = $row1->total_non_gst_export;
                $month = $row1->month;
                $taxable_supply = ($total_taxable_data_gst_export + $total_non_gst_export);
                $taxable_supply_arr[] = $taxable_supply; //taxable supply array
                if ($sum_tax != 0) {
                    $sale_percent = (($taxable_supply) / ($sum_tax * 100));
                } else {
                    $sale_percent = 0;
                }
                $sales_percent_values1 = round(($sale_percent * 10000), 2);
                $sales_percent_values[] = round(($sale_percent * 10000));

                $data .= '<tr>' .
                        '<td>' . $k . '</td>' .
                        '<td>' . $month . '</td>' .
                        '<td>' . $taxable_supply . '</td>' .
                        '<td>' . $sales_percent_values1 . '%</td>' .
                        '</tr>';

                $k++;
            }
            $data .= '<tr>' .
                    '<td>' . '<b>Total</b>' . '</td>' .
                    '<td>' . '' . '</td>' .
                    '<td>' . '<b>' . array_sum($taxable_supply_arr) . '</b> ' . '</td>' .
                    '<td>' . '<b>' . array_sum($sales_percent_values) . '%</b> ' . '</td>' .
                    '</tr>';
            $data .= '</tbody></table></div></div></div>';
//            $data .= "<div class='col-md-12'>
//                                    <label><h4><b>Observation: </b></h4></label><br>
//                                       " . array_sum($sales_percent_values) . " % is the total percentage of export sales done with respect to total sales.
//                                    <span class='required' style='color: red' id='export_observation_error'></span>
//                                </div>";
            $curr_url = $this->input->post("curr_url");
            $url = base_url() . "update_detail/" . base64_encode($customer_id) . "/" . base64_encode($insert_id);
            if ($curr_url == $url) {
                $get_observation = $this->db->query("select export_sale_observation from observation_transaction_all where customer_id='$customer_id' and insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
                if ($this->db->affected_rows() > 0) {
                    $res = $get_observation->row();
                    $observation = $res->export_sale_observation;
                } else {
                    $observation = "";
                }
                $data .= '<div class="col-md-12">
                                    <label><h4><b>Observation:</b></h4></label><span class="required" aria-required="true"> </span>
                                    
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                        <textarea class="form-control" rows="5" id="export_sale_observation" name="export_sale_observation" onkeyup="countWords(this.id);" >' . array_sum($sales_percent_values) . ' % is the total percentage of export sales done with respect to total sales.</textarea>
                                    </div>
                                    <span class="required" style="color: red" id="export_sale_observation_error"></span> 
                                    </div>';
            } else {
                $data .= '<div class="col-md-12">
                                    <label><h4><b>Observation:</b></h4></label><span class="required" aria-required="true"> </span>
                                    
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                        <textarea class="form-control" rows="5" id="export_sale_observation" name="export_sale_observation" onkeyup="countWords(this.id);" >' . array_sum($sales_percent_values) . ' % is the total percentage of export sales done with respect to total sales.</textarea>
                                    </div>
                                    <span class="required" style="color: red" id="export_sale_observation_error"></span> 
                                    </div>';
            }

            $get_observation1 = $this->db->query("select export_sale_remarks from observation_transaction_all where customer_id='$customer_id' and insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
            if ($this->db->affected_rows() > 0) {
                $res = $get_observation1->row();
                $export_sale_remarks = $res->export_sale_remarks;
            } else {
                $export_sale_remarks = "";
            }
            $data .= "<div class='col-md-12'>
                    <h5 class='box-title' style='margin-left: 1%;'><b>Remarks:</b></h5>
                    <textarea id='editor_export_sales' name='editor_export_sales' rows='10' style='width: 96%;margin-left: 1%;height: 15%;' onkeyup='final_word_count(this.id);remove_error('editor_b2b_b2c_sale')'>" . $export_sale_remarks . "</textarea>
                    </div>";
            $abc1 = array();
            for ($o = 0; $o < sizeof($taxable_supply_arr); $o++) {

                $abc1[] = $taxable_supply_arr[$o];
                $aa1 = settype($abc1[$o], "float");
            }


            //function to get months
            $quer2 = $this->db->query("SELECT month from monthly_summary_all where customer_id='$customer_id'  AND insert_id='$insert_id'");
            $months = array();
            if ($quer2->num_rows() > 0) {
                $res2 = $quer2->result();
                foreach ($res2 as $row) {
                    $months[] = $row->month;
                }
            }
            //function to get customer name
            $quer21 = $this->db->query("SELECT customer_name from customer_header_all where customer_id='$customer_id'");

            if ($quer21->num_rows() > 0) {
                $res21 = $quer21->row();
                $customer_name = $res21->customer_name;
            }
            $respnose['data'] = $data;
            $respnose['message'] = "success";
            $respnose['taxable_supply_arr'] = $abc1;  //taxable_supply data
            $respnose['month_data'] = $months; //months 
            $respnose['customer_name'] = $customer_name; //customer
            $respnose['sales_percent_values'] = $sales_percent_values; //sales in percent
        } else {
            $respnose['message'] = "";
            $respnose['taxable_supply_arr'] = "";  //taxable_supply data
        } echo json_encode($respnose);
    }

    // sale b2b view page function
    public function Sale_b2b_b2c() {
        $session_data = $this->session->userdata('login_session');
        $customer_id = ($session_data['customer_id']);
        $query_get_b2b_data = $this->Management_report_model->get_data_b2b($customer_id);
        if ($query_get_b2b_data !== FALSE) {
            $data['b2b_data'] = $query_get_b2b_data;
        } else {
            $data['b2b_data'] = "";
        }
        $this->load->view('customer/B2b_b2c', $data);
    }

    //function to import data from excel and insert into database.
    public function import_excel_b2b() {

        if (isset($_FILES["file_ex_b2b"]["name"])) {
            $path = $_FILES["file_ex_b2b"]["tmp_name"];
            $this->load->library('excel');
            $object = PHPExcel_IOFactory::load($path);
            $worksheet = $object->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            $x = "G";
            //loop to get month data
            while ($object->getActiveSheet()->getCell($x . 6)->getValue() !== "Grand Tatal") {
                $months[] = $object->getActiveSheet()->getCell($x . 6)->getValue();
                $x++;
            }
            $cnt = count($months);
            $month_data = array();
            for ($a12 = 0; $a12 < $cnt; $a12++) {
                $month = $months[$a12];
                $month_data[] = $months[$a12];
                $a12 = ($a12 * 1 + 3);
            }
            for ($i = 1; $i <= $highestRow; $i++) {
                $a_new2 = $object->getActiveSheet()->getCell('A' . $i)->getValue();
                if ($a_new2 == "(2) Total value of supplies on which GST paid (intra-State Supplies [Other than Deemed Export])") {
                    $anew = 1;
                } else if ($a_new2 == "(3) Value of Other Supplies on which no GST paid") {
                    $anew = 2;
                }

                //for get value between credit note and debit note
                $aa2 = $object->getActiveSheet()->getCell('A' . $i)->getValue();
                if ($aa2 == "(4) Cr Note Details") {
                    $value11 = 1;
                } else if ($aa2 == "(5) Dr Note Details") {
                    $value11 = 2;
                }


                $row_prev = $i - 1;
                $sk = 0;
                if ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "Sub Total (B2B)") {
                    $highestColumn_row = $worksheet->getHighestColumn($i);
                    //get first table data in excel
                    if ($object->getActiveSheet()->getCell($highestColumn_row . $i)->getValue() == "" && $object->getActiveSheet()->getCell($highestColumn_row . $i)->getValue() != '0') {
                        $a = strlen($highestColumn_row);
                        $index = strlen($highestColumn_row) - 1;
                        $ord = ord($highestColumn_row[$index]);
                        $a1 = substr($highestColumn_row, 0, 1);
                        $a2 = substr($highestColumn_row, 1);
                        if ($a1 != $a2 and $a2 == "A") {
//                            $index = strlen($a1) - 1;                            
                            $ord = ord($highestColumn_row[1]);
                            $index = 1;
                            $a = $this->getAlpha($a1, $ord, $a, $index);
                            $highestColumn_row = $a . "Z";
                        } else {
                            $highestColumn_row = $this->getAlpha($highestColumn_row, $ord, $a, $index);
                        }
                        $r = 1;
                        $z2 = $object->getActiveSheet()->getCell($highestColumn_row . $i)->getValue();
                        while ($z2 == "") {
                            if ($z2 != "" or $z2 == '0') {
                                $r++;
                            } else {
                                $a = strlen($highestColumn_row);
                                $index = strlen($highestColumn_row) - 1;
                                $ord = ord($highestColumn_row[$index]);
                                $a1 = substr($highestColumn_row, 0, 1);
                                $a2 = substr($highestColumn_row, 1);
                                if ($a1 != $a2 and $a2 == "A") {
                                    $ord = ord($highestColumn_row[1]);
                                    $index = 1;
                                    $o1 = ord($a1);
                                    $o2 = chr($o1 - 1);
                                    $highestColumn_row = $o2 . "Z";
                                } else {
                                    $highestColumn_row = $this->getAlpha($highestColumn_row, $ord, $a, $index);
                                }
                            }
                            $z2 = $object->getActiveSheet()->getCell($highestColumn_row . $i)->getValue();
                            if ($r > 1) {
                                break;
                            }
                            $highest_value_str = substr($highestColumn_row, -2);
                        }
                        $highest_value = $highest_value_str; // got last value here for if
                        for ($k = 0; $k < 4; $k++) {
                            $a11 = strlen($highest_value);
                            $index1 = strlen($highest_value) - 1;
                            $ord1 = ord($highest_value[$index1]);
                            $highestColumn_row_pp = $this->getAlpha($highest_value, $ord1, $a11, $index1);
                            $highest_value = $highestColumn_row_pp;
                        }
                        $highest_value_without_GT = $highest_value; //hightest cloumn till where we have to find our data
                        $char = 'G';
                        $values = array();
                        while ($char !== $highest_value_without_GT) {
                            $values[] = $object->getActiveSheet()->getCell($char . $i)->getValue();
                            $char++;
                        }
                        $cnt = count($values);
                        $interstate_b2b = array();
                        for ($aa11 = 0; $aa11 <= $cnt; $aa11++) {
                            $data1 = $values[$aa11];
                            $interstate_b2b[] = $values[$aa11];
                            $aa11 = ($aa11 * 1 + 3);
                        }
                    } else {
                        if ($anew == 1) {
                            $highest_value = $worksheet->getHighestColumn($i); // got last value here for else
                            for ($k = 0; $k < 4; $k++) {
                                $a11 = strlen($highest_value);
                                $index1 = strlen($highest_value) - 1;
                                $ord1 = ord($highest_value[$index1]);
                                $highestColumn_row_pp = $this->getAlpha($highest_value, $ord1, $a11, $index1);
                                $highest_value = $highestColumn_row_pp;
                            }
                            $highest_value_without_GT = $highest_value; //hightest cloumn till where we have to find our data
                            $char = 'G';
                            $values1 = array();
                            while ($char !== $highest_value_without_GT) {
                                $values1[] = $object->getActiveSheet()->getCell($char . $i)->getValue();
                                $char++;
                            }
                            $cnt = count($values1);
                            $intrastate_b2b = array();
                            for ($a12 = 0; $a12 < $cnt; $a12++) {
                                $data2 = $values1[$a12];
                                $intrastate_b2b[] = $values1[$a12];
                                $a12 = ($a12 * 1 + 3);
                            }
                        } elseif ($value11 == 1) {
                            $highestColumn_dr = $worksheet->getHighestColumn($i);
                            for ($k = 0; $k < 5; $k++) {
                                $a11 = strlen($highestColumn_dr);
                                $index1 = strlen($highestColumn_dr) - 1;
                                $ord1 = ord($highestColumn_dr[$index1]);
                                $a1 = substr($highestColumn_dr, 0, 1);
                                $a2 = substr($highestColumn_dr, 1);
                                if ($a1 != $a2 and $a2 == "A") {
                                    $ord = ord($highestColumn_dr[1]);
                                    $index = 1;
                                    $o1 = ord($a1);
                                    $o2 = chr($o1 - 1);
                                    $highestColumn_row_pp = $o2 . "Z";
                                } else {
                                    $highestColumn_row_pp = $this->getAlpha($highestColumn_dr, $ord1, $a11, $index1);
                                }
                                $highestColumn_dr = $highestColumn_row_pp;
                            }

                            $highest_value_without_DR = $highestColumn_dr; //hightest cloumn till where we have to find our data
                            $char = 'G';
                            $values_CR = array();
                            while ($char !== $highest_value_without_DR) {
                                $values_CR[] = $object->getActiveSheet()->getCell($char . $i)->getValue();
                                $char++;
                            }
                            $cnt = count($values_CR);
                            $credit_b2b = array();
                            for ($a_dr1 = 0; $a_dr1 < $cnt; $a_dr1++) {
                                $Dr_values = $values_CR[$a_dr1];
                                $credit_b2b[] = $values_CR[$a_dr1];
                                $a_dr1 = ($a_dr1 * 1 + 4);
                            }
                        } else {
                            $highestColumn_dr = $worksheet->getHighestColumn($i);
                            for ($k = 0; $k < 5; $k++) {
                                $a11 = strlen($highestColumn_dr);
                                $index1 = strlen($highestColumn_dr) - 1;
                                $ord1 = ord($highestColumn_dr[$index1]);
                                $a1 = substr($highestColumn_dr, 0, 1);
                                $a2 = substr($highestColumn_dr, 1);
                                if ($a1 != $a2 and $a2 == "A") {
                                    $ord = ord($highestColumn_dr[1]);
                                    $index = 1;
                                    $o1 = ord($a1);
                                    $o2 = chr($o1 - 1);
                                    $highestColumn_row_pp = $o2 . "Z";
                                } else {
                                    $highestColumn_row_pp = $this->getAlpha($highestColumn_dr, $ord1, $a11, $index1);
                                }
                                $highestColumn_dr = $highestColumn_row_pp;
                            }

                            $highest_value_without_DR = $highestColumn_dr; //hightest cloumn till where we have to find our data
                            $char = 'G';
                            $values_DR = array();
                            while ($char !== $highest_value_without_DR) {
                                $values_DR[] = $object->getActiveSheet()->getCell($char . $i)->getValue();
                                $char++;
                            }
                            $cnt = count($values_DR);
                            $debit_b2b = array();
                            for ($a_cr1 = 0; $a_cr1 < $cnt; $a_cr1++) {
                                $Dr_values = $values_DR[$a_cr1];
                                $debit_b2b[] = $values_DR[$a_cr1];
                                $a_cr1 = ($a_cr1 * 1 + 4);
                            }
                        }
                    }
                }
                //To get value of Sub Total (B2CS)
                elseif ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "Sub Total (B2CS)") { //interstate
                    $highestColumn_row = $worksheet->getHighestColumn($i);
                    //get first table data in excel
                    if ($object->getActiveSheet()->getCell($highestColumn_row . $i)->getValue() == "" && $object->getActiveSheet()->getCell($highestColumn_row . $i)->getValue() != '0') {

                        $a = strlen($highestColumn_row);
                        $index = strlen($highestColumn_row) - 1;
                        $ord = ord($highestColumn_row[$index]);
                        $a1 = substr($highestColumn_row, 0, 1);
                        $a2 = substr($highestColumn_row, 1);
                        if ($a1 != $a2 and $a2 == "A") {
//                            $index = strlen($a1) - 1;                            
                            $ord = ord($highestColumn_row[1]);
                            $index = 1;
                            $a = $this->getAlpha($a1, $ord, $a, $index);
                            $highestColumn_row = $a . "Z";
                        } else {
                            $highestColumn_row = $this->getAlpha($highestColumn_row, $ord, $a, $index);
                        }
                        $r = 1;
                        $z2 = $object->getActiveSheet()->getCell($highestColumn_row . $i)->getValue();
                        while ($z2 == "") {
                            if ($z2 != "" or $z2 == '0') {
                                $r++;
                            } else {
                                $a = strlen($highestColumn_row);
                                $index = strlen($highestColumn_row) - 1;
                                $ord = ord($highestColumn_row[$index]);
                                $a1 = substr($highestColumn_row, 0, 1);
                                $a2 = substr($highestColumn_row, 1);
                                if ($a1 != $a2 and $a2 == "A") {
                                    $ord = ord($highestColumn_row[1]);
                                    $index = 1;
                                    $o1 = ord($a1);
                                    $o2 = chr($o1 - 1);
                                    $highestColumn_row = $o2 . "Z";
                                } else {
                                    $highestColumn_row = $this->getAlpha($highestColumn_row, $ord, $a, $index);
                                }
                            }
                            $z2 = $object->getActiveSheet()->getCell($highestColumn_row . $i)->getValue();
                            if ($r > 1) {
                                break;
                            }
                            $highest_value_str = substr($highestColumn_row, -2);
                        }
                        $highest_value = $highest_value_str; // got last value here for if
                        for ($k = 0; $k < 4; $k++) {
                            $a11 = strlen($highest_value);
                            $index1 = strlen($highest_value) - 1;
                            $ord1 = ord($highest_value[$index1]);
                            $highestColumn_row_pp = $this->getAlpha($highest_value, $ord1, $a11, $index1);
                            $highest_value = $highestColumn_row_pp;
                        }
                        $highest_value_without_GT1 = $highest_value; //hightest cloumn till where we have to find our data
                        $char = 'G';
                        $values2 = array();
                        while ($char !== $highest_value_without_GT1) {
                            $values2[] = $object->getActiveSheet()->getCell($char . $i)->getValue();
                            $char++;
                        }
                        $cnt = count($values2);
                        $interstate_b2c = array();
                        for ($aa12 = 0; $aa12 <= $cnt; $aa12++) {
                            $data1 = $values2[$aa12];
                            $interstate_b2c[] = $values2[$aa12];
                            $aa12 = ($aa12 * 1 + 3);
                        }
                    } else { //intrastate
                        $sk++;
                        $highest_value = $worksheet->getHighestColumn($i); // got last value here for else
                        for ($k = 0; $k < 4; $k++) {
                            $a11 = strlen($highest_value);
                            $index1 = strlen($highest_value) - 1;
                            $ord1 = ord($highest_value[$index1]);
                            $highestColumn_row_pp = $this->getAlpha($highest_value, $ord1, $a11, $index1);
                            $highest_value = $highestColumn_row_pp;
                        }
                        $highest_value_without_GT = $highest_value; //hightest cloumn till where we have to find our data
                        $char = 'G';
                        $values3 = array();
                        while ($char !== $highest_value_without_GT) {
                            $values3[] = $object->getActiveSheet()->getCell($char . $i)->getValue();
                            $char++;
                        }
                        $cnt = count($values3);
                        $intrastate_b2c = array();
                        for ($a12 = 0; $a12 < $cnt; $a12++) {
                            $data2 = $values3[$a12];
                            $intrastate_b2c[] = $values3[$a12];
                            $a12 = ($a12 * 1 + 3);
                        }
                    }
                } elseif ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "(4) Cr Note Details") {
                    for ($j = $i; $j <= $highestRow; $j++) {
                        if ($object->getActiveSheet()->getCell('B' . $j)->getValue() == "Sub Total (B2CS)") {
                            $highestColumn_dr = $worksheet->getHighestColumn($j);
                            for ($k = 0; $k < 5; $k++) {
                                $a11 = strlen($highestColumn_dr);
                                $index1 = strlen($highestColumn_dr) - 1;
                                $ord1 = ord($highestColumn_dr[$index1]);
                                $a1 = substr($highestColumn_dr, 0, 1);
                                $a2 = substr($highestColumn_dr, 1);
                                if ($a1 != $a2 and $a2 == "A") {
                                    $ord = ord($highestColumn_dr[1]);
                                    $index = 1;
                                    $o1 = ord($a1);
                                    $o2 = chr($o1 - 1);
                                    $highestColumn_row_pp = $o2 . "Z";
                                } else {
                                    $highestColumn_row_pp = $this->getAlpha($highestColumn_dr, $ord1, $a11, $index1);
                                }
                                $highestColumn_dr = $highestColumn_row_pp;
                            }

                            $highest_value_without_DR = $highestColumn_dr; //hightest cloumn till where we have to find our data
                            $char = 'G';
                            $cr_values = array();
                            while ($char !== $highest_value_without_DR) {
                                $cr_values[] = $object->getActiveSheet()->getCell($char . $j)->getValue();
                                $char++;
                            }
                            $cnt = count($values_DR);
                            $credit_b2c = array();
                            for ($a_dr11 = 0; $a_dr11 < $cnt; $a_dr11++) {
                                $cr_values1 = $cr_values[$a_dr11];
                                $credit_b2c[] = $cr_values[$a_dr11];
                                $a_dr11 = ($a_dr11 * 1 + 4);
                            }
                        }
                    }
                } elseif ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "(5) Dr Note Details") {
                    for ($j = $i; $j <= $highestRow; $j++) {
                        if ($object->getActiveSheet()->getCell('B' . $j)->getValue() == "Sub Total (B2CS)") {
                            $highestColumn_dr = $worksheet->getHighestColumn($j);
                            for ($k = 0; $k < 5; $k++) {
                                $a11 = strlen($highestColumn_dr);
                                $index1 = strlen($highestColumn_dr) - 1;
                                $ord1 = ord($highestColumn_dr[$index1]);
                                $a1 = substr($highestColumn_dr, 0, 1);
                                $a2 = substr($highestColumn_dr, 1);
                                if ($a1 != $a2 and $a2 == "A") {
                                    $ord = ord($highestColumn_dr[1]);
                                    $index = 1;
                                    $o1 = ord($a1);
                                    $o2 = chr($o1 - 1);
                                    $highestColumn_row_pp = $o2 . "Z";
                                } else {
                                    $highestColumn_row_pp = $this->getAlpha($highestColumn_dr, $ord1, $a11, $index1);
                                }
                                $highestColumn_dr = $highestColumn_row_pp;
                            }

                            $highest_value_without_DR = $highestColumn_dr; //hightest cloumn till where we have to find our data
                            $char = 'G';
                            while ($char !== $highest_value_without_DR) {
                                $values_DR[] = $object->getActiveSheet()->getCell($char . $j)->getValue();
                                $char++;
                            }
                            $cnt = count($values_DR);
                            $debit_b2c = array();
                            for ($a_dr11 = 0; $a_dr11 < $cnt; $a_dr11++) {
                                $Dr_values = $values_DR[$a_dr11];
                                $debit_b2c[] = $values_DR[$a_dr11];
                                $a_dr11 = ($a_dr11 * 1 + 4);
                            }
                        }
                    }
                } else {
                    $credit_b2c[] = 0;
                    $debit_b2c[] = 0;
                    $debit_b2b[] = 0;
                    $credit_b2b[] = 0;
                    $interstate_b2b[] = 0;
                    $intrastate_b2b[] = 0;
                    $interstate_b2c[] = 0;
                    $intrastate_b2c[] = 0;
                }
            }

            //store b2c values of debit and credi into new variable
            $debit_b2c1 = $debit_b2c;
            $credit_b2c1 = $credit_b2c;


            //code to insert data into database
            $uniq_id = $this->generate_uniq_id(); //unique id generation
            $month_data_arr = $month_data; //array of month data
            $count = count($month_data_arr);
            $vall = 1;
            for ($t = 0; $t < $count; $t++) {
                if ($interstate_b2b == "" or $interstate_b2b === NULL) {
                    $inter_state_b2b = array();
                    $inter_state_b2b[$t] = 0; //array of inter state supply B2B
                } else {
                    $inter_state_b2b = $interstate_b2b; //array of inter state supply B2B
                }
                if ($intrastate_b2b == "" or $intrastate_b2b === NULL) {
                    $intra_state_b2b = array();
                    $intra_state_b2b[$t] = 0; //array of intra state supply B2B
                } else {
                    $intra_state_b2b = $intrastate_b2b; //array of intra state supply B2B
                }
                if ($interstate_b2c == "" or $interstate_b2c === NULL) {
                    $inter_b2c = array();
                    $inter_b2c[$t] = 0; // array of inter state supply B2C
                } else {
                    $inter_b2c = $interstate_b2c; // array of inter state supply B2C
                }
                if ($intrastate_b2c == "" or $intrastate_b2c === NULL) {
                    $intra_b2c = array();
                    $intra_b2c[$t] = 0;   //array of intra state supply B2C
                } else {
                    $intra_b2c = $intrastate_b2c; //array of intra state supply B2C
                }
                if ($debit_b2b == "" or $debit_b2b === NULL) {
                    $debit_b2b_new = array();
                    $debit_b2b_new[$t] = 0;  //array of debit_value B2B
                } else {
                    $debit_b2b_new = $debit_b2b; //array of debit_value B2B
                }
                if ($debit_b2c1 == "" or $debit_b2c1 === NULL) {
                    $debit_b2c_new = array();
                    $debit_b2c_new[$t] = 0;   //array of debit_value B2C
                } else {
                    $debit_b2c_new = $debit_b2c1; //array of debit_value B2C
                }
                if ($credit_b2b == "" or $credit_b2b === NULL) {
                    $credit_b2b_new = array();
                    $credit_b2b_new[$t] = 0;  //array of credit_value B2B
                } else {
                    $credit_b2b_new = $credit_b2b; //array of credit_value B2B
                }
                if ($credit_b2c1 == "" or $credit_b2c1 === NULL) {
                    $credit_b2c_new = array();
                    $credit_b2c_new[$t] = 0;  //array of credit_value B2C
                } else {
                    $credit_b2c_new = $credit_b2c1; //array of credit_value B2C
                }
                //query to insert data into database
                $quer = $this->db->query("insert into b2b_b2c (`unique_id`,`month`,`interstate_b2b`,`interstate_b2c`,`intrastate_b2b`,`intrastate_b2c`,`credit_b2b`,`credit_b2c`,`debit_b2b`,`debit_b2c`)"
                        . " values ('$uniq_id','$month_data[$t]','$inter_state_b2b[$t]','$intra_state_b2b[$t]','$inter_b2c[$t]','$intra_b2c[$t]','$credit_b2b_new[$t]','$credit_b2c_new[$t]','$debit_b2b_new[$t]','$debit_b2c_new[$t]')");

                if ($this->db->affected_rows() > 0) {
                    $vall++;
                }
            }
            if ($vall > 1) {
                $response['message'] = "success";
                $response['status'] = true;
                $response['code'] = 200;
            } else {
                $response['message'] = "";
                $response['status'] = FALSE;
                $response['code'] = 204;
            }echo json_encode($response);
        }
    }

    //to decrement column of excel
    public function getAlpha($highestColumn_row, $ord, $a, $index) {
        if ($ord >= 65) {
            // The final character is still greater than A, decrement
            $highestColumn_row = substr($highestColumn_row, 0, $index) . chr($ord - 1);
        } else {
            if ($a == 2) {
                $highestColumn_row = 'Z';
            } else if ($a == 3) {
                $highestColumn_row = 'ZZ';
            } else if ($a == 1) {
                $highestColumn_row = 'A';
            }
        }
        return $highestColumn_row;
    }

    public function generate_uniq_id() {
        $result = $this->db->query('SELECT unique_id FROM `b2b_b2c` ORDER BY unique_id DESC LIMIT 0,1');
        if ($result->num_rows() > 0) {
            $data = $result->row();
            $uniq_id = $data->unique_id;
            //generate turn_id
            $uniq_id = str_pad( ++$uniq_id, 5, '0', STR_PAD_LEFT);
            return $uniq_id;
        } else {
            $uniq_id = 'btb_1001';
            return $uniq_id;
        }
    }

    //function to get graph function for B2B and B2C.
    public function get_graph_b2b() {
        $customer_id = $this->input->post("customer_id");
         $insert_id = $this->input->post("insert_id");
        $query = $this->db->query("SELECT *  from monthly_summary_all where customer_id='$customer_id' and insert_id='$insert_id'");
        $query_get_observation = $this->db->query("SELECT * from observation_transaction_all where customer_id='$customer_id' AND insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
//        $query_get_graph = $this->Management_report_model->get_graph_query($customer_id, $insert_id);
        $data = ""; //view observations
        $data1 = ""; //view observations
        $data2 = ""; //view observations
        $data_salesb2b_b2c_name = "";
        $data_salesb2b_b2c_observation = "";
        $data_salesb2b_b2c_remarks = "";
        $a = "";
        if ($this->db->affected_rows() > 0) {
            $result = $query->result();
            $result1 = $query_get_observation->row();
            $salesb2b_b2c_observation = $result1->b2b_b2c_observation;
            $salesb2b_b2c_remarks = $result1->b2b_b2c_remarks;

            $data_salesb2b_b2c_name = 'Sales B2B & B2C';
            $data_salesb2b_b2c_observation = $salesb2b_b2c_observation;
//             $data_salesb2b_b2c_remarks=$salesb2b_b2c_remarks;
            $a = $salesb2b_b2c_remarks;
            if ($a == '') {
                $data_salesb2b_b2c_remarks = 'not given';
            } else {
                $data_salesb2b_b2c_remarks = $salesb2b_b2c_remarks;
            }
            $month = array();
            $array_b2b = array();
            $array_b2c = array();
            $array_b2b_ratio = array();
            $array_b2c_ratio = array();
            $data2 .= '<h4><b>5.Sales B2B and B2C</b></h4>';
            $data .= '<div class="row">
                    <div class="col-md-12">
                        <div class="">
                         <table id="example2" class="table table-bordered table-striped">
                                <thead style="background-color: #00008B;color:white">
                                    <tr>
                                        <th>No.</th>
                                        <th>Month</th>
                                        <th>Sales B2B</th>
                                        <th>Sales B2C</th>
                                        <th>Ratio of sales B2B to total sales</th>
                                        <th>Ratio of B2C to total sales</th>
                                    </tr>
                                </thead>
                                <tbody>';
            $k = 1;
            $turnover = array();
            $taxable_supply_arr1 = array();
            foreach ($result as $row1) {
                $inter_state_supply = $row1->inter_state_supply;
                $intra_state_supply = $row1->intra_state_supply;
                $no_gst_paid_supply = $row1->no_gst_paid_supply;
                $debit_value = $row1->debit_value;
                $credit_value = $row1->credit_value;
                //new changes 
                $total_taxable_advance_no_invoice = $row1->total_taxable_advance_no_invoice;
                $total_taxable_advance_invoice = $row1->total_taxable_advance_invoice;
                $total_taxable_data_gst_export = $row1->total_taxable_data_gst_export;
                $total_non_gst_export = $row1->total_non_gst_export;
                //$month = $row1->month;

                $taxable_supply1 = ($inter_state_supply + $intra_state_supply + $no_gst_paid_supply + $debit_value + $total_taxable_advance_no_invoice + $total_taxable_advance_invoice + $total_taxable_data_gst_export + $total_non_gst_export) - ($credit_value);
                $taxable_supply_arr1[] = $taxable_supply1; //taxable supply array
            }
            $sum_tax = array_sum($taxable_supply_arr1);

            foreach ($result as $row) {
                $month[] = $row->month;
                $months = $row->month;
                $interstate_b2b = $row->interstate_b2b;
                $interstate_b2c = $row->interstate_b2c;
                $intrastate_b2b = $row->intrastate_b2b;
                $intrastate_b2c = $row->intrastate_b2c;
                $advance_invoice_not_issue_b2b = $row->advance_invoice_not_issue_b2b;
                $advance_invoice_not_issue_b2c = $row->advance_invoice_not_issue_b2c;
                $advance_invoice_issue_b2b = $row->advance_invoice_issue_b2b;
                $advance_invoice_issue_b2c = $row->advance_invoice_issue_b2c;
                $credit_b2b = $row->credit_b2b;
                $credit_b2c = $row->credit_b2c;
                $debit_b2b = $row->debit_b2b;
                $debit_b2c = $row->debit_b2c;
                $turnover[] = ($row->inter_state_supply + $row->intra_state_supply + $row->no_gst_paid_supply + $row->debit_value) - (1 * $row->credit_value);

                $b2b_data = ($interstate_b2b + $intrastate_b2b + $debit_b2b + $advance_invoice_not_issue_b2b + $advance_invoice_issue_b2b) - $credit_b2b;
                $b2c_data = ($interstate_b2c + $intrastate_b2c + $debit_b2c + $advance_invoice_not_issue_b2c + $advance_invoice_issue_b2c) - $credit_b2c;
                $array_b2b[] = $b2b_data;
                $array_b2c[] = $b2c_data;
                if (($sum_tax) != 0) {
                    $array_b2c_ratio[] = round((($b2c_data) / ($sum_tax)) * 100);
                    $array_b2c_ratio1 = round((($b2c_data ) / ($sum_tax)) * 100);
                    $array_b2b_ratio[] = round((($b2b_data ) / ($sum_tax)) * 100);
                    $array_b2b_ratio1 = round((($b2b_data ) / ($sum_tax)) * 100);
                } else {
                    $array_b2c_ratio[] = 0;
                    $array_b2c_ratio1 = 0;
                    $array_b2b_ratio[] = 0;
                    $array_b2b_ratio1 = 0;
                }
                $data .= '<tr>' .
                        '<td>' . $k . '</td>' .
                        '<td>' . $months . '</td>' .
                        '<td>' . $b2b_data . '</td>' .
                        '<td>' . $b2c_data . '</td>' .
                        '<td>' . $array_b2b_ratio1 . '</td>' .
                        '<td>' . $array_b2c_ratio1 . '</td>' .
                        '</tr>';
                $k++;
            }
//            var_dump($array_b2b_ratio1);
            $data .= '<tr>' .
                    '<td>' . '<b>Total</b>' . '</td>' .
                    '<td>' . '' . '</td>' .
                    '<td>' . '<b>' . array_sum($array_b2b) . '</b> ' . '</td>' .
                    '<td>' . '<b>' . array_sum($array_b2c) . '</b>' . '</td>' .
                    '<td>' . '<b>' . array_sum($array_b2b_ratio) . '</b>' . '</td>' .
                    '<td>' . '<b>' . $ttl_b2c_ratio = array_sum($array_b2c_ratio) . '</b>' . '</td>' .
                    '</tr>';
            $data .= '</tbody></table></div></div></div>';
            $total_turnover = array_sum($turnover);
            if ($total_turnover < 15000000 && $ttl_b2c_ratio >= 90) {
                $data1 .= "<hr><h4><b>Observation :</b></h4>";
                $data1 .= " <span>Your the turnover is less then <b>150 Lacs </b>& B2C sales is grater than <b>90%</b> , Our advise to go form composition scheme.</span>";
            } else {
                $data1 .= "<hr><h4><b>Observation :</b></h4>";
                $data1 .= " <span>B2B supply is " . array_sum($array_b2b_ratio) . "% and B2C supply is " . array_sum($array_b2c_ratio) . "% of total supply.</span>";
                $data1 .= "<h5><b>Note:</b>For detailed and consolidated summary refer section-10.</h5>";
            }

            $count = count($month);
            $array_b2b1 = array();
            $array_b2c1 = array();
            $array_b2b_ratio1 = array();
            $array_b2c_ratio1 = array();

            for ($i = 0; $i < $count; $i++) {
                $array_b2b1[] = $array_b2b[$i];
                $aa1 = settype($array_b2b1[$i], "float");

                $array_b2c1[] = $array_b2c[$i];
                $aa2 = settype($array_b2c1[$i], "float");

                $array_b2b_ratio1[] = $array_b2b_ratio[$i];
                $aa2 = settype($array_b2b_ratio1[$i], "float");

                $array_b2c_ratio1[] = $array_b2c_ratio[$i];
                $aa2 = settype($array_b2c_ratio1[$i], "float");
            }
            // to get max value for range
            $arr = array($array_b2c1, $array_b2b1);
            $max_range = 0;
            foreach ($arr as $val) {
                foreach ($val as $key => $val1) {
                    if ($val1 > $max_range) {
                        $max_range = $val1;
                    }
                }
            }

            // to get max value for ratio
            $arr1 = array($array_b2b_ratio1, $array_b2b_ratio1);
            $max_ratio = 0;
            foreach ($arr1 as $val1) {
                foreach ($val1 as $key => $val11) {
                    if ($val11 > $max_ratio) {
                        $max_ratio = $val11;
                    }
                }
            }
            //function to get customer name
            $quer2 = $this->db->query("SELECT customer_name from customer_header_all where customer_id='$customer_id'");

            if ($quer2->num_rows() > 0) {
                $res2 = $quer2->row();
                $customer_name = $res2->customer_name;
            }
            $response['data'] = $data;
            $response['data1'] = $data1;
            $response['data2'] = $data2;
            $response['message'] = "success";
            $response['array_b2b'] = $array_b2b1;  // B2B data
            $response['array_b2c'] = $array_b2c1;  // B2Cs data
            $response['array_b2b_ratio'] = $array_b2b_ratio1;  // B2Cs data
            $response['array_b2c_ratio'] = $array_b2c_ratio1;  // B2Cs data
            $response['month'] = $month;  // month data
            $response['max_range'] = $max_range;  // Max Range
            $response['max_ratio'] = $max_ratio;  // Max Ratio
            $response['customer_name'] = $customer_name;  // Customer
            $response['data_salesb2b_b2c_name'] = $data_salesb2b_b2c_name;  // Customer
            $response['data_salesb2b_b2c_observation'] = $data_salesb2b_b2c_observation;  // Customer
            $response['data_salesb2b_b2c_remarks'] = $data_salesb2b_b2c_remarks;  // Customer
        } else {
            $response['data'] = "";
            $response['message'] = "";
            $response['array_b2b'] = "";  // B2B data
            $response['array_b2c'] = "";  // B2Cs data
            $response['month'] = "";  // month data
            $response['max_range'] = 0;
        }echo json_encode($response);
    }

    public function get_graph_b2b1() {
        $customer_id = $this->input->post("customer_id");
        $insert_id = $this->input->post("insert_id");
        $curr_url = $this->input->post("curr_url");
        $query = $this->db->query("SELECT *  from monthly_summary_all where customer_id='$customer_id' and insert_id='$insert_id'");
        $query_get_observation = $this->db->query("SELECT * from observation_transaction_all where customer_id='$customer_id' AND insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
//        $query_get_graph = $this->Management_report_model->get_graph_query($customer_id, $insert_id);
        $data = ""; //view observations
        $data_salesb2b_b2c_name = "";
        $data_salesb2b_b2c_observation = "";
        $data_salesb2b_b2c_remarks = "";
        $a = "";
        if ($this->db->affected_rows() > 0) {
            $result = $query->result();
            $result1 = $query_get_observation->row();
            $salesb2b_b2c_observation = $result1->b2b_b2c_observation;
            $salesb2b_b2c_remarks = $result1->b2b_b2c_remarks;

            $data_salesb2b_b2c_name = 'Sales B2B & B2C';
            $data_salesb2b_b2c_observation = $salesb2b_b2c_observation;
//             $data_salesb2b_b2c_remarks=$salesb2b_b2c_remarks;
            $a = $salesb2b_b2c_remarks;
            if ($a == '') {
                $data_salesb2b_b2c_remarks = 'not given';
            } else {
                $data_salesb2b_b2c_remarks = $salesb2b_b2c_remarks;
            }

            $month = array();
            $array_b2b = array();
            $array_b2c = array();
            $array_b2b_ratio = array();
            $array_b2c_ratio = array();
            $data .= '<div class="row">
                    <div class="col-md-12">
                        <div class="">
                         <table id="example2" class="table table-bordered table-striped">
                                <thead style="background-color: #00008B;color:white">
                                    <tr>
                                        <th>No.</th>
                                        <th>Month</th>
                                        <th>Sales B2B</th>
                                        <th>Sales B2C</th>
                                        <th>Ratio of sales B2B to total sales</th>
                                        <th>Ratio of B2C to total sales</th>
                                    </tr>
                                </thead>
                                <tbody>';
            $k = 1;
            $turnover = array();
            $taxable_supply_arr1 = array();
            foreach ($result as $row1) {
                $inter_state_supply = $row1->inter_state_supply;
                $intra_state_supply = $row1->intra_state_supply;
                $no_gst_paid_supply = $row1->no_gst_paid_supply;
                $debit_value = $row1->debit_value;
                $credit_value = $row1->credit_value;
                //new changes 
                $total_taxable_advance_no_invoice = $row1->total_taxable_advance_no_invoice;
                $total_taxable_advance_invoice = $row1->total_taxable_advance_invoice;
                $total_taxable_data_gst_export = $row1->total_taxable_data_gst_export;
                $total_non_gst_export = $row1->total_non_gst_export;
                //$month = $row1->month;

                $taxable_supply1 = ($inter_state_supply + $intra_state_supply + $no_gst_paid_supply + $debit_value + $total_taxable_advance_no_invoice + $total_taxable_advance_invoice + $total_taxable_data_gst_export + $total_non_gst_export) - ($credit_value);
                $taxable_supply_arr1[] = $taxable_supply1; //taxable supply array
            }
            $sum_tax = array_sum($taxable_supply_arr1);

            foreach ($result as $row) {
                $month[] = $row->month;
                $months = $row->month;
                $interstate_b2b = $row->interstate_b2b;
                $interstate_b2c = $row->interstate_b2c;
                $intrastate_b2b = $row->intrastate_b2b;
                $intrastate_b2c = $row->intrastate_b2c;
                $advance_invoice_not_issue_b2b = $row->advance_invoice_not_issue_b2b;
                $advance_invoice_not_issue_b2c = $row->advance_invoice_not_issue_b2c;
                $advance_invoice_issue_b2b = $row->advance_invoice_issue_b2b;
                $advance_invoice_issue_b2c = $row->advance_invoice_issue_b2c;
                $credit_b2b = $row->credit_b2b;
                $credit_b2c = $row->credit_b2c;
                $debit_b2b = $row->debit_b2b;
                $debit_b2c = $row->debit_b2c;
                $turnover[] = ($row->inter_state_supply + $row->intra_state_supply + $row->no_gst_paid_supply + $row->debit_value) - (1 * $row->credit_value);

                $b2b_data = ($interstate_b2b + $intrastate_b2b + $debit_b2b + $advance_invoice_not_issue_b2b + $advance_invoice_issue_b2b) - $credit_b2b;
                $b2c_data = ($interstate_b2c + $intrastate_b2c + $debit_b2c + $advance_invoice_not_issue_b2c + $advance_invoice_issue_b2c) - $credit_b2c;
                $array_b2b[] = $b2b_data;
                $array_b2c[] = $b2c_data;
                if (($sum_tax) != 0) {
                    $array_b2c_ratio[] = round(((($b2c_data) / ($sum_tax)) * 100), 2);
                    $array_b2c_ratio1 = round(((($b2c_data ) / ($sum_tax)) * 100), 2);
                    $array_b2b_ratio[] = round(((($b2b_data ) / ($sum_tax)) * 100), 2);
                    $array_b2b_ratio1 = round(((($b2b_data ) / ($sum_tax)) * 100), 2);
                } else {
                    $array_b2c_ratio[] = 0;
                    $array_b2c_ratio1 = 0;
                    $array_b2b_ratio[] = 0;
                    $array_b2b_ratio1 = 0;
                }
                $data .= '<tr>' .
                        '<td>' . $k . '</td>' .
                        '<td>' . $months . '</td>' .
                        '<td>' . $b2b_data . '</td>' .
                        '<td>' . $b2c_data . '</td>' .
                        '<td>' . $array_b2b_ratio1 . '</td>' .
                        '<td>' . $array_b2c_ratio1 . '</td>' .
                        '</tr>';
                $k++;
            }
//            var_dump($array_b2b_ratio1);
            $data .= '<tr>' .
                    '<td>' . '<b>Total</b>' . '</td>' .
                    '<td>' . '' . '</td>' .
                    '<td>' . '<b>' . array_sum($array_b2b) . '</b> ' . '</td>' .
                    '<td>' . '<b>' . array_sum($array_b2c) . '</b>' . '</td>' .
                    '<td>' . '<b>' . array_sum($array_b2b_ratio) . '</b>' . '</td>' .
                    '<td>' . '<b>' . $ttl_b2c_ratio = array_sum($array_b2c_ratio) . '</b>' . '</td>' .
                    '</tr>';
            $data .= '</tbody></table></div></div></div>';
            $total_turnover = array_sum($turnover);
            $url = base_url() . "update_detail/" . base64_encode($customer_id) . "/" . base64_encode($insert_id);
            if ($curr_url == $url) {
                $get_observation = $this->db->query("select b2b_b2c_observation from observation_transaction_all where customer_id='$customer_id' and insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
                if ($this->db->affected_rows() > 0) {
                    $res = $get_observation->row();
                    $observation = $res->b2b_b2c_observation;
                } else {
                    $observation = "";
                }

                if ($total_turnover < 15000000 && $ttl_b2c_ratio >= 90) {
                    $data .= '<div class="col-md-12">
                                    <label><h4><b>Observation:</b></h4></label><span class="required" aria-required="true"> </span>
                                    
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                        <textarea class="form-control" rows="5" id="b2bb2c_sale_observation" name="b2bb2c_sale_observation" onkeyup="countWords(this.id);" >Your the turnover is less then 150 Lacs & B2C sales is grater than 90% , Our advise to go form composition scheme.</textarea>
                                    </div>
                                    <span class="required" style="color: red" id="b2bb2c_sale_observation_error"></span> 
                                </div><br>';
                } else {
                    $data .= '<div class="col-md-12">
                                    <label><h4><b>Observation:</b></h4></label><span class="required" aria-required="true"> </span>
                                    
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                        <textarea class="form-control" rows="5" id="b2bb2c_sale_observation" name="b2bb2c_sale_observation" onkeyup="countWords(this.id);" >B2B supply is ' . array_sum($array_b2b_ratio) . '% and B2C supply is ' . array_sum($array_b2c_ratio) . '% of total supply.</textarea>
                                    </div>
                                    <span class="required" style="color: red" id="b2bb2c_sale_observation_error"></span> 
                                </div><br>';
                }
            } else {
                if ($total_turnover < 15000000 && $ttl_b2c_ratio >= 90) {
                    $data .= '<div class="col-md-12">
                                    <label><h4><b>Observation:</b></h4></label><span class="required" aria-required="true"> </span>
                                    
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                        <textarea class="form-control" rows="5" id="b2bb2c_sale_observation" name="b2bb2c_sale_observation" onkeyup="countWords(this.id);" >Your the turnover is less then 150 Lacs & B2C sales is grater than 90% , Our advise to go form composition scheme.</textarea>
                                    </div>
                                    <span class="required" style="color: red" id="b2bb2c_sale_observation_error"></span> 
                                </div><br>';
                } else {
                    $data .= '<div class="col-md-12">
                                    <label><h4><b>Observation:</b></h4></label><span class="required" aria-required="true"> </span>
                                    
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-eye"></i>
                                        </span>
                                        <textarea class="form-control" rows="5" id="b2bb2c_sale_observation" name="b2bb2c_sale_observation" onkeyup="countWords(this.id);" >B2B supply is ' . array_sum($array_b2b_ratio) . '% and B2C supply is ' . array_sum($array_b2c_ratio) . '% of total supply.</textarea>
                                    </div>
                                    <span class="required" style="color: red" id="b2bb2c_sale_observation_error"></span> 
                                </div><br>';
                }
            }
            $get_observation1 = $this->db->query("select b2b_b2c_remarks from observation_transaction_all where customer_id='$customer_id' and insert_id='$insert_id' ORDER BY ID DESC LIMIT 1");
            if ($this->db->affected_rows() > 0) {
                $res = $get_observation1->row();
                $b2b_b2c_remarks = $res->b2b_b2c_remarks;
            } else {
                $b2b_b2c_remarks = "";
            }
            $data .= "<div class='col-md-12'>
                    <h5 class='box-title' style='margin-left: 1%;'><b>Remarks:</b></h5>
                    <textarea id='editor_b2b_b2c_sale' name='editor_b2b_b2c_sale' rows='10' style='width: 96%;margin-left: 1%;height: 15%;' onkeyup='final_word_count(this.id);remove_error('editor_b2b_b2c_sale')'>" . $b2b_b2c_remarks . "</textarea>
                    </div>";
//            if ($total_turnover < 15000000 && $ttl_b2c_ratio >= 90) {
//                $data .= "<hr><h4><b>Observation :</b></h4>";
//                $data .= " <span>Your the turnover is less then <b>150 Lacs </b>& B2C sales is grater than <b>90%</b> , Our advise to go form composition scheme.</span>";
//            } else {
//                $data .= "<hr><h4><b>Observation :</b></h4>";
//                $data .= " <span>B2B supply is " . array_sum($array_b2b_ratio) . "% and B2C supply is " . array_sum($array_b2c_ratio) . "% of total supply.</span>";
//            }


            $count = count($month);
            $array_b2b1 = array();
            $array_b2c1 = array();
            $array_b2b_ratio1 = array();
            $array_b2c_ratio1 = array();

            for ($i = 0; $i < $count; $i++) {
                $array_b2b1[] = $array_b2b[$i];
                $aa1 = settype($array_b2b1[$i], "float");

                $array_b2c1[] = $array_b2c[$i];
                $aa2 = settype($array_b2c1[$i], "float");

                $array_b2b_ratio1[] = $array_b2b_ratio[$i];
                $aa2 = settype($array_b2b_ratio1[$i], "float");

                $array_b2c_ratio1[] = $array_b2c_ratio[$i];
                $aa2 = settype($array_b2c_ratio1[$i], "float");
            }
            // to get max value for range
            $arr = array($array_b2c1, $array_b2b1);
            $max_range = 0;
            foreach ($arr as $val) {
                foreach ($val as $key => $val1) {
                    if ($val1 > $max_range) {
                        $max_range = $val1;
                    }
                }
            }

            // to get max value for ratio
            $arr1 = array($array_b2b_ratio1, $array_b2b_ratio1);
            $max_ratio = 0;
            foreach ($arr1 as $val1) {
                foreach ($val1 as $key => $val11) {
                    if ($val11 > $max_ratio) {
                        $max_ratio = $val11;
                    }
                }
            }
            //function to get customer name
            $quer2 = $this->db->query("SELECT customer_name from customer_header_all where customer_id='$customer_id'");

            if ($quer2->num_rows() > 0) {
                $res2 = $quer2->row();
                $customer_name = $res2->customer_name;
            }
            $response['data'] = $data;
            $response['message'] = "success";
            $response['array_b2b'] = $array_b2b1;  // B2B data
            $response['array_b2c'] = $array_b2c1;  // B2Cs data
            $response['array_b2b_ratio'] = $array_b2b_ratio1;  // B2Cs data
            $response['array_b2c_ratio'] = $array_b2c_ratio1;  // B2Cs data
            $response['month'] = $month;  // month data
            $response['max_range'] = $max_range;  // Max Range
            $response['max_ratio'] = $max_ratio;  // Max Ratio
            $response['customer_name'] = $customer_name;  // Customer
            $response['data_salesb2b_b2c_name'] = $data_salesb2b_b2c_name;  // Customer
            $response['data_salesb2b_b2c_observation'] = $data_salesb2b_b2c_observation;  // Customer
            $response['data_salesb2b_b2c_remarks'] = $data_salesb2b_b2c_remarks;
        } else {
            $response['data'] = "";
            $response['message'] = "";
            $response['array_b2b'] = "";  // B2B data
            $response['array_b2c'] = "";  // B2Cs data
            $response['month'] = "";  // month data
            $response['max_range'] = 0;
        }echo json_encode($response);
    }

    //function for display customers firm wise for b2b and b2c
    function hq_view_customer($firm_id = '') {
//        $query_get_cfo_data = $this->Cfo_model->get_data_cfo_admin();
        $session_data = $this->session->userdata('login_session');
        $email = ($session_data['customer_email_id']);
//        $get_firm_id = $this->Customer_model->get_firm_id($email);
//        if ($get_firm_id != FALSE) {
//            $firm_id = $get_firm_id;
//        } else {
//            $firm_id = "";
//        }
        $query_get_data = $this->Cfo_model->get_data_cfo_admin($firm_id);
        if ($query_get_data !== FALSE) {
            $data['b2b_data'] = $query_get_data;
        } else {
            $data['b2b_data'] = "";
        }
        $this->load->view('hq_admin/B2b_b2c', $data);
    }

    //function for display customers firm wise for state wise
    function hq_view_customers($firm_id = '') {
//        $query_get_cfo_data = $this->Cfo_model->get_data_cfo_admin();
        $session_data = $this->session->userdata('login_session');
        $email = ($session_data['customer_email_id']);
//        $get_firm_id = $this->Customer_model->get_firm_id($email);
//        if ($get_firm_id != FALSE) {
//            $firm_id = $get_firm_id;
//        } else {
//            $firm_id = "";
//        }
        $query_get_data = $this->Cfo_model->get_data_cfo_admin($firm_id);
        if ($query_get_data !== FALSE) {
            $data['loc_data'] = $query_get_data;
        } else {
            $data['loc_data'] = "";
        }
        $this->load->view('hq_admin/Sale_state_wise', $data);
    }

    //function for display customers firm wise for sales tax and non tax
    public function hq_view_customers_tax($firm_id = '') {
//        $query_get_cfo_data = $this->Cfo_model->get_data_cfo_admin();
        $session_data = $this->session->userdata('login_session');
        $email = ($session_data['customer_email_id']);
//        $get_firm_id = $this->Customer_model->get_firm_id($email);
//        if ($get_firm_id != FALSE) {
//            $firm_id = $get_firm_id;
//        } else {
//            $firm_id = "";
//        }
        $query_get_data = $this->Cfo_model->get_data_cfo_admin($firm_id);
        if ($query_get_data !== FALSE) {
            $data['tax_exempt_data'] = $query_get_data;
        } else {
            $data['tax_exempt_data'] = "";
        }
        $this->load->view('hq_admin/Sale_tax_nontax_exempt', $data);
    }

    //function for display customers firm wise for month wise
    function hq_view_customerss($firm_id = '') { //function to load data
//        $query_get_cfo_data = $this->Cfo_model->get_data_cfo_admin();
        $session_data = $this->session->userdata('login_session');
        $email = ($session_data['customer_email_id']);
        $query_get_data = $this->Cfo_model->get_data_cfo_admin($firm_id);
        if ($query_get_data !== FALSE) {
            $data['month_wise_data'] = $query_get_data;
        } else {
            $data['month_wise_data'] = "";
        }
        $this->load->view('hq_admin/Sales_month_wise', $data);
    }

}

?>