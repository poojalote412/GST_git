
<?php

class Threeb_vs_one_model extends CI_Model {

    public function insert_GST3Bvs1($data) {
        $q = $this->db->insert("gstr_compare", $data);
        if ($this->db->affected_rows() === 1) {
            return TRUE;
        } else {
            return false;
        }
    }

    public function get_gstr1vs3b_data($customer_id) {
        $qr = $this->db->query("SELECT * from customer_header_all where customer_id='$customer_id'");
        if ($qr->num_rows() > 0) {
            $result = $qr->result();
            return $result;
        } else {
            return FALSE;
        }
    }

}
