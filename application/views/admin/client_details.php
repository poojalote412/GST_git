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
                    <input type="hidden" class="form-control" value="<?php echo $insert_id; ?>"disabled=""name="insert_id"  id="insert_id"   aria-required="true" aria-describedby="input_group-error">
                    <input type="hidden" class="form-control" value="<?php echo $customer_id; ?>"disabled=""name="customer_id"  id="customer_id"   aria-required="true" aria-describedby="input_group-error">
                    <div class="form-group"> 
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label>Customer Name:</label><span class="required" aria-required="true"> </span>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control" name="cust_name" value="<?php echo $cust_result->customer_name; ?>"  id="cust_name" onkeyup="remove_error('customer_name')"   aria-required="true" aria-describedby="input_group-error">
                                </div>
                                <span class="required" style="color: red" id="customer_name_error"></span>
                            </div>

                            <div class="col-md-4">
                                <label>Company Name:</label><span class="required" aria-required="true"> </span>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-bank"></i>
                                    </span>
                                    <input type="text" class="form-control" name="company_name"  id="company_name" onkeyup="remove_error('company_name')"   aria-required="true" aria-describedby="input_group-error">

                                </div>
                                <span class="required" style="color: red" id="customer_name_error"></span>
                            </div>
                            <div class="col-md-4">
                                <label>Address:</label><span class="required" aria-required="true"> </span>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-map"></i>
                                    </span>
                                    <input type="text" class="form-control" name="address" value="<?php echo $cust_result->customer_address; ?>"  id="address" onkeyup="remove_error('customer_name')"   aria-required="true" aria-describedby="input_group-error">

                                </div>
                                <span class="required" style="color: red" id="customer_name_error"></span>
                            </div>
                        </div>
                        <div class="col-md-12"><br>
                            <div class="">
                                <div class="col-md-4">
                                    <label>Managing Director Name:</label><span class="required" aria-required="true"> </span>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-map"></i>
                                        </span>
                                        <input type="text" class="form-control" name="m_d_name" value=""  id="m_d_name" onkeyup="remove_error('customer_name')"   aria-required="true" aria-describedby="input_group-error">

                                    </div>
                                    <span class="required" style="color: red" id="customer_name_error"></span>
                                </div>
                                <div class="col-md-4">
                                    <label>About Company:</label><span class="required" aria-required="true"> </span>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-industry"></i>
                                        </span>
                                        <textarea class="form-control" rows="5" id="about_company" name="about_company"></textarea>
                                    </div>
                                    <span class="required" style="color: red" id="customer_name_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </form> 
                <hr/>


                <div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6"> <div id="container" style="height: 500px;  width:700px"></div></div>
                            <div class="col-md-6"> <div id="cfo_data"></div></div>
                        </div>
                    </div><hr>
                    <div class="row">
                        <div class="col-md-12">

                            <div class="col-md-12"> <div id="rate_wise_data"></div></div>
                        </div>
                    </div><hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">  <div id="container1" style="height: 500px; width: 700px"></div></div>
                            <div class="col-md-6"> <div id="sales_monthly_data"></div></div></div>
                    </div><hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">  <div id="container_state_wise" style="height: 500px; width: 700px"></div></div>
                            <div class="col-md-6"> <div id="sales_state_wise_data"></div></div></div>
                    </div><hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">  <div id="container_export" style="height: 500px; width: 700px"></div></div>
                            <div class="col-md-6"> <div id="compare_3b1_data"></div></div></div>
                    </div><hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">  <div id="container_nontax_exempt" style="height: 500px; width: 700px"></div></div>
                            <div class="col-md-6"> <div id="tax_ntax_Exempt_data"></div></div></div>
                    </div><hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">  <div id="container_sales_b2b_b2c" style="height: 500px; width: 700px"></div></div>
                            <div class="col-md-6"> <div id="compare_b2b_data"></div></div></div>
                    </div><hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">  <div id="container_GSTR3b_vs_2A" style="height: 500px; width: 700px"></div></div>
                            <div class="col-md-6">  <div id="compare_GSTR3B_Vs2_data"></div></div></div>
                    </div><hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">  <div id="container_GSTR3b_vs_1" style="height: 500px; width: 700px"></div></div>
                            <div class="col-md-6">   <div id="compare_3b_vs1_data"></div></div></div>
                    </div><hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">  <div id="container_tax_liability" style="height: 500px; width: 700px"></div></div>
                            <div class="col-md-6">   <div id="tax_liability_data"></div></div></div>
                    </div><hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">  <div id="container_tax_turnover" style="height: 500px; width: 700px"></div></div>
                            <div class="col-md-6">   <div id="tax_turnover_data"></div></div></div>
                    </div><hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">  <div id="container_eligible" style="height: 500px; width: 700px"></div></div>
                            <div class="col-md-6">   <div id="eligible_data"></div></div></div>
                    </div><hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">  <div id="container_gst_payable" style="height: 500px; width: 700px"></div></div>
                            <div class="col-md-6">   <div id="gst_payable"></div></div></div>
                    </div><hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="gstr3B_data"></div>
                        </div>
                    </div><hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="gstr1_data"></div>
                        </div>
                    </div><hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="invoice_ammend_original_data"></div>
                        </div>
                    </div><hr>
                </div>
            </div>
        </div>


