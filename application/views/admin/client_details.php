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
            Reports
            <!--<?php print_r($user_name) ?>-->
                <!--<small>it all starts here</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">Reports</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <form method="POST"  action="" name="frm_add_observations" id="frm_add_observations" class="form-horizontal" novalidate="novalidate">
            <!-- Default box -->
            <div class="box">
                <div class="box-body">

                    <input type="hidden" class="form-control" value="<?php echo $insert_id; ?>"name="insert_id"  id="insert_id"   aria-required="true" aria-describedby="input_group-error">
                    <input type="hidden" class="form-control" value="<?php echo $customer_id; ?>"name="customer_id"  id="customer_id"   aria-required="true" aria-describedby="input_group-error">
                    <div class="form-group"> 
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label>Customer Name:</label><span class="required" aria-required="true"> </span>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control" name="cust_name" value="<?php echo $cust_result->customer_name; ?>"  id="cust_name" onkeyup="remove_error('customer_name')"   aria-required="true" aria-describedby="input_group-error">
                                </div>
                                <span class="required" style="color: red" id="customer_name_error"></span>
                            </div>

                            <div class="col-md-4">
                                <label>Company Name:</label><span class="required" aria-required="true"> </span>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-bank"></i>
                                    </span>
                                    <input type="text" class="form-control" name="company_name"  id="company_name" onkeyup="remove_error('company_name')"   aria-required="true" aria-describedby="input_group-error">
                                </div>
                                <span class="required" style="color: red" id="company_name_error"></span>
                            </div>
                            <div class="col-md-4">
                                <label>Address:</label><span class="required" aria-required="true"> </span>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-map"></i>
                                    </span>
                                    <input type="text" class="form-control" name="address" value="<?php echo $cust_result->customer_address; ?>"  id="address" onkeyup="remove_error('address')"   aria-required="true" aria-describedby="input_group-error">

                                </div>
                                <span class="required" style="color: red" id="address_error"></span>
                            </div>
                        </div>
                        <div class="col-md-12"><br>
                            <div class="">
                                <div class="col-md-4">
                                    <label>Managing Director Name:</label><span class="required" aria-required="true"> </span>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-map"></i>
                                        </span>
                                        <input type="text" class="form-control" name="m_d_name" value=""  id="m_d_name" onkeyup="remove_error('m_d_name')"   aria-required="true" aria-describedby="input_group-error">

                                    </div>
                                    <span class="required" style="color: red" id="m_d_name_error"></span>
                                </div>
                                <div class="col-md-4">
                                    <label>About Company:</label><span class="required" aria-required="true"> </span>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-industry"></i>
                                        </span>
                                        <textarea class="form-control" rows="5" id="about_company" name="about_company"></textarea>
                                    </div>
                                    <span class="required" style="color: red" id="about_company_error"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div>
                <div class="box collapsed-box">
                    <div class="box-header">
                        <h3 class="box-title">TurnOver vs Tax Liability
                            <!--<small>Simple and fast</small>-->
                        </h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-plus"></i></button>
                            <button type="button" class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip"
                                    title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body pad">
                        <div class="col-md-6"> <div id="container" ></div></div>
                        <div class="col-md-6"> <div id="cfo_data"></div></div>
                    </div>
                </div>
                <div class="box collapsed-box">
                    <div class="box-header">
                        <h3 class="box-title">Sales Rate Wise
                            <!--<small>Simple and fast</small>-->
                        </h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-plus"></i></button>
                            <button type="button" class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip"
                                    title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body pad">
                        <div class="col-md-12"> <div id="rate_wise_data"></div></div>
                    </div>
                </div>

                <div class="box collapsed-box">
                    <div class="box-header">
                        <h3 class="box-title">Sales Month Wise
                            <!--<small>Simple and fast</small>-->
                        </h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-plus"></i></button>
                            <button type="button" class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip"
                                    title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body pad">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">  <div id="container1" ></div></div>
                                <div class="col-md-6"> <div id="sales_monthly_data"></div></div></div>
                        </div>
                    </div>
                </div>
                <div class="box collapsed-box">
                    <div class="box-header">
                        <h3 class="box-title">Sale Taxable,Non-Taxable & Exempt
                            <!--<small>Simple and fast</small>-->
                        </h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-plus"></i></button>
                            <button type="button" class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip"
                                    title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body pad">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-4">  <div id="container_nontax_exempt" ></div></div>
                                <div class="col-md-8"> <div id="tax_ntax_Exempt_data"></div></div></div>
                        </div>
                    </div>
                </div>

                <div class="box collapsed-box">
                    <div class="box-header">
                        <h3 class="box-title">Overview of Tax Liability
                            <!--<small>Simple and fast</small>-->
                        </h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-plus"></i></button>
                            <button type="button" class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip"
                                    title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body pad">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">  <div id="container_tax_liability" ></div></div>
                                <div class="col-md-6">   <div id="tax_liability_data"></div></div></div>
                        </div>
                    </div>
                </div>
                <div class="box collapsed-box">
                    <div class="box-header">
                        <h3 class="box-title">Overview of tax turn Over
                            <!--<small>Simple and fast</small>-->
                        </h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-plus"></i></button>
                            <button type="button" class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip"
                                    title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body pad">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">  <div id="container_tax_turnover"></div></div>
                                <div class="col-md-6">   <div id="tax_turnover_data"></div></div></div>
                        </div>
                    </div>
                </div>
                <div class="box collapsed-box">
                    <div class="box-header">
                        <h3 class="box-title">Eligible Ineligible Sales
                            <!--<small>Simple and fast</small>-->
                        </h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-plus"></i></button>
                            <button type="button" class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip"
                                    title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body pad">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">  <div id="container_eligible" ></div></div>
                                <div class="col-md-6">   <div id="eligible_data"></div></div></div>
                        </div>
                    </div>
                </div>
                <div class="box collapsed-box">
                    <div class="box-header">
                        <h3 class="box-title">GSTR-3B vs GSTR-1
                            <!--<small>Simple and fast</small>-->
                        </h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-plus"></i></button>
                            <button type="button" class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip"
                                    title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body pad">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">  <div id="container3b_vs_1" ></div></div>
                                <div class="col-md-6">   <div id="compare_3b1_data"></div><div id="compare_3b1_data1"></div></div></div>
                        </div>
                    </div>
                </div>
                <div class="box collapsed-box">
                    <div class="box-header">
                        <h3 class="box-title">GSTR-3B vs GSTR-2A
                            <!--<small>Simple and fast</small>-->
                        </h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-plus"></i></button>
                            <button type="button" class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip"
                                    title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body pad">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">  <div id="gstr2a_vs1" ></div></div>
                                <div class="col-md-6">   <div id="compare_3b2a_data">
                                    </div><div id="compare_3b2a_data1"></div></div></div>
                        </div>
                    </div>
                </div>
                <div class="box collapsed-box">
                    <div class="box-header">
                        <h3 class="box-title">B2B and B2C sale
                            <!--<small>Simple and fast</small>-->
                        </h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-plus"></i></button>
                            <button type="button" class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip"
                                    title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body pad">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">  <div id="container_b2b_b2c" ></div></div>
                                <div class="col-md-6">   <div id="b2b_b2c_sale"></div> <div id="b2b_b2c_sale1"></div></div></div>
                        </div>
                    </div>
                </div>
                <div class="box collapsed-box">
                    <div class="box-header">
                        <h3 class="box-title">State wise sale
                            <!--<small>Simple and fast</small>-->
                        </h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-plus"></i></button>
                            <button type="button" class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip"
                                    title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body pad">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">  <div id="container_state_wise" ></div></div>
                                <div class="col-md-6">   <div id="location_data"></div></div></div>
                        </div>
                    </div>
                </div>
                <div class="box collapsed-box">
                    <div class="box-header">
                        <h3 class="box-title">Export sale
                            <!--<small>Simple and fast</small>-->
                        </h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-plus"></i></button>
                            <button type="button" class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip"
                                    title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body pad">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">  <div id="container_export" ></div></div>
                                <div class="col-md-6">   <div id="export_sales"></div></div></div>
                        </div>
                    </div>
                </div>
                <div class="box collapsed-box">
                    <div class="box-header">
                        <h3 class="box-title">GSTR Account Details of Due Dates
                            <!--<small>Simple and fast</small>-->
                        </h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-plus"></i></button>
                            <button type="button" class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip"
                                    title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body pad">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">  <div id="account_monthly_data" ></div></div>
                                <div class="col-md-6">   <div id="gstr1_data"></div></div></div>
                        </div>
                    </div>
                </div>
                <div class="box collapsed-box">
                    <div class="box-header">
                        <h3 class="box-title">GST Payable vs Cash
                            <!--<small>Simple and fast</small>-->
                        </h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-plus"></i></button>
                            <button type="button" class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip"
                                    title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body pad">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">  <div id="container_payble_vs_cash" ></div></div>
                                <div class="col-md-6">   <div id="gst_payable_vs_cash_data"></div><div id="gst_payable_vs_cash_data1"></div></div></div>
                        </div>
                    </div>
                </div>
                <div class="box collapsed-box">
                    <div class="box-header">
                        <h3 class="box-title">Invoice Not Included in GSTR-1
                        </h3>
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-plus"></i></button>
                            <button type="button" class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip"
                                    title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body pad">
                        <div class="row">
                            <div class="col-md-12">  <div id="invoce_not_included_data" ></div></div>
                        </div>
                    </div>
                </div>
                <div class="box collapsed-box">
                    <div class="box-header">
                        <h3 class="box-title">Invoice amends in other than original period Analysis
                        </h3>
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-plus"></i></button>
                            <button type="button" class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip"
                                    title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body pad">
                        <div class="row">
                            <div class="col-md-12">  <div id="invoice_ammend_data" ></div></div>
                        </div>
                    </div>
                </div>
                <div class="box collapsed-box">
                    <div class="box-header">
                        <h3 class="box-title">Not in GSTR-2A, but recorded under purchaser's book
                        </h3>
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-plus"></i></button>
                            <button type="button" class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip"
                                    title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body pad">
                        <div class="row">
                            <div class="col-md-12">  <div id="company_all_notin2a_data" ></div></div>
                        </div>
                    </div>
                </div>
                <div class="box collapsed-box">
                    <div class="box-header">
                        <h3 class="box-title"> Not in records, but recorded under GSTR-2A
                        </h3>
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-plus"></i></button>
                            <button type="button" class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip"
                                    title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body pad">
                        <div class="row">
                            <div class="col-md-12">  <div id="company_all_notinrec_data" ></div><div id="company_all_notinrec_data_obs" ></div></div>
                        </div>
                    </div>
                </div>
                <div class="box collapsed-box">
                    <div class="box-header">
                        <h3 class="box-title"> Invoice no., POS and Period mismatch
                        </h3>
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-plus"></i></button>
                            <button type="button" class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip"
                                    title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body pad">
                        <div class="row">
                            <div class="col-md-12">  <div id="company_all_partially_data" ></div></div>
                        </div>
                    </div>
                </div>
                <div class="box box-info">

                    <div class="box-header">
                        <h3 class="box-title"><b>Summary Observation and conclusion</b>
                        </h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                                <i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body pad">

                        <textarea id="editor12" name="editor12" rows="10" style="width: 100%" onkeyup="final_word_count(this.id);remove_error('editor12')"></textarea>
                        <span class="required" style="color: red" id="editor12_error"></span>

                    </div>
                </div>
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title"><b>Issue Matrix</b>
                        </h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button type="button" class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip"
                                    title="Collapse">
                                <i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
                                    title="Remove">
                                <i class="fa fa-times"></i></button>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body pad">
                        <div class="col-md-4">
                            <img src="<?= base_url() ?>/images/IssueMatrix.jpg" style="width: 100%;" >
                        </div>
                        <div class="col-md-8">
                            <div class="col-md-9">
                                <label>Time over-run resulting into penalties.</label>
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <h5>Likelihood</h5>
                                        <select class="form-control select2" id="range_issue_matrix1" onchange="remove_error('range_issue_matrix1')" name="range_issue_matrix1">
                                            <option selected="selected">Select Option</option>
                                        </select>
                                        <span class="required" style="color: red" id="range_issue_matrix1_error"></span>
                                    </div>
                                    <div class="col-md-4">
                                        <h5>Impact</h5>
                                        <select class="form-control select2" id="range_issue_matrix12" onchange="remove_error('range_issue_matrix12')" name="range_issue_matrix12">
                                            <option selected="selected">Select Option</option>
                                        </select>
                                        <span class="required" style="color: red" id="range_issue_matrix12_error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <label>Lack of Internal control management leads to interest penalties GST Notices, inefficient working capital management.</label>
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <h5>Likelihood</h5>
                                        <select class="form-control select2" id="range_issue_matrix2" onchange="remove_error('range_issue_matrix2')" name="range_issue_matrix2">
                                            <option selected="selected">Select Option</option>
                                        </select>
                                        <span class="required" style="color: red" id="range_issue_matrix2_error"></span>
                                    </div>
                                    <div class="col-md-4">
                                        <h5>Impact</h5>
                                        <select class="form-control select2" id="range_issue_matrix22" onchange="remove_error('range_issue_matrix22')" name="range_issue_matrix22">
                                            <option selected="selected">Select Option</option>
                                        </select>
                                        <span class="required" style="color: red" id="range_issue_matrix22_error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">

                                <label>Mismatches of transactions leads to loss of ITC, Interest, Liability or GST Notices</label>
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <h5>Likelihood</h5>
                                        <select class="form-control select2" id="range_issue_matrix3" onchange="remove_error('range_issue_matrix3')" name="range_issue_matrix3">
                                            <option selected="selected">Select Option</option>
                                        </select>
                                        <span class="required" style="color: red" id="range_issue_matrix3_error"></span>
                                    </div>
                                    <div class="col-md-4">
                                        <h5>Impact</h5>
                                        <select class="form-control select2" id="range_issue_matrix32" onchange="remove_error('range_issue_matrix32')" name="range_issue_matrix32">
                                            <option selected="selected">Select Option</option>
                                        </select>
                                        <span class="required" style="color: red" id="range_issue_matrix32_error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <label>Deviation in ITC after comparing GSTR-3B vs 2A </label>
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <h5>Likelihood</h5>
                                        <select class="form-control select2" id="range_issue_matrix4" onchange="remove_error('range_issue_matrix4')" name="range_issue_matrix4">
                                            <option selected="selected">Select Option</option>
                                        </select>
                                        <span class="required" style="color: red" id="range_issue_matrix4_error"></span>
                                    </div>
                                    <div class="col-md-4">
                                        <h5>Impact</h5>
                                        <select class="form-control select2" id="range_issue_matrix42" onchange="remove_error('range_issue_matrix42')" name="range_issue_matrix42">
                                            <option selected="selected">Select Option</option>
                                        </select>
                                        <span class="required" style="color: red" id="range_issue_matrix42_error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <label>Deviation in output liability after comparing GSTR-3B vs GSTR-1.</label>
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <h5>Likelihood</h5>
                                        <select class="form-control select2" id="range_issue_matrix5" onchange="remove_error('range_issue_matrix5')" name="range_issue_matrix5">
                                            <option selected="selected">Select Option</option>
                                        </select>
                                        <span class="required" style="color: red" id="range_issue_matrix5_error"></span>
                                    </div>
                                    <div class="col-md-4">
                                        <h5>Impact</h5>
                                        <select class="form-control select2" id="range_issue_matrix52" onchange="remove_error('range_issue_matrix52')" name="range_issue_matrix52">
                                            <option selected="selected">Select Option</option>
                                        </select>
                                        <span class="required" style="color: red" id="range_issue_matrix52_error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <label>GST Payable in cash.</label>
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <h5>Likelihood</h5>
                                        <select class="form-control select2" id="range_issue_matrix6" onchange="remove_error('range_issue_matrix6')" name="range_issue_matrix6">
                                            <option selected="selected">Select Option</option>
                                        </select>
                                        <span class="required" style="color: red" id="range_issue_matrix6_error"></span>
                                    </div>
                                    <div class="col-md-4">
                                        <h5>Impact</h5>
                                        <select class="form-control select2" id="range_issue_matrix62" onchange="remove_error('range_issue_matrix62')" name="range_issue_matrix62">
                                            <option selected="selected">Select Option</option>
                                        </select>
                                        <span class="required" style="color: red" id="range_issue_matrix62_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions" align="center"><br>
                <div class="row" >
                    <div  class="col-md-12" >
                        <button type="button"  id="save_info" name="save_info" class="btn btn-primary btn-block"  >Save</button>
                    </div>
                </div>
            </div>
        </form> 
