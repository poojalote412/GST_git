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
<style>

    #JSFiddle{
        font-family:Arial Sans Serif;
    }

    #btn_pdf {
        width: 60%;
        margin-right: 20% !important;
        margin-top: 2.5% !important;
        margin-left: 20% !important;
    }
    #btn_div {
        margin-right: 20% !important;
        margin-left: 20% !important;
        width: 60%;
        /*border:1px solid black;*/
        height:100px;
    }


    .page-break {
        page-break-after: always;
        page-break-inside: avoid;
        clear:both;
    }
    .page-break-before {
        page-break-before: always;
        page-break-inside: avoid;
        clear:both;
    }
    /*    #JSFiddle{
            position: absolute; 
            left: 20px; 
            top: 50px; 
            bottom: 0; 
            overflow: auto; 
            width: 600px;
        }*/

    td{
        text-align: left;
        padding-left:  1%;     
    }
    th{
        text-align: left;
        padding-left:  1%; 

    }
    table{
        font-family:Arial narrow;
        font-size: 15px;
    }



    /*    #JSFiddle div:not(:empty):before {
      display: block;
      content: attr(data-label);
    }*/



</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Reports With Page Numbers
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

        <?php
        $page_num = $company_details->page_numbers;
        $exp = explode(",", $page_num);
        $about_client_page_num = $exp[0];
        $gst_compo_page_num = $exp[1];
        $framework_page_num = $exp[2];
        $approach_page_num = $exp[3];
        $details_rep_page_num = $exp[4];
         $executive_summary_page_num = $exp[5];
        $issue_matrix_page_num = $exp[6]; //repated first
        $rating_card_page_num = $exp[7]; //repated second
        $conclusion_page_num = $exp[8];
       $limited_usage_disclosure = $exp[9];
        $disclaimer_page_num = $exp[10];
        $about_ecovis_page_num = $exp[11];
        ?>
        <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <form method="POST" enctype="multipart/form-data" action="" name="frm_add_customer" id="frm_add_customer" class="form-horizontal" novalidate="novalidate">
                    <div class="form-group"> 
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <label>Customer Name</label><span class="required" aria-required="true"> </span>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    <input type="hidden" class="form-control" value="<?php echo $insert_id; ?>"disabled=""name="insert_id"  id="insert_id"   aria-required="true" aria-describedby="input_group-error">
                                    <input type="hidden" class="form-control" value="<?php echo $customer_id; ?>"disabled=""name="customer_id"  id="customer_id"   aria-required="true" aria-describedby="input_group-error">
                                    <input type="hidden" class="form-control" value="<?php echo $client_details->company_name; ?>"disabled=""name="company_name"  id="company_name"   aria-required="true" aria-describedby="input_group-error">
                                    <input type="text" class="form-control" value="<?php echo $customer_details->customer_name ?>"  disabled=""name="cust_name"  id="cust_name" onkeyup="remove_error('customer_name')"   aria-required="true" aria-describedby="input_group-error">

                                </div>
                                <span class="required" style="color: red" id="customer_name_error"></span>
                            </div>

                            <div class="col-md-4">
                                <label>Financial Year </label><span class="required" aria-required="true"> </span>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control" value="<?php echo $insert_header_details->year_id; ?>"  disabled=""name="year_id"  id="year_id" onkeyup="remove_error('customer_name')"   aria-required="true" aria-describedby="input_group-error">

                                </div>
                                <span class="required" style="color: red" id="customer_name_error"></span>
                            </div>
                            <div class="row" style="float:right;margin-top: 2.5%">
                             <div class="col-md-12" >
                            <input type="button" class="btn btn-primary" id="file_location_database"  data-target="#exampleModal-4" data-toggle="modal" value="Save file location" style="" onclick="" />
                            <input type="button" class="btn btn-primary" value="Convert PDF Into word" onclick="window.open('https://smallpdf.com/pdf-to-word')" />
                            </div>
                            </div>
                        </div>


                    </div>
                    <input type="hidden" id="first_div_value" name="first_div_value" value="0">
                    <input type="hidden" id="second_div_value" name="second_div_value" value="0">
                    <input type="hidden" id="third_div_value" name="third_div_value" value="0">
                    <input type="hidden" id="fourth_div_value" name="fourth_div_value" value="0">
                    <input type="hidden" id="visible_customer_detail" name="visible_customer_detail" value="<?php echo $company_details->visible_customer_detail ?>">
                    <!--<input type="text" id="fifth_div_value" name="fifth_div_value" value="0">-->
                    <!--<div class="btn btn-success"><a href="https://smallpdf.com/pdf-to-word">Convert Downloaded PDF Into word</a></div>-->

                </form> 
                <div id="buttons"></div>
                <hr/>

                <div id="JSFiddle" class="page-break-before page-break" style="">
                    <!-- Insert your document here -->
                    <div id="container_image_front" style="page-break-after:always;position: relative;color: white;margin-top:-22px;margin-left: -15px;margin-right: -25px;">
                         <!--<img src="https://premisafe.com/Logo.jpg" width="120px" height="30px">-->
                        <div style="position: absolute;bottom: -4%;margin-left:5% !important;color: white;text-align: center;width: 700px;"> 
                            <b style="font-size: 26px;text-transform: uppercase"><?php
                                if ($company_details->visible_customer_detail == 1) {
                                    echo $report_details->company_name;
                                } else {
                                    echo "XXX";
                                }
                                ?></b> <br>
                        </div>
                        <div style="position: absolute;bottom: -10%;color: white;width: 700px;text-align: center;margin-left:5% !important;" class="centered"> 
                            <br>  <b style="font-size: 20px">Financial Year: &nbsp;<?php echo $insert_header_details->year_id ?></b> <br>
                        </div>
                        <img src="https://premisafe.com/GST_image/GSTReportCover.jpg" style="page-break-after: always" width="800px" height="800px">
                    </div>


                    <header id="header_id" class="header_id" style="display:none;margin-top:20px;">
                        <p style=" text-align: right;font-size:21px;font-family: Comic Sans MS, Times, serif;margin-right: 12px"> <img src="https://premisafe.com/Logo.jpg" style="float: right;margin-right:5%;width:160px;height:40px"></p><br><br><br>
                    </header>

                    <footer style="display:none;margin-top:-30px;">
                        <div>
                            <p style="text-align: left;margin-left: 45px;">Strictly Private and Confidential</p>
                            <p  style="text-align: right; margin-right:  45px;margin-top: -40px">Page <pagenum/> of <totpages/></p>
                        </div>
                    </footer>

                    <!--<div style="page-break-before:always;">-->

                    <div style="page-break-after:always;margin-top:15%;">
                        <div style="margin-left: 36% ;">
                            <b style="font-size:22px;color:#0e385e;text-align: center"></b></div>
                        <div style="margin-left: 5%;margin-right: 5%;margin-top:10%;" ><b>19th August, 2019</b></div>
                        <div style="margin-left: 5%;margin-right: 5%;"><b>
                                <?php
                                if ($company_details->visible_customer_detail == 1) {
                                    echo $client_details->customer_name;
                                } else {
                                    echo "XXX";
                                }
                                ?></b>
                            <?php // echo $client_details->customer_name ?></b>


                        </div>
                        <div style="margin-left: 5%;margin-right: 5%;">
                            <b>Managing Director:
                                <?php
                                if ($company_details->visible_customer_detail == 1) {
                                    echo $client_details->managing_director_name;
                                } else {
                                    echo "XXX";
                                }

//                                echo $client_details->managing_director_name
                                ?>
                            </b>
                        </div>
                        <div style="margin-left: 5%;margin-right: 5%;">
                            <b>    

                                <?php
                                if ($company_details->visible_customer_detail == 1) {
                                    echo $client_details->company_name;
                                } else {
                                    echo "XXX";
                                }
//                                echo $client_details->company_name
                                ?>
                            </b></div>
                        <div style="margin-left: 5%;margin-right: 5%;"><b> 

                                <?php
                                if ($company_details->visible_customer_detail == 1) {
                                    echo $client_details->customer_address;
                                } else {
                                    echo "XXX";
                                }
