<?php
$this->load->view('customer/header');
$this->load->view('customer/navigation');

//Check user login or not using session

if ($session = $this->session->userdata('login_session') == '') {
//take them back to signin 
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
            DASHBOARD
            <!--<small>it all starts here</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">Blank page</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Customer</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">

                <div class="col-md-12">
                    <div class="row">
                        <img src="<?= base_url() ?>/images/sale-month-wise.png" width="600px;" style="margin-right:10%;" alt="logo"/>
                        <img src="<?= base_url() ?>/images/sales-b2b-and-b2c.png" width="600px;" alt="logo"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <img src="<?= base_url() ?>/images/turnover-vs-tax-liabilit (1).png" style="margin-right:10%;" width="600px;" alt="logo"/>
                        <img src="<?= base_url() ?>/images/tax-liability-fy-2017-20.png" width="600px;" alt="logo"/>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.box-body -->
        <!--        <div class="box-footer">
                  Footer
                </div>-->
        <!-- /.box-footer-->

<!-- /.box -->

</section>
<!-- /.content -->
</div>
<!-- /.content>

              

<?php $this->load->view('customer/footer'); ?>