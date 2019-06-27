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

    
    public function employee_dashboard() {
        $session_data = $this->session->userdata('login_session');
        if (is_array($session_data)) {
            $data['session_data'] = $session_data;
            $user_id = ($session_data['user_id']);
        } else {
            $user_id = $this->session->userdata('login_session');
        }
        if ($user_id === "") {
            $user_id = $this->session->userdata('login_session');
        }
        $result2 = $this->db->query("SELECT * FROM `user_header_all` WHERE `user_id`='$user_id'");
        if ($result2->num_rows() > 0) {
            $record = $result2->row();
            $user_id = $record->user_id;
           
//            if ($result3->num_rows() > 0) {
//                $record3 = $result3->row();
//                $value_permit = $record->leave_approve_permission;
//                $data['val'] = $value_permit;
//            } else {
                $data['val'] = '';
            }
        }
}

?>