//                                echo $client_details->customer_address
                                ?>
                            </b>
                        </div>
                        <div style="margin-left: 36%;margin-top:20%;"> <b style="font-size:16px;"><u>Sub: GST Health Check Report</u></b></div>
                        <div id="content_client_letterPDF" style=""></div>

                    </div>

                    <!--                    <div id="container_image_limited_usage" style="margin-top:15%;page-break-after:always;">
                                            <img src="https://premisafe.com/GST_image/LimitedUsage&Abbreviation.jpg" width="800px" height="900px">
                                        </div>-->
                    <div style="margin-top: 15%;page-break-after: always;position: relative;">
                        <p style="position: absolute;margin-top:13%;margin-left: 44%;color:#0e385e;font-size:22px"><b>&nbsp;<?php echo $about_client_page_num; ?></b></p>
                        <p style="position: absolute;margin-top:13%;margin-left: 84%;color:white;font-size:22px"><b>&nbsp;5</b></p>
                        <p style="position: absolute;margin-top:22%;margin-left: 44%;color:white;font-size:22px"><b>&nbsp;<?php echo $gst_compo_page_num; ?></b></p>
                        <p style="position: absolute;margin-top:22%;margin-left: 84%;color:#0e385e;font-size:22px"><b>&nbsp;<?php echo $framework_page_num; ?></b></p>
                        <p style="position: absolute;margin-top:32%;margin-left: 44%;color:#0e385e;font-size:22px"><b>&nbsp;<?php echo $approach_page_num; ?></b></p>
                        <p style="position: absolute;margin-top:32%;margin-left: 84%;color:white;font-size:22px"><b>&nbsp;<?php echo $details_rep_page_num; ?></b></p>
                        <p style="position: absolute;margin-top:42%;margin-left: 44%;color:white;font-size:22px"><b>&nbsp;<?php echo $executive_summary_page_num; ?></b></p>
                        <p style="position: absolute;margin-top:42%;margin-left: 83%;color:#0e385e;font-size:22px"><b>&nbsp;&nbsp;<?php echo $issue_matrix_page_num; ?></b></p>
                        <p style="position: absolute;margin-top:53%;margin-left: 44%;color:#0e385e;font-size:22px"><b>&nbsp;<?php echo $rating_card_page_num; ?></b></p>
                        <p style="position: absolute;margin-top:53%;margin-left: 83%;color:white;font-size:22px"><b>&nbsp;&nbsp;<?php echo $conclusion_page_num; ?></b></p>
                        <p style="position: absolute;margin-top:62%;margin-left: 44%;color:white;font-size:22px"><b>&nbsp;<?php echo $limited_usage_disclosure; ?></b></p>
                        <p style="position: absolute;margin-top:62%;margin-left: 83%;color:#0e385e;font-size:22px"><b>&nbsp;&nbsp;<?php echo $disclaimer_page_num; ?></b></p>
                        <p style="position: absolute;margin-top:68%;margin-left: 83%;color:white;font-size:22px"><b>&nbsp;&nbsp;<?php echo $about_ecovis_page_num; ?></b></p>

                        <img src="https://premisafe.com/GST_image/GSTContent.jpg" style="margin-left: -5px;" width="800px" height="700px"style="page-break-after:always;" >
                    </div>

                    <div style="page-break-after:always;width:700px;margin-left: 5%;margin-right:5%;margin-top:15%;text-align: justify;text-justify: inter-word;height:800px">
                        <h4 style="font-size:20px;color:#0e385e;padding:4px;width:700px;"><b>1. ABOUT CLIENT </b></h4> 
                        <div style="width:700px;height:550px;">
<!--                            <p style="height: 14%;margin-top: 2%;padding-top: 5%;font-family:Microsoft Sans Serif;font-size: 18px;text-transform: uppercase;padding:4px;width:700px;text-align:center">
                                <?php
                                if ($company_details->visible_customer_detail == 1) {
                                    echo $client_details->company_name;
                                } else {
                                    echo "XXX";
                                }
                                ?>
                            </p>-->
                            <p style="font-size: 13px;">
                                <?php
                                if ($company_details->visible_customer_detail == 1) {
                                    echo $report_details->about_company;
                                } else {
                                    echo "XXX";
                                }
