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
                <div class="row">
                    <div class="col-xs-4">
                        <label>About Client</label>
                        <input type="text" class="form-control" placeholder="About Client Page Number">
                    </div>
                    <div class="col-xs-4">
                        <label>Executive Summary</label>
                        <input type="text" class="form-control" placeholder="Executive Summary Page Number">
                    </div>
                    <div class="col-xs-4">
                        <label>GST Component & Overview</label>
                        <input type="text" class="form-control" placeholder="GST Component & Overview Page Number">
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-xs-4">
                        <label>GST Framework</label>
                        <input type="text" class="form-control" placeholder="GST Framework Page Number">
                    </div>
                    <div class="col-xs-4">
                        <label>Details Of GST Report & Insight</label>
                        <input type="text" class="form-control" placeholder="Details Of GST Report & Insight Page Number">
                    </div>
                    <div class="col-xs-4">
                        <label>Issue Matrix</label>
                        <input type="text" class="form-control" placeholder="Issue Matrix Page Number">
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-xs-4">
                        <label>Rating Card</label>
                        <input type="text" class="form-control" placeholder="Rating Card Page Number">
                    </div>
                    <div class="col-xs-4">
                        <label>Conclusion</label>
                        <input type="text" class="form-control" placeholder="Conclusion Page Number">
                    </div>
                </div><br>
                <div class="col-xs-2" style="float:right;">
                <button type="button" class="btn btn-block btn-success"  >Success</button>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </section>




</div>
<?php $this->load->view('customer/footer'); ?>

<script>





</script>
