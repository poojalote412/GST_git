<?php
$this->load->view('customer/header');
$this->load->view('customer/navigation');

//Check user login or not using session

if ($session = $this->session->userdata('login_session') == '') {
//take them back to signin 
//    echo 'fghjf';
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


<div class="main-panel">
        <div class="content-wrapper">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Account Report</h4>
                        <form class="forms-sample" id="import_form" method="post" name="import_form" enctype="multipart/form-data">


                                <div class="form-group">
                                    <label>File upload</label>
                                    <input type="file" name="file_ex" class="file-upload-default">
                                    <div class="input-group col-xs-12">
                                        <input type="text" class="form-control file-upload-info" name="file_ex" id="file_ex" required accept=".xls, .xlsx" disabled placeholder="Upload File">
                                        <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-primary"  type="button" >Upload</button>
                                        </span>
                                    </div>
                                </div>


                                <button type="button" name="imports" id="imports" class="btn btn-primary mr-2">Submit</button>
                                <button class="btn btn-light">Cancel</button>
                        </form><br>
                        
                        <button type="button" name="get_graph" id="get_graph" onclick="get_graph_fun();"class="btn btn-primary mr-2" >Get Graph</button>
                            <div id="container1"></div>
                            <div id="container2"></div>
                    </div>
                </div>
            </div> 
            
        </div>
</div>

<?php $this->load->view('customer/footer');?>
<script>
    
    $("#imports").click(function () {
        alert("ujhguj");
                var $this = $(this);
                $this.button('loading');
                setTimeout(function () {
                    $this.button('reset');
                }, 2000);

                var formid = document.getElementById("import_form");

                //  var stud_email = $("#stud_email").val();

                $.ajax({
                    type: "post",
                    url: "<?= base_url("Account_report/import") ?>",
                    dataType: "json",
                    data: new FormData(formid), //form data
                    processData: false,
                    contentType: false,
                    cache: false,
                    async: false,
                    //            data: $("#Add_UniversityStudent").serialize(),
                    success: function (result) {
                        // alert(result.error);
                        if (result.status === true) {
                            alert('Data Submitted Successfully');
                            // return;
                            location.reload();
                        } else if (result.status === false) {
                            alert('something went wrong')
                        } else {
                            $('#' + result.id + '_error').html(result.error);
                            $('#message').html(result.error);
                        }
                    },
                    error: function (result) {
                        //                console.log(result);
                        if (result.status === 500) {
                            alert('Internal error: ' + result.responseText);
                        } else {
                            alert('Unexpected error.');
                        }
                    }
                });
            });
            function  remove_error(id) {
                $('#' + id + '_error').html("");
            }
    </script>