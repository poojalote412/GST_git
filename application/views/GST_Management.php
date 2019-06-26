<?php
$this->load->view('header');
//$this->load->view('web_rmt/cua_navigation');
//$this->load->view('web_rmt/dashboard_tab');
defined('BASEPATH') OR exit('No direct script access allowed');
?>


<body>
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->
    
    <?php include'header.php';?>
    
    <!-- partial -->
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
    <?php $this->load->view('navigation'); ?>
      <!-- partial -->
     <div class="content-wrapper">
           
          <div class="col-12 grid-margin stretch-card">
              <div class="card">
                  <div class="card-body">
                  <h4 class="card-title">Basic Excel Upload</h4>
                  
                  <form class="forms-sample">
                   
                    
                    <div class="form-group">
                      <label>File upload</label>
                      <input type="file" name="img[]" class="file-upload-default">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload File">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button" >Upload</button>
                        </span>
                      </div>
                    </div>
                    
                    
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
        </div>
          </div>
    <?php $this->load->view('footer'); ?> 
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>

  <!-- Custom js for this page-->
  <!-- End custom js for this page-->
</body>



</html>
