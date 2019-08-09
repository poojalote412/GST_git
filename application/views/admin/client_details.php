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
                <form method="POST"  action="" name="frm_add_observations" id="frm_add_observations" class="form-horizontal" novalidate="novalidate">
                    <input type="hidden" class="form-control" value="<?php echo $insert_id; ?>"name="insert_id"  id="insert_id"   aria-required="true" aria-describedby="input_group-error">
                    <input type="hidden" class="form-control" value="<?php echo $customer_id; ?>"name="customer_id"  id="customer_id"   aria-required="true" aria-describedby="input_group-error">
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
                                <span class="required" style="color: red" id="company_name_error"></span>
                            </div>
                            <div class="col-md-4">
                                <label>Address:</label><span class="required" aria-required="true"> </span>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-map"></i>
                                    </span>
                                    <input type="text" class="form-control" name="address" value="<?php echo $cust_result->customer_address; ?>"  id="address" onkeyup="remove_error('address')"   aria-required="true" aria-describedby="input_group-error">

                                </div>
                                <span class="required" style="color: red" id="address_error"></span>
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
                                        <input type="text" class="form-control" name="m_d_name" value=""  id="m_d_name" onkeyup="remove_error('m_d_name')"   aria-required="true" aria-describedby="input_group-error">

                                    </div>
                                    <span class="required" style="color: red" id="m_d_name_error"></span>
                                </div>
                                <div class="col-md-4">
                                    <label>About Company:</label><span class="required" aria-required="true"> </span>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-industry"></i>
                                        </span>
                                        <textarea class="form-control" rows="5" id="about_company" name="about_company"></textarea>
                                    </div>
                                    <span class="required" style="color: red" id="about_company_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </form> 
                <hr/>


                <div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6"> <div id="container" ></div></div>
                            <div class="col-md-6"> <div id="cfo_data"></div></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">

                            <div class="col-md-12"> <div id="rate_wise_data"></div></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">  <div id="container1" ></div></div>
                            <div class="col-md-6"> <div id="sales_monthly_data"></div></div></div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-4">  <div id="container_nontax_exempt" ></div></div>
                            <div class="col-md-8"> <div id="tax_ntax_Exempt_data"></div></div></div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">  <div id="container_tax_liability" ></div></div>
                            <div class="col-md-6">   <div id="tax_liability_data"></div></div></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">  <div id="container_tax_turnover"></div></div>
                            <div class="col-md-6">   <div id="tax_turnover_data"></div></div></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">  <div id="container_eligible" ></div></div>
                            <div class="col-md-6">   <div id="eligible_data"></div></div></div>
                    </div>

                </div>
                <div class="form-actions" align="center"><br>
                    <div class="row" >
                        <div  class="col-md-offset-3 col-md-9" >
                            <!--<a href="Customer" class="btn btn-primary"  style="float:right; margin: 2px;">Cancel</a>-->
                            <button type="button"  id="save_info" name="save_info" class="btn btn-primary"  style="float:right;  margin: 2px;">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


</div>

</section>



</div>

<?php $this->load->view('customer/footer'); ?>
<script>
    $(function () {
        $("#example3").DataTable();
    });
</script>
<script>
    
    $("#save_info").click(function () {
//        alert("testing");
//        var $this = $(this);
//        $this.button('loading');
//        setTimeout(function () {
//            $this.button('reset');
//        }, 2000);
//        document.getElementById('loaders1').style.display = "block";

        $.ajax({
            type: "POST",
            url: "<?= base_url("Customer_admin/save_observation") ?>",
            dataType: "json",
            data: $("#frm_add_observations").serialize(),
            success: function (result) {
                console.log(result);
                if (result.status === true) {
//                    document.getElementById('loaders1').style.display = "none";
                    alert('Information Added successfully');

                    return;
                    window.location.href = "<?= base_url("add_customer") ?>";
                } else {
//                    document.getElementById('loaders1').style.display = "none";
                    $('#message').html(result.error);
                    $('#' + result.id + '_error').html(result.error);
                    $(window).scrollTop($('#' + result.id).offset().top);
                }
            },
            error: function (result) {
                //console.log(result);
                if (result.status === 500) {
//                    document.getElementById('loaders1').style.display = "none";
                    alert('Internal error: ' + result.responseText);
                } else {
//                    document.getElementById('loaders1').style.display = "none";
                    alert('Unexpected error.');
                }
            }
        });
    });
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
    });



    function  remove_error(id) {
        $('#' + id + '_error').html("");
    }


</script>