</div>

</section>



</div>

<?php $this->load->view('customer/footer'); ?>
<script>
    $(document).ready(function () {
        var customer_id = document.getElementById("customer_id").value;
        var insert_id = document.getElementById("insert_id").value;
        $.ajax({
            type: "post",
            url: "<?= base_url("Report/get_content_pdf1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                $('#content_pdf').html("");
                if (result.message === "success") {

                    var data = result.data;
                    $('#content_pdf').html("");
                    $('#content_pdf').html(data);
//                    $('#example2').DataTable();
                } else {

                }
            },
        });
        $.ajax({
            type: "post",
            url: "<?= base_url("Cfo_dashboard/get_graph_Turnover_vs_liabality1") ?>",
            dataType: "json",
//            processData: false,
//            contentType: false,
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                $('#cfo_data').html("");
                if (result.message === "success") {

                    var data = result.data;
                    $('#cfo_data').html("");
                    $('#cfo_data').html(data);
//                    $('#example2').DataTable();
                } else {

                }
            },
        });
        $.ajax({
            type: "POST",
            url: "<?= base_url("Cfo_dashboard/get_graph_Turnover_vs_liabality") ?>",
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
                    var chart = Highcharts.chart('container', {
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
                            }],
                    });
//                    chart.setTitle({
//                        useHTML: true,
//                        text: " <img src='<?= base_url() ?>/images/sale-month-wise.png' width='60px;' style='margin-right:10%;' alt='logo'/>" + "Test Title"
//                    });

                }
            }
        });
        $.ajax({
            type: "POST",
            url: "<?= base_url("Management_report/get_graph_sales_month_wise1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {

                    var taxable_supply = result.taxable_supply_arr;
                    var data_month = result.month_data;
                    var max_range = result.max_range;
                    var sales_percent_values = result.sales_percent_values;
                    var customer_name = "Customer Name:" + result.customer_name;
                    Highcharts.chart('container1', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Sale Month Wise'
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
                                    text: 'Supply Values'
                                }
                            }, {
                                min: 0,
                                max: 100,
                                opposite: true,
                                title: {
                                    text: 'Sales(in %)'
                                }
                            }],
                        legend: {
                            shadow: false
                        },
                        tooltip: {
                            shared: true
                        },
                        series: [{
                                type: 'column',
                                name: 'Sales Month Wise',
                                data: taxable_supply,
                                color: '#87CEEB',
                                tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                },
                            }, {
                                type: 'spline',
                                color: '#AE72E4',
                                name: 'Ratio of Sales',
                                data: sales_percent_values,
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
        });

        $.ajax({
            type: "post",
            url: "<?= base_url("Management_report/get_graph_sales_month_wise1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                $('#sales_monthly_data').html("");
                if (result.message === "success") {

                    var data = result.data;

                    $('#sales_monthly_data').html(data);
//                    $('#example2').DataTable();
                } else {

                }
            },

        });
        $.ajax({
            type: "POST",
            url: "<?= base_url("Management_report/get_graph_state_wise1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {

                    var data_a = result.taxable_value;
                    var max_range = result.data_liability;
                    var data_state = result.state;
                    var customer_name = "Customer Name:" + result.customer_name;
                    Highcharts.chart('container_state_wise', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Sales Satewise'
                        },
                        subtitle: {
                            text: customer_name,
                        },
                        xAxis: {
                            categories: data_state
                        },
                        yAxis: [{
                                max: max_range,
                                title: {
                                    text: 'Taxable Values'
                                }
                            }, ],
                        legend: {
                            shadow: false
                        },
                        tooltip: {
                            shared: true
                        },
                        series: [{
                                name: 'States',
                                data: data_a,
                                color: '#146FA7',
                                tooltip: {
                                    valuePrefix: '₹',
                                },
                            }]
                    });
                }
            }
        });
        $.ajax({
            type: "post",
            url: "<?= base_url("Management_report/get_graph_state_wise1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                if (result.message === "success") {

                    var data = result.data;
//                    $('#location_data').html("");
                    $('#sales_state_wise_data').html(data);
//                    $('#example2').DataTable();
                } else {

                }
            },

        });

        //graph for sale tax and non-taxable exempt
        $.ajax({
            type: "POST",
            url: "<?= base_url("Management_report/get_graph_taxable_nontx_exempt1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {

                    var taxable_supply = result.taxable_supply_arr;
                    var sub_total_non_gst = result.sub_total_non_gst_arr;
                    var sub_total_exempt = result.sub_total_exempt_arr;
                    var ratio_taxable_supply = result.ratio_taxable_supply;
                    var ratio_subtotal_nongst = result.ratio_subtotal_nongst;
                    var ratio_subtotal_exempt = result.ratio_subtotal_exempt;
                    var data_month = result.month_data;
                    var max_range = result.max_range;
                    var customer_name = "Customer Name:" + result.customer_name;
                    Highcharts.chart('container_nontax_exempt', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Sale Taxable,Non-Taxable & Exempt'
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
                                    text: 'Supply Values'
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
                        },
                        series: [{
                                name: 'Taxable Supply',
                                data: taxable_supply,
                                color: '#146FA7',
                                tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                },
                            }, {
                                name: 'Exempt Supply',
                                data: sub_total_exempt,
                                color: '#B8160E',
                                tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                }, }, {
                                name: 'Non-GST Supply',
                                data: sub_total_non_gst,
                                color: '#5BCB45',
                                tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                },
                            },
                            {
                                type: 'spline',
                                color: '#AE72E4',
                                name: 'Ratio of Taxable supply by Total supply',
                                data: ratio_taxable_supply,
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
                            }, {
                                type: 'spline',
                                color: '#0ACAF0',
                                name: 'Ratio of Exempt Supply by Total supply',
                                data: ratio_subtotal_exempt,
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
                            }, {
                                type: 'spline',
                                color: '#FAC127',
                                name: 'Ratio of Non-GST supply by Total supply',
                                data: ratio_subtotal_nongst,
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
        });

        //observation table for sale tax and non-taxable exempt
        $.ajax({
            type: "post",
            url: "<?= base_url("Management_report/get_graph_taxable_nontx_exempt1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                $('#tax_ntax_Exempt_data').html("");
                if (result.message === "success") {

                    var data = result.data;

                    $('#tax_ntax_Exempt_data').html(data);
//                    $('#example2').DataTable();
                } else {

                }
            },

        });

        //graph for sales B2B & B2Cs
        $.ajax({
            type: "POST",
            url: "<?= base_url("Management_report/get_graph_b2b1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {

                    var array_b2b = result.array_b2b;
                    var array_b2c = result.array_b2c;
                    var array_b2b_ratio = result.array_b2b_ratio;
                    var array_b2c_ratio = result.array_b2c_ratio;
                    var max = result.max_range;
                    var customer_name = "Customer Name:" + result.customer_name;
//                    var max_ratio = result.max_ratio;
                    var data_month = result.month;
                    Highcharts.chart('container_sales_b2b_b2c', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: ' Sales B2B and B2C'
                        },
                        subtitle: {
                            text: customer_name
                        },
                        xAxis: {
                            categories: data_month
                        },
                        yAxis: [{

                                max: max,
                                title: {
                                    text: 'Sales'
                                }
                            }, {
//                                min: 0,
                                max: 100,
                                opposite: true,
                                title: {
                                    text: 'Ratio(in %) '
                                }
                            }],
                        legend: {
                            shadow: false
                        },
                        tooltip: {
                            shared: true
                        },
                        series: [{
                                type: 'column',
                                name: 'Sale B2B',
                                data: array_b2b,
                                color: '#146FA7',
                                tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                }
                            }, {
                                type: 'column',
                                name: 'Sale B2C',
                                data: array_b2c,
                                color: '#B8160E',
                                tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                }
                            }, {
                                type: 'spline',
                                color: '#5BCB45',
                                name: 'Ratio of sales B2B to total sales',
                                data: array_b2b_ratio,
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
                                }
                            }, {
                                type: 'spline',
                                color: '#B596E7',
                                name: 'Ratio of B2C to total sales',
                                data: array_b2c_ratio,
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
                                }
                            }]
                    });
                }
            }
        });

        //observation table for sales B2B & B2Cs
        $.ajax({
            type: "post",
            url: "<?= base_url("Management_report/get_graph_b2b1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                if (result.message === "success") {

                    var data = result.data;
                    $('#compare_b2b_data').html("");
                    $('#compare_b2b_data').html(data);
//                    $('#example2').DataTable();
                } else {

                }
            },

        });

        //Graph for comparison GSTR3B vs GSTR2A
        $.ajax({
            type: "POST",
            url: "<?= base_url("Threeb_vs_twoa/get_graph1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id},
            success: function (result) {
                if (result.message === "success") {

                    var data_a = result.gstr_tb;
                    var data_difference = result.difference;
                    var cumu_difference = result.cumu_difference;
                    var data_gstr2a = result.gstr2a;
                    var max = result.max;
                    var months = result.month_data;
                    Highcharts.chart('container_GSTR3b_vs_2A', {
                        chart: {
                            type: 'Combination chart',
                            type: 'area'
                        },
                        title: {
                            text: 'Comparison Between GSTR-3B & GSTR-2A'
                        },
                        subtitle: {
                            text: 'Customer Name: ANAND RATHI GLOBAL FINANCE LIMITED 2017-18'
                        },
                        xAxis: {
                            categories: months,
                            crosshair: true
                        },
                        yAxis: {
                            //                                            min: 0,
                            max: max,
//                                    tickInterval: 1000000,
                            title: {
                                text: 'Rupees (millions)'
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                    '<td style="padding:0"><b>{point.y:.1f} M</b></td></tr>',
                            footerFormat: '</table>',
                            shared: true,
                            useHTML: true
                        },
                        plotOptions: {
                            column: {
                                pointPadding: 0.1,
                                borderWidth: 0
                            },
                            spline: {
                                pointPadding: 0.1,
                                borderWidth: 0
                            },

                            area: {
                                stacking: 'normal',
                                lineColor: '#FFFF00',
                                lineWidth: 1,
                                color: '#FFFF00',
                                marker: {
                                    lineWidth: 1,
                                    lineColor: '#FFFF00'
                                }
                            }
                        },
                        series: [{
                                type: 'column',
                                name: 'GSTR-3B',
                                data: data_a

                            }, {
                                type: 'column',
                                name: 'GSTR-2A',
                                data: data_gstr2a,
                                lineColor: '#FF8C00',
                                color: '#FF8C00'

                            }, {
                                type: 'spline',
                                name: 'Difference',
                                data: data_difference

                            }, {
                                type: 'area',
                                name: 'Cumulative Difference',
                                data: cumu_difference

                            }, ]
                    });




                } else {

                }
            }
        });

        //observation table for comparison GSTR3B VS GSTR 2A
        $.ajax({
            type: "post",
            url: "<?= base_url("Threeb_vs_twoa/get_graph1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                $('#compare_3b1_data').html("");
                if (result.message === "success") {

                    var data = result.data;
                    $('#compare_GSTR3B_Vs2_data').html("");
                    $('#compare_GSTR3B_Vs2_data').html(data);
//                    $('#example2').DataTable();
                } else {

                }
            },

        });

        //Graph for comparison GSTR3B vs GSTR1

        $.ajax({
            type: "POST",
            url: "<?= base_url("Threeb_vs_one/get_graph1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {

                    var data_a = result.data_gstr3b;
                    var data_gstr1_res = result.data_gstr1;
                    var data_difference = result.difference;
                    var cumu_difference = result.cumu_difference;
                    var max = result.max;
                    var month = result.month_data;
                    var customer_name = "Customer Name:" + result.customer_name;
                    Highcharts.chart('container_GSTR3b_vs_1', {
                        chart: {
                            type: 'Combination chart'
                        },
                        title: {
                            text: 'Comparison Between GSTR-3B & GSTR-1'
                        },
                        subtitle: {
                            text: customer_name
                        },
                        xAxis: {
                            categories: month,
                            crosshair: true
                        },
                        yAxis: {
                            min: 0,
                            max: max,
//                            tickInterval: 1000,
                            title: {
                                text: 'Rupees (millions)'
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                    '<td style="padding:0"><b>{point.y:.1f} M</b></td></tr>',
                            footerFormat: '</table>',
                            shared: true,
                            useHTML: true
                        },
                        plotOptions: {
                            column: {
                                pointPadding: 0.2,
                                borderWidth: 0
                            }
                        },
                        series: [{
                                type: 'column',
                                name: 'GSTR-3B',
                                data: data_a

                            }, {
                                type: 'column',
                                name: 'GSTR-1',
                                data: data_gstr1_res,
                                lineColor: '#A9A9A9',
                                color: '#A9A9A9'

                            }, {
                                type: 'spline',
                                name: 'Difference',
                                data: data_difference,
                                lineColor: '#2271B3',
                                color: '#2271B3'

                            }, {
                                type: 'column',
                                name: 'Cumulative Difference',
                                data: cumu_difference,
                                lineColor: '#87cefa',
                                color: '#87cefa'

                            }]
                    });
                }
            }
        });

        //observation table for comparison GSTR3B VS GSTR 1

        $.ajax({
            type: "post",
            url: "<?= base_url("Threeb_vs_one/get_graph1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                $('#compare_3b1_data').html("");
                if (result.message === "success") {

                    var data = result.data;
                    $('#compare_3b_vs1_data').html("");
                    $('#compare_3b_vs1_data').html(data);
//                    $('#example2').DataTable();
                } else {

                }
            },

        });
        $.ajax({
            type: "post",
            url: "<?= base_url("Account_report/get_graph1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                $('#gstr3B_data').html("");
                if (result.message === "success") {
                    var data = result.data;
                    $('#gstr3B_data').html(data);
//                    $('#example1').DataTable();
                } else {

                }
            },

        });

        $.ajax({
            type: "post",
            url: "<?= base_url("Account_report/get_gstr1_details1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert(data);
                $('#gstr1_data').html("");
                if (result.message === "success") {
                    var data = result.data;
                    $('#gstr1_data').html(data);
//                    $('#example2').DataTable();
                } else {

                }
            },

        });

