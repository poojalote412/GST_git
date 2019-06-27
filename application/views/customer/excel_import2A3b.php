<!DOCTYPE html>
<html>
    <head>
        <title>How to Import Excel Data into Mysql in Codeigniter</title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>asset/bootstrap.min.css" />
        <script src="<?php echo base_url(); ?>asset/jquery.min.js"></script>

    </head>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>





    <body>
        <div class="container">
            <br />
            <h3 align="center">How to Import Excel Data into Mysql in Codeigniter</h3>
            <form method="post" id="import_form" name="import_form" enctype="multipart/form-data">
                <p><label>Select Excel File</label>
                    <input type="file" name="file_ex" id="file_ex" required accept=".xls, .xlsx" /></p>
                <br />
                <input type="button" name="imports" id="imports" value="import"  class="btn btn-info" />
            </form>
            <br />
            <form method="post" id="table_form" name="table_form" enctype="multipart/form-data">
                <div class="table-responsive" id="customer_data">

                </div>
                <br>
                <div id="btn" name="btn"></div>
                <div id="btn1" name="btn1"></div>
                <button type="button" name="get_graph" id="get_graph" onclick="get_graph_fun();"class="btn btn-info" >Get Graph</button>
            </form>
            <div id="container1"></div>
            <div id="container2"></div>
            <?php // var_dump($result); ?>
        </div>
    </body>
</html>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>

<script>

                    $(document).ready(function () {
                    });

                        $("#imports").click(function (event) {
//                          +
//                           alert("ghjj");
                            var formid = document.getElementById("import_form");
                            event.preventDefault();
                            $.ajax({
                                url: "<?php echo base_url(); ?>Excel_import2A/import",
                                type: "POST",
                                data: new FormData(formid),
                                contentType: false,
                                cache: false,
                                processData: false,
                                async: false,
                                success: function (data) {
                                    var btn = '<button type="button" name="insert_data" id="insert_data" onclick="insert_data_a();"class="btn btn-info" >Store Value</button>';
                                    $('#btn').html(btn);
                                    $('#file_ex').val('');
                                    $('#customer_data').html(data);
                                }
                            });
                        });

                        
                    function insert_data_a() {
//        var formid = document.getElementById("table_form");
                        $.ajax({
                            type: "POST",
                            url: "<?= base_url("Excel_import2A/insert_data") ?>",
                            dataType: "json",
                            data: $("#table_form").serialize(),
                            success: function (result) {
                                if (result.message === "success") {
                                    alert('Data inserted Successfully');
//                    var btn = '<button type="button" name="get_graph" id="get_graph" onclick="get_graph_fun();"class="btn btn-info" >Get Graph</button>';
//                    $('#btn1').html(btn);
//                    location.reload();
                                } else if (result.status === false) {
                                    alert('something went wrong')
                                } else {
                                    $('#' + result.id + '_error').html(result.error);
                                    $('#message').html(result.error);
                                }
                            },
                            error: function (result) {
                                console.log(result);
                                if (result.status === 500) {
                                    alert('Internal error: ' + result.responseText);
                                } else {
                                    alert('Unexpected error.');
                                }
                            }
                        });
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
                                            type: 'column'
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
                                            }
                                        },
                                        series: [{
                                                name: 'GSTR-3B',
                                                data: data_a

                                            },  {
                                                name: 'Difference',
                                                data: data_difference

                                            }, {
                                                name: 'Cumulative Difference',
                                                data: cumu_difference

                                            }, {
                                                name: 'GSTR-2A',
                                                data: data_gstr2a

                                            },]
                                    });


                                }
                            }
                        });

                    }
</script>
