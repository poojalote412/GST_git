<?php
$this->load->view('customer/header');
$this->load->view('admin/navigation');

//Check user login or not using session

if ($session = $this->session->userdata('login_session') == '') {
//take them back to signin 
//    echo 'fghjf';
    redirect(base_url() . 'GST_AdminLogin');
}
$session_data = $this->session->userdata('login_session');
if (is_array($session_data)) {
    $data['session_data'] = $session_data;
//    var_dump($session_data);
    $username = ($session_data['customer_id']);
} else {
    $username = $this->session->userdata('login_session');
}
?>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Reports
            <!--<?php print_r($user_name) ?>-->
                <!--<small>it all starts here</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">Reports</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">


        <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <form method="POST"  action="" name="frm_add_customer" id="frm_add_customer" class="form-horizontal" novalidate="novalidate">
                    <div class="form-group"> 
                        <div class="col-md-12">
                            <!--                            <div class="col-md-4">
                                                            <label>Customer ID</label><span class="required" aria-required="true"> </span>
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-user"></i>
                                                                </span>
                                                                <input type="text" class="form-control" value="<?php echo $user_name[0]['customer_id'] ?>" disabled="" name="customer_id"  id="customer_id" onkeyup="remove_error('customer_name')"  aria-required="true" aria-describedby="input_group-error">
                                                                
                                                            </div>
                                                            <span class="required" style="color: red" id="customer_name_error"></span>
                                                        </div>-->

                            <!--                            <div class="col-md-4">
                                                            <label>Insert ID</label><span class="required" aria-required="true"> </span>
                                                            <div class="input-group">
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-user"></i>
                                                                </span>
                                                                <input type="text" class="form-control" value="<?php echo $user_name[1]['insert_id'] ?>"  disabled=""name="insert_id"  id="insert_id" onkeyup="remove_error('customer_name')"   aria-required="true" aria-describedby="input_group-error">
                                                                
                                                            </div>
                                                            <span class="required" style="color: red" id="customer_name_error"></span>
                                                        </div>-->
                            <?php
//                            $user_name = 'user_name';
//                            echo count($user_name);
                            for ($x = 0; $x < count($user_name); $x++) {
                                ?>

                                
                                <div class="col-md-4">
                                    <label>Customer Name</label><span class="required" aria-required="true"> </span>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </span>
                                        <input type="hidden" class="form-control" disabled=""name="insert_id"  id="insert_id"  onkeyup="remove_error('customer_name')"   aria-required="true" aria-describedby="input_group-error">
                                        <input type="text" class="form-control" value="<?php echo $user_name[$x]['customer_name'] ?>"  disabled=""name="cust_name"  id="cust_name" onkeyup="remove_error('customer_name')"   aria-required="true" aria-describedby="input_group-error">

                                    </div>
                                    <span class="required" style="color: red" id="customer_name_error"></span>
                                </div>

                                <div class="col-md-4">
                                    <label>Year ID</label><span class="required" aria-required="true"> </span>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-user"></i>
                                        </span>
                                        <input type="text" class="form-control" value="<?php echo $user_name[$x]['year_id'] ?>"  disabled=""name="year_id"  id="year_id" onkeyup="remove_error('customer_name')"   aria-required="true" aria-describedby="input_group-error">

                                    </div>
                                    <span class="required" style="color: red" id="customer_name_error"></span>
                                </div>
                            <?php }
                            ?>





                        </div>
                    </div>

                </form> 

            </div>


        </div>

    </section>



</div>


<script>
    
      $("#btn_add_customer").click(function () {
    var insert_id = document.getElementById('insert_id').value;
    $.ajax({
            type: "post",
            url: "<?= base_url("Report/index") ?>",
            dataType: "json",
            data: {insert_id: insert_id},
            alert(data);
            success: function (result) {
                var ele3 = document.getElementById('insert_id');
                if (result['message'] === 'success') {
                    var data = result.user_data;

                    //console.log(data.length);
                    ele3.innerHTML = '<option value="">Select Employee</option>';
                    for (i = 0; i < data.length; i++)
                    {                        // POPULATE SELECT ELEMENT WITH JSON.
                        ele3.innerHTML = ele3.innerHTML + '<option value="' + data[i]['user_id'] + '">' + data[i]['user_name'] + '</option>';
                    }
                } else {
                    ele3.innerHTML = "";
                }
            }
        });
        });
    </script>