//                            echo $report_details->about_company
                                ?> </p>
                        </div>
                    </div>

                    <div style="page-break-after:always;width:700px;margin-right:5%;margin-top:15%;">
                        <div id="container_image_GST_abbreviation"><img src="https://premisafe.com/GST_image/Abbreviation.jpg" width="800px" height="900px"></div>
                       
                    </div>

                    <!--                    <div style="page-break-after:always;width:700px;margin-left: 5%;margin-right:  5%;margin-top:9%;text-align: justify;">
                                            <div id="content_pdf" style=""></div>
                                        </div>-->

                    <div id="container_image_components_overview" style="margin-top:15%;">
                        <img src="https://premisafe.com/GST_image/GSTComponents&Overview.jpg" width="800px" height="900px" style="page-break-after:always;">
                    </div>
                    <div class="test" style="page-break-after:always;margin-top:15%;">
                        <div id="container_image_GST_framework"><img src="https://premisafe.com/GST_image/GSTFramework.jpg" width="800px" height="900px"></div>
                    </div>
                    <div class="test" style="page-break-after:always;margin-top:13%">
                        <div id="container_image_approach" style="margin-top:9%;"><img src="https://premisafe.com/GST_image/Approach.jpg" width="750px" height="900px" style="page-break-after:always;"></div>
                    </div>
                    <!--Details of GST Reports & insights-->

                    <div class="test" id="first_div" style="display: block">
                        <div style="margin-top:15%;margin-left:5%;margin-right: 5%;">
                            <h4 class="" style="color:#0e385e;font-size:20px;"><b>6.DETAILS OF GST REPORTS AND INSIGHTS</b></h4>
                            <h4 class="" style="background:#0e385e; color:white;width:700px;text-align:center">DATA INSIGHTS</h4>
                            <h4 class="" style="color:#0e385e"><b>A.SALES REPORT</b></h4>
                        </div>
                        <div class="test" id="monthly_div" style="page-break-after:always;margin-left:5%;margin-right: 5%;">
                            <div id="sales_monthly_data2" ></div>
                            <div id="container_sales_month_wise"  style="width:700px;"></div>
                            <div id="sales_monthly_data1" style="width:700px; "></div>
                        </div>
                        <input type="hidden" id="sales_ratewise_div" name="sales_ratewise_div" value="0">
                        <div class="test" id="sales_rate_statewise_div" style="margin-top:15%;margin-left:5%;margin-right: 5%;page-break-after:always;">
                            <div id="compare_sales_ratewise_data1" style="width:700px;"></div>
                            <div id="compare_sales_ratewise_data" style="width:700px;"></div><br><br><br>
                            <div id="sales_state_wise_data2"  style="width:700px;"></div>
                            <div id="container_state_wise" style="width:700px;"></div>
                            <div id="sales_state_wise_data1"  style="width:700px;"></div>
                        </div>


                        <div class="test" id="tax_nontax_div" style="page-break-after:always;margin-top:15%;margin-left:5%;margin-right: 5%;">
                            <div id="tax_ntax_Exempt_data2" style="width:700px;"></div>
                            <div id="container_nontax_exempt" style="width:700px;"></div>
                            <div id="tax_ntax_Exempt_data1" style="width:700px;"></div>
                        </div>

                        <div class="test" id="compare_b2b_div" style="page-break-after:always;margin-top:15%;margin-left:5%;margin-right: 5%;">
                            <div id="compare_b2b_data2" style="width:700px;"></div>
                            <div id="container_sales_b2b_b2c" style="width:700px;"></div>
                            <div id="compare_b2b_data1" style="width:700px;"></div>
                        </div>

                    </div>
                    <!--Comparison & Deviation Report-->
                    <div class="test" id="second_div" style="display:block">
                        <div style="margin-top:14%;margin-left:5%;margin-right: 5%;">
                            <h4 style="color:#0e385e;"><b>B.COMPARISON AND DEVIATION REPORT</b></h4>
                        </div>
                        <div class="test" id="comp_3b_2" style="page-break-after:always;margin-left:5%;margin-right: 5%;">
                            <div id="compare_GSTR3B_Vs2_data2" style="width:700px;"></div>
                            <div id="compare_GSTR3B_Vs2_data" style="width:700px;"></div><br><br>
                            <div id="container_GSTR3b_vs_2A"  style="width:700px;"></div>
                            <div id="compare_GSTR3B_Vs2_data1" style="width:700px;"></div>
                        </div>
                        <div class="test" id="comp_3b_1" style="page-break-after:always;margin-top:14%;margin-left:5%;margin-right: 5%;">
                            <div id="compare_3b_vs1_data2" style="width:700px;"></div>
                            <div id="compare_3b_vs1_data" style="width:700px;"></div><br><br>
                            <div id="container_GSTR3b_vs_1" style="width:700px;"></div>
                            <div id="compare_3b_vs1_data1" style="width:700px;"></div>
                        </div>
                    </div>

                    <!--BAROMETER CFO DASHBOARD-->
                    <div class="test" id="third_div" style="display:block">
                        <div style="margin-top:15%;margin-left:5%;margin-right: 5%;">
                            <p style="background:#cd273f; color:white;padding:4px;border:1px solid;width:700px;text-align:center"><b>BAROMETER-CFO DASHBOARD</b></p>
                            <h4 style="color:#0e385e;"><b>A. CFO DASHBOARD</b></h4>
                        </div>
                        <div class="test_tax_turn" id="test_tax_turn"  style="page-break-after:always;display: block;margin-left:5%;margin-right: 5%;display:block">
                            <div id="tax_turnover_data2" style="width:700px;"></div>
                            <div id="tax_turnover_data" style="width:700px;"></div>
                            <div id="container_tax_turnover"  style="width:700px;"></div>
                            <div id="tax_turnover_data1" style="width:700px;"></div>
                        </div>

                        <div class="test" id="cfodata" style="page-break-after:always;margin-top:14%;display:block">
                            <div id="cfo_data2"  style="width:700px;margin-left:5%;margin-right: 5%;"></div>
                            <div id="cfo_data" style="width:700px;margin-left:5%;margin-right: 5%;"></div>
                            <div id="container_turnovervs_liability" style="width:700px;margin-left:5%;margin-right: 5%;display:block"></div>
                            <div id="cfo_data1" style="width:700px;margin-left:5%;margin-right: 5%;"></div>
                        </div>

                        <div class="test" id="tax_liabilitydiv" style="page-break-after:always;margin-top:14%;margin-left:5%;margin-right: 5%;display:block">
                            <div id="tax_liability_data2" style="width:700px;"></div>
                            <div id="tax_liability_data" style="width:700px;"></div>
                            <div id="container_tax_liability" style="width:700px;"></div>
                            <div id="tax_liability_data1" style="width:700px;"></div>
                        </div>

                        <div class="test" id="payable_cash"style="page-break-after:always;margin-top:14%;margin-left:5%;margin-right: 5%;display:block">
                            <div id="gst_payablevscash_data2" style="width:700px;"></div>
                            <div id="gst_payablevscash_data" style="width:700px;"></div>
                            <div id="container_gst_payablevscash"  style="width:700px;"></div>
                            <div id="gst_payablevscash_data1" style="width:700px;"></div>
                        </div>

                        <div class="test" id="tax_eli_ineli" style="page-break-after:always;margin-top:14%;margin-left:5%;margin-right: 5%;display:block">
                            <div id="tax_iniligible_data2" style="width:700px;"></div>
                            <div id="tax_iniligible_data" style="width:700px;"></div>
                            <div id="container_eligible_credit"  style="width:700px;"></div>
                            <div id="tax_iniligible_data1" style="width:700px;"></div>
                        </div>
                    </div>

                    <!--InFORMATION COMPARISON-->
                    <div class="test" id="fourth_div" style="display:block">
                        <div style="margin-top:15%;margin-left:5%;margin-right: 5%;">
                            <p style="background:#516b22; color:white;width:700px;text-align:center;"><b>INFORMATION COMPARISON</b></p>
                        </div>
                        <input type="hidden" id="complience_div" name="complience_div" value="0">
                        <input type="hidden" id="internal_control_div" name="internal_control_div" value="0">
                        <input type="hidden" id="invoice_comparison_div" name="invoice_comparison_div" value="0">
                        <div class="test" id="complience_report_div" style="page-break-after:always;margin-left:5%;margin-right: 5%;">
                            <h4 style="color:#0e385e;"><b>A. COMPLIANCE REPORT</b></h4>
                            <div id="gstr3B_data1" style="width:700px;"></div>
                            <div id="gstr3B_data" style="width:700px;"></div>
                            <div id="gstr1_data1" style="width:700px;"></div>
                            <div id="gstr1_data" style="width:700px;"></div>
                        </div>


                        <div class="test" id="internal_control" >
                            <div style="margin-top:15%;margin-left:5%;margin-right: 5%;">
                                <h4 style="color:#0e385e;"><b>B. INTERNAL CONTROL REPORT</b></h4>
                            </div>
                            <div class="test_amend" id="test_amend" style="page-break-after:always;margin-left:5%;margin-right: 5%;display: block;">
                                <div id="invoice_ammend_original_data" style=""></div>
                                <div id="invoice_ammend_original_data1" style=""></div>
                            </div>

                            <div class="test1" id="invoice_notinclude_gstr1_data_div" style="page-break-after:always;margin-top:14%;margin-left:5%;margin-right: 5%;">
                                <div id="invoice_notinclude_gstr1_data"  style=""></div>
                                <div id="invoice_notinclude_gstr1_data1" style=""></div>
                            </div>
                        </div>


                        <div class="test" id="invoice_wise_comparison" >
                            <div style="margin-top:15%;margin-left:5%;margin-right: 5%;">
                                <h4 style="color:#0e385e;"><b>C. INVOICE WISE COMPARISON OR MISMATCH REPORT</b></h4>
                            </div>
                            <div class="test_not_in_2a" id="test_not_in_2a" style="page-break-after:always;margin-left:5%;margin-right: 5%;">
                                <div id="company_all_notin2a_data" style=""></div>
                                <div id="company_all_notin2a_data1" style=""></div>
                            </div>

                            <div class="test" id="not_in_rec" style="page-break-after:always;margin-left:5%;margin-right: 5%; ">
                                <div id="company_all_notinrec_data" style=""></div>
                                <div id="company_all_notinrec_data1" style=""></div>
                            </div>

                            <div class="test" id="partially" style="page-break-after:always;margin-left:5%;margin-right: 5%;">
                                <div id="company_all_partially_data" style=" "></div>
                                <div id="company_all_partially_data1" style=""></div>
                            </div>
                        </div>

                        <div class="test" style="page-break-after:always;margin-top: 15%">
                       <!--<div id="container_image_issue_matrix" style=""><img src="https://premisafe.com/GST_image/Disclaimer.jpg" width="900px" height="900px" style=""></div><br><br>-->  
                            <p style="font-size:20px; color:#0e385e;padding:4px;width:700px;margin-left: 5%;margin-right: 5%"><b>7. EXECUTIVE SUMMARY</b> </p>
                            <div id="container_executive_summary1" style=""></div><br><br> 
                            <table class="table-bordered table-striped" width="700px" style="margin-left: 5%;margin-right: 5%;margin-top: -12%;">
                                <thead style="background-color: #0e385e;color:white">
                                    <tr>

                                        <th style="width:14%">Reports</th>
                                        <th>Observation</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>

                                <tbody id="reports_observation_table" name="reports_observation_table" style="font-size:12px;">

                                </tbody>

                            </table>
                        </div>

                        <div class="test" style="page-break-after:always;margin-top:7%">
                            <div id="container_image_issue_matrix" style=""><img src="https://premisafe.com/GST_image/IssueMatrix.jpg" style="width:700px" height="100px" style=""></div><br><br><br>  
                            <div id="heat_map_tbl" style="width:850px;margin-left: 5%"></div>
                            <div id="container_heat_map" style="width:700px;outline: 2px dashed blue;"></div>
                        </div>

                        <div class="test" style="page-break-after:always;margin-top:9%">
                            <div id="container_image_rating_card" style=""><img src="https://premisafe.com/GST_image/RatingCard.jpg" style="width:700px" height="100px" style=""></div><br><br><br>  
                            <div id="rating_card" style="margin-left: 5%"></div>
                            <!--<div id="container_heat_map" style="width:700px"></div>-->
                        </div>

                    </div>

                    <!--<div class="test" id="fifth_div" style="display:block">-->
                    <div class="test" style="page-break-after:always;margin-top: 15%">
                       <!--<div id="container_image_issue_matrix" style=""><img src="https://premisafe.com/GST_image/Disclaimer.jpg" width="900px" height="900px" style=""></div><br><br>-->  
                        <div id="" style="width:850px">
                            <p style="font-size:19px; color:#0e385e;padding:4px;width:700px;margin-left: 5%;margin-right: 5%"><b>10. SUMMARY OBSERVATION & CONCLUSION</b> </p>

                            <p style="margin-left: 5%">Following are the conclusions drawn after doing the analysis:</p>
                            <p align="justify" style="margin-left: 5%;margin-right:  5%;font-size: 13px;letter-spacing: 0.5px;">
                                <?php
                                if ($company_details->visible_customer_detail == 1) {
                                    echo '<h5 style="margin-left: 5%"><b>Compliemnts/facts:</b></h5>';
                                    echo'<p style="margin-left: 7%;margin-right:  5%;font-size: 14px;">' . $company_details->compliments_conclusion_summary . '</p>';
                                    //echo '<br>';
                                    echo '<h5 style="margin-left: 5%"><b>Serious Problems:</b></h5>';
                                    echo '<p style="margin-left: 7%;margin-right:  5%;font-size: 14px;">' . $company_details->serious_conclusion_summary . '</p>';
                                  //  echo '<br>';
                                    echo '<h5 style="margin-left: 5%"><b>Improvement:</b></h5>';
                                    echo '<p style="margin-left: 7%;margin-right:  5%;font-size: 14px;">' . $company_details->improvement_conclusion_summary . '</p>';
                                } else {
                                    echo "XXX";
                                }
//                                echo $company_details->conclusion_summary
                                ?>
                            </p>
                            <p align="justify" style="margin-left: 5%;margin-right:  5%;font-size: 14px;letter-spacing: 0.5px;" value="<?php echo $company_details->serious_conclusion_summary ?>"></p>
                        </div>
                        <!--<div id="container_heat_map" style="width:700px"></div>-->
                    </div>
                    <!--</div>-->

                    <div class="test" style="page-break-after:always;margin-top:13%">
                        <div id="container_image_disclaimer" ><img src="https://premisafe.com/GST_image/Disclaimer.jpg" width="750px" height="900px" style="page-break-after:always;"></div>
                    </div><br><br>

