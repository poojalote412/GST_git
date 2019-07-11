<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cfo_dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Cfo_model');
        $this->load->model('login_model');
        $this->load->helper('url');
    }

    function index() {
        $session_data = $this->session->userdata('login_session');
        $customer_id = ($session_data['customer_id']);
        $query_get_cfo_data = $this->Cfo_model->get_data_cfo($customer_id);
        if ($query_get_cfo_data !== FALSE) {
            $data['cfo_data'] = $query_get_cfo_data;
        } else {
            $data['cfo_data'] = "";
        }
        $this->load->view('customer/Cfo_dashboard', $data);
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

    // function to generate tunover id
    public function turnover_id() {
        $result = $this->db->query('SELECT uniq_id FROM `turnover_vs_tax_liability` ORDER BY uniq_id DESC LIMIT 0,1');
        if ($result->num_rows() > 0) {
            $data = $result->row();
            $turn_id = $data->uniq_id;
            //generate turn_id
            $turn_id = str_pad(++$turn_id, 5, '0', STR_PAD_LEFT);
            return $turn_id;
        } else {
            $turn_id = 'turn_1001';
            return $turn_id;
        }
    }

    //function to get graph for turn over vs tax liability
    public function get_graph_Turnover_vs_liabality() {
        $customer_id = $this->input->post("customer_id");

        $quer1 = $this->db->query("SELECT `monthly_summary_all`.`month`,`monthly_summary_all`.`inter_state_supply`,`monthly_summary_all`.`intra_state_supply`,"
                . "`monthly_summary_all`.`no_gst_paid_supply`, `monthly_summary_all`.`debit_value`,`monthly_summary_all`.`credit_value`,`3b_offset_summary_all`.`outward_liability`,"
                . "`3b_offset_summary_all`.`rcb_liablity` FROM `monthly_summary_all` INNER JOIN `3b_offset_summary_all` "
                . "ON `monthly_summary_all`.`month`=`3b_offset_summary_all`.`month` where `monthly_summary_all`.`customer_id`='$customer_id' "
                . "AND `3b_offset_summary_all`.`customer_id`='$customer_id'");
        $data = "";
        if ($quer1->num_rows() > 0) {
            $res = $quer1->result();
            $turnover1 = array();
            $tax_liabality1 = array();
            $ratio_val = array();
            $data .= '<div class="row">
                    <div class="col-md-12">
                        <div class="">
                         <table id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>TurnOver</th>
                                        <th>Tax Liability</th>
                                        <th>Ratio</th>
                                    </tr>
                                </thead>
                                <tbody>';
            $k=1;
            foreach ($res as $row) {
                //formula to get turnover , ratio , liability
                $turnover = ($row->inter_state_supply + $row->intra_state_supply + $row->no_gst_paid_supply + $row->debit_value) - (1 * $row->credit_value);
                $tax_liabality = $row->outward_liability + (1 * $row->rcb_liablity);
                $ratio = ($tax_liabality / $turnover) * 100;
                $ratio_val[] = round($ratio);
                $turnover1[] = $turnover;
                $tax_liabality1[] = $tax_liabality;
                $data .= '<tr>' .
                        '<td>' . $k . '</td>' .
                        '<td>' . $turnover . '</td>' .
                        '<td>' . $tax_liabality . '</td>' .
                        '<td>' . round($ratio)."%" . '</td>' .
                        '</tr>';
                $k++;
            }
            $data .= '</tbody></table></div></div></div>';
//            var_dump($turnover1);
            // loop to get turnover value
            $abc = array();
            $pqr = array();
            $lmn = array();
            for ($o = 0; $o < sizeof($turnover1); $o++) {
                $abc[] = $turnover1[$o];
                $aa1 = settype($abc[$o], "float");

                $pqr[] = $tax_liabality1[$o];
                $aa2 = settype($pqr[$o], "float");

                $lmn[] = $ratio_val[$o];
                $aa3 = settype($lmn[$o], "float");
            }

            // to get max value for range
            $arr = array($abc, $pqr, $lmn);
            $max_range = 0;
            foreach ($arr as $val) {
                foreach ($val as $key => $val1) {
                    if ($val1 > $max_range) {
                        $max_range = $val1;
                    }
                }
            }
            //function to get months
            $quer2 = $this->db->query("SELECT month from monthly_summary_all where customer_id='$customer_id'");
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

            $respose['data'] = $data;
            $respose['message'] = "success";
            $respose['data_turn_over'] = $abc;  //turnover data
            $respose['data_liability'] = $pqr; //tax liability data
            $respose['ratio'] = $lmn; //ratio
            $respose['customer_name'] = $customer_name; //customer
            $respose['month_data'] = $months; //months 
            $respose['max_range'] = $max_range; //maximum range for graph
        } else {
            $respose['message'] = "";
            $respose['data_turn_over'] = "";
            $respose['data_liability'] = "";
            $respose['ratio'] = "";
        } echo json_encode($respose);
    }

}

?>