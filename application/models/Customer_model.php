<?php

class Customer_model extends CI_Model {

    function insert($data) {
        $this->db->insert_batch('tbl_customer', $data);
    }

    function saverecords($CustomerName, $Address, $City) {

        $query = "insert into tbl_customer values('','$CustomerName','$Address','$City')";
        $this->db->query($query);
    }

    public function display_customers($cust_id) {
        $this->db->select(`customer_id`, `customer_name`, `customer_address`, `customer_city`, `customer_state`, `customer_country`, `customer_email_id`, `customer_contact_number`, `gst_no`, `pincode`, `pan_no`);
        $this->db->from('customer_header_all');
        $this->db->where('customer_id', $cust_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query;
        } else {
            return FALSE;
        }
    }

    //add customer from admin panel of GST

    public function add_customer($data_cust) {
//         $this->db2 = $this->load->database('db2',TRUE);
        $q = $this->db->insert("customer_header_all", $data_cust);
        if ($this->db->affected_rows() == 1) {
            return TRUE;
        } else {
            return false;
        }
    }

    //delete customer from admin panel 

    public function delete_customer($customer_id) {
        $this->db->query("delete from customer_header_all where customer_id='$customer_id'");
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function update_customer_details($data, $customer_id) {
//        var_dump($data);
        $this->db->set($data);
//         $this->db->where($data1);
        $this->db->where('customer_id', $customer_id);
        $this->db->update('customer_header_all');

        if ($this->db->affected_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function get_firm_id($email) {
        $query = $this->db->query("select firm_id from customer_header_all where customer_email_id='$email'");
        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->firm_id;
        } else {
            return FALSE;
        }
    }

}