<!--                    <div class="test" style="page-break-after:always;margin-top:10%">
                        <p style="font-size:18px;background:#0e385e; color:white;padding:4px;border:1px solid;width:700px;text-align:center;margin-left: 5%;margin-right: 5%"><b>12. Disclaimer </b></p><br>
                        <div id="container_image_disclaimer" style=""></div><br><br>  
                    </div>-->

                    <div class="test" style="page-break-after:always;margin-top:10%">
                        <!--<div id="container_image_about" style=""><img src="https://premisafe.com/GST_image/about.jpg" width="780px" height="800px" style=""></div><br><br>-->  
                        <div id="container_ecovis" style="">
                            <img src="https://premisafe.com/GST_image/about.jpg" width="780px" height="800px" style="">
                            
                        </div><br><br>  

                    </div>
                    <div class="test" style="margin-top:10%">
                        <div id="container_image_services" style=""><img src="https://premisafe.com/GST_image/OurServicesPage.jpg" width="780px" height="800px" style=""></div><br><br>  

                    </div>

                </div>
            </div>


        </div>
        <div id="yourID" style="display: none;"></div>

        <div class="modal fade" id="exampleModal-4" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel"><b>Upload downloaded file to save the location:</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="forms-sample" id="location_form" method="post" name="location_form" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>File upload</label>
                                <div class="input-group col-xs-6">
                                    <input type="hidden" class="form-control" value="<?php echo $insert_id; ?>"  name="insert_id"  id="insert_id"   aria-required="true" aria-describedby="input_group-error">
                                    <input type="hidden" class="form-control" value="<?php echo $customer_id; ?>" name="customer_id"  id="customer_id"   aria-required="true" aria-describedby="input_group-error">
                                    <input type="hidden" class="form-control" value="<?php echo $company_details->report_id; ?>" name="report_id"  id="report_id"   aria-required="true" aria-describedby="input_group-error">

                                    <input type="file" class="form-control file-upload" name="file_upload" id="file_upload"  placeholder="file_upload">
                                </div><br>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" name="file_location" id="file_location" class="btn btn-success">Submit</button>
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </section>



</div>

