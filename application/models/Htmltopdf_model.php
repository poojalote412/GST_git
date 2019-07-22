<?php

class Htmltopdf_model extends CI_Model {

    function fetch() {
        $this->db->order_by('CustomerID', 'DESC');
        return $this->db->get('tbl_customer');
    }

    function fetch_single_details($customer_id,$insert_id) {
        $this->db->where('customer_id', $customer_id);
        $this->db->where('insert_id', $insert_id);
        $data = $this->db->get('customer_header_all');
        $output = '<div  align="center">';
        foreach ($data->result() as $row) {

            $output .= '<img style="width:500px;"src="' . base_url() . 'images/sale-month-wise.png" />
                                        <p><b>Name : </b>' . $row->customer_name . '</p>
					<p><b>Address : </b>' . $row->customer_address . '</p>
					<p><b>City : </b>' . $row->customer_city . '</p>
					<p><b>City : </b>' . $row->customer_state . '</p>
			
			';
        }
        $output .= '
		<div>
			<span colspan="2" align="center"><a href="' . base_url() . 'Customer" class="btn btn-primary">Back</a></span>
		</div>
		';
        $output .= '</div>';
        return $output;
    }

}

?>