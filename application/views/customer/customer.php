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
            
            <h3>Customer Form</h3> <br><br>
           <form method="post" name="form1" id="form1">
          Name: <input type="text" name="cname" id="cname"><br><br>
          
           Address <input type="text" name="caddress" id="caddress"><br><br>
           
           City: <input type="text" name="ccity" id="ccity"><br><br>
           
           <input type="submit" name="save" value="Add Customer" onclick="insert_data();" />
          <!--<button type="button" name="add" id="add" class="btn btn-success">AddCustomer</button>-->
           </form>
        </div>
    <?php $this->load->view('customer/footer');?>
</div>

<script>
    
    function insert_data() {
      
//        var formid = document.getElementById("table_form");
                        $.ajax({
                            type: "POST",
                            url: "<?= base_url("Customer/insert_data") ?>",
                            dataType: "json",
                            data: $("#form1").serialize(),
                            success: function (result) {
                                if (result.message === "success") {
                                    alert('Data inserted Successfully');
                    
                                } else if (result.status === false) {
                                    alert('something went wrong')
                                } else {
                                    $('#' + result.id + '_error').html(result.error);
                                    $('#message').html(result.error);
                                }
                            },
//                            error: function (result) {
//                                console.log(result);
//                                if (result.status === 500) {
//                                    alert('Internal error: ' + result.responseText);
//                                } else {
//                                    alert('Unexpected error.');
//                                }
//                            }
                        });
                    }
    </script>