<?php $this->load->view('customer/footer'); ?>
<script>
    $("#file_location").click(function () {
//              alert(insert_page_location);
        var formid = document.getElementById("location_form");
        var customer_id = document.getElementById("customer_id").value;
        var insert_id = document.getElementById("insert_id").value;
        var report_id = document.getElementById("report_id").value;
//        alert(customer_id);
//            alert(insert_id);
        console.log(customer_id);
        console.log(insert_id);
        $.ajax({
            type: "post",
            url: "<?= base_url("Report/file_location_upload") ?>",
            dataType: "json",
            data: new FormData(formid), //form data
//                 data: {customer_id: customer_id, insert_id: insert_id,report_id:report_id},
            processData: false,
            contentType: false,
            cache: false,
            async: false,
//            data: $("#Add_UniversityStudent").serialize(),
            success: function (result) {
                // alert(result.error);
                if (result.status === true) {
                    alert('File location added Successfully');
                    // return;
                    location.reload();
                } else if (result.status === false) {
                    alert('something went wrong');

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

    $(document).ready(function () {

        //For DETAILS OF GST REPORTS AND INSIGHTS DIVS

        var customer_id = document.getElementById("customer_id").value;
        var insert_id = document.getElementById("insert_id").value;
        var company_name = document.getElementById("company_name").value;
        var visible_customer_detail = document.getElementById("visible_customer_detail").value;


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

        //Ajax call for limited usage and disclosure

        $.ajax({
            type: "post",
            url: "<?= base_url("Report/get_content_limited_usage") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                //                 alert();
                $('#container_image_limited_usage').html("");
                if (result.message === "success") {

                    var data = result.data;
                    $('#container_image_limited_usage').html("");
                    $('#container_image_limited_usage').html(data);
                    //                    $('#example2').DataTable();
                } else {

                }
            },
        });

        //Ajax call for disclaimer
        $.ajax({
            type: "post",
            url: "<?= base_url("Report/get_content_disclaimer") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                //                 alert();
                $('#container_image_disclaimer').html("");
                if (result.message === "success") {

                    var data = result.data;
                    $('#container_image_disclaimer').html("");
                    $('#container_image_disclaimer').html(data);
                    //                    $('#example2').DataTable();
                } else {

                }
            },
        });

        //Ajax call for about Ecovis RKCA

        $.ajax({
            type: "post",
            url: "<?= base_url("Report/get_content_about_ecovis") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                //                 alert();
                $('#container_ecovis_about').html("");
                if (result.message === "success") {

                    var data = result.data;
                    $('#container_ecovis_about').html("");
                    $('#container_ecovis_about').html(data);
                    //                    $('#example2').DataTable();
                } else {

                }
            },
        });

        //Ajax call for Letter to client PDF

        $.ajax({
            type: "post",
            url: "<?= base_url("Report/get_letter_to_clientPDF") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                //                 alert();
                $('#content_client_letterPDF').html("");
                if (result.message === "success") {

                    var data = result.data;
                    $('#content_client_letterPDF').html("");
                    $('#content_client_letterPDF').html(data);
                    //                    $('#example2').DataTable();
                } else {

                }
            },
        });


        $.ajax({
            type: "post",
            url: "<?= base_url("Cfo_dashboard/get_graph_Turnover_vs_liabality") ?>",
            dataType: "json",
            //            processData: false,
            //            contentType: false,
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                //                 alert();
                //$('#cfo_data').html("");
                if (result.message === "success") {
                    document.getElementById("third_div_value").value++;
                    var data = result.data;
                    var data1 = result.data1;
                    var data2 = result.data2;
                    var data_turnover_vsliability_name = result.data_turnover_vsliability_name;
                    var data_turnover_vsliability_observation = result.data_turnover_vsliability_observation;
                    var data_turnover_vsliability_remarks = result.data_turnover_vsliability_remarks;

                    //                    $('#cfo_data').html("");
                    $('#cfo_data').html(data);
                    $('#cfo_data1').html(data1);
                    $('#cfo_data2').html(data2);
                    $("#reports_observation_table").append('<tr><td>' + data_turnover_vsliability_name + '</td><td>' + data_turnover_vsliability_observation + '</td><td>' + data_turnover_vsliability_remarks + '</td></tr>');
                    //                    $('#example2').DataTable();
                } else {
                    //alert('else');
                    document.getElementById("cfo_data").style.display = "none";
                    document.getElementById("cfo_data1").style.display = "none";
                    document.getElementById("cfo_data2").style.display = "none";
                    document.getElementById("cfodata").style.display = "none";
                }
            },
        });
        $.ajax({
            type: "POST",
            url: "<?= base_url("Cfo_dashboard/get_graph_Turnover_vs_liabality") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {
                    document.getElementById("third_div_value").value++;
                    var data_a = result.data_turn_over;
                    var data_liability = result.data_liability;
                    var data_ratio = result.ratio;
                    var data_month = result.month_data;
                    var max_range = result.max_range;
                    var customer_name = company_name;
                    if (visible_customer_detail == 1) {
                        var customer_name = company_name;
                    } else {
                        var customer_name = "XXX";
                    }
                    Highcharts.chart('container_turnovervs_liability', {
                        //                    var chart = Highcharts.chart('container_turnovervs_liability', {
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
                        },credits: {
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
                            }],
                    });
                    //                    chart.setTitle({
                    //                        useHTML: true,
                    //                        text: " <img src='<?= base_url() ?>/images/sale-month-wise.png' width='60px;' style='margin-right:10%;' alt='logo'/>" + "Test Title"
                    //                    });

                } else {
                    document.getElementById("container_turnovervs_liability").style.display = "none";
                }
            }
        });
        $.ajax({
            type: "POST",
            url: "<?= base_url("Management_report/get_graph_sales_month_wise") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {
                    document.getElementById("first_div_value").value++;
                    var taxable_supply = result.taxable_supply_arr;
                    var data_month = result.month_data;
                    var max_range = result.max_range;
                    var sales_percent_values = result.sales_percent_values;
                    var customer_name = company_name;
                    if (visible_customer_detail == 1) {
                        var customer_name = company_name;
                    } else {
                        var customer_name = "XXX";
                    }
                    Highcharts.chart('container_sales_month_wise', {
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
                        },credits: {
                            enabled: false
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
                    document.getElementById("container_sales_month_wise").style.display = "none";
                    document.getElementById("monthly_div").style.display = "none";
                }

            }
        });

        $.ajax({
            type: "post",
            url: "<?= base_url("Management_report/get_graph_sales_month_wise") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                //                 alert();
                $('#sales_monthly_data').html("");
                $('#sales_monthly_data1').html("");
                $('#sales_monthly_data2').html("");
                if (result.message === "success") {
                    document.getElementById("first_div_value").value++;
                    var data = result.data;
                    var data1 = result.data1;
                    var data2 = result.data2;
                    var data_monthwise_name = result.data_monthwise_name;
                    var data_month_observation = result.data_month_observation;
                    var data_month_remarks = result.data_month_remarks;

                    $('#sales_monthly_data').html(data);
                    $('#sales_monthly_data1').html(data1);
                    $('#sales_monthly_data2').html(data2);
                    $("#reports_observation_table").append('<tr><td>' + data_monthwise_name + '</td><td>' + data_month_observation + '</td><td>' + data_month_remarks + '</td></tr>');
                    //                    $('#example2').DataTable();
                } else {
                    document.getElementById("sales_monthly_data").style.display = "none";
                    document.getElementById("sales_monthly_data1").style.display = "none";
                    document.getElementById("sales_monthly_data2").style.display = "none";
                    document.getElementById("monthly_div").style.display = "none";
                }
            },

        });
        $.ajax({
            type: "POST",
            url: "<?= base_url("Management_report/get_graph_state_wise") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {
                    document.getElementById("first_div_value").value++;
                    document.getElementById("sales_ratewise_div").value++;
                    var data_a = result.taxable_value;
                    var max_range = result.data_liability;
                    var data_state = result.state;
                    var customer_name = company_name;
                    if (visible_customer_detail == 1) {
                        var customer_name = company_name;
                    } else {
                        var customer_name = "XXX";
                    }
                    Highcharts.chart('container_state_wise', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'Sales Statewise'
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
                        },credits: {
                            enabled: false
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
                    document.getElementById("container_state_wise").style.display = "none";
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
                    document.getElementById("first_div_value").value++;
                    document.getElementById("sales_ratewise_div").value++;
                    var data = result.data;
                    var data1 = result.data1;
                    var data2 = result.data2;
                    var data_statewise_name = result.data_statewise_name;
                    var data_statewise_observation = result.data_statewise_observation;
                    var data_statewise_remarks = result.data_statewise_remarks;
                    //                    $('#location_data').html("");
                    $('#sales_state_wise_data').html(data);
                    $('#sales_state_wise_data1').html(data1);
                    $('#sales_state_wise_data2').html(data2);
                    $("#reports_observation_table").append('<tr><td>' + data_statewise_name + '</td><td>' + data_statewise_observation + '</td><td>' + data_statewise_remarks + '</td></tr>');
                    //                    $('#example2').DataTable();
                } else {
                    document.getElementById("sales_state_wise_data").style.display = "none";
                    document.getElementById("sales_state_wise_data1").style.display = "none";
                    document.getElementById("sales_state_wise_data2").style.display = "none";
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
                    document.getElementById("first_div_value").value++;
                    var taxable_supply = result.taxable_supply_arr;
                    var sub_total_non_gst = result.sub_total_non_gst_arr;
                    var sub_total_exempt = result.sub_total_exempt_arr;
                    var ratio_taxable_supply = result.ratio_taxable_supply;
                    var ratio_subtotal_nongst = result.ratio_subtotal_nongst;
                    var ratio_subtotal_exempt = result.ratio_subtotal_exempt;
                    var data_month = result.month_data;
                    var max_range = result.max_range;
                    var customer_name = company_name;
                    if (visible_customer_detail == 1) {
                        var customer_name = company_name;
                    } else {
                        var customer_name = "XXX";
                    }
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
                        },credits: {
                            enabled: false
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
                    document.getElementById("container_nontax_exempt").style.display = "none";
                    document.getElementById("tax_nontax_div").style.display = "none";
                }
            }
        });

        //observation table for sale tax and non-taxable exempt
        $.ajax({
            type: "post",
            url: "<?= base_url("Management_report/get_graph_taxable_nontx_exempt") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                //                 alert();
                $('#tax_ntax_Exempt_data').html("");
                if (result.message === "success") {
                    document.getElementById("first_div_value").value++;
                    var data = result.data;
                    var data1 = result.data1;
                    var data2 = result.data2;
                    var data_tax_nontax_name = result.data_tax_nontax_name;
                    var data_tax_nontax_observation = result.data_tax_nontax_observation;
                    var data_tax_nontax_remarks = result.data_tax_nontax_remarks;

                    $('#tax_ntax_Exempt_data').html(data);
                    $('#tax_ntax_Exempt_data1').html(data1);
                    $('#tax_ntax_Exempt_data2').html(data2);
                    $("#reports_observation_table").append('<tr><td>' + data_tax_nontax_name + '</td><td>' + data_tax_nontax_observation + '</td><td>' + data_tax_nontax_remarks + '</td></tr>');
                    //                    $('#example2').DataTable();
                } else {
                    document.getElementById("tax_ntax_Exempt_data").style.display = "none";
                    document.getElementById("tax_ntax_Exempt_data1").style.display = "none";
                    document.getElementById("tax_ntax_Exempt_data2").style.display = "none";
                    document.getElementById("tax_nontax_div").style.display = "none";
                }
            },

        });

        //graph for sales B2B & B2Cs
        $.ajax({
            type: "POST",
            url: "<?= base_url("Management_report/get_graph_b2b")?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {
                    document.getElementById("first_div_value").value++;
                    var array_b2b = result.array_b2b;
                    var array_b2c = result.array_b2c;
                    var array_b2b_ratio = result.array_b2b_ratio;
                    var array_b2c_ratio = result.array_b2c_ratio;
                    var max = result.max_range;
                    var customer_name = company_name;
                    if (visible_customer_detail == 1) {
                        var customer_name = company_name;
                    } else {
                        var customer_name = "XXX";
                    }
                    //                    var max_ratio = result.max_ratio;
                    var data_month = result.month;
                    Highcharts.chart('container_sales_b2b_b2c', {
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

                                max: max,
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
                        },credits: {
                            enabled: false
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
                    document.getElementById("container_sales_b2b_b2c").style.display = "none";
                    document.getElementById("compare_b2b_div").style.display = "none";
                }
            }
        });



        //observation table for sales B2B & B2Cs
        $.ajax({
            type: "post",
            url: "<?= base_url("Management_report/get_graph_b2b") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                //                 alert();
                if (result.message === "success") {
                    document.getElementById("first_div_value").value++;
                    var data = result.data;
                    var data1 = result.data1;
                    var data2 = result.data2;
                    var data_salesb2b_b2c_name = result.data_salesb2b_b2c_name;
                    var data_salesb2b_b2c_observation = result.data_salesb2b_b2c_observation;
                    var data_salesb2b_b2c_remarks = result.data_salesb2b_b2c_remarks;

                    $('#compare_b2b_data').html("");
                    $('#compare_b2b_data').html(data);
                    $('#compare_b2b_data1').html(data1);
                    $('#compare_b2b_data2').html(data2);
                    $("#reports_observation_table").append('<tr><td>' + data_salesb2b_b2c_name + '</td><td>' + data_salesb2b_b2c_observation + '</td><td>' + data_salesb2b_b2c_remarks + '</td></tr>');
                    //                    $('#example2').DataTable();
                } else {
                    document.getElementById("compare_b2b_data").style.display = "none";
                    document.getElementById("compare_b2b_data1").style.display = "none";
                    document.getElementById("compare_b2b_data2").style.display = "none";
                    document.getElementById("compare_b2b_div").style.display = "none";


                }
            },

        });

        //table for sales rate wise

        $.ajax({
            type: "post",
            url: "<?= base_url("Management_report/get_data_rate_wise") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {
                    document.getElementById("first_div_value").value++;
                    document.getElementById("sales_ratewise_div").value++;
                    var data = result.data;
                    var data1 = result.data1;
                    var data_ratewise_name = result.data_ratewise_name;
                    var data_rate_observation = result.data_rate_observation;
                    var data_rate_remarks = result.data_rate_remarks;
                    $('#compare_sales_ratewise_data').html("");
                    $('#compare_sales_ratewise_data').html(data);
                    $('#compare_sales_ratewise_data1').html(data1);
                    $("#reports_observation_table").append('<tr><td>' + data_ratewise_name + '</td><td>' + data_rate_observation + '</td><td>' + data_rate_remarks + '</td></tr>');
                    //                    $('#example2').DataTable();
                } else {
                    document.getElementById("compare_sales_ratewise_data").style.display = "none";
                    document.getElementById("compare_sales_ratewise_data1").style.display = "none";
                }
            },

        });

        //Graph for comparison GSTR3B vs GSTR2A
        $.ajax({
            type: "POST",
            url: "<?= base_url("Threeb_vs_twoa/get_graph") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id},
            success: function (result) {
                if (result.message === "success") {
                    document.getElementById("second_div_value").value++;
                    var data_a = result.gstr_tb;
                    var data_difference = result.difference;
                    var cumu_difference = result.cumu_difference;
                    var data_gstr2a = result.gstr2a;
                    var max = result.max;
                    var months = result.month_data;
                    var customer_name = company_name;
                    if (visible_customer_detail == 1) {
                        var customer_name = company_name;
                    } else {
                        var customer_name = "XXX";
                    }
                    Highcharts.chart('container_GSTR3b_vs_2A', {
                        chart: {
                            type: 'Combination chart',
                            type: 'area'
                        },
                        title: {
                            text: 'Comparison Between GSTR-3B & GSTR-2A'
                        },
                        subtitle: {
                            text: customer_name
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

                } else {
                    document.getElementById("container_GSTR3b_vs_2A").style.display = "none";
                }
            }
        });

        //observation table for comparison GSTR3B VS GSTR 2A
        $.ajax({
            type: "post",
            url: "<?= base_url("Threeb_vs_twoa/get_graph") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                //                 alert();
                $('#compare_3b1_data').html("");
                if (result.message === "success") {
                    document.getElementById("second_div_value").value++;
                    var data = result.data;
                    var data1 = result.data1;
                    var data2 = result.data2;
                    var data_threeb_vs2A_name = result.data_threeb_vs2A_name;
                    var data_threeb_vs2A_observation = result.data_threeb_vs2A_observation;
                    var data_threeb_vs2A_remarks = result.data_threeb_vs2A_remarks;
                    $('#compare_GSTR3B_Vs2_data').html("");
                    $('#compare_GSTR3B_Vs2_data').html(data);
                    $('#compare_GSTR3B_Vs2_data1').html(data1);
                    $('#compare_GSTR3B_Vs2_data2').html(data2);
                    $("#reports_observation_table").append('<tr><td>' + data_threeb_vs2A_name + '</td><td>' + data_threeb_vs2A_observation + '</td><td>' + data_threeb_vs2A_remarks + '</td></tr>');

                    $("#container_GSTR3b_vs_2A").prepend("Deduct: In-Eligible Credit :<input type='text'><br>*To be ﬁlled by client so that the client will get the clear picture of eligible credit.");
                    //                    $('#example2').DataTable();
                } else {
                    document.getElementById("compare_GSTR3B_Vs2_data").style.display = "none";
                    document.getElementById("compare_GSTR3B_Vs2_data1").style.display = "none";
                    document.getElementById("compare_GSTR3B_Vs2_data2").style.display = "none";
                    document.getElementById("comp_3b_2").style.display = "none";
                }
            },

        });

        //Graph for comparison GSTR3B vs GSTR1

        $.ajax({
            type: "POST",
            url: "<?= base_url("Threeb_vs_one/get_graph") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {
                    document.getElementById("second_div_value").value++;
                    var data_a = result.data_gstr3b;
                    var data_gstr1_res = result.data_gstr1;
                    var data_difference = result.difference;
                    var cumu_difference = result.cumu_difference;
                    var max = result.max;
                    var month = result.month_data;
                    var customer_name = company_name;
                    if (visible_customer_detail == 1) {
                        var customer_name = company_name;
                    } else {
                        var customer_name = "XXX";
                    }
                    Highcharts.chart('container_GSTR3b_vs_1', {
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
                        },credits: {
                            enabled: false
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
                    document.getElementById("container_GSTR3b_vs_1").style.display = "none";
                }
            }
        });

        //observation table for comparison GSTR3B VS GSTR 1

        $.ajax({
            type: "post",
            url: "<?= base_url("Threeb_vs_one/get_graph") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                //                 alert();
                $('#compare_3b1_data').html("");
                if (result.message === "success") {
                    document.getElementById("second_div_value").value++;
                    var data = result.data;
                    var data1 = result.data1;
                    var data2 = result.data2;
                    var data_threeb_vs1_name = result.data_threeb_vs1_name;
                    var data_threeb_vs1_observation = result.data_threeb_vs1_observation;
                    var data_threeb_vs1_remarks = result.data_threeb_vs1_remarks;
                    $('#compare_3b_vs1_data').html("");
                    $('#compare_3b_vs1_data').html(data);
                    $('#compare_3b_vs1_data1').html(data1);
                    $('#compare_3b_vs1_data2').html(data2);
                    $("#reports_observation_table").append('<tr><td>' + data_threeb_vs1_name + '</td><td>' + data_threeb_vs1_observation + '</td><td>' + data_threeb_vs1_remarks + '</td></tr>');
                    //                    $('#example2').DataTable();
                } else {
                    document.getElementById("compare_3b_vs1_data").style.display = "none";
                    document.getElementById("compare_3b_vs1_data1").style.display = "none";
                    document.getElementById("compare_3b_vs1_data2").style.display = "none";
                    document.getElementById("comp_3b_1").style.display = "none";
                }
            },

        });
        $.ajax({
            type: "post",
            url: "<?= base_url("Account_report/get_graph") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                //                 alert();
                $('#gstr3B_data').html("");
                if (result.message === "success") {
                    document.getElementById("fourth_div_value").value++;
                    document.getElementById("complience_div").value++;
                    var data = result.data;
                    var data1 = result.data1;
                    var data_gstr3b_name = result.data_gstr3b_name;
                    var data_gstr3b_observation = result.data_gstr3b_observation;
                    var data_gstr3b_remarks = result.data_gstr3b_remarks;
                    $('#gstr3B_data').html(data);
                    $('#gstr3B_data1').html(data1);
                    $("#reports_observation_table").append('<tr><td>' + data_gstr3b_name + '</td><td>' + data_gstr3b_observation + '</td><td>' + data_gstr3b_remarks + '</td></tr>');

                    //                    $('#example1').DataTable();
                } else {
                    document.getElementById("gstr3B_data").style.display = "none";
                    document.getElementById("gstr3B_data1").style.display = "none";
                }
            },

        });

        $.ajax({
            type: "post",
            url: "<?= base_url("Account_report/get_gstr1_details1") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                //                 alert(data);
                $('#gstr1_data').html("");
                if (result.message === "success") {
                    document.getElementById("fourth_div_value").value++;
                    document.getElementById("complience_div").value++;
                    var data = result.data;
                    var data1 = result.data1;
                    $('#gstr1_data').html(data);
                    $('#gstr1_data1').html(data1);
                    //                    $('#example2').DataTable();
                } else {
                    document.getElementById("gstr1_data").style.display = "none";
                    document.getElementById("gstr1_data1").style.display = "none";
                }
            }

        });

        //Graph for tax overview liability


        $.ajax({
            type: "POST",
            url: "<?= base_url("Internal_acc_report/get_graph") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {
                    document.getElementById("third_div_value").value++;
                    var data_outwards = result.data_outward;
                    var data_rcbs = result.data_rcb;
                    var data_inelligibles = result.data_inelligible;
                    var data_rtcs = result.new_net_rtc;
                    var data_paid_credit = result.data_paid_credit;
                    var data_paid_cash = result.data_paid_cash;
                    var data_late_fee = result.data_late_fee;
                    var data_month = result.month_data;
                    var customer_name = company_name;
                    if (visible_customer_detail == 1) {
                        var customer_name = company_name;
                    } else {
                        var customer_name = "XXX";
                    }
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
                        },credits: {
                            enabled: false
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
                                name: 'RCM Liability',
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
                                name: 'Net ITC',
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
                    document.getElementById("container_tax_liability").style.display = "none";
                }
            }
        });

        //table  for tax overview liability
        $.ajax({
            type: "post",
            url: "<?= base_url("Internal_acc_report/get_graph") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                //                 alert();
                $('#tax_liability_data').html("");
                $('#tax_liability_data1').html("");
                if (result.message === "success") {
                    document.getElementById("third_div_value").value++;
                    var data = result.data;
                    var data1 = result.data1;
                    var data2 = result.data2;
                    var data_tax_liability_name = result.data_tax_liability_name;
                    var data_tax_liability_observation = result.data_tax_liability_observation;
                    var data_tax_liability_remarks = result.data_tax_liability_remarks;


                    $('#tax_liability_data').html(data);
                    $('#tax_liability_data1').html(data1);
                    $('#tax_liability_data2').html(data2);
                    $("#reports_observation_table").append('<tr><td>' + data_tax_liability_name + '</td><td>' + data_tax_liability_observation + '</td><td>' + data_tax_liability_remarks + '</td></tr>');
                    //                    $('#example2').DataTable();
                } else {
                    document.getElementById("tax_liability_data").style.display = "none";
                    document.getElementById("tax_liability_data1").style.display = "none";
                    document.getElementById("tax_liability_data2").style.display = "none";
                    document.getElementById("tax_liabilitydiv").style.display = "none";

                }
            },

        });

        //Graph for tax turnover

        $.ajax({
            type: "POST",
            url: "<?= base_url("Internal_acc_report/get_graph_tax_turnover") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {
                    document.getElementById("third_div_value").value++;
                    var taxable_value = result.taxable_value;
                    var tax_value = result.tax_value;
                    var tax_ratio = result.tax_ratio;
                    var data_month = result.month_data;
                    var max_range = result.max_range;
                    var customer_name = company_name;
                    if (visible_customer_detail == 1) {
                        var customer_name = company_name;
                    } else {
                        var customer_name = "XXX";
                    }
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
                        },credits: {
                            enabled: false
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
                    document.getElementById("container_tax_turnover").style.display = "none";
                    document.getElementById("test_tax_turn").style.display = "none";
                }
            }
        });

        //Table data for tax turnover

        $.ajax({
            type: "post",
            url: "<?= base_url("Internal_acc_report/get_graph_tax_turnover") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                //                 alert();

                if (result.message === "success") {
                    $('#tax_turnover_data').html("");
                    document.getElementById("third_div_value").value++;
                    var data = result.data;
                    var data1 = result.data1;
                    var data2 = result.data2;
                    var data_tax_turnover_name = result.data_tax_turnover_name;
                    var data_tax_turnover_observation = result.data_tax_turnover_observation;
                    var data_tax_turnover_remarks = result.data_tax_turnover_remarks;

                    $('#tax_turnover_data').html(data);
                    $('#tax_turnover_data1').html(data1);
                    $('#tax_turnover_data2').html(data2);
                    $("#reports_observation_table").append('<tr><td>' + data_tax_turnover_name + '</td><td>' + data_tax_turnover_observation + '</td><td>' + data_tax_turnover_remarks + '</td></tr>');
                    //                    $('#example2').DataTable();
                } else {
                    document.getElementById("tax_turnover_data").style.display = "none";
                    document.getElementById("tax_turnover_data1").style.display = "none";
                    document.getElementById("tax_turnover_data2").style.display = "none";
                    document.getElementById("test_tax_turn").style.display = "none";
                }
            },

        });


        //Graph for GST PAyable vs Cash

        $.ajax({
            type: "POST",
            url: "<?= base_url("Internal_acc_report/get_graph_gst_payable_vs_cash") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {
                    document.getElementById("third_div_value").value++;
                    var liability = result.liability;
                    var net_itc = result.net_itc;
                    var paid_in_cash = result.paid_in_cash;
                    var percent = result.percent;
                    var data_month = result.month_data;
                    var max_range = result.max_range;
                    var customer_name = company_name;
                    if (visible_customer_detail == 1) {
                        var customer_name = company_name;
                    } else {
                        var customer_name = "XXX";
                    }
                    Highcharts.chart('container_gst_payablevscash', {
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
                        },credits: {
                            enabled: false
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
                    document.getElementById("container_gst_payablevscash").style.display = "none";
                }
            }
        });

        //Table data for GST payable vs cash

        $.ajax({
            type: "post",
            url: "<?= base_url("Internal_acc_report/get_graph_gst_payable_vs_cash") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {
                    document.getElementById("third_div_value").value++;
                    var data = result.data;
                    var data1 = result.data1;
                    var data2 = result.data2;
                    var data_payable_vs_cash_name = result.data_payable_vs_cash_name;
                    var data_payable_vs_cash_observation = result.data_payable_vs_cash_observation;
                    var data_payable_vs_cash_remarks = result.data_payable_vs_cash_remarks;

                    $('#gst_payablevscash_data').html("");
                    $('#gst_payablevscash_data').html(data);
                    $('#gst_payablevscash_data1').html(data1);
                    $('#gst_payablevscash_data2').html(data2);
                    $("#reports_observation_table").append('<tr><td>' + data_payable_vs_cash_name + '</td><td>' + data_payable_vs_cash_observation + '</td><td>' + data_payable_vs_cash_remarks + '</td></tr>');
                    //                    $('#example2').DataTable();
                } else {
                    document.getElementById("gst_payablevscash_data").style.display = "none";
                    document.getElementById("gst_payablevscash_data1").style.display = "none";
                    document.getElementById("gst_payablevscash_data2").style.display = "none";
                    document.getElementById("payable_cash").style.display = "none";
                }
            },

        });


        //Graph for heat map


        $.ajax({
            type: "post",
            url: "<?= base_url("Report/get_heat_map") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                //                 alert();
                $('#heat_map_tbl').html("");
                if (result.message === "success") {
                    document.getElementById("fourth_div_value").value++;
                    var data = result.data;
                    //                    var data1 = result.data1;
                    $('#heat_map_tbl').html("");
                    $('#heat_map_tbl').html(data);
                    //                    $('#heat_map_tbl1').html(data1);
                    //                    $('#heat_map_tbl_id').DataTable();
                } else {
                    document.getElementById("heat_map_tbl").style.display = "none";
                }
            },

        });
        $.ajax({
            type: "post",
            url: "<?= base_url("Report/get_heat_map") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {
                    document.getElementById("fourth_div_value").value++;
                    var likelihood_impact = result.likelihood_impact;
                    var likelihood_risk = result.likelihood_risk;
                    Highcharts.chart('container_heat_map', {
                        chart: {
                            type: 'scatter',
                            zoomType: 'xy',
                            //                            backgroundColor: '#E38B0B',
                        },

                        title: {
                            text: 'Heat Map'
                        },
                        subtitle: {
                            //                            text: 'Source: Heinz  2003'
                        },
                        xAxis: {
                            gridLineWidth: 1,
                            title: {
                                enabled: true,
                                //                                text: 'Height (cm)'
                            },
                            startOnTick: true,
                            endOnTick: true,
                            showLastLabel: true
                        },
                        yAxis: {
                            gridLineWidth: 1,

                            plotBands: [{// mark the weekend
                                    color: '#74D56F',
                                    from: 0,
                                    to: 6
                                }, {// mark the weekend
                                    color: '#D8D824',
                                    from: 6,
                                    to: 11
                                }, {// mark the weekend
                                    color: '#eb5c3d',
                                    from: 11,
                                    to: 625
                                }],

                        },

                        legend: {
                            layout: 'vertical',
                            align: 'left',
                            verticalAlign: 'top',
                            x: 100,
                            y: 70,
                            floating: true,
                            backgroundColor: Highcharts.defaultOptions.chart.backgroundColor,
                            borderWidth: 1
                        },

                        plotOptions: {
                            scatter: {
                                marker: {
                                    radius: 5,
                                    states: {
                                        hover: {
                                            enabled: true,
                                            lineColor: 'rgb(100,100,100)'
                                        }
                                    }
                                },
                                states: {
                                    hover: {
                                        marker: {
                                            enabled: false
                                        }
                                    }
                                },
                                tooltip: {
                                    headerFormat: '<b>{series.name}</b><br>',
                                    pointFormat: '{point.x} , {point.y} '
                                }
                            }
                        },
                        series: [{
                                name: 'Impact',
                                color: '#1D6AB2',
                                data: likelihood_impact

                            }, {
                                name: 'Risk Score',
                                color: '#C62E2E',
                                data: likelihood_risk
                            }]
                    });
                } else {
                    document.getElementById("container_heat_map").style.display = "none";
                }
            },

        });

        //Graph for GST iniligible and eligible credit

        $.ajax({
            type: "POST",
            url: "<?= base_url("Internal_acc_report/get_graph_eligible_ineligible") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.message === "success") {
                    document.getElementById("third_div_value").value++;
                    var ineligible_itc = result.ineligible_itc;
                    var net_itc = result.net_itc;
                    var ineligible_ratio = result.ineligible_ratio;
                    var eligible_ratio = result.eligible_ratio;
                    var data_month = result.month_data;
                    var max_range = result.max_range;
                    var customer_name = company_name;
                    if (visible_customer_detail == 1) {
                        var customer_name = company_name;
                    } else {
                        var customer_name = "XXX";
                    }
                    Highcharts.chart('container_eligible_credit', {
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
                        },credits: {
                            enabled: false
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
                    document.getElementById("container_eligible_credit").style.display = "none";
                }
            }
        });

        //table data for GST iniligible and eligible credit

        $.ajax({
            type: "post",
            url: "<?= base_url("Internal_acc_report/get_graph_eligible_ineligible") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                //                 alert();
                $('#tax_iniligible_data').html("");
                if (result.message === "success") {
                    document.getElementById("third_div_value").value++;
                    var data = result.data;
                    var data1 = result.data1;
                    var data2 = result.data2;
                    var data_eligible_name = result.data_eligible_name;
                    var data_eligible_observation = result.data_eligible_observation;
                    var data_eligible_remarks = result.data_eligible_remarks;

                    $('#tax_iniligible_data').html(data);
                    $('#tax_iniligible_data1').html(data1);
                    $('#tax_iniligible_data2').html(data2);
                    $("#reports_observation_table").append('<tr><td>' + data_eligible_name + '</td><td>' + data_eligible_observation + '</td><td>' + data_eligible_remarks + '</td></tr>');
                    //                    $('#example2').DataTable();
                } else {
                    document.getElementById("tax_iniligible_data").style.display = "none";
                    document.getElementById("tax_iniligible_data1").style.display = "none";
                    document.getElementById("tax_iniligible_data2").style.display = "none";
                    document.getElementById("tax_eli_ineli").style.display = "none";
                }
            },

        });
        
        //summaary for export sales
        
        $.ajax({
            type: "post",
            url: "<?= base_url("Management_report/get_graph_exports") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
//                 alert();
                if (result.message === "success") {

                    var data = result.data;
                    var data_export_sales_name = result.data_export_sales_name;
                    var data_export_sales_observation = result.data_export_sales_observation;
                    var data_export_sales_remarks = result.data_export_sales_remarks;
                   
                    $('#export_sales').html("");
                    $('#export_sales').html(data);
                    $('#example2').DataTable();
                    $("#reports_observation_table").append('<tr><td>' + data_export_sales_name + '</td><td>' + data_export_sales_observation + '</td><td>' + data_export_sales_remarks + '</td></tr>');
                    
                } else {

                }
            },

        });

        //table data for Invoice ammend in other than original

        //         $('#invoice_ammend_original_data').html("");
        $.ajax({
            type: "post",
            url: "<?= base_url("Invoice_comp_report/get_table_data_ammend") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.status === true) {
                    document.getElementById("fourth_div_value").value++;
                    document.getElementById("internal_control_div").value++;
                    var data = result.data;
                    var data1 = result.data1;
                    var data_invoice_ammend_name = result.data_invoice_ammend_name;
                    var data_invoice_ammend_observation = result.data_invoice_ammend_observation;
                    var data_invoice_ammend_remarks = result.data_invoice_ammend_remarks;
                    

                    $('#invoice_ammend_original_data').html(data);
                    $('#invoice_ammend_original_data1').html(data1);
                    $("#reports_observation_table").append('<tr><td>' + data_invoice_ammend_name + '</td><td>' + data_invoice_ammend_observation + '</td><td>' + data_invoice_ammend_remarks + '</td></tr>');
                    
                    //                    $('#example2').DataTable();
                } else {
                    document.getElementById("invoice_ammend_original_data").style.display = "none";
                    document.getElementById("invoice_ammend_original_data1").style.display = "none";
                    document.getElementById("test_amend").style.display = "none";
                }
            }

        });

        //Report Card

        $.ajax({
            type: "post",
            url: "<?= base_url("Report/get_rating_card") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                //                 alert();
                $('#rating_card').html("");
                if (result.message === "success") {

                    var data = result.data;
                    $('#rating_card').html("");
                    $('#rating_card').html(data);
                } else {
                    document.getElementById("rating_card").style.display = "none";
                }
            },

        });

        //table data for Invoice not included in GSTR1

        //        $('#invoice_notinclude_gstr1_data').html("");

        $.ajax({
            type: "post",
            url: "<?= base_url("Invoice_comp_report/get_table_data") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.status === true) {
                    document.getElementById("fourth_div_value").value++;
                    document.getElementById("internal_control_div").value++;
                    var data = result.data;
                    var data1 = result.data1;
                    var data_invoice_ammend_name = result.data_invoice_ammend_name;
                    var data_invoice_ammend_observation = result.data_invoice_ammend_observation;
                    var data_invoice_ammend_remarks = result.data_invoice_ammend_remarks;
                    

                    $('#invoice_notinclude_gstr1_data').html(data);
                    $('#invoice_notinclude_gstr1_data1').html(data1);
                    $("#reports_observation_table").append('<tr><td>' + data_invoice_ammend_name + '</td><td>' + data_invoice_ammend_observation + '</td><td>' + data_invoice_ammend_remarks + '</td></tr>');
                    
                } else {
                    document.getElementById("invoice_notinclude_gstr1_data1").style.display = "none";
                    document.getElementById("invoice_notinclude_gstr1_data").style.display = "none";
                    document.getElementById("invoice_notinclude_gstr1_data_div").style.display = "none";
                }
            }

        });

        //Get all Not in 2A records

        $.ajax({
            type: "post",
            url: "<?= base_url("Invoice_comp_report/get_not_in2a_records_details") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.status === true) {
                    document.getElementById("fourth_div_value").value++;
                    document.getElementById("invoice_comparison_div").value++;
                    var data = result.data;
                    var data1 = result.data1;
                    var data_not_in_2a_name = result.data_not_in_2a_name;
                    var data_not_in_2a_observation = result.data_not_in_2a_observation;
                    var data_not_in_2a_remarks = result.data_not_in_2a_remarks;


                    $('#company_all_notin2a_data').html(data);
                    $('#company_all_notin2a_data1').html(data1);
                    $("#reports_observation_table").append('<tr><td>' + data_not_in_2a_name + '</td><td>' + data_not_in_2a_observation + '</td><td>' + data_not_in_2a_remarks + '</td></tr>');
                    

                } else {
                    document.getElementById("company_all_notin2a_data").style.display = "none";
                    document.getElementById("company_all_notin2a_data1").style.display = "none";
                    document.getElementById("test_not_in_2a").style.display = "none";
                }
            }

        });


        //Get all Not in records
        $.ajax({
            type: "post",
            url: "<?= base_url("Invoice_comp_report/get_not_inrec_records_all") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.status === true) {
                    document.getElementById("fourth_div_value").value++;
                    document.getElementById("invoice_comparison_div").value++;
                    var data = result.data;
                    var data1 = result.data1;
                    var data_not_in_rec_name = result.data_not_in_rec_name;
                    var data_not_in_rec_observation = result.data_not_in_rec_observation;
                    var data_not_in_rec_remarks = result.data_not_in_rec_remarks;
                    $('#company_all_notinrec_data').html(data);
                    $('#company_all_notinrec_data1').html(data1);
                    $("#reports_observation_table").append('<tr><td>' + data_not_in_rec_name + '</td><td>' + data_not_in_rec_observation + '</td><td>' + data_not_in_rec_remarks + '</td></tr>');
                    

                } else {
                    document.getElementById("company_all_notinrec_data").style.display = "none";
                    document.getElementById("company_all_notinrec_data1").style.display = "none";
                    document.getElementById("not_in_rec").style.display = "none";
                }
            }

        });

        //Get all company details for partially match summary
        $.ajax({
            type: "post",
            url: "<?= base_url("Invoice_comp_report/get_all_partial_records") ?>",
            dataType: "json",
            data: {customer_id: customer_id, insert_id: insert_id},
            success: function (result) {
                if (result.status === true) {
                    document.getElementById("fourth_div_value").value++;
                    document.getElementById("invoice_comparison_div").value++;
                    var data = result.data;
                    var data1 = result.data1;
                    var data_partial_match_name = result.data_partial_match_name;
                    var data_partial_match_observation = result.data_partial_match_observation;
                    var data_partial_match_remarks = result.data_partial_match_remarks;
                    

                    $('#company_all_partially_data').html(data);
                    $('#company_all_partially_data1').html(data1);
                    $("#reports_observation_table").append('<tr><td>' + data_partial_match_name + '</td><td>' + data_partial_match_observation + '</td><td>' + data_partial_match_remarks + '</td></tr>');
                    
                } else {
                    document.getElementById("company_all_partially_data1").style.display = "none";
                    document.getElementById("company_all_partially_data").style.display = "none";
                    document.getElementById("partially").style.display = "none";
                }
            }

        });


    });


    setTimeout(function () {
        var first_div_value = document.getElementById("first_div_value").value;
        if (first_div_value >= 0)
        {
            document.getElementById("first_div").style.display = "block";
        } else {
            document.getElementById("first_div").style.display = "none";
        }

        //COMPARISON AND DEVIATION REPORT DIVS
        var second_div_value = document.getElementById("second_div_value").value;
        if (second_div_value > 0)
        {
            document.getElementById("second_div").style.display = "block";
        } else {
            document.getElementById("second_div").style.display = "none";
        }

        //BAROMETER-CFO DASHBOARD DIVS
        var third_div_value = document.getElementById("third_div_value").value;
        if (third_div_value > 0)
        {
            document.getElementById("third_div").style.display = "block";
        } else {
            document.getElementById("third_div").style.display = "none";
        }

        //INFORMATION COMPARISON DIVS
        var fourth_div_value = document.getElementById("fourth_div_value").value;
        if (fourth_div_value > 0)
        {
            document.getElementById("fourth_div").style.display = "block";
        } else {
            document.getElementById("fourth_div").style.display = "none";
        }
        var complience_div = document.getElementById("complience_div").value;
        if (complience_div > 0)
        {
            document.getElementById("complience_report_div").style.display = "block";
        } else {
            document.getElementById("complience_report_div").style.display = "none";
        }

        var internal_control_div = document.getElementById("internal_control_div").value;
        if (internal_control_div > 0)
        {
            document.getElementById("internal_control").style.display = "block";
        } else {
            document.getElementById("internal_control").style.display = "none";
        }

        var invoice_comparison_div = document.getElementById("invoice_comparison_div").value;
        if (invoice_comparison_div > 0)
        {
            document.getElementById("invoice_wise_comparison").style.display = "block";
        } else {
            document.getElementById("invoice_wise_comparison").style.display = "none";
        }

        var sales_ratewise_div = document.getElementById("sales_ratewise_div").value;
        if (sales_ratewise_div > 0)
        {
            document.getElementById("sales_rate_statewise_div").style.display = "block";
        } else {
            document.getElementById("sales_rate_statewise_div").style.display = "none";
        }

        if ($('#test_not_in_2a').css('display') === 'none')
        {
            document.getElementById("not_inrec_head").style.marginTop = "4%";
        } else {

        }
        if ($('#test_not_in_2a').css('display') === 'none' && $('#not_in_rec').css('display') === 'none')
        {
            document.getElementById("pos_period").style.marginTop = "4%";
        } else {

        }

    }, 6000);

