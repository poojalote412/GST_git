<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/offline-exporting.js"></script>

<style>
    .container {
        max-width: 600px;
        min-width: 300px;
        margin: 0 auto;
    }

    #buttonrow {
        max-width: 600px;
        min-width: 320px;
        margin: 0 auto;
    }

    .highcharts-axis-line {
        stroke-width: 0;
    }

</style>
<div id="JSFiddle">
    <div style="page-break-before:always;">
        <div id="container3" class="container"></div>
        <div id="container1" class="container"></div>
        <div id="container2" class="container"></div>
    </div>
</div>

<div id="buttonrow">
    <button id="export-png">Export to PNG</button>
    <button id="export-pdf">Export to PDF</button>
</div>

<script>
    /**
     * Create a global getSVG method that takes an array of charts as an argument. The SVG is returned as an argument in the callback.
     */
    Highcharts.getSVG = function (charts, options, callback) {
        var svgArr = [],
                top = 0,
                width = 0,
                addSVG = function (svgres) {
                    // Grab width/height from exported chart
                    var svgWidth = +svgres.match(
                            /^<svg[^>]*width\s*=\s*\"?(\d+)\"?[^>]*>/
                            )[1],
                            svgHeight = +svgres.match(
                                    /^<svg[^>]*height\s*=\s*\"?(\d+)\"?[^>]*>/
                                    )[1],
                            // Offset the position of this chart in the final SVG
                            svg;

                    if (svgWidth > 500) {
                        svg = svgres.replace('<svg', '<g transform="translate(0,' + top + ')" ');
                        top += svgHeight;
                        width = Math.max(width, svgWidth);
                    } else {
                        svg = svgres.replace('<svg', '<g transform="translate(' + width + ', 0 )"');
                        top = Math.max(top, svgHeight);
                        width += svgWidth;
                    }

                    svg = svg.replace('</svg>', '</g>');
                    svgArr.push(svg);
                },
                exportChart = function (i) {
                    if (i === charts.length) {

                        // add SVG image to exported svg
                        addSVG(svgImg.outerHTML);

                        return callback('<svg height="' + top + '" width="' + width +
                                '" version="1.1" xmlns="http://www.w3.org/2000/svg">' + svgArr.join('') + '</svg>');
                    }
                    charts[i].getSVGForLocalExport(options, {}, function (e) {
                        console.log("Failed to get SVG");
                    }, function (svg) {
                        addSVG(svg);
                        return exportChart(i + 1); // Export next only when this SVG is received
                    });
                };

        exportChart(0);
    };

    /**
     * Create a global exportCharts method that takes an array of charts as an argument,
     * and exporting options as the second argument
     */
    Highcharts.exportCharts = function (charts, options) {
        options = Highcharts.merge(Highcharts.getOptions().exporting, options);

        // Get SVG asynchronously and then download the resulting SVG
        Highcharts.getSVG(charts, options, function (svg) {
            Highcharts.downloadSVGLocal(svg, options, function () {
                console.log("Failed to export on client side");
            });
        });
    };

// Set global default options for all charts
    Highcharts.setOptions({
        exporting: {
            fallbackToExportServer: false // Ensure the export happens on the client side or not at all
        }
    });

// Create the charts
    var chart1 = Highcharts.chart('container1', {

        chart: {
            height: 200,
            width: 300,
            type: 'pie'
        },

        title: {
            text: 'First Chart'
        },

        credits: {
            enabled: false
        },

        series: [{
                data: [
                    ['Apples', 5],
                    ['Pears', 9],
                    ['Oranges', 2]
                ]
            }],

        exporting: {
            enabled: false // hide button
        }

    });
    var chart2 = Highcharts.chart('container2', {

        chart: {
            type: 'column',
            height: 200,
            width: 300
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
            enabled: false // hide button
        }
    });

// function that convert image from url to blob
    function toDataURL(url, callback) {
        var xhr = new XMLHttpRequest();
        xhr.onload = function () {
            var reader = new FileReader();
            reader.onloadend = function () {
                callback(reader.result);
            }
            reader.readAsDataURL(xhr.response);
        };
        xhr.open('GET', url);
        xhr.responseType = 'blob';
        xhr.send();
    }


    var svgImg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    svgImg.setAttribute('xmlns:xlink', 'http://www.w3.org/1999/xlink');
    svgImg.setAttribute('height', '400');
    svgImg.setAttribute('width', '600');
    svgImg.setAttribute('id', 'test');

    var svgimg = document.createElementNS('http://www.w3.org/2000/svg', 'image');
    svgimg.setAttribute('height', '400');
    svgimg.setAttribute('width', '600');
    svgimg.setAttribute('id', 'testimg');

// convert image and add to svg image object
    toDataURL('<?= base_url('images/samples/slide.jpg'); ?>', function (dataUrl) {
        svgimg.setAttributeNS('http://www.w3.org/1999/xlink', 'href', dataUrl);
    });

    svgimg.setAttribute('x', '0');
    svgimg.setAttribute('y', '0');
    svgImg.appendChild(svgimg);

// add svg with image to DOM
    document.querySelector('#container3').appendChild(svgImg);


    $('#export-png').click(function () {
        Highcharts.exportCharts([chart1, chart2]);
    });

//    $('#export-pdf').click(function () {
//        Highcharts.exportCharts([chart1, chart2], {
//            type: 'application/pdf'
//        });
//    });

    var click = "return xepOnline.Formatter.Format('JSFiddle', {render:'download'})";
    jQuery('#export-pdf').append('<button onclick="' + click + '">PDF</button>');

</script>