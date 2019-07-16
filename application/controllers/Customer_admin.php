 <?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customer_admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
//        $this->load->model('Customer_model');
        $this->load->database();
         $this->load->model('Customer_model');
    }
//
    function index() {
//        $data['result'] = $result;
//         $result = $this->Customer_model->display_customers($customer_id);
        
        $query = $this->db->query("SELECT * FROM `customer_header_all` where user_type='2'");
        if ($query->num_rows() > 0) {
            $record = $query->result();
            $data['result'] = $record;
        } else {
            $data['result'] = "";
        }
        $this->load->view('admin/Customer_details',$data);
    }

     function add_customer() {
//       
        $this->load->view('admin/add_customer');
    }


}



?>