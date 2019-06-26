
<?php
$this->load->view('header');
$this->load->view('navigation');


?>


<div class="main-panel">
        <div class="content-wrapper">
            
            
          d
            
            
            
            
        </div>
</div>



<script>

//    $(document).ready(function(e) {
//    $('#imports').click(function ()
//    {
////       
//        $.ajax({
//            //data :{action: "showroom"},
//            url: "<?= base_url("GST_3BVs1/import") ?>", //php page URL where we post this data to view from database
//            type: 'POST',
//            success: function (data) {
//
//
//
//                $("#excel-data").html(data);
////                $(".excel-data").show();
//            }
//
//        });
//
//
//
//    });
//    }


    $("#imports").click(function () {

//        alert("helloooo");
        var $this = $(this);
        $this.button('loading');
        setTimeout(function () {
            $this.button('reset');
        }, 2000);

        var formid = document.getElementById("import_form");

        //  var stud_email = $("#stud_email").val();

        $.ajax({
            type: "post",
            url: "<?= base_url("GST_3BVs1/import") ?>",
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


//    $("#historylist").show();
//        $("#excel-data").show();
//        display: none;

    });
//      $("#excel-data").show();
    function  remove_error(id) {
        $('#' + id + '_error').html("");
    }


//    

    function get_graph_fun()
    {
        $.ajax({
            type: "POST",
            url: "<?= base_url("GST_3BVs1/get_graph") ?>",
            dataType: "json",

            success: function (result) {
                if (result.message === "success") {

                    var data_a = result.data_gstr3b;
                    var data_gstr1_res = result.data_gstr1;
//                                    var data_gstr_one_ammend_res = result.data_gstr_one_ammend;
                    var data_difference = result.difference;
                    var cumu_difference = result.cumu_difference;
                    Highcharts.chart('container1', {
                        chart: {
                            type: 'Combination chart'
                        },
                        title: {
                            text: 'Comparison Between GSTR-3B & GSTR-1'
                        },
                        subtitle: {
                            text: 'Customer Name: ANAND RATHI GLOBAL FINANCE LIMITED '
                        },
                        xAxis: {
                            categories: [
                                'March',
                                'February',
                                'January',
                                'December',
                                'November',
                                'October',
                                'September',
                                'August',
                                'July',
                                'June',
                                'May',
                                'April'
                            ],
                            crosshair: true
                        },
                        yAxis: {
//                                            min: 0,
                            max: 10000000,
                            tickInterval: 1000000,
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
                }
            }
        });

    }

</script>