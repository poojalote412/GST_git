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
}