</div>

</div>




</section>



</div>

<?php $this->load->view('customer/footer'); ?>

<script>
    $(function () {
        $("#example3").DataTable();
        $("#example_invoice_not_include").DataTable();
        $("#example_ammend").DataTable();
        $("#example_not_in_2a").DataTable();
        $("#example_not_in_rec").DataTable();


        var $select1 = $("#range_issue_matrix1");
        var $select2 = $("#range_issue_matrix2");
        var $select3 = $("#range_issue_matrix3");
        var $select4 = $("#range_issue_matrix4");
        var $select5 = $("#range_issue_matrix5");
        var $select6 = $("#range_issue_matrix6");
        var $select7 = $("#range_issue_matrix12");
        var $select8 = $("#range_issue_matrix22");
        var $select9 = $("#range_issue_matrix32");
        var $select10 = $("#range_issue_matrix42");
        var $select11 = $("#range_issue_matrix52");
        var $select12 = $("#range_issue_matrix62");
        for (i = 1; i <= 25; i++) {
            $select1.append($('<option></option>').val(i).html(i));
            $select2.append($('<option></option>').val(i).html(i));
            $select3.append($('<option></option>').val(i).html(i));
            $select4.append($('<option></option>').val(i).html(i));
            $select5.append($('<option></option>').val(i).html(i));
            $select6.append($('<option></option>').val(i).html(i));
            $select7.append($('<option></option>').val(i).html(i));
            $select8.append($('<option></option>').val(i).html(i));
            $select9.append($('<option></option>').val(i).html(i));
            $select10.append($('<option></option>').val(i).html(i));
            $select11.append($('<option></option>').val(i).html(i));
            $select12.append($('<option></option>').val(i).html(i));

        }

    });
