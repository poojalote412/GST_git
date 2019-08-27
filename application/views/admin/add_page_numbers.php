<?php
$this->load->view('customer/header');
$this->load->view('admin/navigation');
?>
<!--<script src="http://code.highcharts.com/highcharts.js"></script>-->
<script src="<?php base_url() . "/" ?>js/pdf_conversion.js"></script>
<script src="<?php base_url() . "/" ?>js/pdf_conversion2.js"></script>
<style>
    .info {
        background-color: #e7f3fe;
        border-left: 6px solid #2196F3;
    }

</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Add Page Numbers

 <!--<small>it all starts here</small>-->
        </h1>

        <!--<button id="cmd">generate PDF</button>-->
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Add page Numbers</li>

        </ol><br>
        <div class="box box-danger">

            <div class="box-header with-border">
                <h3 class="box-title">Page Numbers</h3><br><br>
                <div class="info">
                    <p><h4>Previous Downloaded PDF file do not contains index Page.if you want index page please fill out Page Numbers by referring downloaded PDF.</h4></p>
                </div>
            </div>
            <div class="box-body">
                <form method="POST"  action="" name="add_page_num" id="add_page_num" class="form-horizontal" novalidate="novalidate">
                    <input type="hidden" id="customer_id" name="customer_id" value="<?php echo $customer_id ?>">
                    <input type="hidden" id="insert_id" name="insert_id" value="<?php echo $insert_id ?>">
                    <div class="row">
                        <div class="col-xs-4">
                            <label>About Client</label>
                            <input type="number" id="about_client" name="about_client" onkeyup="remove_error(this.id)"class="form-control" placeholder="About Client Page Number">
                            <span class="required" style="color: red" id="about_client_error"></span>
                        </div>
                        <div class="col-xs-4">
                            <label>Executive Summary</label>
                            <input type="number" id="exe_sum" name="exe_sum" class="form-control" onkeyup="remove_error(this.id)" placeholder="Executive Summary Page Number">
                            <span class="required" style="color: red" id="exe_sum_error"></span>
                        </div>
                        <div class="col-xs-4">
                            <label>GST Component & Overview</label>
                            <input type="number" id="gst_cmp_overview" name="gst_cmp_overview" onkeyup="remove_error(this.id)" class="form-control" placeholder="GST Component & Overview Page Number">
                            <span class="required" style="color: red" id="gst_cmp_overview_error"></span>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-xs-4">
                            <label>GST Framework</label>
                            <input type="number" id="gst_framework" name="gst_framework" onkeyup="remove_error(this.id)" class="form-control" placeholder="GST Framework Page Number">
                            <span class="required" style="color: red" id="gst_framework_error"></span>
                        </div>
                        <div class="col-xs-4">
                            <label>Details Of GST Report & Insight</label>
                            <input type="number" id="gst_report_insight" name="gst_report_insight" onkeyup="remove_error(this.id)" class="form-control" placeholder="Details Of GST Report & Insight Page Number">
                            <span class="required" style="color: red" id="gst_report_insight_error"></span>
                        </div>
                        <div class="col-xs-4">
                            <label>Issue Matrix</label>
                            <input type="number" id="issue_matrix" name="issue_matrix" class="form-control" onkeyup="remove_error(this.id)" placeholder="Issue Matrix Page Number">
                            <span class="required" style="color: red" id="issue_matrix_error"></span>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-xs-4">
                            <label>Rating Card</label>
                            <input type="number" id="report_card" name="report_card" class="form-control" onkeyup="remove_error(this.id)" placeholder="Rating Card Page Number">
                            <span class="required" style="color: red" id="report_card_error"></span>
                        </div>
                        <div class="col-xs-4">
                            <label>Conclusion</label>
                            <input type="number" id="conclusion" name="conclusion" class="form-control" onkeyup="remove_error(this.id)" placeholder="Conclusion Page Number">
                            <span class="required" style="color: red" id="conclusion_error"></span>
                        </div>
                    </div><br>
                    <div class="col-xs-2" style="float:right;">
                        <button type="button" id="save_page_numbers" name="save_page_numbers" class="btn btn-block btn-success"  >Save</button>
                    </div>
                </form>
            </div>
            <!-- /.box-body -->
        </div>
    </section>




</div>
<?php $this->load->view('customer/footer'); ?>

<script>


    function  remove_error(id) {
        $('#' + id + '_error').html("");
    }
    $("#save_page_numbers").click(function () {
        var customer_id = document.getElementById("customer_id").value;
        var insert_id = document.getElementById("insert_id").value;
        $.ajax({
            type: "POST",
            url: "<?= base_url("Report/save_page_numbers") ?>",
            dataType: "json",
            data: $("#add_page_num").serialize(),
            success: function (result) {
                if (result.status === true) {
//                    document.getElementById('loaders1').style.display = "none";
                    alert('Page Numbers Added successfully');

                    window.location.href = "<?= base_url() ?>Generate_report_with_page_num/" + btoa(customer_id) + "/" + btoa(insert_id);
                } else {
//                    document.getElementById('loaders1').style.display = "none";
//                    $('#message').html(result.error);
                    $('#' + result.id + '_error').html(result.error);
                    $(window).scrollTop($('#' + result.id).offset().top);
                }
            },
            error: function (result) {
                //console.log(result);
                if (result.status === 500) {
//                    document.getElementById('loaders1').style.display = "none";
                    alert('Internal error: ' + result.responseText);
                } else {
//                    document.getElementById('loaders1').style.display = "none";
                    alert('Unexpected error.');
                }
            }
        });
    });

</script>
