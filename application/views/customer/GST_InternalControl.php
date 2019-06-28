<?php
$this->load->view('customer/header');
$this->load->view('customer/navigation');

//Check user login or not using session

if ($session = $this->session->userdata('login_session') == '') {
//take them back to signin 
//    echo 'fghjf';
    redirect(base_url() . 'GST_AdminLogin');
}
$session_data = $this->session->userdata('login_session');
if (is_array($session_data)) {
    $data['session_data'] = $session_data;
    $username = ($session_data['user_id']);
} else {
    $username = $this->session->userdata('login_session');
}
?>


<div class="main-panel">
        <div class="content-wrapper">
            
           GST INTERNAL REPORT
            
        </div>
    <?php$this->load->view('customer/footer');?>
</div>
