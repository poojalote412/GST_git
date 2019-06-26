<?php
$this->load->view('header');
//$this->load->view('web_rmt/cua_navigation');
//$this->load->view('web_rmt/dashboard_tab');
defined('BASEPATH') OR exit('No direct script access allowed');
?>



<body>
    <div class="container-scroller">
        <!-- partial:../../partials/_navbar.html -->




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
            < <?php $this->load->view('navigation'); ?>
            <!-- partial -->

            <div class="content-wrapper">

                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Turnover Vs Tax Liability</h4>
                            <h4 class="card-title">Avgrund Popup</h4>
                            <p class="card-description">Avgrund simple popup</p>
                            <a href="#" id="show" class="btn btn-outline-danger">Click here!</a>

                            <form class="forms-sample" id="import_form" method="post" name="import_form" enctype="multipart/form-data">


                                <div class="form-group">
                                    <label>File upload</label>
                                    <input type="file" name="file_ex" class="file-upload-default">
                                    <div class="input-group col-xs-6">
                                        <input type="text" class="form-control file-upload-info" name="file_ex" id="file_ex" required accept=".xls, .xlsx" disabled placeholder="Upload File1">

                                        <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-primary"  type="button" >Upload</button>
                                        </span>
                                    </div><br>
                                    <div class="input-group col-xs-6">
                                        <input type="text" class="form-control file-upload-info" name="file_ex1" id="file_ex1" required accept=".xls, .xlsx" disabled placeholder="Upload File2">

                                        <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-primary"  type="button" >Upload</button>
                                        </span>
                                    </div>
                                </div>


                                <button type="button" name="import" id="import" class="btn btn-primary mr-2">Submit</button>
                                <!--<button class="btn btn-light">Cancel</button>-->
                                <button type="button" name="get_graph" id="get_graph" onclick="get_graph_fun();"class="btn btn-info" >Get Graph</button>
                            </form><br>
                            <form method="post" id="table_form" name="table_form" enctype="multipart/form-data">
                                <div class="table-responsive" id="customer_data">

                                </div>
                                <br>


                            </form>
                            <div id="container"></div>
                            <!--<div class="content-wrapper">-->
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Data table</h4>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table id="order-listing" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Order #</th>
                                                            <th>Purchased On</th>
                                                            <th>Customer</th>
                                                            <th>Ship to</th>
                                                            <th>Base Price</th>
                                                            <th>Purchased Price</th>
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>2012/08/03</td>
                                                            <td>Edinburgh</td>
                                                            <td>New York</td>
                                                            <td>$1500</td>
                                                            <td>$3200</td>
                                                            <td>
                                                                <label class="badge badge-info">On hold</label>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-outline-primary">View</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>2</td>
                                                            <td>2015/04/01</td>
                                                            <td>Doe</td>
                                                            <td>Brazil</td>
                                                            <td>$4500</td>
                                                            <td>$7500</td>
                                                            <td>
                                                                <label class="badge badge-danger">Pending</label>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-outline-primary">View</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>3</td>
                                                            <td>2010/11/21</td>
                                                            <td>Sam</td>
                                                            <td>Tokyo</td>
                                                            <td>$2100</td>
                                                            <td>$6300</td>
                                                            <td>
                                                                <label class="badge badge-success">Closed</label>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-outline-primary">View</button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>4</td>
                                                            <td>2016/01/12</td>
                                                            <td>Sam</td>
                                                            <td>Tokyo</td>
                                                            <td>$2100</td>
                                                            <td>$6300</td>
                                                            <td>
                                                                <label class="badge badge-success">Closed</label>
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-outline-primary">View</button>
                                                            </td>
                                                        </tr>


                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- content-wrapper ends -->
                            <!-- partial:../../partials/_footer.html -->
                            <footer class="footer">
                                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                                    <span class="text-center text-sm-left d-block d-sm-inline-block">Copyright © 2018 <a href="https://www.urbanui.com/" target="_blank">Urbanui</a>. All rights reserved.</span>
                                    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="typcn typcn-heart text-danger"></i></span>
                                </div>
                            </footer>
                            <!-- partial -->

                        </div>

                    </div>
                </div>



                <?php $this->load->view('footer'); ?> 
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->
        <!-- base:js -->

        <!-- End custom js for this page-->
</body>



<script>
    $("#import").click(function (event) {
        var formid = document.getElementById("import_form");
        event.preventDefault();
        $.ajax({
            url: "<?php echo base_url(); ?>Turnover_vs_liabality/import_excel",
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

                $('#customer_data').html(data);
            }
        });
    });

    function get_graph_fun()
    {
        $.ajax({
            type: "POST",
            url: "<?= base_url("Turnover_vs_liabality/get_graph_Turnover_vs_liabality") ?>",
            dataType: "json",
            success: function (result) {
                if (result.message === "success") {

                    var data_a = result.data_turn_over;
                    var data_liability = result.data_liability;
                    var data_ratio = result.ratio;
                    Highcharts.chart('container', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Turnover vs Tax Liability'
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
                            ]
                        },
                        yAxis: [{
                                max: 50000000,
                                title: {
                                    text: 'TurnOver'
                                }
                            }, {
                                min: 0,
                                max: 100,
                                opposite: true,
                                title: {
                                    text: 'Ration(in %) of tax liability to turnover'
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
                                color: '#042C77',
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
                                color: '#047736',
                                name: 'Profit',
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
</script>