//export sale
        $.ajax({
            type: "post",
            url: "<?= base_url("Management_report/get_graph_exports") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                if (result.message === "success") {

                    var data = result.data;
                    $('#compare_3b1_data').html("");
                    $('#compare_3b1_data').html(data);
//                    $('#example2').DataTable();
                } else {

                }
            },

        });

        $.ajax({
            type: "POST",
            url: "<?= base_url("Management_report/get_graph_exports") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {

                    var taxable_supply = result.taxable_supply_arr;
                    var data_month = result.month_data;
                    var max_range = result.max_range;
                    var sales_percent_values = result.sales_percent_values;
                    var customer_name = "Customer Name:" + result.customer_name;
                    Highcharts.chart('container_export', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Export Sale'
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
                                    text: 'Supply Values'
                                }
                            }, {
                                min: 0,
                                max: 100,
                                opposite: true,
                                title: {
                                    text: 'Sales(in %)'
                                }
                            }],
                        legend: {
                            shadow: false
                        },
                        tooltip: {
                            shared: true
                        },
                        series: [{
                                type: 'column',
                                name: 'Sales Month Wise',
                                data: taxable_supply,
                                color: '#098569',
                                tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                },
                            }, {
                                type: 'spline',
                                color: '#A91408',
                                name: 'Ratio of Sales',
                                data: sales_percent_values,
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
        });

        //rate wise summary
        $.ajax({
            type: "post",
            url: "<?= base_url("Management_report/get_data_rate_wise") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {

                    var data = result.data;
                    $('#compare_3b1_data').html("");
                    $('#compare_3b1_data').html(data);
                    $('#example2').DataTable();
                } else {

                }
            },

        });

