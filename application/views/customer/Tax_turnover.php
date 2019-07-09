//sale

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
    $username = ($session_data['customer_id']);
} else {
    $username = $this->session->userdata('login_session');
}
?>

<div class="main-panel">
    <div class="content-wrapper">


        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tax Turnover</h4>
                <div class="col-md-6">
                </div>
                <div class="col-md-6">




                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-light">
                            <b>Note: </b> &nbsp; This Graph is automatically generate when you upload files for CFO. 
                        </ol>
                    </nav>
                    <!--<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal-4" data-whatever="@mdo">Upload New</button>-->
                </div>
                <br><br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="order-listing" class="table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Unique id</th>
                                        <th>Customer</th>
                                        <th>View Graph</th>
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
                                                <td><?php echo $row->uniq_id; ?></td>
                                                <td>ANAND RATHI GLOBAL FINANCE LIMITED 2017-18</td>
                                                <td><button type="button" name="get_graph" id="get_graph" onclick="get_graph_fun('<?php echo $row->uniq_id; ?>');"class="btn btn-outline-primary" >View</button></td>
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
                    </div>
                </div>
                <div id="container"></div>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('customer/footer'); ?>
<script>

//function to get graph view
    function get_graph_fun(turn_id)
    {
//        alert("TEsting");
        $.ajax({
            type: "POST",
            url: "<?= base_url("Internal_acc_report/get_graph_tax_turnover") ?>",
            dataType: "json",
            data: {turn_id: turn_id},
            success: function (result) {
                if (result.message === "success") {

                    var taxable_value = result.taxable_value;
                    var tax_value = result.tax_value;
                    var tax_ratio = result.tax_ratio;
                    var data_month = result.month_data;
                    var max_range = result.max_range;
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
                            text: 'Customer Name: ANAND RATHI GLOBAL FINANCE LIMITED 2017-18'
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
                                type:'column',
                                name: 'Tax Value',
                                data: tax_value,
                                stack: taxable_value,
                                color: '#AA381E',
                               tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                },
                            },{
                                type:'column',
                                name: 'Taxable Value',
                                data: taxable_value,
                                color: '#00008b',
                                stack: taxable_value,
                                tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                },
                            },{
                                type: 'spline',
                                name: 'Tax ratio',
                                data: tax_ratio,
//                                stack: taxable_value,
                                color: '#808080',
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
                               
                            },]
                    });
                }
            }
        }
        );

    }
</script>

