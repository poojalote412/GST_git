<?php
$this->load->view('customer/header');
$this->load->view('admin/navigation');
?>
<!--<script src="http://code.highcharts.com/highcharts.js"></script>-->
<script src="<?php base_url() . "/" ?>js/pdf_conversion.js"></script>
<script src="<?php base_url() . "/" ?>js/pdf_conversion2.js"></script>
<style>

</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            DASHBOARD
            <button id="export">Export all</button>
            <!--<small>it all starts here</small>-->
        </h1>

        <!--<button id="cmd">generate PDF</button>-->
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">Blank page</li>

        </ol>
        <div id="container" style="min-width: 310px; height: 400px; max-width: 800px; margin: 0 auto"></div>
        <div id="heat_map_tbl"></div>
    </section>

    <!-- Insert your document here -->

    <!--    <div id="buttons"></div>
        <hr/>
        <div id="JSFiddle">
             Insert your document here 
            <header style="display:none;margin-top:20px;">
                <p>Add your header</p>
            </header>
            <footer style="display:none">
                <p>Add your footer</p>
            </footer>
            <div id="container1" style="height: 500px; width:700px"></div>
    
                    <div style="page-break-before:always;">
                        <div id="container2" style="height: 500px;  width:700px"></div>
                    </div>
            <div style="page-break-before:always;">
                <div id="container" style="height: 500px;  width:700px"></div>
                <div id="cfo_data"></div>
            </div>
        </div>-->



</div>
<?php $this->load->view('customer/footer'); ?>

<script>



    $(document).ready(function () {
        $.ajax({
            type: "post",
            url: "<?= base_url("Report/get_heat_map") ?>",
            dataType: "json",
            data: {customer_id: 'cust_1006', insert_id: 'insert_1001'},
            success: function (result) {
//                 alert();
                $('#heat_map_tbl').html("");
                if (result.message === "success") {

                    var data = result.data;
                    $('#heat_map_tbl').html("");
                    $('#heat_map_tbl').html(data);
                    $('#heat_map_tbl_id').DataTable();
                } else {

                }
            },

        });
        $.ajax({
            type: "post",
            url: "<?= base_url("Report/get_heat_map") ?>",
            dataType: "json",
            data: {customer_id: 'cust_1006', insert_id: 'insert_1001'},
            success: function (result) {
                if (result.message === "success") {
                    var likelihood_impact = result.likelihood_impact;
                    var likelihood_risk = result.likelihood_risk;
                    Highcharts.chart('container', {
                        chart: {
                            type: 'scatter',
                            zoomType: 'xy',
//                            backgroundColor: '#E38B0B',
                        },

                        title: {
                            text: 'ISSUE MATRIX'
                        },
                        subtitle: {
//                            text: 'Source: Heinz  2003'
                        },
                        xAxis: {
                            gridLineWidth: 1,
                            title: {
                                enabled: true,
//                                text: 'Height (cm)'
                            },
                            startOnTick: true,
                            endOnTick: true,
                            showLastLabel: true
                        },
                        yAxis: {
                            gridLineWidth: 1,

                            plotBands: [{// mark the weekend
                                    color: '#74D56F',
                                    from: 0,
                                    to: 6
                                }, {// mark the weekend
                                    color: '#D8D824',
                                    from: 6,
                                    to: 11
                                }, {// mark the weekend
                                    color: '#eb5c3d',
                                    from: 11,
                                    to: 25
                                }],

                        },

                        legend: {
                            layout: 'vertical',
                            align: 'left',
                            verticalAlign: 'top',
                            x: 100,
                            y: 70,
                            floating: true,
                            backgroundColor: Highcharts.defaultOptions.chart.backgroundColor,
                            borderWidth: 1
                        },

                        plotOptions: {
                            scatter: {
                                marker: {
                                    radius: 5,
                                    states: {
                                        hover: {
                                            enabled: true,
                                            lineColor: 'rgb(100,100,100)'
                                        }
                                    }
                                },
                                states: {
                                    hover: {
                                        marker: {
                                            enabled: false
                                        }
                                    }
                                },
                                tooltip: {
                                    headerFormat: '<b>{series.name}</b><br>',
                                    pointFormat: '{point.x} , {point.y} '
                                }
                            }
                        },
                        series: [{
                                name: 'Impact',
                                color: '#1D6AB2',
                                data: likelihood_impact

                            }, {
                                name: 'Risk Score',
                                color: '#C62E2E',
                                data: likelihood_risk
                            }]
                    });
                } else {

                }
            },

        });
        $.ajax({
            type: "POST",
            url: "<?= base_url("Cfo_dashboard/get_graph_Turnover_vs_liabality") ?>",
            dataType: "json",
            data: {customer_id: 'cust_1001', insert_id: 'insert_1001'},
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
    });
    Highcharts.getSVG = function (charts) {
        var svgArr = [],
                top = 0,
                width = 0;

        $.each(charts, function (i, chart) {
            var svg = chart.getSVG();
            svg = svg.replace('<svg', '<g transform="translate(0,' + top + ')" ');
            svg = svg.replace('</svg>', '</g>');

            top += chart.chartHeight;
            width = Math.max(width, chart.chartWidth);

            svgArr.push(svg);
        });

        return '<svg height="' + top + '" width="' + width + '" version="1.1" xmlns="http://www.w3.org/2000/svg">' + svgArr.join('') + '</svg>';
    };

    /**
     * Create a global exportCharts method that takes an array of charts as an argument,
     * and exporting options as the second argument
     */
    Highcharts.exportCharts = function (charts, options) {
        var form
        svg = Highcharts.getSVG(charts);

        // merge the options
        options = Highcharts.merge(Highcharts.getOptions().exporting, options);

        // create the form
        form = Highcharts.createElement('form', {
            method: 'post',
            action: options.url
        }, {
            display: 'none'
        }, document.body);

        // add the values
        Highcharts.each(['filename', 'type', 'width', 'svg'], function (name) {
            Highcharts.createElement('input', {
                type: 'hidden',
                name: name,
                value: {
                    filename: options.filename || 'chart',
                    type: options.type,
                    width: options.width,
                    svg: svg
                }[name]
            }, null, form);
        });
        //console.log(svg); return;
        // submit
        form.submit();

        // clean up
        form.parentNode.removeChild(form);
    };





 
<!-- PDF, Postscript and XPS are set to download as Fiddle (and some browsers) will not embed them -->

    var click = "return xepOnline.Formatter.Format('JSFiddle', {render:'download'})";
    jQuery('#buttons').append('<button onclick="' + click + '">PDF</button>');

</script>
