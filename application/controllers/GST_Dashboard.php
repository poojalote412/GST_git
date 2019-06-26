 <?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class GST_Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
    }

    function index() {
//        $data['result'] = $result;
        $this->load->view('index');
    }


    

}

?>