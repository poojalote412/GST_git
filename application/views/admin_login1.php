<?php
$this->load->view('/customer/header1');
//$this->load->view('/customer/navigation');
?>


<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
            <div class="row w-100 mx-0">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                        <div class="brand-logo">
                            <!--<img src="http://www.urbanui.com/celestial/template/images/logo.svg" alt="logo">-->
                        </div>
                        <!--              <h4>Hello! let's get started</h4>
                                      <h6 class="font-weight-light">Sign in to continue.</h6>-->
                        <form class="pt-3"  method="post" name="f_login" action="<?= base_url() ?>Gst_admin_login/admin_login" id="f_login">
                            <div class="form-group">
                                <input type="text" name="user_id" class="form-control form-control-lg" id="user_id" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password"class="form-control form-control-lg" id="password" placeholder="Password">
                            </div>
                            <div class="m-login__form-action">
                                <span style="color:red"><?= (empty($error)) ? "" : $error ?></span>
                                <span style="color:green"><?= (empty($reason)) ? "" : $reason ?></span>
                            </div>
                            <div class="mt-3">
                                <input value="SIGN IN" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"  type="submit">
                            </div>
                            <div class="my-2 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <label class="form-check-label text-muted">
                                        <input type="checkbox" class="form-check-input">
                                        Keep me signed in
                                    </label>
                                </div>
                                <a href="#" class="auth-link text-black">Forgot password?</a>
                            </div>
                            <!--                <div class="mb-2">
                                              <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                                                <i class="typcn typcn-social-facebook-circular mr-2"></i>Connect using facebook
                                              </button>
                                            </div>-->
                            <div class="text-center mt-4 font-weight-light">
                                Don't have an account? <a href="register.html" class="text-primary">Create</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
