<?php
$this->load->view('header');
//$this->load->view('web_rmt/cua_navigation');
//$this->load->view('web_rmt/dashboard_tab');
defined('BASEPATH') OR exit('No direct script access allowed');
?>



<body>
    <div class="container-scroller">
        <!-- partial:../../partials/_navbar.html -->

        <!--Header-->

        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:../../partials/_settings-panel.html -->
            <div class="theme-setting-wrapper">
                <div id="settings-trigger"><i class="typcn typcn-cog-outline"></i></div>
                <div id="theme-settings" class="settings-panel">
                    <i class="settings-close typcn typcn-delete-outline"></i>
                    <p class="settings-heading">SIDEBAR SKINS</p>
                    <div class="sidebar-bg-options" id="sidebar-light-theme">
                        <div class="img-ss rounded-circle bg-light border mr-3"></div>
                        Light
                    </div>
                    <div class="sidebar-bg-options selected" id="sidebar-dark-theme">
                        <div class="img-ss rounded-circle bg-dark border mr-3"></div>
                        Dark
                    </div>
                    <p class="settings-heading mt-2">HEADER SKINS</p>
                    <div class="color-tiles mx-0 px-4">
                        <div class="tiles success"></div>
                        <div class="tiles warning"></div>
                        <div class="tiles danger"></div>
                        <div class="tiles primary"></div>
                        <div class="tiles info"></div>
                        <div class="tiles dark"></div>
                        <div class="tiles default border"></div>
                    </div>
                </div>
            </div>
            <!-- partial -->
            <!-- partial:../../partials/_sidebar.html -->
<?php $this->load->view('navigation'); ?> 
            <!-- partial -->
            <div class="content-wrapper">

                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">GSTR-3B VS GSTR-2A</h4>

                            <form class="forms-sample" id="import_form" method="post" name="import_form" enctype="multipart/form-data">


                                <div class="form-group">
                                    <label>File upload</label>
                                    <input type="file" name="file_ex" class="file-upload-default">
                                    <div class="input-group col-xs-12">
                                        <input type="text" class="form-control file-upload-info" name="file_ex" id="file_ex" required accept=".xls, .xlsx" disabled placeholder="Upload File">
                                        <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-primary"  type="button" >Upload</button>
                                        </span>
                                    </div>
                                </div>


                                <button type="button" name="imports" id="imports" class="btn btn-primary mr-2">Submit</button>
                                <button class="btn btn-light">Cancel</button>
                            </form><br>
                            <button type="button" name="get_graph" id="get_graph" onclick="get_graph_fun();"class="btn btn-primary mr-2" >Get Graph</button>
                            <div id="container1"></div>
                            <div id="container2"></div>
                        </div>
                    </div>
                </div>
<?php $this->load->view('footer'); ?> 
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>

        <script>

            $("#imports").click(function () {
                var $this = $(this);
                $this.button('loading');
                setTimeout(function () {
                    $this.button('reset');
                }, 2000);

                var formid = document.getElementById("import_form");

                //  var stud_email = $("#stud_email").val();

                $.ajax({
                    type: "post",
                    url: "<?= base_url("GST_3BVs2A/import") ?>",
                    dataType: "json",
                    data: new FormData(formid), //form data
                    processData: false,
                    contentType: false,
                    cache: false,
                    async: false,
                    //            data: $("#Add_UniversityStudent").serialize(),
                    success: function (result) {
                        // alert(result.error);
                        if (result.status === true) {
                            alert('Data Submitted Successfully');
                            // return;
                            location.reload();
                        } else if (result.status === false) {
                            alert('something went wrong')
                        } else {
                            $('#' + result.id + '_error').html(result.error);
                            $('#message').html(result.error);
                        }
                    },
                    error: function (result) {
                        //                console.log(result);
                        if (result.status === 500) {
                            alert('Internal error: ' + result.responseText);
                        } else {
                            alert('Unexpected error.');
                        }
                    }
                });
            });
            function  remove_error(id) {
                $('#' + id + '_error').html("");
            }




            function get_graph_fun()
            {
                //                        alert("ghgh");
                $.ajax({
                    type: "POST",
                    url: "<?= base_url("GST_3BVs2A/get_graph") ?>",
                    dataType: "json",

                    success: function (result) {
                        if (result.message === "success") {

                            var data_a = result.data_gstr3b;
                            //                                    var data_gstr2a = result.data_gstr2a;
                            //                                    var data_gstr_one_ammend_res = result.data_gstr_one_ammend;
                            var data_difference = result.difference;
                            var cumu_difference = result.cumu_difference;
                            var data_gstr2a = result.gstr2a_difference;
                            Highcharts.chart('container1', {
                                chart: {
                                    type: 'Combination chart',
                                    type: 'area'
                                },
                                title: {
                                    text: 'Comparison Between GSTR-3B & GSTR-2A'
                                },
                                subtitle: {
                                    text: 'Customer Name: ANAND RATHI GLOBAL FINANCE LIMITED '
                                },
                                xAxis: {
                                    categories: [
                                        'March',
                                        'February',
                                        'January',
                                        'December',
                                        'November',
                                        'October',
                                        'September',
                                        'August',
                                        'July',
                                        'June',
                                        'May',
                                        'April'
                                    ],
                                    crosshair: true
                                },
                                yAxis: {
                                    //                                            min: 0,
                                    max: 10000000,
                                    tickInterval: 1000000,
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
                                               color:'#FF8C00'
                                        
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




                        }
                    }
                });

            }


        </script>




