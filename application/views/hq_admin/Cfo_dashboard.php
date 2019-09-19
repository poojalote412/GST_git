<?php
$this->load->view('customer/header');
$this->load->view('hq_admin/navigation');

//Check user login or not using session

if ($session = $this->session->userdata('login_session') == '') {
//take them back to signin 
//    echo 'fghjf';
    redirect(base_url() . 'GST_AdminLogin');
}
$session_data = $this->session->userdata('login_session');
if (is_array($session_data)) {
    $data['session_data'] = $session_data;
//    var_dump($session_data);
    $username = ($session_data['customer_id']);
} else {
    $username = $this->session->userdata('login_session');
}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Turnover Vs Tax Liability
            <!--<small>it all starts here</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">CFO Dashboard</li>
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
                <div class="col-md-4" style="margin-top: 1.5%">
                    <select class="form-control m-select2 m-select2-general" id="ddl_firm_name_fetch" name="ddl_firm_name_fetch" onchange="get_sorted_data(this.value)">
                        <option value="">Select Office</option>
                        <!--<option value="1">All</option>-->
                    </select>
                    <span class="required" id="ddl_firm_name_fetch_error"></span>
                </div>
            </div>
            <div class="box-body">


                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <!--<th>Unique id</th>-->
                            <th>Customer</th>
                            <th>View Graph</th>
                            <th>View Observations</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
//                                    var_dump($cfo_data);
                        if ($cfo_data !== "") {
                            $i = 1;
                            foreach ($cfo_data as $row) {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row->customer_name; ?></td>
                                    <td><button type="button" name="get_graph" id="get_graph" onclick="get_graph_fun('<?php echo $row->customer_id; ?>', '<?php echo $row->insert_id; ?>');"class="btn btn-outline-primary" >View</button></td>
                                    <td><button type="button" name="get_records" id="get_records" data-customer_id="<?php echo $row->customer_id; ?>" data-insert_id="<?php echo $row->insert_id; ?>" data-toggle="modal" data-target="#view_value_modal"class="btn bg-maroon-gradient" ><i class="fa fa-fw fa-eye"></i></button></td>
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
            <div id="container"></div>

        </div>

    </section>

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
                        <div id="cfo_data"></div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="exampleModal-4" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="forms-sample" id="import_form" method="post" name="import_form" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>File upload</label>
                        <input type="file" name="file_ex" class="file-upload-default">
                        <div class="input-group col-xs-6">
                            <input type="file" class="form-control file-upload" name="file_ex" id="file_ex" required accept=".xls, .xlsx"  placeholder="Upload File1">

                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-light"  type="button" >Upload</button>
                            </span>
                        </div><br>
                        <div class="input-group col-xs-6">
                            <input type="file" class="form-control file-upload" name="file_ex1" id="file_ex1" required accept=".xls, .xlsx"  placeholder="Upload File2">

                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-light"  type="button" >Upload</button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" name="import" id="import" class="btn btn-success mr-2">Submit</button>
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

//    //AJAX for get firm name
    $.ajax({
        url: "<?= base_url("Customer_admin/get_ddl_firm_name") ?>",
        dataType: "json",
        success: function (result) {
            if (result['message'] === 'success') {
                var data = result.firm_data;
                var ele3 = document.getElementById('ddl_firm_name_fetch');
                for (i = 0; i < data.length; i++)
                {
                    // POPULATE SELECT ELEMENT WITH JSON.
                    ele3.innerHTML = ele3.innerHTML + '<option value="' + data[i]['firm_id'] + '">' + data[i]['firm_name'] + '</option>';
                }
            }
        }
    });
////    
    //get data of customer firm wise

    function get_sorted_data() {
        var firm_id_fetch = document.getElementById('ddl_firm_name_fetch').value;
        window.location.href = "<?= base_url("Cfo_dashboard/hq_view_customer/") ?>" + firm_id_fetch;

    }

    $('#view_value_modal').on('show.bs.modal', function (e) {
        var customerid = $(e.relatedTarget).data('customer_id');
        var customer_id = document.getElementById('customer_id').value = customerid;
        var insertid = $(e.relatedTarget).data('insert_id');
        var insert_id = document.getElementById('insert_id').value = insertid;
        $.ajax({
            type: "post",
            url: "<?= base_url("Cfo_dashboard/get_graph_Turnover_vs_liabality") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                $('#cfo_data').html("");
                if (result.message === "success") {

                    var data = result.data;
                    $('#cfo_data').html("");
                    $('#cfo_data').html(data);
                    $('#example2').DataTable();
                } else {

                }
            },

        });
    });
    $("#import").click(function (event) {
        var formid = document.getElementById("import_form");
        event.preventDefault();
        $.ajax({

            url: "<?= base_url("Cfo_dashboard/import_excel") ?>",
            type: "POST",
            data: new FormData(formid),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            async: false,
            success: function (result) {
                if (result.status === true) {
                    alert('Data Submitted Successfully');
                    // return;
                    location.reload();
                } else if (result.status === false) {
                    alert('something went wrong');
                } else if (result.message === 'file_missmatch') {
                    alert('You have selected wrong File');
                } else {
                    $('#' + result.id + '_error').html(result.error);
                    $('#message').html(result.error);
                }
            }
        });
    });


//function to get graph view
    function get_graph_fun(customer_id, insert_id)
    {
        $.ajax({
            type: "POST",
            url: "<?= base_url("Cfo_dashboard/get_graph_Turnover_vs_liabality") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {

                    var data_a = result.data_turn_over;
                    var data_liability = result.data_liability;
                    var data_ratio = result.ratio;
                    var data_month = result.month_data;
                    var max_range = result.max_range;
                    var customer_name = "Customer Name:" + result.customer_name;
                    Highcharts.chart('container', {
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
                        }, credits: {
                            enabled: false
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
                            }]
                    });
                }
            }
        }
        );

    }
</script>