//tax liabilty
        $.ajax({
            type: "POST",
            url: "<?= base_url("Internal_acc_report/get_graph1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {

                    var data_outwards = result.data_outward;
                    var data_rcbs = result.data_rcb;
                    var data_inelligibles = result.data_inelligible;
                    var data_rtcs = result.new_net_rtc;
                    var data_paid_credit = result.data_paid_credit;
                    var data_paid_cash = result.data_paid_cash;
                    var data_late_fee = result.data_late_fee;
                    var data_month = result.month_data;
                    var customer_name = "Customer Name:" + result.customer_name;
                    Highcharts.chart('container_tax_liability', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Tax Liability'
                        },
                        subtitle: {
                            text: customer_name
                        },
                        xAxis: {
                            categories: data_month,
                            crosshair: true
                        },
                        yAxis: {
                            min: 0,
//                            max: 100000,                           
                            title: {
                                text: 'Rupees (millions)'
                            },
//                            stackLabels: {
//                                enabled: true,
//                                style: {
//                                    fontWeight: 'bold',
//                                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
//                                }
//                            }

                        },

                        tooltip: {
                            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                    '<td style="padding:0"><b>{point.y:.1f} M</b></td></tr>',
                            footerFormat: '</table>',
                            shared: true,
                            useHTML: true
                        },
                        plotOptions: {
                            column: {
                                stacking: 'normal',
                                pointPadding: 0.1,
                                borderWidth: 0,

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
                        series: [{

                                type: 'column',
                                name: 'Outward Liability',
                                data: data_outwards,
                                stack: data_outwards,
                                lineColor: '#87ceeb',
                                color: '#87ceeb'


                            }, {
                                type: 'column',
                                name: 'RCB Liability',
                                data: data_rcbs,
                                stack: data_outwards,
                                lineColor: '#000000',
                                color: '#000000'


                            }, {
                                type: 'column',
                                name: 'Ineligible ITC',
                                stack: data_inelligibles,
                                data: data_inelligibles,
                                lineColor: '#228B22',
                                color: '#228B22'

                            }, {
                                type: 'column',
                                name: 'NET ITC',
                                stack: data_inelligibles,
                                data: data_rtcs,
                                lineColor: '#FF8300',
                                color: '#FF8300'

                            }, {
                                type: 'column',
                                name: 'Paid in Credit',
                                data: data_paid_credit,
                                stack: data_paid_credit,
                                lineColor: '#0078D7',
                                color: '#0078D7'

                            }, {
                                type: 'column',
                                name: 'Paid in Cash',
                                data: data_paid_cash,
                                stack: data_paid_credit,
                                lineColor: '#e75480',
                                color: '#e75480'

                            }, {
                                type: 'column',
                                name: 'Interest Late Fee',
                                data: data_late_fee,
                                lineColor: '#FFFF00',
                                color: '#FFFF00'
                            }, ]
                    });

                }
            }
        });
        $.ajax({
            type: "post",
            url: "<?= base_url("Internal_acc_report/get_graph1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                $('#tax_liability_data').html("");
                if (result.message === "success") {

                    var data = result.data;

                    $('#tax_liability_data').html(data);
                    $('#example2').DataTable();
                } else {

                }
            },

        });
