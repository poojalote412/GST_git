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
    $username = ($session_data['user_id']);
} else {
    $username = $this->session->userdata('login_session');
}
?>
<div class="main-panel">
    <div class="content-wrapper">


        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Turnover Vs Tax Liability</h4>
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal-4" data-whatever="@mdo">Upload New</button>
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
                            <input type="file" class="form-control file-upload" name="file_ex" id="file_ex" required accept=".xls, .xlsx"  placeholder="Upload File1">

                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-light"  type="button" >Upload</button>
                            </span>
                        </div><br>
                        <div class="input-group col-xs-6">
                            <input type="file" class="form-control file-upload" name="file_ex1" id="file_ex1" required accept=".xls, .xlsx"  placeholder="Upload File2">

                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-light"  type="button" >Upload</button>
                            </span>
                        </div><br>
                        <div class="input-group col-xs-6">
                            <input type="file" class="form-control file-upload" name="file_ex_compare" id="file_ex_compare" required accept=".xls, .xlsx"  placeholder="Upload File2">

                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-light"  type="button" >Upload</button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" name="import" id="import" class="btn btn-success mr-2">Submit</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>

</div>

<?php $this->load->view('customer/footer'); ?>
<script>
    $("#import").click(function (event) {
        var formid = document.getElementById("import_form");
        event.preventDefault();
        $.ajax({

//            url: "<?php // echo base_url();  ?>Test/import_excel",
//        type: "POST",

            url: "<?= base_url("Test/import_excel") ?>",
            type: "POST",

            data: new FormData(formid),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            async: false,
            success: function (result) {
                if (result.status === true) {
                    alert('Data Submitted Successfully');
                    // return;
                    location.reload();
                } else if (result.status === false) {
                    alert('something went wrong');
                } else if (result.message === 'file_missmatch') {
                    alert('You have selected wrong File');
                } else {
                    $('#' + result.id + '_error').html(result.error);
                    $('#message').html(result.error);
                }
            }
        });
    });


//function to get graph view
//    function get_graph_fun(turn_id)
//    {
//        $.ajax({
//            type: "POST",
//            url: "<?= base_url("Cfo_dashboard/get_graph_Turnover_vs_liabality") ?>",
//            dataType: "json",
//            data: {turn_id: turn_id},
//            success: function (result) {
//                if (result.message === "success") {
//
//                    var data_a = result.data_turn_over;
//                    var data_liability = result.data_liability;
//                    var data_ratio = result.ratio;
//                    var data_month = result.month_data;
//                    var max_range = result.max_range;
//                    Highcharts.chart('container', {
//                        chart: {
//                            type: 'column'
//                        },
//                        title: {
//                            text: 'Turnover vs Tax Liability'
//                        },
//                        subtitle: {
//                            text: 'Customer Name: ANAND RATHI GLOBAL FINANCE LIMITED 2017-18'
//                        },
//                        xAxis: {
//                            categories: data_month
//                        },
//                        yAxis: [{
//                                max: max_range,
//                                title: {
//                                    text: 'TurnOver'
//                                }
//                            }, {
//                                min: 0,
//                                max: 100,
//                                opposite: true,
//                                title: {
//                                    text: 'Ratio(in %) of tax liability to turnover'
//                                }
//                            }],
//                        legend: {
//                            shadow: false
//                        },
//                        tooltip: {
//                            shared: true
//                        },
//                        series: [{
//                                name: 'TurnOver',
//                                data: data_a,
//                                color: '#146FA7',
//                                tooltip: {
//                                    valuePrefix: '₹',
//                                    valueSuffix: ' M'
//                                },
//                            }, {
//                                name: 'Tax Liability',
//                                data: data_liability,
//                                color: '#B8160E',
//                                tooltip: {
//                                    valuePrefix: '₹',
//                                    valueSuffix: ' M'
//                                },
//                            }, {
//                                type: 'spline',
//                                color: '#5BCB45',
//                                name: 'Ratio',
//                                data: data_ratio,
//                                yAxis: 1,
//                                tooltip: {
//                                    valueSuffix: ' %'
//                                },
//                                plotOptions: {
//                                    spline: {
//                                        dataLabels: {
//                                            enabled: true
//                                        },
//                                        enableMouseTracking: false
//                                    }
//                                },
//                            }]
//                    });
//                }
//            }
//        }
//        );
//
//    }
</script>

