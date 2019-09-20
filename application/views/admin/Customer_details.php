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
    $username = ($session_data['customer_id']);
} else {
    $username = $this->session->userdata('login_session');
}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Customer Details
            <!--<small>it all starts here</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <!--            <li><a href="#">Examples</a></li>-->
            <li class="active">Customer Details</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"></h3>
                <!--<input type="text" name="customer_id" name="customer_id" value="<?php echo $row->customer_id; ?>">-->
                <div class="box-tools pull-right">
                    <input type="hidden" name="insert_id" id="insert_id" value="">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div><br>
            
            <div class="box-body">


                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Customer</th>
                            <th>Email ID</th>
                            <th>Year</th>
                            <th>Contact No</th>
                            <th>Created On</th>
                            <th>Action</th>
                            <th>Previous Files</th>
                            <!--<th>Upload</th>-->

                        </tr>
                    </thead>
                    <tbody>

                        <?php
//                                    var_dump($cfo_data);
                        if ($result !== "") {
                            $i = 1;
                            foreach ($result as $row) {
                                $customer_id = $row->customer_id;
                                $insert_id = $row->insert_id;
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row->customer_name; ?><input type="hidden" name="insert_id" id="insert_id" value="<?php echo $row->insert_id; ?>"></td>
                                    <td><?php echo $row->customer_email_id; ?></td>
                                    <td><?php echo $row->year_id; ?></td>
                                    <td><?php echo $row->customer_contact_number; ?></td>
                                    <td><?php echo $row->created_on; ?></td>
                                    <td><button id="testing1" onclick="page_diversion('<?php echo $customer_id; ?>', '<?php echo $insert_id; ?>');" class="btn btn-primary">Generate Report</button></td>
                                    <td><button id="files_view" onclick="" data-target="#exampleModal-4" data-toggle="modal" data-customer_id="<?php echo $customer_id ?>" data-insert_id="<?php echo $insert_id ?>"class="btn btn-primary">View</button></td>
                                    <?php
                                    $i++;
                                }
                            } else {
                                
                            }
                            ?>
                    </tbody>
                </table>
            </div>
            <div id="container"></div>

        </div>

    </section>

</div>

<div class="modal fade"  id="exampleModal-4" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin: auto;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel"><b>You can download here your previous files:</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="forms-sample" id="download_prev_form" method="post" name="download_prev_form" enctype="multipart/form-data">
                    <div class="col-md-12">
                         <div class="col-md-4">
                        <div id="example2"  style="width: 850px;margin: auto;" name="example2"></div>
                         </div>
                        <div class="col-md-4">
                            <div class="form-group">
<!--                                <label>File Download</label>-->
                                <div class="input-group col-xs-6">
                                    <input type="hidden" class="form-control" value="<?php echo $insert_id; ?>"  name="insert_id"  id="insert_id"   aria-required="true" aria-describedby="input_group-error">
                                    <input type="hidden" class="form-control" value="<?php echo $customer_id; ?>" name="customer_id"  id="customer_id"   aria-required="true" aria-describedby="input_group-error">
                                    <br>

                                    <!--<button class="btn" id="download_prev_file" name="download_prev_file"  style="background-color: DodgerBlue;color: white;padding: 10px 12px;"><i class="fa fa-download"></i></button>-->
                                    <!--<input type="text" class="form-control" value="<?php echo $company_details->report_id; ?>" name="report_id"  id="report_id"   aria-required="true" aria-describedby="input_group-error">-->


                                </div><br>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
<!--                                <label>Date</label>-->
                                <div class="input-group col-xs-6">
                                   
                                </div><br>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <!--<button type="button" name="file_location" id="file_location" class="btn btn-success">Submit</button>-->
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('customer/footer'); ?>


