<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
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
      <!-- partial -->
      <!-- partial:../../partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <div class="d-flex sidebar-profile">
            
           
          </div>
          <div class="nav-search">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Type to search..." aria-label="search" aria-describedby="search">
              <div class="input-group-append">
                <span class="input-group-text" id="search">
                  <i class="typcn typcn-zoom"></i>
                </span>
              </div>
            </div>
          </div>
          <p class="sidebar-menu-title">Dash menu</p>
          <ul class="nav">
           <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url();?>GST_Dashboard">
                <i class="typcn typcn-device-desktop menu-icon"></i>
                <!--<span class="menu-title">Dashboard <span class="badge badge-primary ml-3">New</span></span>-->
                 <span class="menu-title">Dashboard</span>
              </a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url();?>GST_CFODashboard">
                <i class="typcn typcn-device-desktop menu-icon"></i>
                <!--<span class="menu-title">Dashboard <span class="badge badge-primary ml-3">New</span></span>-->
                 <span class="menu-title">CFO Dashboard</span>
              </a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url();?>GST_Management">
                <i class="typcn typcn-device-desktop menu-icon"></i>
                <!--<span class="menu-title">Dashboard <span class="badge badge-primary ml-3">New</span></span>-->
                 <span class="menu-title">Management Report</span>
              </a>
            </li>
            
            
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url();?>GST_Account">
                <i class="typcn typcn-device-desktop menu-icon"></i>
                <!--<span class="menu-title">Dashboard <span class="badge badge-primary ml-3">New</span></span>-->
                 <span class="menu-title">Account Report</span>
              </a>
            </li>
            
            
              <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url();?>GST_Internal_Control">
                <i class="typcn typcn-device-desktop menu-icon"></i>
                <!--<span class="menu-title">Dashboard <span class="badge badge-primary ml-3">New</span></span>-->
                 <span class="menu-title">Internal Control Report</span>
              </a>
            </li>
            
            
            
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url();?>GST_Invoice_Comparison">
                <i class="typcn typcn-device-desktop menu-icon"></i>
                <!--<span class="menu-title">Dashboard <span class="badge badge-primary ml-3">New</span></span>-->
                 <span class="menu-title">Invoice wise Comparison or Mismatch Report</span>
              </a>
            </li>
            
           <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#editors" aria-expanded="false" aria-controls="editors">
                <i class="typcn typcn-point-of-interest-outline menu-icon"></i>
                <span class="menu-title">Comparison And Deviation Report</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="editors">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"><a class="nav-link" href="<?php echo base_url();?>GST_3BVs1">GSTR3B VS GSTR-1</a></li>
                  <li class="nav-item"><a class="nav-link" href="<?php echo base_url();?>GST_3BVs2A">GSTR3B vs GSTR-2A</a></li>
                </ul>
              </div>
            </li>
            
            
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url();?>GST_Logout">
                <i class="typcn typcn-device-desktop menu-icon"></i>
                <!--<span class="menu-title">Dashboard <span class="badge badge-primary ml-3">New</span></span>-->
                 <span class="menu-title">Logout</span>
              </a>
            </li>
            
           
            
          </ul>
         
        </nav>
