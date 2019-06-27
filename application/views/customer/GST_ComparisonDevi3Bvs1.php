<?php
$this->load->view('customer/header');
$this->load->view('customer/navigation');
?>



<div class="main-panel"> 
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">GSTR-3B VS GSTR-1</h4>
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

        <div class="col-lg-12 grid-margin stretch-card ">
            <div id="excel-data"  style="display: none;">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Excel Data</h4>
                        <p class="card-description">
                            Report <code>.GSTR-3B VS GSTR-1</code>
                        </p>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>

                                        <th>
                                            Month
                                        </th>
                                        <th>
                                            GSTR-3B
                                        </th>
                                        <th>
                                            GSTR-1
                                        </th>
                                        <th>
                                            GSTR-1 Ammend
                                        </th>
                                        <th>
                                            Difference
                                        </th>
                                        <th>
                                            Cummulative Difference
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
//
                                    if ($data !== '') {
                                        foreach ($data as $row) {
                                            ?>
                                            <tr>

                                                <td><?php echo $row->month; ?></td>
                                                <td><?php echo $row->gstr_tb; ?></td>
                                                <td><?php echo $row->gstr_one; ?></td>
                                                <td><?php echo $row->gstr_one_ammend; ?></td>
                                                <td><?php echo $row->difference; ?></td>
                                                <td><?php echo $row->cumu_difference; ?></td>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tr>




                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>




    </div>

</div>
<?php $this->load->view('customer/footer'); ?>





<script>


    $("#imports").click(function () {

//        alert("helloooo");
//        var $this = $(this);
//        $this.button('loading');
//        setTimeout(function () {
//            $this.button('reset');
//        }, 2000);

        var formid = document.getElementById("import_form");

        $.ajax({
            type: "post",
            url: "<?= base_url("GST_3BVs1/import") ?>",
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
                    alert(data);
//                      $('.excel-data').html(data);
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


//    $("#historylist").show();
//        $("#excel-data").show();
//        display: none;

    });
//      $("#excel-data").show();
    function  remove_error(id) {
        $('#' + id + '_error').html("");
    }


//    

    function get_graph_fun()
    {
        $.ajax({
            type: "POST",
            url: "<?= base_url("GST_3BVs1/get_graph") ?>",
            dataType: "json",

            success: function (result) {
                if (result.message === "success") {

                    var data_a = result.data_gstr3b;
                    var data_gstr1_res = result.data_gstr1;
                    var data_difference = result.difference;
                    var cumu_difference = result.cumu_difference;
                    var max = result.max;
                    Highcharts.chart('container1', {
                        chart: {
                            type: 'Combination chart'
                        },
                        title: {
                            text: 'Comparison Between GSTR-3B & GSTR-1'
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
                            min: 0,
                            max: max,
//                            tickInterval: 1000,
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
                                pointPadding: 0.2,
                                borderWidth: 0
                            }
                        },
                        series: [{
                                type: 'column',
                                name: 'GSTR-3B',
                                data: data_a

                            }, {
                                type: 'column',
                                name: 'GSTR-1',
                                data: data_gstr1_res,
                                lineColor: '#A9A9A9',
                                color: '#A9A9A9'

                            }, {
                                type: 'spline',
                                name: 'Difference',
                                data: data_difference,
                                lineColor: '#2271B3',
                                color: '#2271B3'

                            }, {
                                type: 'column',
                                name: 'Cumulative Difference',
                                data: cumu_difference,
                                lineColor: '#87cefa',
                                color: '#87cefa'

                            }]
                    });
                }
            }
        });

    }

</script>