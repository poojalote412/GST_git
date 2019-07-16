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
            Partially Match Records
            <!--<small>it all starts here</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">Partially Match Records</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">  </h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div><br>
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
                        if ($partial_data !== "") {
                            $i = 1;
                            foreach ($partial_data as $row) {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row->customer_name; ?></td>
                                    <td>
                                        <a type="button" class="btn btn-default" name="get_records" id="get_records" onclick="get_records_partial_match('<?php echo $row->customer_id; ?>');"><i class="fa fa-eye"></i> view</a>
                                        <!--<button type="button" name="get_records" id="get_records" onclick="get_records_not_in_2a('<?php echo $row->customer_id; ?>');"class="btn btn-app" >View</button>-->
                                    </td>
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
            <hr>
            <div class="box-body">
                <div id="company_data"></div>
            </div> 

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
<div class="modal fade" id="partial_records_data_modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="ModalLabel">Not In 2A Records</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="forms-sample" id="compant_form" method="post" name="company_form" enctype="multipart/form-data">
                    <input type="hidden" id="company_name" name="company_name">
                    <input type="hidden" id="customer_id" name="customer_id">
                    <input type="hidden" id="insert_id" name="insert_id">
                    <div id="not_in2a_data"></div>
                </form>
            </div>
            <div class="modal-footer">
                <!--                <button type="button" name="import" id="import" class="btn btn-success">Submit</button>-->
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

    function get_records_partial_match(customer_id)
    {
        $.ajax({
            type: "post",
            url: "<?= base_url("Invoice_comp_report/get_table_company_partially_match") ?>",
            dataType: "json",
            data: {customer_id: customer_id},
            success: function (result) {
                if (result.status === true) {
                    var data = result.data;
                    $('#company_data').html("");
                    $('#company_data').html(data);
                    $('#example2').DataTable();
                } else {

                }
            },

        });
    }
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
    function get_graph_fun(customer_id)
    {
        $.ajax({
            type: "POST",
            url: "<?= base_url("Cfo_dashboard/get_graph_Turnover_vs_liabality") ?>",
            dataType: "json",
            data: {customer_id: customer_id},
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
    //get modal for comapany detail
    $('#partial_records_data_modal').on('show.bs.modal', function (e) {
        var companyname = $(e.relatedTarget).data('company_name');
        var company_name = document.getElementById('company_name').value = companyname;
        var customerid = $(e.relatedTarget).data('customer_id');
        var customer_id = document.getElementById('customer_id').value = customerid;
        var insertid = $(e.relatedTarget).data('insert_id');
        var insert_id = document.getElementById('insert_id').value = insertid;
        $.ajax({
            type: "post",
            url: "<?= base_url("Invoice_comp_report/get_partial_records") ?>",
            dataType: "json",
            data: {company_name: company_name, customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.status === true) {
                    var data = result.data;
                    $('#not_in2a_data').html("");
                    $('#not_in2a_data').html(data);
                    $('#example3').DataTable();
                } else {

                }
            },

        });
    });
</script>

