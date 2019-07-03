<div class="container-fluid page-body-wrapper">  
    <!-- partial:../../partials/_settings-panel.html -->
    <div class="theme-setting-wrapper">
        <div id="settings-trigger"><i class="typcn typcn-cog-outline"></i></div>
        <div id="theme-settings" class="settings-panel">
            <i class="settings-close typcn typcn-delete-outline"></i>
            <p class="settings-heading">SIDEBAR SKINS</p>
            <div class="sidebar-bg-options" id="sidebar-light-theme">
                <div class="img-ss rounded-circle bg-light border mr-3"></div>
                Light
            </div>
            <div class="sidebar-bg-options selected" id="sidebar-dark-theme">
                <div class="img-ss rounded-circle bg-dark border mr-3"></div>
                Dark
            </div>
            <p class="settings-heading mt-2">HEADER SKINS</p>
            <div class="color-tiles mx-0 px-4">
                <div class="tiles success"></div>
                <div class="tiles warning"></div>
                <div class="tiles danger"></div>
                <div class="tiles primary"></div>
                <div class="tiles info"></div>
                <div class="tiles dark"></div>
                <div class="tiles default border"></div>
            </div>
        </div>

    </div>

    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="d-flex sidebar-profile">
            <!--            <div class="sidebar-profile-image">
                          <img src="<?php echo base_url() . "images/"; ?>faces/face29.png" alt="image">
                          <span class="sidebar-status-indicator"></span>
                        </div>-->
            <!--            <div class="sidebar-profile-name">
                          <p class="sidebar-name">
                            Kenneth Osborne
                          </p>
                          <p class="sidebar-designation">
                            Welcome
                          </p>
                        </div>-->
        </div>
        <div class="nav-search">
            <!--            <div class="input-group">
                          <input type="text" class="form-control" placeholder="Type to search..." aria-label="search" aria-describedby="search">
                          <div class="input-group-append">
                            <span class="input-group-text" id="search">
                              <i class="typcn typcn-zoom"></i>
                            </span>
                          </div>
                        </div>-->
        </div>
        <p class="sidebar-menu-title">Dash menu</p>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>Cust_dashboard">
                    <i class="typcn typcn-device-desktop menu-icon"></i>
                    <!--<span class="menu-title">Dashboard <span class="badge badge-primary ml-3">New</span></span>-->
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>Cfo_dashboard">
                    <i class="typcn typcn-device-desktop menu-icon"></i>
                    <!--<span class="menu-title">Dashboard <span class="badge badge-primary ml-3">New</span></span>-->
                    <span class="menu-title">CFO Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#editors" aria-expanded="true" aria-controls="editors">
                    <i class="typcn typcn-point-of-interest-outline menu-icon"></i>
                    <span class="menu-title">Comparison And Deviation <br>Report</span>
                    <!--<i class="menu-arrow"></i>-->
                </a>
                <div class="collapse" id="editors">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>Threeb_Vs_one">GSTR3B VS GSTR-1</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>Threeb_vs_twoa">GSTR3B vs GSTR-2A</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link"  data-toggle="collapse" href="#editors_mng" aria-expanded="true" aria-controls="editors" >
                    <i class="typcn typcn-device-desktop menu-icon"></i>
                    <!--<span class="menu-title">Dashboard <span class="badge badge-primary ml-3">New</span></span>-->
                    <span class="menu-title">Management Report</span>
                </a>
                <div class="collapse" id="editors_mng">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>Sale_b2b_b2c">Sales B2B & B2Cs </a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>Sale_state_wise">Sales State Wise</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>Sale_taxable_nontaxable">Sales Taxable, non-taxable <br> and Exempt</a></li>
                          <li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?>Sale_month_wise">Sales Month Wise</a></li>
                    </ul>
                </div>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>Account">
                    <i class="typcn typcn-device-desktop menu-icon"></i>
                    <!--<span class="menu-title">Dashboard <span class="badge badge-primary ml-3">New</span></span>-->
                    <span class="menu-title">Account Report</span>
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>Internal_control">
                    <i class="typcn typcn-device-desktop menu-icon"></i>
                    <!--<span class="menu-title">Dashboard <span class="badge badge-primary ml-3">New</span></span>-->
                    <span class="menu-title">Internal Control Report</span>
                </a>
            </li>



            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>Invoice_comparison">
                    <i class="typcn typcn-device-desktop menu-icon"></i>
                    <!--<span class="menu-title">Dashboard <span class="badge badge-primary ml-3">New</span></span>-->
                    <span class="menu-title">Invoice wise Comparison <br> or Mismatch Report</span>
                </a>
            </li>







            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>Gst_admin_login/admin_logout">
                    <i class="typcn typcn-device-desktop menu-icon"></i>
                    <!--<span class="menu-title">Dashboard <span class="badge badge-primary ml-3">New</span></span>-->
                    <span class="menu-title">Logout</span>
                </a>
            </li>


        </ul>
    </nav>



