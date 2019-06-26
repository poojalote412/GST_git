
<?php
class GST_3BVs1Model extends CI_Model
{
	 public function insert_GST3Bvs1($data) {
        $q = $this->db->insert("gstr_compare", $data);
        if ($this->db->affected_rows() === 1) {
            return TRUE;
        } else {
            return false;
        }
    }
    
    
    
    public function display_GST3Bvs1()
 {
 $query=$this->db->query("select * from gstr_compare");
 return $query->result();
 }
}
