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
            Customer can add GST FILES:
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
<!--                <span class="caption-subject font-red sbold uppercase">Customer can generate following graphs:</span>
                                <br> <br><span class="required" id="file_ex_sales_monthly">
                                    1.Sales details monthly</span><br><br>
                                    <span class="required" id="file_ex_tb_offset">
                                    2.3-B offset summary</span><br><br>
                                    <span class="required" id="file_ex_3bvs1_graph">
                                    3.Comparison of GSTR 3B vs 1</span><br> <br>
                                <span class="required" id="file_ex_3bvs2_graph">  
                                    4.Comparison of GSTR 3B vs 2</span><br> <br>
                                      <span class="required" id="file_ex_reconcill_graph">  
                                    5.Reconcillation party wise</span>-->
                <form method="POST"  action="" name="frm_add_customer" id="frm_add_customer" class="form-horizontal" novalidate="novalidate">

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
                                <input type="text" disabled=""class="form-control" name="customer_name"  id="customer_name"  placeholder="Name" aria-required="true" aria-describedby="input_group-error">
                            </div>
                            <span class="required" id="customer_name_error"></span>
                        </div>

                        <div class="col-md-4">
                            <label>Choose Years</label><span class="required" aria-required="true"> * </span>
                            <select class="form-control m-select2 m-select2-general" id="customer_file_years" required name="customer_file_years" onchange="get_sorted_years()">
                                <option value="">Select option</option>

                            </select>
                            <span class="required" id="customer_name_error"></span>
                        </div>


                    </div>
                    <br><br>
                    
                    <div class="form-group">
                        <div class="col-md-4">
                            <label>Consolidated sales details monthly</label><span class="required" aria-required="true"> * </span>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </span>
                                <!--<input type="hidden" name="cust_id" value="<?php echo $record->customer_id; ?>" id="cust_id">-->
                                <input type="file" class="form-control" name="file_ex1" id="file_ex1" value=""  placeholder="Name" aria-required="true">


                            </div>
                            <span class="required" id="file_ex1_error"></span>
                            <!--<span class="required" id="file_ex1_graph"></span>-->


                        </div>

                        <div class="col-md-4">
                            <label>3B offset</label><span class="required" aria-required="true"> * </span>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </span>
                                <!--<input type="hidden" name="cust_id" value="<?php echo $record->customer_id; ?>" id="cust_id">-->
                                <input type="file" class="form-control" name="file_ex2" id="file_ex2" value=""  placeholder="Name" aria-required="true">
                            </div>
                            <span class="required" id="file_ex2_error"></span>

                        </div>

                        <div class="col-md-4">
                            <label>Comparison Report</label><span class="required" aria-required="true"> * </span>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </span>
                                <!--<input type="hidden" name="cust_id" value="<?php echo $record->customer_id; ?>" id="cust_id">-->
                                <input type="file" class="form-control"  name="file_ex_compare" id="file_ex_compare" required accept=".xls, .xlsx"  placeholder="Upload File" aria-required="true">
                            </div>
                            <span class="required" id="file_ex_compare_error"></span>


                        </div>


                    </div>
                    <br><br>

                    <div class="form-group">

                        <div class="col-md-4">
                            <label>Reconcillation report</label><span class="required" aria-required="true"> * </span>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </span>
                                <!--<input type="hidden" name="cust_id" value="<?php echo $record->customer_id; ?>" id="cust_id">-->
                                <input type="file" class="form-control" name="file_ex_reconcill" id="file_ex_reconcill" value=""  placeholder="Name" aria-required="true">

                            </div>
                            <span class="required" id="file_ex_reconcill_error"></span>

                        </div>

                    </div>
                    <br>



                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <a href="Customer" class="btn btn-primary"  style="float:right; margin: 2px;">Cancel</a>
                                <button type="button"  id="btn_add_customer" name="btn_add_customer" class="btn btn-primary"  style="float:right;  margin: 2px;">Add Files</button>
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

    $('#customer_file_years').each(function () {

        var year = (new Date().getFullYear());
        var current = year;

        year -= 3;
        var next = year + 1;
//                                                         var next=a++;
        for (var i = 0; i < 6; i++) {
            if ((year + 1) == current)
                $(this).append('<option selected value=-"' + (year + i) + '-' + (next + i) + '">' + (year + i) + '-' + (next + i) + '</option>');
            else
                $(this).append('<option value="' + (year + i) + '-' + (next + i) + '">' + (year + i) + '-' + (next + i) + '</option>');
        }

    });
</script>

