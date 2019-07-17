<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">


        </div>
        <!-- search form -->

        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <!--<li class="header">MAIN NAVIGATION</li>-->
            <li class="">
                <a href="<?php echo base_url(); ?>Cust_dashboard">
                    <i class="fa fa-dashboard" ></i> <span>Dashboard</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
            </li>
            <li class="">
                <a href="<?php echo base_url(); ?>Cfo_dashboard">
                    <i class="fa fa-dashboard" ></i> <span>CFO Dashboard</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-share"></i> <span>Comparison And Deviation <br> Report</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url(); ?>Threeb_Vs_one"><i class="fa fa-circle-o"></i> GSTR3B VS GSTR-1</a></li>

                    <li><a href="<?php echo base_url(); ?>Threeb_vs_twoa"><i class="fa fa-circle-o"></i> GSTR3B vs GSTR-2A</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-share"></i> <span>Management Report</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url(); ?>Sale_b2b_b2c"><i class="fa fa-circle-o"></i> Sales B2B & B2Cs</a></li>
                    <li><a href="<?php echo base_url(); ?>Sale_state_wise"><i class="fa fa-circle-o"></i> Sales State Wise</a></li>
                    <li><a href="<?php echo base_url(); ?>Sale_taxable_nontaxable"><i class="fa fa-circle-o"></i>Sales Taxable, non-taxable <br> and Exempt</a></li>
                    <li><a href="<?php echo base_url(); ?>Sale_month_wise"><i class="fa fa-circle-o"></i> Sales Month Wise</a></li>
                </ul>
            </li>
            <li class="">
                <a href="<?php echo base_url(); ?>Account">
                    <i class="fa fa-dashboard" ></i> <span>Account Report</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-share"></i> <span>Internal Control Report</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url(); ?>TurnoverVsTaxability"><i class="fa fa-circle-o"></i>Tax Liability</a></li>
                    <li><a href="<?php echo base_url(); ?>Tax_turnover"><i class="fa fa-circle-o"></i>Tax Turnover</a></li>
                    <li><a href="<?php echo base_url(); ?>eligible_ineligible_itc"><i class="fa fa-circle-o"></i>Eligible and Ineligible Credit</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-share"></i> <span>Invoice wise Comparison <br> or Mismatch Report</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url(); ?>not_in_2a"><i class="fa fa-circle-o"></i>Not In 2A</a></li>
                    <li><a href="<?php echo base_url(); ?>not_in_record"><i class="fa fa-circle-o"></i>Not In Records</a></li>
                    <li><a href="<?php echo base_url(); ?>partial_match"><i class="fa fa-circle-o"></i>Partially Match</a></li>
                </ul>
            </li>
            
            <li class="">
                <a href="<?php echo base_url(); ?>Gst_admin_login/admin_logout">
                    <i class="fa fa-dashboard" ></i> <span>Logout</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>