 <?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_dashboard  extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
    }

    function index() {
//        $data['result'] = $result;
        $this->load->view('admin/admin_dashboard');
    }



}

?>