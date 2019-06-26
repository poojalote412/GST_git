<?php
$this->load->view('header');
$this->load->view('navigation');


?>

<div class="main-panel">
        <div class="content-wrapper">
        
            
            <div class="col-12 grid-margin stretch-card">
                
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Turnover Vs Tax Liability</h4>
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
                            </form>
                        <div id="container"></div>
                    </div>
                    
                    
                </div>
                
            </div>
            
            
            
        </div>
    
</div>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script>
    $("#import").click(function (event) {
        var formid = document.getElementById("import_form");
        event.preventDefault();
        $.ajax({
            url: "<?php echo base_url(); ?>GST_CFO_Dashboard/import_excel",
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
            url: "<?= base_url("GST_CFO_Dashboard/get_graph_Turnover_vs_liabality") ?>",
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

