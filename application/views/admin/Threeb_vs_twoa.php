<?php
$this->load->view('customer/header');
$this->load->view('admin/navigation');


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
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            GSTR-3B VS GSTR-2A
            <!--<small>it all starts here</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <!--            <li><a href="#">Examples</a></li>-->
            <li class="active">GSTR-3B VS GSTR-2A</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <!--                <h3 class="box-title">Customer</h3>-->

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">


                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Customer</th>
                            <th>View Graph</th>
                            <th>View Observations</th>
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
                                    <td><button type="button" name="get_graph" id="get_graph" onclick="get_graph_fun('<?php echo $row->customer_id; ?>', '<?php echo $row->insert_id; ?>');"class="btn btn-outline-primary" >View</button></td>
                                    <td><button type="button" name="get_records" id="get_records" data-customer_id="<?php echo $row->customer_id; ?>" data-insert_id="<?php echo $row->insert_id; ?>"data-toggle="modal" data-target="#view_value_modal"class="btn bg-maroon-gradient" ><i class="fa fa-fw fa-eye"></i></button></td>
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
            <div id="container1"></div>

        </div>

    </section>

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
<div class="modal fade" id="view_value_modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="ModalLabel">Observations</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="forms-sample" id="import_form" method="post" name="import_form" enctype="multipart/form-data">
                    <input type="hidden" id="customer_id" name="customer_id">
                    <input type="hidden" id="insert_id" name="insert_id">
                    <div class="form-group">
                        <div id="compare_3b1_data"></div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>

</div>
<?php $this->load->view('customer/footer'); ?>
<script>
    $(function () {
        $("#example1").DataTable();
        $("#example2").DataTable();
    });
</script>
<script>
//view observation modal
    $('#view_value_modal').on('show.bs.modal', function (e) {
        var customerid = $(e.relatedTarget).data('customer_id');
        var customer_id = document.getElementById('customer_id').value = customerid;
        var insertid = $(e.relatedTarget).data('insert_id');
        var insert_id = document.getElementById('insert_id').value = insertid;
        $.ajax({
            type: "post",
            url: "<?= base_url("Threeb_vs_twoa/get_graph") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                $('#compare_3b1_data').html("");
                if (result.message === "success") {

                    var data = result.data;
                    $('#compare_3b1_data').html("");
                    $('#compare_3b1_data').html(data);
                    $('#example2').DataTable();
                } else {

                }
            },

        });
    });
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




    function get_graph_fun(customer_id, insert_id)
    {
//        alert("ghgh");
        $.ajax({
            type: "POST",
            url: "<?= base_url("Threeb_vs_twoa/get_graph") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id},
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
                        },credits: {
                            enabled: false
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




                }else{
                
                }
            }
        });

    }



</script>




