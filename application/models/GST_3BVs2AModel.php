
<?php
class GST_3BVs2AModel extends CI_Model
{
	 public function insert_GST3Bvs2A($data) {
        $q = $this->db->insert("gstr_compare", $data);
        if ($this->db->affected_rows() === 1) {
            return TRUE;
        } else {
            return false;
        }
    }
}
