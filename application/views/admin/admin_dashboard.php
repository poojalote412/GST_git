<?php
$this->load->view('customer/header');
$this->load->view('admin/navigation');
?>
<script src="http://code.highcharts.com/highcharts.js"></script>

<script src="http://code.highcharts.com/modules/exporting.js"></script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            DASHBOARD
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
    <header style="display:none;margin-top:20px;"><p>Add your header</p></header>     
    <footer style="display:none"><p>Add your header</p></footer>  
    <div id="container1" style="height: 200px; width:700px"></div>

    <div id="container2" style="height: 200px;  width:700px"></div>



    <div id="container3" style="height: 200px;  width:700px"></div>


    <div id="container4" style="height: 200px;  width:700px"></div>

    <div id="container5" style="height: 200px;  width:700px"></div>




    <button id="export">Export all</button>
</div>
<?php $this->load->view('customer/footer'); ?>

<script>
    /**
     * Create a global getSVG method that takes an array of charts as an argument
     */
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

    var chart1 = new Highcharts.Chart({

        chart: {
            renderTo: 'container1'
        },

        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },

        series: [{
                data: [29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]}]

    });

    var chart2 = new Highcharts.Chart({

        chart: {
            renderTo: 'container2',
            type: 'column'
        },

        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },

        series: [{
                data: [176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4, 29.9, 71.5, 106.4, 129.2, 144.0]}]

    });
    var chart3 = new Highcharts.Chart({

        chart: {
            renderTo: 'container3',
            type: 'column'
        },

        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },

        series: [{
                data: [176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4, 29.9, 71.5, 106.4, 129.2, 144.0]}]

    });
    var chart4 = new Highcharts.Chart({

        chart: {
            renderTo: 'container4',
            type: 'column'
        },

        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },

        series: [{
                data: [176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4, 29.9, 71.5, 106.4, 129.2, 144.0]}]

    });
    var chart5 = new Highcharts.Chart({

        chart: {
            renderTo: 'container5',
            type: 'column'
        },

        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },

        series: [{
                data: [176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4, 29.9, 71.5, 106.4, 129.2, 144.0]}]

    });
    

    $('#export').click(function () {
        var options = {
            pagesplit: true,
            type: "application/pdf",
           
        };
        Highcharts.exportCharts([chart1, chart2, chart3, chart4, chart5], options);
    });
</script>
