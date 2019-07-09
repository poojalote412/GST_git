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
                    <h4 class="card-title">GSTR-3B VS GSTR-2A</h4>
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal-4" data-whatever="@mdo">Upload New</button> <br><br>
                    <!--<button type="button" name="get_graph" id="get_graph" onclick="get_graph_fun();"class="btn btn-primary mr-2 btn-sm" >Get Graph</button>-->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="order-listing" class="table">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <!--<th>Unique id</th>-->
                                            <th>Customer</th>
                                            <th>View Graph</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
//                                    var_dump($gstr1_vs_3b_data);
                                        if ($gstr1_vs_2a_data !== "") {
                                            $i = 1;
                                            foreach ($gstr1_vs_2a_data as $row) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $row->customer_name; ?></td>
                                                    <!--<td>ANAND RATHI GLOBAL FINANCE LIMITED 2017-18</td>-->
                                                    <td><button type="button" name="get_graph" id="get_graph" onclick="get_graph_fun('<?php echo $row->customer_id; ?>');"class="btn btn-outline-primary" >View</button></td>
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
                            <input type="text" class="form-control file-upload-info" name="file_ex" id="file_ex" required accept=".xls, .xlsx"  placeholder="Upload File">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary"  type="button" >Upload</button>
                            </span>
                            <span class="required" id="file_ex_error" style="color:#e02222;padding-left:4 px"></span>
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

    $("#imports").click(function () {
        var formid = document.getElementById("import_form");

        $.ajax({
            type: "post",
            url: "<?= base_url("Threeb_vs_twoa/import") ?>",
            dataType: "json",
            data: new FormData(formid), //form data
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            //            data: $("#Add_UniversityStudent").serialize(),
            success: function (result) {
//                alert("hgh");
//                 alert(result.error);
                if (result.status === true) {
                    alert('Data Submitted Successfully');
                    // return;
                    location.reload();
                } else if (result.status === false) {
                    alert('something went wrong');
                } else {
//                    alert(result.id);
                    $('#' + result.id + '_error').html(result.error);
//                    $('#message').html(result.error);
                }
            },
            error: function (result) {
                //                console.log(result);
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




    function get_graph_fun(customer_id)
    {
//        alert("ghgh");
        $.ajax({
            type: "POST",
            url: "<?= base_url("Threeb_vs_twoa/get_graph") ?>",
            dataType: "json",
            data: {customer_id: customer_id},
            success: function (result) {
                if (result.message === "success") {

                    var data_a = result.gstr_tb;
                    var data_difference = result.difference;
                    var cumu_difference = result.cumu_difference;
                    var data_gstr2a = result.gstr2a;
                    var max = result.max;
                    var months = result.month_data;
                    Highcharts.chart('container1', {
                        chart: {
                            type: 'Combination chart',
                            type: 'area'
                        },
                        title: {
                            text: 'Comparison Between GSTR-3B & GSTR-2A'
                        },
                        subtitle: {
                            text: 'Customer Name: ANAND RATHI GLOBAL FINANCE LIMITED 2017-18'
                        },
                        xAxis: {
                            categories: months,
                            crosshair: true
                        },
                        yAxis: {
                            //                                            min: 0,
                            max: max,
//                                    tickInterval: 1000000,
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
                            },
                            spline: {
                                pointPadding: 0.1,
                                borderWidth: 0
                            },

                            area: {
                                stacking: 'normal',
                                lineColor: '#FFFF00',
                                lineWidth: 1,
                                color: '#FFFF00',
                                marker: {
                                    lineWidth: 1,
                                    lineColor: '#FFFF00'
                                }
                            }
                        },
                        series: [{
                                type: 'column',
                                name: 'GSTR-3B',
                                data: data_a

                            }, {
                                type: 'column',
                                name: 'GSTR-2A',
                                data: data_gstr2a,
                                lineColor: '#FF8C00',
                                color: '#FF8C00'

                            }, {
                                type: 'spline',
                                name: 'Difference',
                                data: data_difference

                            }, {
                                type: 'area',
                                name: 'Cumulative Difference',
                                data: cumu_difference

                            }, ]
                    });




                }
            }
        });

    }



</script>




