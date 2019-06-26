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
                    <input type="file" name="file_ex" id="file_ex" required accept=".xls, .xlsx" />
                    <input type="file" name="file_ex1" id="file_ex1" required accept=".xls, .xlsx" />
                </p>
                <br />
                <input type="button" name="import" id="import" value="import"  class="btn btn-info" />
            </form>
            <br />
            <form method="post" id="table_form" name="table_form" enctype="multipart/form-data">
                <div class="table-responsive" id="customer_data">

                </div>
                <br>

                <button type="button" name="get_graph" id="get_graph" onclick="get_graph_fun();"class="btn btn-info" >Get Graph</button>
            </form>
            <div id="container"></div>
            <?php // var_dump($result); ?>
        </div>
    </body>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
</html>

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
                                                }
                                            }]
                                    });
                                }
                            }
                        }
                        );

                    }
</script>