//rate wise data
        $.ajax({
            type: "post",
            url: "<?= base_url("Management_report/get_data_rate_wise1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {

                    var data = result.data;
                    $('#rate_wise_data').html("");
                    $('#rate_wise_data').html(data);
//                    $('#example2').DataTable();
                } else {

                }
            },

        });
//tax turnover
        $.ajax({
            type: "POST",
            url: "<?= base_url("Internal_acc_report/get_graph_tax_turnover1") ?>",
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
                    Highcharts.chart('container_tax_turnover', {
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
        $.ajax({
            type: "post",
            url: "<?= base_url("Internal_acc_report/get_graph_tax_turnover1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                $('#tax_turnover_data').html("");
                if (result.message === "success") {
                    var data = result.data;

                    $('#tax_turnover_data').html(data);
//                    $('#example2').DataTable();
                } else {

                }
            },

        });
//eligible and ineligible data
        $.ajax({
            type: "POST",
            url: "<?= base_url("Internal_acc_report/get_graph_eligible_ineligible1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {

                    var ineligible_itc = result.ineligible_itc;
                    var net_itc = result.net_itc;
                    var ineligible_ratio = result.ineligible_ratio;
                    var eligible_ratio = result.eligible_ratio;
                    var data_month = result.month_data;
                    var max_range = result.max_range;
                    var customer_name = "Customer Name:" + result.customer_name;
                    Highcharts.chart('container_eligible', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Eligible and Ineligible Credit'
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
                                    text: 'Sales'
                                }
                            }, {
//                                min: 0,
                                max: 100,
                                opposite: true,
                                title: {
                                    text: 'Ratio(in %) '
                                }
                            }],
                        legend: {
                            shadow: false
                        },
                        tooltip: {
                            shared: true
                        },
                        series: [{
                                type: 'column',
                                name: ' Ineligible ITC',
                                data: ineligible_itc,
                                color: '#146FA7',
                                tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                }
                            }, {
                                type: 'column',
                                name: 'Eligible ITC',
                                data: net_itc,
                                color: '#B8160E',
                                tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                }
                            }, {
                                type: 'spline',
                                color: '#5BCB45',
                                name: 'Ratio Of Ineligible ITC to total ITC',
                                data: ineligible_ratio,
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
                                }
                            }, {
                                type: 'spline',
                                color: '#B596E7',
                                name: 'Ratio of Eligible ITC to Total ITC',
                                data: eligible_ratio,
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
                                }
                            }]
                    });
                } else {
                    alert('no graph available.please insert files.');
                }
            }
        }
        );

        $.ajax({
            type: "post",
            url: "<?= base_url("Internal_acc_report/get_graph_eligible_ineligible1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                $('#eligible_data').html("");
                if (result.message === "success") {

                    var data = result.data;

                    $('#eligible_data').html(data);
//                    $('#example2').DataTable();
                } else {

                }
            },

        });
