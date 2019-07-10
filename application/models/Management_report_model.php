<?php

class Management_report_model extends CI_Model {

    public function get_data_b2b($customer_id) {
        $qr = $this->db->query("SELECT * from customer_header_all where customer_id='$customer_id'");
        if ($qr->num_rows() > 0) {
            $result = $qr->result();
            return $result;
        } else {
            return FALSE;
        }
    }

    public function get_graph_query($customer_id) {
        $qr = $this->db->query("SELECT *  from monthly_summary_all where customer_id='$customer_id'");
        if ($qr->num_rows() > 0) {
            $result = $qr->result();
            return $result;
        } else {
            return FALSE;
        }
    }

}
