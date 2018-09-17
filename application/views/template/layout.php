<?php 
    $CI =& get_instance();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title><?= @$title; ?> </title>

    <!-- Bootstrap -->
    <link href="<?= site_url();?>assets/gantelela/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?= site_url();?>assets/gantelela/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?= site_url();?>assets/gantelela/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?= site_url();?>assets/gantelela/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	
    <!-- bootstrap-progressbar -->
    <link href="<?= site_url();?>assets/gantelela/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="<?= site_url();?>assets/gantelela/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="<?= site_url();?>assets/gantelela/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="<?= site_url();?>assets/gantelela/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <link href="<?= site_url();?>assets/gantelela/vendors/normalize-css/normalize.css" rel="stylesheet">
    <link href="<?= site_url();?>assets/gantelela/vendors/ion.rangeSlider/css/ion.rangeSlider.css" rel="stylesheet">
    <link href="<?= site_url();?>assets/gantelela/vendors/ion.rangeSlider/css/ion.rangeSlider.skinFlat.css" rel="stylesheet">
    

    <!-- Custom Theme Style -->
    <link href="<?= site_url();?>assets/gantelela/build/css/custom.min.css" rel="stylesheet">

    <style>
        .form-error{
            color:red;
        }
    </style>

    <!-- jquery -->
    <script src="<?= site_url();?>assets/gantelela/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?= site_url();?>assets/gantelela/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?= site_url();?>assets/gantelela/vendors/moment/min/moment.min.js"></script>

    <script src="<?= site_url();?>assets/gantelela/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <!-- sidebar -->
        <?php $CI->load->view(@$sidebar);?>
        <!-- /sidebar -->

        <!-- top navigation -->
        <?php $CI->load->view('template/header');?>
        <!-- /top navigation -->

        <!-- page content -->
        <?php $CI->load->view(@$content);?>
        <!-- /page content -->

        <!-- footer content -->
        <?php $CI->load->view('template/footer');?>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
  
    <!-- FastClick -->
    <script src="<?= site_url();?>assets/gantelela/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?= site_url();?>assets/gantelela/vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="<?= site_url();?>assets/gantelela/vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="<?= site_url();?>assets/gantelela/vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="<?= site_url();?>assets/gantelela/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="<?= site_url();?>assets/gantelela/vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="<?= site_url();?>assets/gantelela/vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="<?= site_url();?>assets/gantelela/vendors/Flot/jquery.flot.js"></script>
    <script src="<?= site_url();?>assets/gantelela/vendors/Flot/jquery.flot.pie.js"></script>
    <script src="<?= site_url();?>assets/gantelela/vendors/Flot/jquery.flot.time.js"></script>
    <script src="<?= site_url();?>assets/gantelela/vendors/Flot/jquery.flot.stack.js"></script>
    <script src="<?= site_url();?>assets/gantelela/vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="<?= site_url();?>assets/gantelela/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="<?= site_url();?>assets/gantelela/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="<?= site_url();?>assets/gantelela/vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="<?= site_url();?>assets/gantelela/vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="<?= site_url();?>assets/gantelela/vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="<?= site_url();?>assets/gantelela/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="<?= site_url();?>assets/gantelela/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    
    <script src="<?= site_url();?>assets/gantelela/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?= site_url();?>assets/gantelela/build/js/custom.min.js"></script>
	
  </body>
</html>
