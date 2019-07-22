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
                <!--<input type="text" name="customer_id" name="customer_id" value="<?php echo $row->customer_id;?>">-->
                <div class="box-tools pull-right">
                    <!--<input type="text" name="customer_id" id="customer_id"value="">-->
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div><br>
            <div class="actions" style="float: right;">
                <div class="btn-group">
                    <a href="add_customer"><button id="" class="btn btn-primary"> 
                            <i class="fa fa-plus"></i>
                            Add New Customer
                        </button>
                    </a>
                </div>
            </div><br><br>
            <div class="box-body">


                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Customer</th>
                            <th>Email ID</th>
                            <th>Contact No</th>
                            <th>Created On</th>
                            <th>Action</th>
<<<<<<< HEAD
                            <th>Upload</th>
=======
<!--                            <th>View</th>
                            <th>View PDF</th>-->
>>>>>>> 966bd20a1a036d7f96a5535b0e5def033a863c02
                        </tr>
                    </thead>
                    <tbody>

                        <?php
//                                    var_dump($cfo_data);
                        if ($result !== "") {
                            $i = 1;
                            foreach ($result as $row) {
                                $customer_id= $row->customer_id;
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row->customer_name; ?></td>
                                    <td><?php echo $row->customer_email_id; ?></td>
                                    <td><?php echo $row->customer_contact_number; ?></td>
                                    <td><?php echo $row->created_on; ?></td>
        <!--                       <td><button type="button" name="get_graph" id="get_graph" onclick="get_graph_fun('<?php echo $row->customer_id; ?>');"class="btn btn-outline-primary" >Edit</button>
                                    <button type="button" name="get_graph" id="get_graph" onclick="get_graph_fun('<?php echo $row->customer_id; ?>');"class="btn btn-outline-primary" >Delete</button></td>
                                    -->
<<<<<<< HEAD
                                    <script>
                                     document.getElementById("customer_id").value='<?php echo $customer_id;?>';
                                    </script>
                                    <td><a class="btn btn-circle red btn-icon-only btn-default" onclick="delete_customer('<?php echo $row->customer_id; ?>')"><i class="fa fa-remove"></i></a>
                                        <a class="btn btn-circle blue btn-icon-only btn-default" href="<?= base_url("view_edit_customer/" . $row->customer_id); ?>" data-desig_id="CA"><i class="fa fa-pencil"></i></a></td>
                                     <td><a class="btn btn-circle red btn-icon-only btn-primary" href="<?= base_url("view_edit_customer_files/" . $row->customer_id); ?>">Upload</a></td>
=======
                                    <td><a class="btn btn-circle red btn-icon-only btn-default" onclick="delete_designation('CA')"><i class="fa fa-remove"></i></a>
                                        <a class="btn btn-circle blue btn-icon-only btn-default" data-toggle="modal" data-target="#edit_designation" data-desig_id="CA"><i class="fa fa-pencil"></i></a></td>
        <!--                                    <td><a class="btn btn-circle blue btn-icon-only btn-default"type="button" href="<?= base_url() . 'htmltopdf/details/' . $row->customer_id . '/' . $row->insert_id ?>">View</a></td>
                                    <td><a class="btn btn-circle blue btn-icon-only btn-default"type="button" target="_blank" href="<?= base_url() . 'htmltopdf/pdfdetails/' . $row->customer_id . '/' . $row->insert_id ?>">View in PDF</a></td>
                                    <td><a class="btn btn-circle blue btn-icon-only btn-default"type="button" target="_blank" onclick="view_pdf('<?php // echo $row->customer_id;  ?>', '<?php // echo $row->insert_id;  ?>')">View in PDF</a></td>-->
>>>>>>> 966bd20a1a036d7f96a5535b0e5def033a863c02
                                </tr> 
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


<?php $this->load->view('customer/footer'); ?>

<<<<<<< HEAD
<script>
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
=======

<script>
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
>>>>>>> 966bd20a1a036d7f96a5535b0e5def033a863c02
    }
</script>

