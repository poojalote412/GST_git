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
                <h4 class="card-title">Tax Liability</h4>
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
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
                                        <!--<th>Unique id</th>-->
                                        <th>Customer</th>
                                        <th>View Graph</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
//                                    var_dump($cfo_data);
                                    if ($tax_data !== "") {
                                        $i = 1;
                                        foreach ($tax_data as $row) {
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row->customer_name; ?></td>
                                                <!--<td>ANAND RATHI GLOBAL FINANCE LIMITED 2017-18</td>-->
                                                <td><button type="button" name="get_graph" id="get_graph"  onclick="get_graph_fun('<?php echo $row->customer_id; ?>');"class="btn btn-outline-primary" >View</button></td>
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
                <div id="container1"></div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="exampleModal-4" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="forms-sample" id="import_form" method="post" name="import_form" enctype="multipart/form-data">


                    <div class="form-group">
                        <label>File upload</label>
                        <input type="file" name="file_ex" class="file-upload-default">
                        <div class="input-group col-xs-6">
                            <input type="file" class="form-control file-upload" name="file_ex1" id="file_ex1" required accept=".xls, .xlsx"  placeholder="Upload File1">

                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-light"  type="button" >Upload</button>
                            </span>
                        </div><br>
                        <div class="input-group col-xs-6">
                            <input type="file" class="form-control file-upload" name="file_ex2" id="file_ex2" required accept=".xls, .xlsx"  placeholder="Upload File2">

                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-light"  type="button" >Upload</button>
                            </span>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" name="imports" id="imports" class="btn btn-success mr-2">Submit</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>

</div>

<?php $this->load->view('customer/footer'); ?>


<script>
    $("#imports").click(function (event) {
//        alert("ijmikjm");
        var formid = document.getElementById("import_form");
        event.preventDefault();
        $.ajax({
            url: "<?php echo base_url(); ?>Internal_acc_report/import_excel",
            type: "POST",
            data: new FormData(formid),
            contentType: false,
            cache: false,
            processData: false,
            async: false,
            success: function (data) {

                $('#file_ex').val('');
//                    load_data();
//                    alert(data);

//                $('#customer_data').html(data);


            }
        });
    });



    function get_graph_fun(customer_id)
    {
//        alert("testing");
        $.ajax({
            type: "POST",
            url: "<?= base_url("Internal_acc_report/get_graph") ?>",
            dataType: "json",
            data: {customer_id: customer_id},
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
                    Highcharts.chart('container1', {
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

    }

</script>