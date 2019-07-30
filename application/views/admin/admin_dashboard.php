<?php
$this->load->view('customer/header');
$this->load->view('admin/navigation');
?>
<!--<script src="http://code.highcharts.com/highcharts.js"></script>-->
<script src="<?php base_url() . "/" ?>js/pdf_conversion.js"></script>
<script src="<?php base_url() . "/" ?>js/pdf_conversion2.js"></script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            DASHBOARD
            <!--<button id="export">Export all</button>-->
            <!--<small>it all starts here</small>-->
        </h1>

        <!--<button id="cmd">generate PDF</button>-->
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">Blank page</li>

        </ol>
    </section>

    <!-- Insert your document here -->

    <div id="buttons"></div>
    <hr/>
    <div id="JSFiddle">
        <!-- Insert your document here -->
        <header  style="display:none;margin-top:20px;">
            <p>Add your header</p>
        </header>
        <footer style="display:none">
            <p>Add your footer</p>
        </footer>
        <!--<div id="container1" style="height: 500px; width:700px"></div>-->

        <!--        <div style="page-break-before:always;">
                    <div id="container2" style="height: 500px;  width:700px"></div>
                </div>-->
        <div style="page-break-before:always;">
            <div id="container" style="height: 500px;  width:700px"></div>
            <div id="cfo_data"></div>
        </div>
    </div>



</div>
<?php $this->load->view('customer/footer'); ?>

<script>
    $(document).ready(function () {
        $.ajax({
            type: "post",
            url: "<?= base_url("Cfo_dashboard/get_graph_Turnover_vs_liabality") ?>",
            dataType: "json",
            data: {customer_id: 'cust_1007', insert_id: 'insert_1003'},
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
            data: {customer_id: 'Cust_1007', insert_id: 'insert_1003'},
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
