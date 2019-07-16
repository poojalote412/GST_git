<?php
class Customer_model extends CI_Model
{
	
	function insert($data)
	{
		$this->db->insert_batch('tbl_customer', $data);
	}
        
        function saverecords($CustomerName,$Address,$City)
	{

	$query="insert into tbl_customer values('','$CustomerName','$Address','$City')";
	$this->db->query($query);
	}
        
        function display_customers($customer_id){
            $query = "select * from customer_header_all where customer_id='$customer_id'";
            $this->db->query($query);
             if ($query->num_rows() > 0) {
                return true;
            }
            
        }
}
