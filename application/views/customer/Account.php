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
            Accounts Reports
            <!--<small>it all starts here</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">Accounts Reports</li>
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


                                        <th>View Observations</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    <?php
//                                    var_dump($cfo_data);
                                    if ($account_data !== "") {
                                        $i = 1;
                                        foreach ($account_data as $row) {
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row->customer_name; ?></td>

                                                <td><button type="button" name="get_records" id="get_records" data-customer_id="<?php echo $row->customer_id; ?>" data-toggle="modal" data-target="#view_value_modal"class="btn bg-maroon-gradient" ><i class="fa fa-fw fa-eye"></i></button></td>
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
                                <div class="form-group">
                                    <div id="account_monthly_data"></div>

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
        $.ajax({
            type: "post",
            url: "<?= base_url("Account_report/get_graph") ?>",
            dataType: "json",
            data: {customer_id: customer_id},
            success: function (result) {
//                 alert();
                if (result.message === "success") {

                    var data = result.data;
                    $('#account_monthly_data').html("");
                    $('#account_monthly_data').html(data);
                    $('#example2').DataTable();
                } else {

                }
            },

        });
    });


//    $("#imports").click(function () {
//        alert("ujhguj");
//                var $this = $(this);
//                $this.button('loading');
//                setTimeout(function () {
//                    $this.button('reset');
//                }, 2000);
//
//                var formid = document.getElementById("import_form");
//
//                //  var stud_email = $("#stud_email").val();
//
//                $.ajax({
//                    type: "post",
//                    url: "<?= base_url("Account_report/import") ?>",
//                    dataType: "json",
//                    data: new FormData(formid), //form data
//                    processData: false,
//                    contentType: false,
//                    cache: false,
//                    async: false,
//                    //            data: $("#Add_UniversityStudent").serialize(),
//                    success: function (result) {
//                        // alert(result.error);
//                        if (result.status === true) {
//                            alert('Data Submitted Successfully');
//                            // return;
//                            location.reload();
//                        } else if (result.status === false) {
//                            alert('something went wrong')
//                        } else {
//                            $('#' + result.id + '_error').html(result.error);
//                            $('#message').html(result.error);
//                        }
//                    },
//                    error: function (result) {
//                        //                console.log(result);
//                        if (result.status === 500) {
//                            alert('Internal error: ' + result.responseText);
//                        } else {
//                            alert('Unexpected error.');
//                        }
//                    }
//                });
//            });
//            function  remove_error(id) {
//                $('#' + id + '_error').html("");
//            }
</script>
	