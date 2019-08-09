<?php

class Internal_acc_report_model extends CI_Model {

    public function get_data_taxliability($customer_id) {
        $qr = $this->db->query("SELECT customer_header_all.customer_id,customer_header_all.customer_name,customer_header_all.customer_email_id,insert_header_all.insert_id"
                . " FROM insert_header_all INNER JOIN customer_header_all ON customer_header_all.customer_id=insert_header_all.customer_id where customer_header_all.customer_id='$customer_id'");
        if ($qr->num_rows() > 0) {
            $result = $qr->result();
            return $result;
        } else {
            return FALSE;
        }
    }

    public function get_data_taxliability_admin() {
        $qr = $this->db->query("SELECT customer_header_all.customer_id,customer_header_all.customer_name,customer_header_all.customer_email_id,insert_header_all.insert_id"
                . " FROM insert_header_all INNER JOIN customer_header_all ON customer_header_all.customer_id=insert_header_all.customer_id");
        if ($qr->num_rows() > 0) {
            $result = $qr->result();
            return $result;
        } else {
            return FALSE;
        }
    }

    public function get_year($customer_id, $insert_id) {
        $qr = $this->db->query("SELECT year_id  from insert_header_all where customer_id='$customer_id' and insert_id='$insert_id'");
        if ($qr->num_rows() > 0) {
            $result = $qr->row();
            $year_id = $result->year_id;
            return $year_id;
        } else {
            return FALSE;
        }
    }

}