</script>
<script>

    $("#save_info").click(function () {
        var customer_id = document.getElementById("customer_id").value;
        var insert_id = document.getElementById("insert_id").value;
        $.ajax({
            type: "POST",
            url: "<?= base_url("Customer_admin/save_observation") ?>",
            dataType: "json",
            data: $("#frm_add_observations").serialize(),
            success: function (result) {
                console.log(result);
                if (result.status === true) {
//                    document.getElementById('loaders1').style.display = "none";
                    alert('Information Added successfully');

                    window.location.href = "<?= base_url() ?>Generate_report/" + customer_id + "/" + insert_id;
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

    function countWords(id) {
        s = document.getElementById(id).value;
        s = s.replace(/(^\s*)|(\s*$)/gi, "");
        s = s.replace(/[ ]{2,}/gi, " ");
        s = s.replace(/\n /, "\n");
        var g = s.split(' ').length;
        if (g > 150)
        {
            alert('only 150 words allow.');
        } else {
        }
    }

    function final_word_count(id) {
        s = document.getElementById(id).value;
        s = s.replace(/(^\s*)|(\s*$)/gi, "");
        s = s.replace(/[ ]{2,}/gi, " ");
        s = s.replace(/\n /, "\n");
        var g = s.split(' ').length;
        if (g > 600)
        {
            alert('only 600 words allow.');
        } else {
        }
    }
    $(document).ready(function () {


        var customer_id = document.getElementById("customer_id").value;
        var insert_id = document.getElementById("insert_id").value;

        $.ajax({
            type: "post",
            url: "<?= base_url("Report/get_content_pdf1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                $('#content_pdf').html("");
                if (result.message === "success") {

                    var data = result.data;
                    $('#content_pdf').html("");
                    $('#content_pdf').html(data);
//                    $('#example2').DataTable();
                } else {

                }
            },
        });
        $.ajax({
            type: "post",
            url: "<?= base_url("Cfo_dashboard/get_graph_Turnover_vs_liabality1") ?>",
            dataType: "json",
//            processData: false,
//            contentType: false,
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                $('#cfo_data').html("");
                if (result.message === "success") {

                    var data = result.data;
                    $('#cfo_data').html("");
                    $('#cfo_data').html(data);
//                    $('#example2').DataTable();
                } else {

                }
            },
        });
        $.ajax({
            type: "POST",
            url: "<?= base_url("Cfo_dashboard/get_graph_Turnover_vs_liabality1") ?>",
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
                    var chart = Highcharts.chart('container', {
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
                            }],
                    });
//                    chart.setTitle({
//                        useHTML: true,
//                        text: " <img src='<?= base_url() ?>/images/sale-month-wise.png' width='60px;' style='margin-right:10%;' alt='logo'/>" + "Test Title"
//                    });

                } else {
                    $('#container').html("");
                    $('#container').html("<b>Please insert files to see result of turnover vs tax liabilty.</b>");
                }
            }
        });
        $.ajax({
            type: "POST",
            url: "<?= base_url("Management_report/get_graph_sales_month_wise1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {

                    var taxable_supply = result.taxable_supply_arr;
                    var data_month = result.month_data;
                    var max_range = result.max_range;
                    var sales_percent_values = result.sales_percent_values;
                    var customer_name = "Customer Name:" + result.customer_name;
                    Highcharts.chart('container1', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Sale Month Wise'
                        },
                        subtitle: {
                            text: customer_name
                        },
                        xAxis: {
                            categories: data_month
                        },
                        yAxis: [{
                                max: max_range,
                                title: {
                                    text: 'Supply Values'
                                }
                            }, {
                                min: 0,
                                max: 100,
                                opposite: true,
                                title: {
                                    text: 'Sales(in %)'
                                }
                            }],
                        legend: {
                            shadow: false
                        },
                        tooltip: {
                            shared: true
                        },
                        series: [{
                                type: 'column',
                                name: 'Sales Month Wise',
                                data: taxable_supply,
                                color: '#87CEEB',
                                tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                },
                            }, {
                                type: 'spline',
                                color: '#AE72E4',
                                name: 'Ratio of Sales',
                                data: sales_percent_values,
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
                            }, ]
                    });
                } else {
                    $('#container1').html("");
                    $('#container1').html("<b>Please insert files to see result.</b>");
                }
            }
        });
        $.ajax({
            type: "post",
            url: "<?= base_url("Management_report/get_graph_sales_month_wise1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                $('#sales_monthly_data').html("");
                if (result.message === "success") {

                    var data = result.data;
                    $('#sales_monthly_data').html(data);
//                    $('#example2').DataTable();
                } else {

                }
            },
        });
        $.ajax({
            type: "post",
            url: "<?= base_url("Management_report/get_graph_state_wise1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                if (result.message === "success") {

                    var data = result.data;
//                    $('#location_data').html("");
                    $('#sales_state_wise_data').html(data);
//                    $('#example2').DataTable();
                } else {

                }
            },
        });
        //graph for sale tax and non-taxable exempt
        $.ajax({
            type: "POST",
            url: "<?= base_url("Management_report/get_graph_taxable_nontx_exempt1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {

                    var taxable_supply = result.taxable_supply_arr;
                    var sub_total_non_gst = result.sub_total_non_gst_arr;
                    var sub_total_exempt = result.sub_total_exempt_arr;
                    var ratio_taxable_supply = result.ratio_taxable_supply;
                    var ratio_subtotal_nongst = result.ratio_subtotal_nongst;
                    var ratio_subtotal_exempt = result.ratio_subtotal_exempt;
                    var data_month = result.month_data;
                    var max_range = result.max_range;
                    var customer_name = "Customer Name:" + result.customer_name;
                    Highcharts.chart('container_nontax_exempt', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Sale Taxable,Non-Taxable & Exempt'
                        },
                        subtitle: {
                            text: customer_name
                        },
                        xAxis: {
                            categories: data_month
                        },
                        yAxis: [{
                                max: max_range,
                                title: {
                                    text: 'Supply Values'
                                }
                            }, {
                                min: 0,
                                max: 100,
                                opposite: true,
                                title: {
                                    text: 'Ratio(in %)'
                                }
                            }],
                        legend: {
                            shadow: false
                        },
                        tooltip: {
                            shared: true
                        },
                        series: [{
                                name: 'Taxable Supply',
                                data: taxable_supply,
                                color: '#146FA7',
                                tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                },
                            }, {
                                name: 'Exempt Supply',
                                data: sub_total_exempt,
                                color: '#B8160E',
                                tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                }, }, {
                                name: 'Non-GST Supply',
                                data: sub_total_non_gst,
                                color: '#5BCB45',
                                tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                },
                            },
                            {
                                type: 'spline',
                                color: '#AE72E4',
                                name: 'Ratio of Taxable supply by Total supply',
                                data: ratio_taxable_supply,
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
                            }, {
                                type: 'spline',
                                color: '#0ACAF0',
                                name: 'Ratio of Exempt Supply by Total supply',
                                data: ratio_subtotal_exempt,
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
                            }, {
                                type: 'spline',
                                color: '#FAC127',
                                name: 'Ratio of Non-GST supply by Total supply',
                                data: ratio_subtotal_nongst,
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
                } else {
                    $('#container_nontax_exempt').html("");
                    $('#container_nontax_exempt').html("<b>Please insert files to see result.</b>");
                }
            }
        });
        //observation table for sale tax and non-taxable exempt
        $.ajax({
            type: "post",
            url: "<?= base_url("Management_report/get_graph_taxable_nontx_exempt1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                $('#tax_ntax_Exempt_data').html("");
                if (result.message === "success") {

                    var data = result.data;
                    $('#tax_ntax_Exempt_data').html(data);
//                    $('#example2').DataTable();
                } else {

                }
            },
        });
