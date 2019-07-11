<?php

class Invoice_comp_report_model extends CI_Model {

    public function get_data($customer_id) {
        $qr = $this->db->query("SELECT * from customer_header_all where customer_id='$customer_id'");
        if ($qr->num_rows() > 0) {
            $result = $qr->result();
            return $result;
        } else {
            return FALSE;
        }
    }

    public function get_company($customer_id) {
        $query = $this->db->query("select distinct company_name from gstr_2a_reconciliation_all where customer_id='$customer_id'");
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return FALSE;
        }
    }

}
