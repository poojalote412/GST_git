<?php
$this->load->view('customer/header');
$this->load->view('hq_admin/navigation');

//Check user login or not using session

if ($session = $this->session->userdata('login_session') == '') {
//take them back to signin 
//    echo 'fghjf';
    redirect(base_url() . 'GST_AdminLogin');
}
$session_data = $this->session->userdata('login_session');
if (is_array($session_data)) {
    $data['session_data'] = $session_data;
    $username = ($session_data['customer_id']);
} else {
    $username = $this->session->userdata('login_session');
}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Add New Customer
               <!--<small>it all starts here</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <!--            <li><a href="#">Examples</a></li>-->
            <li class="active">New Customer</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"></h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div><br>

            <div class="box-body">
                <form method="POST"  action="" name="frm_add_customer" id="frm_add_customer" class="form-horizontal" novalidate="novalidate">
                    <!--<div class="row">-->
                        <div class="form-group">
                            <div class="col-md-12">
                                <!--<p id="message" style="color:red"> </p>-->
                            </div> <br>
                            <div class="col-md-4">
                                <label>Customer Name</label><span class="required" aria-required="true"> * </span>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control" name="customer_name"  id="customer_name" onkeyup="remove_error('customer_name')"  placeholder="Name" aria-required="true" aria-describedby="input_group-error">
                                    
                                </div>
                                <span class="required" style="color: red" id="customer_name_error"></span>
                            </div>

                            <div class="col-md-4">
                                <label>Email id</label><span class="required" aria-required="true"> * </span>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </span>
                                    <input type="text" class="form-control" name="customer_email_id"  id="customer_email_id" onkeyup="remove_error('customer_email_id')"   placeholder="Email Address" aria-required="true" aria-describedby="input_group-error">
                                </div>
                                <span class="required" id="customer_email_id_error"></span>
                            </div> 

                            <div class="col-md-4">
                                <label>Contact Number</label><span class="required" aria-required="true"> * </span>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-mobile"></i>
                                    </span>
                                    <input type="text" name="customer_contact_number"  id="customer_contact_number" onkeyup="remove_error('customer_contact_number')"  data-required="1" class="form-control" placeholder="Contact Number"> 
                                </div>
                                <span class="required" style="color:red" id="customer_contact_number_error"></span>
                            </div> 
                        </div>
                    <!--</div>-->
                    <br><br>
                    <!--<div class="row">-->
                        <div class="form-group">
                            <div class="col-md-4">
                                <label>Address </label><span class="required" aria-required="true"> * </span>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-map"></i>
                                    </span>
                                    <input type="text" name="customer_address"  id="customer_address" onkeyup="remove_error('customer_address')"  data-required="1" class="form-control" placeholder="Address"> 
                                </div>
                                <span class="required" style="color:red" id="customer_address_error"></span>
                            </div>

                            <div class="col-md-4">
                                <label>Pincode</label><span class="required" aria-required="true"> * </span>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-barcode "></i>
                                    </span>

                                    <input type="text" name="pincode"  id="pincode" onkeyup="remove_error('pincode')"  data-required="1" class="form-control" placeholder="Pincode"> 
                                </div>
                                <span class="required" style="color: red" id="pincode_error"></span>
                            </div>

                            <div class="col-md-4">
                                <label>City </label><span class="required" aria-required="true"> * </span>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-hospital-o"></i>
                                    </span>
                                    <input type="text" name="customer_city"  id="customer_city" onkeyup="remove_error('customer_city')" data-required="1" class="form-control" placeholder="City">
                                </div>
                                <span class="required" style="color:red" id="customer_city_error"></span>
                            </div>


                        </div>
                    <!--</div>-->
                    <br><br>
                    <!--<div class="row">-->
                        <div class="form-group">

                            <div class="col-md-4">
                                <label>State</label><span class="required" aria-required="true"> * </span>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-flag"></i>
                                    </span>
                                    <input type="text" name="customer_state"  id="customer_state" onkeyup="remove_error('customer_state')" data-required="1" class="form-control" placeholder="State"> 
                                </div>
                                <span class="required" style="color: red" id="customer_state_error"></span>
                            </div>

                            <div class="col-md-4">
                                <label>Country</label><span class="required" aria-required="true"> * </span>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-globe"></i>
                                    </span>

                                    <input type="text" name="customer_country"  id="customer_country" onkeyup="remove_error('customer_country')"  data-required="1" class="form-control" placeholder="Country"> 
                                </div>
                                <span class="required" style="color: red" id="customer_country_error"></span>

                            </div>  

                            <div class="col-md-4">
                                <label>Gst No
                                </label><span class="required" aria-required="true"> * </span>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-save "></i>
                                    </span>

                                    <input type="text" name="gst_no"  id="gst_no" onkeyup="remove_error('gst_no')"  data-required="1" class="form-control" placeholder="Gst No"> 
                                </div>
                                <span class="required" style="color: red" id="gst_no_error"></span>
                            </div>



                        <!--</div>-->
                    </div><br>
                    <!--<div class="row">-->
                        <div class="form-group">
                            <div class="col-md-4">
                                <label>Pan No </label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-barcode "></i>
                                    </span>
                                    <input type="text" name="pan_no" id="pan_no" onkeyup="remove_error('pan_no')" data-required="1" class="form-control" placeholder="PanNo">
                                </div>
                                <span class="required" style="color: red" id="pan_no_error"></span>
                            </div>
                        </div>
                    <!--</div>-->
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <a href="Customer" class="btn btn-primary"  style="float:right; margin: 2px;">Cancel</a>
                                <button type="button"  id="btn_add_customer" name="btn_add_customer" class="btn btn-primary"  style="float:right;  margin: 2px;">Add Customer</button>
                            </div>
                        </div>
                    </div>
                    <div id="container"></div>
                    <div class="loading" id="loaders1" style="display:none;"></div>
                </form>
            </div>

    </section>

</div>


<?php $this->load->view('customer/footer'); ?>

<script>
    $("#btn_add_customer").click(function () {
//        alert("testing");
        var $this = $(this);
        $this.button('loading');
        setTimeout(function () {
            $this.button('reset');
        }, 2000);
        document.getElementById('loaders1').style.display = "block";

        $.ajax({
            type: "POST",
            url: "<?= base_url("Customer_admin/create_customer") ?>",
            dataType: "json",
            data: $("#frm_add_customer").serialize(),
            success: function (result) {
                console.log(result);
                if (result.status === true) {
                    document.getElementById('loaders1').style.display = "none";
                    alert('Customer inserted successfully');

                    return;
                    window.location.href = "<?= base_url("add_customer") ?>";
                } else {
                    document.getElementById('loaders1').style.display = "none";
                    $('#message').html(result.error);
                    $('#' + result.id + '_error').html(result.error);
                }
            },
            error: function (result) {
                //console.log(result);
                if (result.status === 500) {
                    document.getElementById('loaders1').style.display = "none";
                    alert('Internal error: ' + result.responseText);
                } else {
                    document.getElementById('loaders1').style.display = "none";
                    alert('Unexpected error.');
                }
            }
        });
    });




    $("#btn_adad_customer").click(function () {
//      alert("j");
//        var formid = document.getElementById("table_form");
        $.ajax({
            type: "POST",
            url: "<?= base_url("Customer_admin/create_customer") ?>",
            dataType: "json",
            data: $("#frm_add_customer").serialize(),
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
    });
</script>