//tax liabilty
        $.ajax({
            type: "POST",
            url: "<?= base_url("Internal_acc_report/get_graph1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {

                    var data_outwards = result.data_outward;
                    var data_rcbs = result.data_rcb;
                    var data_inelligibles = result.data_inelligible;
                    var data_rtcs = result.new_net_rtc;
                    var data_paid_credit = result.data_paid_credit;
                    var data_paid_cash = result.data_paid_cash;
                    var data_late_fee = result.data_late_fee;
                    var data_month = result.month_data;
                    var customer_name = "Customer Name:" + result.customer_name;
                    Highcharts.chart('container_tax_liability', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Tax Liability'
                        },
                        subtitle: {
                            text: customer_name
                        },
                        xAxis: {
                            categories: data_month,
                            crosshair: true
                        },
                        yAxis: {
                            min: 0,
//                            max: 100000,                           
                            title: {
                                text: 'Rupees (millions)'
                            },
//                            stackLabels: {
//                                enabled: true,
//                                style: {
//                                    fontWeight: 'bold',
//                                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
//                                }
//                            }

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
                                stacking: 'normal',
                                pointPadding: 0.1,
                                borderWidth: 0,
                            },
                            area: {
                                stacking: 'normal',
                                lineColor: '#FFFF00',
                                lineWidth: 3,
                                color: '#FFFF00',
                                marker: {
                                    lineWidth: 1,
                                    lineColor: '#FFFF00'
                                }
                            }
                        },
                        series: [{

                                type: 'column',
                                name: 'Outward Liability',
                                data: data_outwards,
                                stack: data_outwards,
                                lineColor: '#87ceeb',
                                color: '#87ceeb'


                            }, {
                                type: 'column',
                                name: 'RCB Liability',
                                data: data_rcbs,
                                stack: data_outwards,
                                lineColor: '#000000',
                                color: '#000000'


                            }, {
                                type: 'column',
                                name: 'Ineligible ITC',
                                stack: data_inelligibles,
                                data: data_inelligibles,
                                lineColor: '#228B22',
                                color: '#228B22'

                            }, {
                                type: 'column',
                                name: 'NET ITC',
                                stack: data_inelligibles,
                                data: data_rtcs,
                                lineColor: '#FF8300',
                                color: '#FF8300'

                            }, {
                                type: 'column',
                                name: 'Paid in Credit',
                                data: data_paid_credit,
                                stack: data_paid_credit,
                                lineColor: '#0078D7',
                                color: '#0078D7'

                            }, {
                                type: 'column',
                                name: 'Paid in Cash',
                                data: data_paid_cash,
                                stack: data_paid_credit,
                                lineColor: '#e75480',
                                color: '#e75480'

                            }, {
                                type: 'column',
                                name: 'Interest Late Fee',
                                data: data_late_fee,
                                lineColor: '#FFFF00',
                                color: '#FFFF00'
                            }, ]
                    });
                } else {
                    $('#container_tax_liability').html("");
                    $('#container_tax_liability').html("<b>Please insert files to see result.</b>");
                }
            }
        });
        $.ajax({
            type: "post",
            url: "<?= base_url("Internal_acc_report/get_graph1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                $('#tax_liability_data').html("");
                if (result.message === "success") {

                    var data = result.data;
                    $('#tax_liability_data').html(data);
                    $('#example2').DataTable();
                } else {

                }
            },
        });
