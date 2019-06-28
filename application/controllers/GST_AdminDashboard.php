 <?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class GST_AdminDashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
    }

    function index() {
//        $data['result'] = $result;
        $this->load->view('admin/admin_dashboard');
    }


//    public function DisplayLoginData()
//        {
//            /* Check session created or not */
//            if (isset($this->session->userdata['user_id']))
//            {
//                $user_id  = $this->session->userdata['user_id'];
//                $data["user_logindata"] = $this->GST_CustDashboard_model->get_login_id($user_id);
//                $this->load->view('Cust_dashboard', $data);
//            }
//            else
//            {
////                echo "<script>window.location='http://localhost/CRUDOperationCI/index.php/crudController/Login'</script>";
//                 redirect(base_url() . 'admin_login');
//            }
//        }

}

?>