//gst payable vs cash data
        $.ajax({
            type: "post",
            url: "<?= base_url("Internal_acc_report/get_graph_gst_payable_vs_cash1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                $('#gst_payable').html("");
                if (result.message === "success") {

                    var data = result.data;
                    $('#gst_payable').html("");
                    $('#gst_payable').html(data);
//                    $('#example2').DataTable();
                } else {

                }
            },

        });
        $.ajax({
            type: "POST",
            url: "<?= base_url("Internal_acc_report/get_graph_gst_payable_vs_cash1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {

                    var liability = result.liability;
                    var net_itc = result.net_itc;
                    var paid_in_cash = result.paid_in_cash;
                    var percent = result.percent;
                    var data_month = result.month_data;
                    var max_range = result.max_range;
                    var customer_name = "Customer Name:" + result.customer_name;
                    Highcharts.chart('container_gst_payable', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'GST Payable vs Cash'
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
                                    text: 'Percentage(%) paid in cash'
                                }
                            }],
                        legend: {
                            shadow: false
                        },
                        tooltip: {
                            shared: true
                        },
                        series: [{
                                name: 'Tax Liability',
                                data: liability,
                                color: '#146FA7',
                                tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                },
                            }, {
                                name: 'ITC',
                                data: net_itc,
                                color: '#B8160E',
                                tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                },
                            }, {
                                name: 'Paid in Cash',
                                data: paid_in_cash,
                                color: '#36BE69',
                                tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                },
                            }, {
                                type: 'spline',
                                color: '#F9AB58',
                                name: 'Percentage paid in cash',
                                data: percent,
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
        //table data for Invoice ammend in other than original

//         $('#invoice_ammend_original_data').html("");
        $.ajax({
            type: "post",
            url: "<?= base_url("Invoice_comp_report/get_table_data_ammend") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.status === true) {
                    var data = result.data;

                    $('#invoice_ammend_original_data').html(data);
//                    $('#example2').DataTable();
                } else {
                    $('#invoice_ammend_original_data').html("");
                    alert('no data availabale');
                }
            }

        });
    });



</script>



