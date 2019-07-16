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
        $query = $this->db->query("select distinct company_name,customer_id,insert_id from gstr_2a_reconciliation_all where customer_id='$customer_id' and status='not_in_2a'");
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return FALSE;
        }
    }

    public function get_company_partial($customer_id) {
        $query = $this->db->query("select distinct company_name,customer_id,insert_id from gstr_2a_reconciliation_partially_match_summary where customer_id='$customer_id' and status='Partly_Mat'");
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return FALSE;
        }
    }

    public function get_company_not_in_rec($customer_id) {
        $query = $this->db->query("select distinct company_name,customer_id,insert_id from gstr_2a_reconciliation_all where customer_id='$customer_id' and status='not_in_rec'");
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return FALSE;
        }
    }

    public function get_notin2a_records($company_name, $customer_id, $insert_id) {
        $query = $this->db->query("select * from gstr_2a_reconciliation_all where company_name='$company_name' and status='not_in_2a' and customer_id='$customer_id'and insert_id='$insert_id'");
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return FALSE;
        }
    }

    public function get_notinrec_records($company_name, $customer_id, $insert_id) {
        $query = $this->db->query("select * from gstr_2a_reconciliation_all where company_name='$company_name' and status='not_in_rec' and customer_id='$customer_id'and insert_id='$insert_id'");
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return FALSE;
        }
    }

    public function get_partial_record($company_name, $customer_id, $insert_id) {
        $query = $this->db->query("select distinct company_name,customer_id,insert_id from gstr_2a_reconciliation_partially_match_summary where customer_id='$customer_id' and status='Partly_Mat' and company_name='$company_name' and insert_id='$insert_id'");
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return FALSE;
        }
    }

}
