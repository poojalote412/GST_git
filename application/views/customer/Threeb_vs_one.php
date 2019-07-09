<?php
$this->load->view('customer/header');
$this->load->view('customer/navigation');

//Check user login or not using session

if ($session = $this->session->userdata('login_session') == '') {
//take them back to signin 
//    echo 'fghjf';
    redirect(base_url() . 'GST_AdminLogin');
}
$session_data = $this->session->userdata('login_session');
if (is_array($session_data)) {
    $data['session_data'] = $session_data;
    $username = ($session_data['customer_id']);
} else {
    $username = $this->session->userdata('login_session');
}
?>


<div class="main-panel"> 
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">GSTR-3B VS GSTR-1</h4>
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal-4" data-whatever="@mdo">Upload New</button><br><br>
                    <!--<button type="button" name="get_graph" id="get_graph" onclick="get_graph_fun();"class="btn btn-primary mr-2 btn-sm" >Get Graph</button> <br><br>-->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="order-listing" class="table">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Unique id</th>
                                            <th>Customer</th>
                                            <th>View Graph</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
//                                    var_dump($gstr1_vs_3b_data);
                                        if ($gstr1_vs_3b_data !== "") {
                                            $i = 1;
                                            foreach ($gstr1_vs_3b_data as $row) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $row->compare_id; ?></td>
                                                    <td>ANAND RATHI GLOBAL FINANCE LIMITED 2017-18</td>
                                                    <td><button type="button" name="get_graph" id="get_graph" onclick="get_graph_fun('<?php echo $row->compare_id; ?>');"class="btn btn-outline-primary" >View</button></td>
                                                </tr> 
                                                <?php
                                                $i++;
                                            }
                                        } else {
                                            
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="container1"></div>
                </div>   
            </div>   
        </div>   

        <div class="col-lg-12 grid-margin stretch-card ">

        </div>




    </div>

</div>


<div class="modal fade" id="exampleModal-4" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">New File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
                </form><br>
            </div>
            <div class="modal-footer">
                <button type="button" name="imports" id="imports" class="btn btn-info mr-2">Submit</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>

</div>
<?php $this->load->view('customer/footer'); ?>





<script>

// function to upload new 
    $("#imports").click(function () {
        var formid = document.getElementById("import_form");

        $.ajax({
            type: "post",
            url: "<?= base_url("Threeb_vs_one/import") ?>",
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

    });
    function  remove_error(id) {
        $('#' + id + '_error').html("");
    }


    // function to display graph
    function get_graph_fun(cmpr_id)
    {
        $.ajax({
            type: "POST",
            url: "<?= base_url("Threeb_vs_one/get_graph") ?>",
            dataType: "json",
            data:{cmpr_id:cmpr_id},
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
                            text: 'Customer Name: ANAND RATHI GLOBAL FINANCE LIMITED 2017-18 '
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