//rate wise data
        $.ajax({
            type: "post",
            url: "<?= base_url("Management_report/get_data_rate_wise1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {

                    var data = result.data;
                    $('#rate_wise_data').html("");
                    $('#rate_wise_data').html(data);
//                    $('#example2').DataTable();
                } else {
                    $('#rate_wise_data').html("");
                    $('#rate_wise_data').html("<b>Please insert files to see result.</b>");
                }
            },
        });
//tax turnover
        $.ajax({
            type: "POST",
            url: "<?= base_url("Internal_acc_report/get_graph_tax_turnover1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {

                    var taxable_value = result.taxable_value;
                    var tax_value = result.tax_value;
                    var tax_ratio = result.tax_ratio;
                    var data_month = result.month_data;
                    var max_range = result.max_range;
                    var customer_name = "Customer Name:" + result.customer_name;
                    Highcharts.chart('container_tax_turnover', {
                        chart: {
                            type: 'Combination chart'
                        },
                        title: {
                            text: 'Tax Turnover'
                        },
                        plotOptions: {
                            column: {
                                stacking: 'normal',
                                pointPadding: 0.1,
                                borderWidth: 0,
                            },
                            spline: {
                                pointPadding: 0.1,
                                borderWidth: 0
                            },
                            area: {
                                stacking: 'normal',
                                lineColor: '#FFFF00',
                                lineWidth: 3,
                                color: '#FFFF00',
                                marker: {
                                    lineWidth: 1,
                                    lineColor: '#FFFF00'
                                }
                            }
                        },
                        subtitle: {
                            text: customer_name
                        },
                        xAxis: {
                            categories: data_month
                        },
                        yAxis: [{
                                max: max_range,
                                title: {
                                    text: 'Tax Values'
                                }
                            }, {
                                min: 0,
                                max: 100,
                                opposite: true,
                                title: {
                                    text: 'Ratio(in %)'
                                }
                            }],
                        legend: {
                            shadow: false
                        },
                        tooltip: {
                            shared: true
                        },
                        series: [{
                                type: 'column',
                                name: 'Tax Value',
                                data: tax_value,
                                stack: taxable_value,
                                color: '#AA381E',
                                tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                },
                            }, {
                                type: 'column',
                                name: 'Taxable Value',
                                data: taxable_value,
                                color: '#4D6FB0',
                                stack: taxable_value,
                                tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                },
                            }, {
                                type: 'spline',
                                name: 'Tax ratio',
                                data: tax_ratio,
//                                stack: taxable_value,
                                color: '#078436',
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
                            }, ]
                    });
                } else {
                    $('#container_tax_turnover').html("");
                    $('#container_tax_turnover').html("<b>Please insert files to see result.</b>");
                }
            }
        });
        $.ajax({
            type: "post",
            url: "<?= base_url("Internal_acc_report/get_graph_tax_turnover1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                $('#tax_turnover_data').html("");
                if (result.message === "success") {
                    var data = result.data;
                    $('#tax_turnover_data').html(data);
//                    $('#example2').DataTable();
                } else {

                }
            },
        });
