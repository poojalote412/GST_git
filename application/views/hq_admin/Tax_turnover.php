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
            Tax Turnover
            <!--<small>it all starts here</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Internal Account Report</a></li>
            <li class="active">Tax Turnover</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <!--                <h3 class="box-title">Customer</h3>-->

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
                
                <div class="col-md-4" style="margin-top: 1.5%">
                    <select class="form-control m-select2 m-select2-general" id="ddl_firm_name_fetch" name="ddl_firm_name_fetch" onchange="get_sorted_data(this.value)">
                        <option value="">Select Office</option>
                        <!--<option value="1">All</option>-->
                    </select>
                    <span class="required" id="ddl_firm_name_fetch_error"></span>
                </div>
            </div>
            <div class="box-body">


                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Customer</th>
                            <th>View Graph</th>
                            <th>View Observations</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
//                                    var_dump($cfo_data);
                        if ($tax_turnover_data !== "") {
                            $i = 1;
                            foreach ($tax_turnover_data as $row) {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row->customer_name; ?></td>
                                    <td><button type="button" name="get_graph" id="get_graph" onclick="get_graph_fun('<?php echo $row->customer_id; ?>', '<?php echo $row->insert_id; ?>');"class="btn btn-outline-primary" >View</button></td>
                                    <td><button type="button" name="get_records" id="get_records" data-insert_id="<?php echo $row->insert_id; ?>" data-customer_id="<?php echo $row->customer_id; ?>" data-toggle="modal" data-target="#view_value_modal"class="btn bg-maroon-gradient" ><i class="fa fa-fw fa-eye"></i></button></td>
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
<!--modal for view observations-->
<div class="modal fade" id="view_value_modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="ModalLabel">Observations</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="forms-sample" id="import_form" method="post" name="import_form" enctype="multipart/form-data">
                    <input type="hidden" id="customer_id" name="customer_id">
                    <input type="hidden" id="insert_id" name="insert_id">
                    <div class="form-group">
                        <div id="tax_turnover_data"></div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>

</div>



<?php $this->load->view('customer/footer'); ?>
<script>
    $(function () {
        $("#example1").DataTable();
        $("#example2").DataTable();
    });
</script>
<script>
    
     //AJAX for get firm name
    $.ajax({
        url: "<?= base_url("Customer_admin/get_ddl_firm_name") ?>",
        dataType: "json",
        success: function (result) {
            if (result['message'] === 'success') {
                var data = result.firm_data;
                var ele3 = document.getElementById('ddl_firm_name_fetch');
                for (i = 0; i < data.length; i++)
                {
                    // POPULATE SELECT ELEMENT WITH JSON.
                    ele3.innerHTML = ele3.innerHTML + '<option value="' + data[i]['firm_id'] + '">' + data[i]['firm_name'] + '</option>';
                }
            }
        }
    });
    
    //get data of customer firm wise
    
     function get_sorted_data() {
        var firm_id_fetch = document.getElementById('ddl_firm_name_fetch').value;
        window.location.href = "<?= base_url("Internal_acc_report/hq_view_customers/") ?>" + firm_id_fetch;

    }
    
//view observations modal
    $('#view_value_modal').on('show.bs.modal', function (e) {
        var customerid = $(e.relatedTarget).data('customer_id');
        var customer_id = document.getElementById('customer_id').value = customerid;
        var insertid = $(e.relatedTarget).data('insert_id');
        var insert_id = document.getElementById('insert_id').value = insertid;
        $.ajax({
            type: "post",
            url: "<?= base_url("Internal_acc_report/get_graph_tax_turnover") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                $('#tax_turnover_data').html("");
                if (result.message === "success") {

                    var data = result.data;

                    $('#tax_turnover_data').html(data);
                    $('#example2').DataTable();
                } else {

                }
            },

        });
    });
//function to get graph view
    function get_graph_fun(customer_id, insert_id)
    {
//        alert("TEsting");
        $.ajax({
            type: "POST",
            url: "<?= base_url("Internal_acc_report/get_graph_tax_turnover") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {

                    var taxable_value = result.taxable_value;
                    var tax_value = result.tax_value;
                    var tax_ratio = result.tax_ratio;
                    var data_month = result.month_data;
                    var max_range = result.max_range;
                    var customer_name = "Customer Name:" + result.customer_name;
                    Highcharts.chart('container', {
                        chart: {
                            type: 'Combination chart'
                        },
                        title: {
                            text: 'Tax Turnover'
                        },
                        plotOptions: {
                            column: {
                                stacking: 'normal',
                                pointPadding: 0.1,
                                borderWidth: 0,

                            },
                            spline: {
                                pointPadding: 0.1,
                                borderWidth: 0
                            },

                            area: {
                                stacking: 'normal',
                                lineColor: '#FFFF00',
                                lineWidth: 3,
                                color: '#FFFF00',
                                marker: {
                                    lineWidth: 1,
                                    lineColor: '#FFFF00'
                                }
                            }
                        },
                        subtitle: {
                            text: customer_name
                        },
                        xAxis: {
                            categories: data_month
                        },
                        yAxis: [{
                                max: max_range,
                                title: {
                                    text: 'Tax Values'
                                }
                            }, {
                                min: 0,
                                max: 100,
                                opposite: true,
                                title: {
                                    text: 'Ratio(in %)'
                                }
                            }],
                        legend: {
                            shadow: false
                        },
                        tooltip: {
                            shared: true
                        },credits: {
                            enabled: false
                        },
                        series: [{
                                type: 'column',
                                name: 'Tax Value',
                                data: tax_value,
                                stack: taxable_value,
                                color: '#AA381E',
                                tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                },
                            }, {
                                type: 'column',
                                name: 'Taxable Value',
                                data: taxable_value,
                                color: '#4D6FB0',
                                stack: taxable_value,
                                tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                },
                            }, {
                                type: 'spline',
                                name: 'Tax ratio',
                                data: tax_ratio,
//                                stack: taxable_value,
                                color: '#078436',
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

                            }, ]
                    });
                }
            }
        }
        );

    }
</script>

