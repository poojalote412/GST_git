<?php

class Cfo_model extends CI_Model {
    
    public function get_data_cfo()
    {
        $qr= $this->db->query("SELECT DISTINCT uniq_id  from turnover_vs_tax_liability");
        if($qr ->num_rows() >0)
        {
           $result=$qr->result();
           return $result;
        }else{
            return FALSE;
        }
    }
    
}