//eligible and ineligible data
        $.ajax({
            type: "POST",
            url: "<?= base_url("Internal_acc_report/get_graph_eligible_ineligible1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {

                    var ineligible_itc = result.ineligible_itc;
                    var net_itc = result.net_itc;
                    var ineligible_ratio = result.ineligible_ratio;
                    var eligible_ratio = result.eligible_ratio;
                    var data_month = result.month_data;
                    var max_range = result.max_range;
                    var customer_name = "Customer Name:" + result.customer_name;
                    Highcharts.chart('container_eligible', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Eligible and Ineligible Credit'
                        },
                        subtitle: {
                            text: customer_name
                        },
                        xAxis: {
                            categories: data_month
                        },
                        yAxis: [{

                                max: max_range,
                                title: {
                                    text: 'Sales'
                                }
                            }, {
//                                min: 0,
                                max: 100,
                                opposite: true,
                                title: {
                                    text: 'Ratio(in %) '
                                }
                            }],
                        legend: {
                            shadow: false
                        },
                        tooltip: {
                            shared: true
                        },
                        series: [{
                                type: 'column',
                                name: ' Ineligible ITC',
                                data: ineligible_itc,
                                color: '#146FA7',
                                tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                }
                            }, {
                                type: 'column',
                                name: 'Eligible ITC',
                                data: net_itc,
                                color: '#B8160E',
                                tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                }
                            }, {
                                type: 'spline',
                                color: '#5BCB45',
                                name: 'Ratio Of Ineligible ITC to total ITC',
                                data: ineligible_ratio,
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
                                }
                            }, {
                                type: 'spline',
                                color: '#B596E7',
                                name: 'Ratio of Eligible ITC to Total ITC',
                                data: eligible_ratio,
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
                                }
                            }]
                    });
                } else {
                    $('#container_eligible').html("");
                    $('#container_eligible').html("<b>Please insert files to see result.</b>");
                }
            }
        });
        $.ajax({
            type: "post",
            url: "<?= base_url("Internal_acc_report/get_graph_eligible_ineligible1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                $('#eligible_data').html("");
                if (result.message === "success") {

                    var data = result.data;
                    $('#eligible_data').html(data);
//                    $('#example2').DataTable();
                } else {

                }
            },
        });
//GSTR-3B vs GSTR-1
        $.ajax({
            type: "POST",
            url: "<?= base_url("Threeb_vs_one/get_graph") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {

                    var data_a = result.data_gstr3b;
                    var data_gstr1_res = result.data_gstr1;
                    var data_difference = result.difference;
                    var cumu_difference = result.cumu_difference;
                    var max = result.max;
                    var month = result.month_data;
                    var customer_name = "Customer Name:" + result.customer_name;
                    Highcharts.chart('container3b_vs_1', {
                        chart: {
                            type: 'Combination chart'
                        },
                        title: {
                            text: 'Comparison Between GSTR-3B & GSTR-1'
                        },
                        subtitle: {
                            text: customer_name
                        },
                        xAxis: {
                            categories: month,
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
                } else {
                    $('#container3b_vs_1').html("");
                    $('#container3b_vs_1').html("<b>Please insert files to see result.</b>");
                }
            }
        });
        $.ajax({
            type: "post",
            url: "<?= base_url("Threeb_vs_one/get_graph") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                $('#compare_3b1_data1').html("");
                $('#compare_3b1_data').html("");
                if (result.message === "success") {

                    var data = result.data;
                    var data1 = result.data1;
                    $('#compare_3b1_data').html("");
                    $('#compare_3b1_data').html(data);
                    $('#compare_3b1_data1').html(data1);
                    $('#example2').DataTable();
                } else {

                }
            },

        });