<script>
    
    
    $('#exampleModal-4').on('show.bs.modal', function (e) {

        var customerid = $(e.relatedTarget).data('customer_id');
        var customer_id = document.getElementById('customer_id').value = customerid;
        var insertid = $(e.relatedTarget).data('insert_id');
        var insert_id = document.getElementById('insert_id').value = insertid;
//forcefully complete button validation
        $.ajax({
            type: "POST",
            url: "<?= base_url("Customer_admin/get_file_loacation") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                if (result.message === 'success') {
                if (result['message'] === 'success') {
                    
//                    document.getElementById("example2").ele();
                console.log(data);
                 var data= result.data_tbl;
                $("#example2").html(data);
//                alert(data);

                } else {
                }
            }
        });




    });
    
    function page_diversion(customer_id, insert_id)
    {

        $.ajax({
            type: "POST",
            url: "<?= base_url("Customer_admin/page_diversion") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},

            success: function (result) {

                if (result.report_sts == '1') {
                    window.location.href = "<?= base_url() ?>update_detail/" + btoa(customer_id) + "/" + btoa(insert_id);
                } else {
                    window.location.href = "<?= base_url() ?>enter_detail/" + btoa(customer_id) + "/" + btoa(insert_id);
                }
            }
        });
    }
    function delete_customer()
    {
//        alert("gyhguyjhgujh");
        var customer_id = document.getElementById('customer_id').value;

        var result = confirm("Are You Sure, You Want To Delete This customer?");
        if (result) {
            $.ajax({
                type: "POST",
                url: "<?= base_url("Customer_admin/del_customer") ?>",
                dataType: "json",
                data: {customer_id: customer_id},

                success: function (result) {

                    if (result.status == true) {
                        alert('Customer Deleted Successfully');
                        location.reload();
                    } else {
                        alert('something went wrong');
                    }
                }
            });
        } else {
        }
    }


    $(function () {
        $("#example1").DataTable();
    });

    function view_pdf(customer_id, insert_id)
    {
        $.ajax({
            type: "POST",
            url: "<?= base_url("Cfo_dashboard/pdfdetails") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {

                    var data_a = result.data_turn_over;
                    var data_liability = result.data_liability;
                    var data_ratio = result.ratio;
                    var data_month = result.month_data;
                    var max_range = result.max_range;
                    var customer_name = "Customer Name:" + result.customer_name;
                    Highcharts.chart('container', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Turnover vs Tax Liability'
                        },
                        subtitle: {
                            text: customer_name,
                        },
                        xAxis: {
                            categories: data_month
                        },
                        yAxis: [{
                                max: max_range,
                                title: {
                                    text: 'TurnOver'
                                }
                            }, {
                                min: 0,
                                max: 100,
                                opposite: true,
                                title: {
                                    text: 'Ratio(in %) of tax liability to turnover'
                                }
                            }],
                        legend: {
                            shadow: false
                        },
                        tooltip: {
                            shared: true
                        },
                        series: [{
                                name: 'TurnOver',
                                data: data_a,
                                color: '#146FA7',
                                tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                },
                            }, {
                                name: 'Tax Liability',
                                data: data_liability,
                                color: '#B8160E',
                                tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                },
                            }, {
                                type: 'spline',
                                color: '#5BCB45',
                                name: 'Ratio',
                                data: data_ratio,
                                yAxis: 1,
                                tooltip: {
                                    valueSuffix: ' %'
                                },
                                plotOptions: {
                                    spline: {
                                        dataLabels: {
                                            enabled: true
                                        },
                                        enableMouseTracking: false
                                    }
                                },
                            }]
                    });
                }
            }
        }
        );

    }



    function testing1() {
        alert("hujhj");
        var insert_id = document.getElementById('insert_id').value;
        $.ajax({
            type: "post",
            url: "<?= base_url("Report/index") ?>",
            dataType: "json",
            data: {insert_id: insert_id},
//            alert(data);
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
    }


    function testing() {

        var insert_id = document.getElementById('insert_id').val();
        alert(insert_id);
//        var akshay=$('#insert_id').val();
//        alert(akshay);
        console.log(akshay);
        console.log(insert_id);
//      
        $.ajax({
            type: "POST",
            url: "<?= base_url("Report/index") ?>",
            dataType: "json",
            data: {insert_id: insert_id},

            success: function (result) {
                console.log(result);
                if (result.status == true) {
                    alert('Customer Deleted Successfully');
                    location.reload();
                } else {
                    alert('something went wrong');
                }
            }
        });

    }



</script>

