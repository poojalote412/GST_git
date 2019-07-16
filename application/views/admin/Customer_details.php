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
    $username = ($session_data['customer_id']);
} else {
    $username = $this->session->userdata('login_session');
}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Customer Details
            <!--<small>it all starts here</small>-->
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <!--            <li><a href="#">Examples</a></li>-->
            <li class="active">Customer Details</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"></h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div><br>
            <div class="actions" style="float: right;">
                <div class="btn-group">
                    <a href="add_customer"><button id="" class="btn btn-primary"> 
                            <i class="fa fa-plus"></i>
                            Add New Customer
                        </button>
                    </a>
                </div>
            </div><br><br>
            <div class="box-body">


                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Customer</th>
                            <th>Email ID</th>
                            <th>Contact No</th>
                            <th>Created On</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
//                                    var_dump($cfo_data);
                        if ($result !== "") {
                            $i = 1;
                            foreach ($result as $row) {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row->customer_name; ?></td>
                                    <td><?php echo $row->customer_email_id; ?></td>
                                    <td><?php echo $row->customer_contact_number; ?></td>
                                    <td><?php echo $row->created_on; ?></td>
        <!--                                    <td><button type="button" name="get_graph" id="get_graph" onclick="get_graph_fun('<?php echo $row->customer_id; ?>');"class="btn btn-outline-primary" >Edit</button>
                                    <button type="button" name="get_graph" id="get_graph" onclick="get_graph_fun('<?php echo $row->customer_id; ?>');"class="btn btn-outline-primary" >Delete</button></td>
                                    -->
                                    <td><a class="btn btn-circle red btn-icon-only btn-default" onclick="delete_designation('CA')"><i class="fa fa-remove"></i></a>
                                        <a class="btn btn-circle blue btn-icon-only btn-default" data-toggle="modal" data-target="#edit_designation" data-desig_id="CA"><i class="fa fa-pencil"></i></a></td>
                                </tr> 
                                <?php
                                $i++;
                            }
                        } else {
                            
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div id="container"></div>

        </div>

    </section>

</div>


<?php $this->load->view('customer/footer'); ?>

<script>

</script>

