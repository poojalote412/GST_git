 <?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Hq_dashboard  extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
    }

    function index() {
//        $data['result'] = $result;
        $this->load->view('hq_admin/hq_dashboard');
    }



}

?>