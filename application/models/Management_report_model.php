<?php

class Management_report_model extends CI_Model {

    public function get_data_b2b() {
        $qr = $this->db->query("SELECT DISTINCT unique_id  from b2b_b2c");
        if ($qr->num_rows() > 0) {
            $result = $qr->result();
            return $result;
        } else {
            return FALSE;
        }
    }

    public function get_graph_query($unique_id) {
        $qr = $this->db->query("SELECT *  from b2b_b2c where unique_id='$unique_id'");
        if ($qr->num_rows() > 0) {
            $result = $qr->result();
            return $result;
        } else {
            return FALSE;
        }
    }

}
