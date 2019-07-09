<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gst_admin_login extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {
//        $data['result'] = $result;
        $this->load->view('admin_login');
        $this->load->helper('form');
    }

    public function admin_login() {
        $user_id = $this->input->post('user_id');
        $password = $this->input->post('password');
        $pass = ($password);
        $this->load->model('login_model');
        $result = $this->login_model->login_validation($user_id, $pass);
        if (empty($user_id) || empty($pass)) {
            $data['error'] = "Please enter login or password.";
            $this->load->view('admin_login', $data);
        } elseif ($result === FALSE) {
            $data['error'] = "id password mismatch";
            $this->load->view('admin_login', $data);
        } else {

            if ($result !== FALSE) {
                $user_type = $result['user_type'];
                if ($user_type == '1') {
                    $customer_id = $result['customer_id'];
                    $activity_status = $result['activity_status'];
                    $session_data = array(
                        'customer_id' => $customer_id,
                        'user_type' => $user_type,
                    );
                } else {
                    $customer_id = $result['customer_id'];
                    $activity_status = $result['activity_status'];
                    $session_data = array(
                        'customer_id' => $customer_id,
                        'user_type' => $user_type,
                    );
                    
                }
                if ($user_type == '1') {  //superadmin
                    $this->session->set_userdata('login_session', $session_data);
                    redirect(base_url() . 'admin_dashboard');
                } else {
                    $this->session->set_userdata('login_session', $session_data);
                    redirect(base_url() . 'Cust_dashboard');
                }
            }
        }
    }

    public function admin_logout() {
        // Destroy session data
        $this->session->sess_destroy();
//        $data['reason'] = 'Successfully Logout';
//        $data['reason'] = '';
        $this->load->view('admin_login');
    }

}

?>