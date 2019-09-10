<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gst_dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
//        $this->load->model('GST_CustDashboard_model'); /* load model default which you create */
        $this->load->library('session');
    }

    public function index() {
        $this->load->view('customer/Cust_dashboard');
    }
    
      public function index_hq() {
        $this->load->view('admin/Admin_dashboard');
    }
    public function index_admin() {
        $this->load->view('hq_admin/hq_dashboard');
    }

}

?>