//GSTR-1 vs GSTR-2A
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
                    Highcharts.chart('gstr2a_vs1', {
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
                } else {
                    $('#gstr2a_vs1').html("");
                    $('#gstr2a_vs1').html("<b>Please insert files to see result.</b>");
                }
            }
        });
        $.ajax({
            type: "post",
            url: "<?= base_url("Threeb_vs_twoa/get_graph_with_observation") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                $('#compare_3b2a_data').html("");
                $('#compare_3b2a_data1').html("");
                if (result.message === "success") {

                    var data = result.data;
                    var data1 = result.data1;
                    $('#compare_3b2a_data').html("");
                    $('#compare_3b2a_data').html(data);
                    $('#compare_3b2a_data1').html(data1);
                    $('#compare_3b2a_data1').prepend("<labale><b>Less: In-Eligible Credit:</b></lable> <input type='number' id='less_in_credit' name='less_in_credit' value='a'>");
                    $('#example2').DataTable();
                } else {
                  
                }
            },

        });

//B2B and B2C Sale
        $.ajax({
            type: "POST",
            url: "<?= base_url("Management_report/get_graph_b2b") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {
                    var array_b2b = result.array_b2b;
                    var array_b2c = result.array_b2c;
                    var array_b2b_ratio = result.array_b2b_ratio;
                    var array_b2c_ratio = result.array_b2c_ratio;
                    var max = result.max_range;
                    var customer_name = "Customer Name:" + result.customer_name;
//                    var max_ratio = result.max_ratio;
                    var data_month = result.month;
                    Highcharts.chart('container_b2b_b2c', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: ' Sales B2B and B2C'
                        },
                        subtitle: {
                            text: customer_name
                        },
                        xAxis: {
                            categories: data_month
                        },
                        yAxis: [{

//                                max: max,
                                title: {
                                    text: 'Sales'
                                }
                            }, {
                                min: 0,
//                                max: 100,
                                opposite: true,
                                title: {
                                    text: 'Ratio(in %) '
                                }
                            }],
                        legend: {
                            shadow: false
                        },
                        tooltip: {
                            shared: true
                        },
                        series: [{
                                type: 'column',
                                name: 'Sale B2B',
                                data: array_b2b,
                                color: '#146FA7',
                                tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                }
                            }, {
                                type: 'column',
                                name: 'Sale B2C',
                                data: array_b2c,
                                color: '#B8160E',
                                tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                }
                            }, {
                                type: 'spline',
                                color: '#5BCB45',
                                name: 'Ratio of sales B2B to total sales',
                                data: array_b2b_ratio,
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
                                }
                            }, {
                                type: 'spline',
                                color: '#B596E7',
                                name: 'Ratio of B2C to total sales',
                                data: array_b2c_ratio,
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
                                }
                            }]
                    });
                } else {
                    $('#container_b2b_b2c').html("");
                    $('#container_b2b_b2c').html("<b>Please insert files to see result.</b>");
                }
            }
        });
        $.ajax({
            type: "post",
            url: "<?= base_url("Management_report/get_graph_b2b") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                if (result.message === "success") {

                    var data = result.data;
                    var data1 = result.data1;
                    $('#b2b_b2c_sale').html("");
                    $('#b2b_b2c_sale1').html("");
                    $('#b2b_b2c_sale').html(data);
                    $('#b2b_b2c_sale1').html(data1);
                    $('#example2').DataTable();
                } else {

                }
            },

        });
//state wise sale
        $.ajax({
            type: "POST",
            url: "<?= base_url("Management_report/get_graph_state_wise") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {

                    var data_a = result.taxable_value;
                    var max_range = result.data_liability;
                    var data_state = result.state;
                    var customer_name = "Customer Name:" + result.customer_name;
                    Highcharts.chart('container_state_wise', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Sales Satewise'
                        },
                        subtitle: {
                            text: customer_name,
                        },
                        xAxis: {
                            categories: data_state
                        },
                        yAxis: [{
                                max: max_range,
                                title: {
                                    text: 'Taxable Values'
                                }
                            }, ],
                        legend: {
                            shadow: false
                        },
                        tooltip: {
                            shared: true
                        },
                        series: [{
                                name: 'States',
                                data: data_a,
                                color: '#146FA7',
                                tooltip: {
                                    valuePrefix: '₹',
                                },
                            }]
                    });
                } else {
                    $('#container_state_wise').html("");
                    $('#container_state_wise').html("<b>Please insert files to see result.</b>");
                }
            }
        });
        $.ajax({
            type: "post",
            url: "<?= base_url("Management_report/get_graph_state_wise") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                if (result.message === "success") {

                    var data = result.data;
                    $('#location_data').html("");
                    $('#location_data').html(data);
                    $('#example2').DataTable();
                } else {

                }
            },

        });
//export sale
        $.ajax({
            type: "POST",
            url: "<?= base_url("Management_report/get_graph_exports") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {

                    var taxable_supply = result.taxable_supply_arr;
                    var data_month = result.month_data;
                    var max_range = result.max_range;
                    var sales_percent_values = result.sales_percent_values;
                    var customer_name = "Customer Name:" + result.customer_name;
                    Highcharts.chart('container_export', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Sale Month Wise'
                        },
                        subtitle: {
                            text: customer_name
                        },
                        xAxis: {
                            categories: data_month
                        },
                        yAxis: [{
                                max: max_range,
                                title: {
                                    text: 'Supply Values'
                                }
                            }, {
                                min: 0,
                                max: 100,
                                opposite: true,
                                title: {
                                    text: 'Sales(in %)'
                                }
                            }],
                        legend: {
                            shadow: false
                        },
                        tooltip: {
                            shared: true
                        },
                        series: [{
                                type: 'column',
                                name: 'Sales Month Wise',
                                data: taxable_supply,
                                color: '#098569',
                                tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                },
                            }, {
                                type: 'spline',
                                color: '#A91408',
                                name: 'Ratio of Sales',
                                data: sales_percent_values,
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
                            }, ]
                    });
                }
            }
        });
        $.ajax({
            type: "post",
            url: "<?= base_url("Management_report/get_graph_exports") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                if (result.message === "success") {

                    var data = result.data;
                    $('#export_sales').html("");
                    $('#export_sales').html(data);
                    $('#example2').DataTable();
                } else {

                }
            },

        });