</script>
<script>
    Highcharts.getSVG = function (charts) {
        var svgArr = [],
                top = 0,
                width = 0;
        $.each(charts, function (i, chart) {
            var svg = chart.getSVG();
            svg = svg.replace('<svg', '<g transform="translate(0,' + top + ')" ');
            svg = svg.replace('</svg>', '</g>');
            top += chart.chartHeight;
            width = Math.max(width, chart.chartWidth);
            svgArr.push(svg);
        });
        return '<svg height="' + top + '" width="' + width + '" version="1.1" xmlns="http://www.w3.org/2000/svg">' + svgArr.join('') + '</svg>';
    };


    Highcharts.exportCharts = function (charts, options) {
        var form
        svg = Highcharts.getSVG(charts);
        // merge the options
        options = Highcharts.merge(Highcharts.getOptions().exporting, options);
        // create the form
        form = Highcharts.createElement('form', {
            method: 'post',
            action: options.url
        }, {
            display: 'none'
        }, document.body);
        // add the values
        Highcharts.each(['filename', 'type', 'width', 'svg'], function (name) {
            Highcharts.createElement('input', {
                type: 'hidden',
                name: name,
                value: {
                    filename: options.filename || 'chart',
                    type: options.type,
                    width: options.width,
                    svg: svg
                }[name]
            }, null, form);
        });
        //console.log(svg); return;
        // submit
        form.submit();
        // clean up
        form.parentNode.removeChild(form);
    };



    var click = "return xepOnline.Formatter.Format('JSFiddle', {render:'download'})";
    jQuery('#buttons').append('<div class=""><div id="btn_div" class="col-md-12"><button class="btn btn-block btn-success btn-lg" id="btn_pdf" onclick="' + click + '">Generate PDF With Index Page</button></div></div>');



</script>


