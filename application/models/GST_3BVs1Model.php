
<?php

class GST_3BVs1Model extends CI_Model {

    public function insert_GST3Bvs1($data) {
        $q = $this->db->insert("gstr_compare", $data);
        if ($this->db->affected_rows() === 1) {
            return TRUE;
        } else {
            return false;
        }
    }

    public function get_gstr1vs3b_data() {
        $query = $this->db->query("select distinct compare_id from gstr_compare where gstr2a = ''");
        if ($query->num_rows() > 0) {
            $result=$query->result();
            return $result;
        } else {
            return false;
        }
    }

}
