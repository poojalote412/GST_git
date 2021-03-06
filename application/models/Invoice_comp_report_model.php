<?php

class Invoice_comp_report_model extends CI_Model {

    public function get_data($customer_id) {
        $qr = $this->db->query("SELECT customer_header_all.customer_id,customer_header_all.customer_name,customer_header_all.customer_email_id,insert_header_all.insert_id"
                . " FROM insert_header_all INNER JOIN customer_header_all ON customer_header_all.customer_id=insert_header_all.customer_id where customer_header_all.customer_id='$customer_id'");
        if ($qr->num_rows() > 0) {
            $result = $qr->result();
            return $result;
        } else {
            return FALSE;
        }
    }

    public function get_data_admin($firm_id) {
        $qr = $this->db->query("SELECT customer_header_all.customer_id,customer_header_all.customer_name,customer_header_all.customer_email_id,insert_header_all.insert_id"
                . " FROM insert_header_all INNER JOIN customer_header_all ON customer_header_all.customer_id=insert_header_all.customer_id where customer_header_all.firm_id='$firm_id'");
        if ($qr->num_rows() > 0) {
            $result = $qr->result();
            return $result;
        } else {
            return FALSE;
        }
    }

    public function get_company($customer_id, $insert_id) {
        $query = $this->db->query("select distinct company_name,customer_id,insert_id from gstr_2a_reconciliation_all where customer_id='$customer_id' and insert_id='$insert_id' and status='not_in_2a'");
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return FALSE;
        }
    }

    //All data of company for report
    
    public function get_company_data($customer_id, $insert_id) {
        $query = $this->db->query("select company_name,customer_id,insert_id from gstr_2a_reconciliation_all where customer_id='$customer_id' and insert_id='$insert_id' and status='not_in_2a'");
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return FALSE;
        }
    }
    
    public function get_company_not_in_rec($customer_id, $insert_id) {
        $query = $this->db->query("select distinct company_name,customer_id,insert_id from gstr_2a_reconciliation_all where customer_id='$customer_id'and insert_id='$insert_id' and status='not_in_rec'");
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
    
     //function for get all records all not in 2A records with company details
    
     public function get_notin2a_records_all($customer_id, $insert_id) {
        $query = $this->db->query("select * from gstr_2a_reconciliation_all where status='not_in_2a' and customer_id='$customer_id'and insert_id='$insert_id'");
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

    //function for get all records all not in records with company details
    
    public function get_notinrec_records_all($customer_id, $insert_id) {
        $query = $this->db->query("select * from gstr_2a_reconciliation_all where status='not_in_rec' and customer_id='$customer_id'and insert_id='$insert_id'");
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return FALSE;
        }
    }
    
    public function get_partial_record($company_name, $customer_id, $insert_id) {
        $query = $this->db->query("select * from gstr_2a_reconciliation_partially_match_summary where customer_id='$customer_id' and status='Partly_Mat' and company_name='$company_name' and insert_id='$insert_id'");
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return FALSE;
        }
    }

    public function get_company_partial($customer_id, $insert_id) {
        $query = $this->db->query("select distinct company_name,customer_id,insert_id from gstr_2a_reconciliation_partially_match_summary where customer_id='$customer_id' and insert_id='$insert_id' and status='Partly_Mat'");
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return FALSE;
        }
    }
    
    //Get all partially company details for report
    
    public function get_company_partial_all_data($customer_id, $insert_id) {
        $query = $this->db->query("select * from gstr_2a_reconciliation_partially_match_summary where customer_id='$customer_id' and insert_id='$insert_id' and status='Partly_Mat'");
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return FALSE;
        }
    }

    public function get_details_invoice_not_included($customer_id, $insert_id) {
        $query = $this->db->query("select * from invoice_not_included_gstr1 where customer_id='$customer_id' and insert_id='$insert_id'");
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return FALSE;
        }
    }
    public function get_details_invoice_ammneded($customer_id, $insert_id) {
        $query = $this->db->query("select * from invoices_amended_summary_all where customer_id='$customer_id' and insert_id='$insert_id'");
        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result;
        } else {
            return FALSE;
        }
    }

}
