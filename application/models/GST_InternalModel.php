<?php
class GST_InternalModel extends CI_Model
{
	
     public function get_data_taxliability()
    {
        $qr= $this->db->query("SELECT DISTINCT tax_libility_id  from tax_liability");
        if($qr ->num_rows() >0)
        {
           $result=$qr->result();
           return $result;
        }else{
            return FALSE;
        }
    }
    
}
