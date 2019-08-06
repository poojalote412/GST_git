<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

                <form method="POST"  action="" name="frm_add_customer" id="frm_add_customer" class="form-horizontal" novalidate="novalidate">
                    <div class="form-group"> 
                        <div class="col-md-12">
                            <div class="col-md-4">
                              
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    <input type="hidden" class="form-control" value="<?php echo $insert_id; ?>"disabled=""name="insert_id"  id="insert_id"   aria-required="true" aria-describedby="input_group-error">
                                    <input type="hidden" class="form-control" value="<?php echo $customer_id; ?>"disabled=""name="customer_id"  id="customer_id"   aria-required="true" aria-describedby="input_group-error">
                                  
                                </div>
                                <span class="required" style="color: red" id="customer_name_error"></span>
                            </div>

                           
                        </div>
                    </div>

                </form> 
<div style="page-break-after:always">
    <div id="container1" class="container"></div>
    <!--<div style="page-break-before: always; page-break-after: always; width: 100%; height: 500px;">-->
    <!--<div style="width: 100%; height: 200px"></div>-->

    <div id="container2" class="container"></div>

    <div id="container3" class="container"></div>
    <div id="container4" class="container"></div>
    <div id="container5" class="container"></div>
</div>

<div id="buttonrow">
    <button id="export-png">Export to PNG</button>
    <button id="export-pdf">Export to PDF</button>
</div>

<script>
    /**
     * Create a global getSVG method that takes an array of charts as an
     * argument
     */
    Highcharts.getSVG = function (charts) {
        var svgArr = [],
                top = 0,
                width = 0;

        Highcharts.each(charts, function (chart) {
            var svg = chart.getSVG(),
                    // Get width/height of SVG for export
                    svgWidth = +svg.match(
                            /^<svg[^>]*width\s*=\s*\"?(\d+)\"?[^>]*>/
                            )[1],
                    svgHeight = +svg.match(
                            /^<svg[^>]*height\s*=\s*\"?(\d+)\"?[^>]*>/
                            )[1];

            svg = svg.replace(
                    '<svg',
                    '<g transform="translate(' + width + ', 0 )" '
                    );
            svg = svg.replace('</svg>', '</g>');

            width += svgWidth;
            top = Math.max(top, svgHeight);

            svgArr.push(svg);
        });

        return '<svg height="' + top + '" width="' + width +
                '" version="1.1" xmlns="http://www.w3.org/2000/svg">' +
                svgArr.join('') + '</svg>';
    };

    /**
     * Create a global exportCharts method that takes an array of charts as an
     * argument, and exporting options as the second argument
     */
    Highcharts.exportCharts = function (charts, options) {

        // Merge the options
        options = Highcharts.merge(Highcharts.getOptions().exporting, options);

        // Post to export server
        Highcharts.post(options.url, {
            filename: options.filename || 'chart',
            type: options.type,
            width: options.width,
            svg: Highcharts.getSVG(charts)
        });
    };

    var customer_id = document.getElementById("customer_id").value;
    var insert_id = document.getElementById("insert_id").value;
    var chart1 = Highcharts.chart('container1', {

        chart: {
            events: {
                load: function () {
                    this.renderer.image('https://res.cloudinary.com/dh4xz9esz/image/upload/v1564826945/slide_u8oojb.jpg', 120, 80, 350, 350).add();
                }
            }
        },
        title: {
            text: 'First Image'
        }

    });

    var chart2 = Highcharts.chart('container2', {

        chart: {
            type: 'column',
            height: 200
        },

        title: {
            text: 'Second Chart'
        },

        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
            ]
        },

        series: [{
                data: [176.0, 135.6, 148.5, 216.4, 194.1, 95.6,
                    54.4, 29.9, 71.5, 106.4, 129.2, 144.0
                ],
                colorByPoint: true,
                showInLegend: false
            }],

        exporting: {
            enabled: false, // hide button
        }

    });


    var chart3 = Highcharts.chart('container3', {

        chart: {
            type: 'column',
            height: 200,
            width: 300
        },
        title: {
            text: 'Third Chart',

        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
            ]
        },
        series: [{
                data: [176.0, 135.6, 148.5, 216.4, 194.1, 95.6,
                    54.4, 29.9, 71.5, 106.4, 129.2, 144.0
                ],
                colorByPoint: true,
                showInLegend: false
            }],
        exporting: {
            enabled: false // hide button
        }
    });

    var chart4 = Highcharts.chart('container4', {

        chart: {
            events: {
                load: function () {
                    this.renderer.image('https://res.cloudinary.com/dh4xz9esz/image/upload/v1564826750/sample.jpg', 120, 80, 350, 350).add();
                }
            }
        },
        title: {
            text: 'Fourth Image'
        }

    });
    

    $('#export-png').click(function () {
        Highcharts.exportCharts([chart1, chart2, chart3, chart4]);
    });

    $('#export-pdf').click(function () {
        Highcharts.exportCharts([chart1, chart2, chart3, chart4], {
            type: 'application/pdf'
        });
    });



</script>