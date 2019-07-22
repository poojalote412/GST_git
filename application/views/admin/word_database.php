<?php
$this->load->view('customer/header');
$this->load->view('admin/navigation');
?>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Test
             <!--<small>it all starts here</small>-->
        </h1>


        <!--<button id="cmd">generate PDF</button>-->
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">Blank page</li>
        </ol>
    </section>

    <!-- Main content -->
    <form class="form" id="ff">

        <section class="content">

            <!-- Default box -->


            <div class="box-body">
               
 <form method="post" id="import_form" name="import_form" enctype="multipart/form-data">
                    <p><label>Select Excel File</label>
                        <input type="file" name="file_ex" id="file_ex" aria-required="true" required accept=".xls,.xlsx,.rtf"/></p>
                    <br/>
                    <input type="button" name="import" id="import" value="import"  class="btn btn-info" />
                </form>
                <div id="container"></div>

                <!--</iframe>-->
            </div>


        </section>

    </form>
    <!-- /.content -->
</div>




<?php $this->load->view('customer/footer'); ?>
<!-- these js files are used for making PDF -->
<script>


    $("#import").click(function (event) {
//        alert("hu");
//        var formid = document.getElementById('import_form');
        event.preventDefault();
        $.ajax({
           type: "POST",
            url: "<?= base_url("Word_database/word_to_database") ?>",
            dataType: "json",
            data: $("#import_form").serialize(),
            success: function (result) {
                if (result.message === "success") {
                    alert('Data inserted Successfully');


                } else if (result.status === false) {
                    alert('something went wrong')
                } else {
                    $('#' + result.id + '_error').html(result.error);
                    $('#message').html(result.error);
                }
            },
        });
    });
</script>



<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script> 


<script>
(function () {

    var
            form = $('.form'),
            cache_width = form.width(),
            a4 = [595.28, 841.89]; // for a4 size paper width and height  

    $('#create_pdf').on('click', function () {
        $('body').scrollTop(0);
        createPDF();
    });
    //create pdf  
    function createPDF() {
        getCanvas().then(function (canvas) {
            var
                    img = canvas.toDataURL("image/png"),
                    doc = new jsPDF({
                        unit: 'px',
                        format: 'a4'
                    });
            doc.addImage(img, 'JPEG', 20, 20);
            doc.save('GST.pdf');
            form.width(cache_width);
        });
    }

    // create canvas object  
    function getCanvas() {
        form.width((a4[0] * 1.33333) - 80).css('max-width', 'none');
        return html2canvas(form, {
            imageTimeout: 2000,
            removeContainer: true
        });
    }

}());
</script>  
<script>
    /* 
     * jQuery helper plugin for examples and tests 
     */
    (function ($) {
        $.fn.html2canvas = function (options) {
            var date = new Date(),
                    $message = null,
                    timeoutTimer = false,
                    timer = date.getTime();
            html2canvas.logging = options && options.logging;
            html2canvas.Preload(this[0], $.extend({
                complete: function (images) {
                    var queue = html2canvas.Parse(this[0], images, options),
                            $canvas = $(html2canvas.Renderer(queue, options)),
                            finishTime = new Date();

                    $canvas.css({position: 'absolute', left: 0, top: 0}).appendTo(document.body);
                    $canvas.siblings().toggle();

                    $(window).click(function () {
                        if (!$canvas.is(':visible')) {
                            $canvas.toggle().siblings().toggle();
                            throwMessage("Canvas Render visible");
                        } else {
                            $canvas.siblings().toggle();
                            $canvas.toggle();
                            throwMessage("Canvas Render hidden");
                        }
                    });
                    throwMessage('Screenshot created in ' + ((finishTime.getTime() - timer) / 1000) + " seconds<br />", 4000);
                }
            }, options));

            function throwMessage(msg, duration) {
                window.clearTimeout(timeoutTimer);
                timeoutTimer = window.setTimeout(function () {
                    $message.fadeOut(function () {
                        $message.remove();
                    });
                }, duration || 2000);
                if ($message)
                    $message.remove();
                $message = $('<div ></div>').html(msg).css({
                    margin: 0,
                    padding: 10,
                    background: "#000",
                    opacity: 0.7,
                    position: "fixed",
                    top: 10,
                    right: 10,
                    fontFamily: 'Tahoma',
                    color: '#fff',
                    fontSize: 12,
                    borderRadius: 12,
                    width: 'auto',
                    height: 'auto',
                    textAlign: 'center',
                    textDecoration: 'none'
                }).hide().fadeIn().appendTo('body');
            }
        };
    })(jQuery);

</script> 