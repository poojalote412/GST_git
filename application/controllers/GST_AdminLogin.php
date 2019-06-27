 <?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class GST_AdminLogin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
    }

    function index() {
//        $data['result'] = $result;
        $this->load->view('admin_login');
    }


    

}

?>