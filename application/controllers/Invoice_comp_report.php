 <?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Invoice_comp_report extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
    }

    function index() {
//        $data['result'] = $result;
        $this->load->view('customer/Invoice_comp_report ');
    }


    

}

?>