//gstr due dates
        $.ajax({
            type: "post",
            url: "<?= base_url("Account_report/get_graph") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                $('#account_monthly_data').html("");
                if (result.message === "success") {
                    var data = result.data;
                    $('#account_monthly_data').html(data);
                    $('#example1').DataTable();
                } else {
                    $('#account_monthly_data').html("");
                    $('#account_monthly_data').html("<b>Please insert files to see result.</b>");

                }
            },

        });
        $.ajax({
            type: "post",
            url: "<?= base_url("Account_report/get_gstr1_details") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert(data);
                $('#gstr1_data').html("");
                if (result.message === "success") {
                    var data = result.data;
                    $('#gstr1_data').html(data);
                    $('#example2').DataTable();
                } else {
                    $('#gstr1_data').html("");
                    $('#gstr1_data').html("<b>Please insert files to see result.</b>");
                }
            },

        });
//GST payable vs cash
        $.ajax({
            type: "POST",
            url: "<?= base_url("Internal_acc_report/get_graph_gst_payable_vs_cash") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {

                    var liability = result.liability;
                    var net_itc = result.net_itc;
                    var paid_in_cash = result.paid_in_cash;
                    var percent = result.percent;
                    var data_month = result.month_data;
                    var max_range = result.max_range;
                    var customer_name = "Customer Name:" + result.customer_name;
                    Highcharts.chart('container_payble_vs_cash', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'GST Payable vs Cash'
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
                                    text: 'Percentage(%) paid in cash'
                                }
                            }],
                        legend: {
                            shadow: false
                        },
                        tooltip: {
                            shared: true
                        },
                        series: [{
                                name: 'Tax Liability',
                                data: liability,
                                color: '#146FA7',
                                tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                },
                            }, {
                                name: 'ITC',
                                data: net_itc,
                                color: '#B8160E',
                                tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                },
                            }, {
                                name: 'Paid in Cash',
                                data: paid_in_cash,
                                color: '#36BE69',
                                tooltip: {
                                    valuePrefix: '₹',
                                    valueSuffix: ' M'
                                },
                            }, {
                                type: 'spline',
                                color: '#F9AB58',
                                name: 'Percentage paid in cash',
                                data: percent,
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
                } else {
                    $('#container_payble_vs_cash').html("");
                    $('#container_payble_vs_cash').html("<b>Please insert files to see result.</b>");
                }
            }
        });
        $.ajax({
            type: "post",
            url: "<?= base_url("Internal_acc_report/get_graph_gst_payable_vs_cash") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                $('#gst_payable_vs_cash_data').html("");
                $('#gst_payable_vs_cash_data1').html("");
                if (result.message === "success") {

                    var data = result.data;
                    var data1 = result.data1;
                    $('#gst_payable_vs_cash_data').html("");
                    $('#gst_payable_vs_cash_data1').html("");
                    $('#gst_payable_vs_cash_data').html(data);
                    $('#gst_payable_vs_cash_data1').html(data1);
                    $('#example2').DataTable();
                } else {

                }
            },

        });
//invoice not included
        $.ajax({
            type: "post",
            url: "<?= base_url("Invoice_comp_report/get_table_data1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.status === true) {
                    $('#invoce_not_included_data').html("");
                    var data = result.data;
                    $('#invoce_not_included_data').html(data);
                    $('#example_invoice_not_include').DataTable();
                } else {
                    $('#invoce_not_included_data').html("");
                    $('#invoce_not_included_data').html("<b>Please insert files to see result.</b>");
                }
            },

        });
//invoce ammendment data
        $.ajax({
            type: "post",
            url: "<?= base_url("Invoice_comp_report/get_table_data_ammend1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.status === true) {
                    var data = result.data;

                    $('#invoice_ammend_data').html(data);
                    $('#example_ammend').DataTable();
                } else {
                    $('#invoice_ammend_data').html("");
                    $('#company_data').html("<b>Please insert files to see result.</b>");

                }
            },

        });
//gstr not in 2a
        $.ajax({
            type: "post",
            url: "<?= base_url("Invoice_comp_report/get_not_in2a_records_details1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.status === true) {
                    var data = result.data;

                    $('#company_all_notin2a_data').html(data);
                    $('#example_not_in_2a').DataTable();
                } else {
                    $('#company_all_notin2a_data').html("");
                    $('#company_all_notin2a_data').html("<b>Please insert files to see result.</b>");
                }
            }

        });
//not in records
        $.ajax({
            type: "post",
            url: "<?= base_url("Invoice_comp_report/get_not_inrec_records_all") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.status === true) {
                    var data = result.data;
                    var data1 = result.data1;

                    $('#company_all_notinrec_data').html(data);
                    $('#company_all_notinrec_data_obs').html(data1);
                    $('#example_not_in_rec').DataTable();
                } else {
                    $('#company_all_notinrec_data').html("");
                    $('#company_all_notinrec_data').html("<b>Please insert files to see result.</b>");
//                    alert('no data available.please insert files.');
                }
            }

        });
//partially matched records
        $.ajax({
            type: "post",
            url: "<?= base_url("Invoice_comp_report/get_all_partial_records1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.status === true) {
                    var data = result.data;

                    $('#company_all_partially_data').html(data);
                    $('#example_partial').DataTable();
                } else {
                    $('#company_all_partially_data').html("");
                    $('#company_all_partially_data').html("<b>Please insert files to see result.</b>");
                }
            }

        });

    });



    function  remove_error(id) {
        $('#' + id + '_error').html("");
    }
//    function copy_to_final(id)
//    {
//        var txt = document.getElementById("cfo_observation").value;
//        var box = $("#editor1");
//        box.val(box.val() + txt);
//    }


</script>



