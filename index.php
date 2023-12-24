<?php
require_once('config/connection.php');

if(isset($_SESSION['username']))
{
	?>
		<!DOCTYPE html>
		<html lang="en">
		<head>
		  <meta charset="utf-8">
		  <meta name="viewport" content="width=device-width, initial-scale=1">
		  <title>Dashboard</title>

		  <!-- Google Font: Source Sans Pro -->
		  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		  <!-- Font Awesome -->
		  <link rel="stylesheet" href="assets/AdminLTE/plugins/fontawesome-free/css/all.min.css">
		  <!-- Ionicons -->
		  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
		  <!-- Tempusdominus Bootstrap 4 -->
		  <link rel="stylesheet" href="assets/AdminLTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
		  <!-- iCheck -->
		  <link rel="stylesheet" href="assets/AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
		  <!-- JQVMap -->
		  <link rel="stylesheet" href="assets/AdminLTE/plugins/jqvmap/jqvmap.min.css">
		  <!-- Theme style -->
		  <link rel="stylesheet" href="assets/AdminLTE/dist/css/adminlte.min.css">
		  <!-- overlayScrollbars -->
		  <link rel="stylesheet" href="assets/AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
		  <!-- Daterange picker -->
		  <link rel="stylesheet" href="assets/AdminLTE/plugins/daterangepicker/daterangepicker.css">
		  <!-- summernote -->
		  <link rel="stylesheet" href="assets/AdminLTE/plugins/summernote/summernote-bs4.min.css">
		  <link rel="stylesheet" href="assets/AdminLTE/plugins/select2/css/select2.min.css">
		</head>
		<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">

		  <!-- Preloader -->
		  <!-- <div class="preloader flex-column justify-content-center align-items-center">
		    <img class="animation__shake" src="assets/AdminLTE/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
		  </div> -->

		  <!-- Navbar -->
		  <?php include_once('templates/navbar.php')?>
		  <!-- /.navbar -->

		  <!-- Main Sidebar Container -->
		  <?php include_once('templates/sidebar.php')?>
		  <!-- Main Sidebar Container -->

		  <!-- Content Wrapper. Contains page content -->
		  <div class="content-wrapper">
		  	<?php include_once 'switch.php'?>
		  </div>
		  <!-- /.content-wrapper -->
		  <footer class="main-footer">
        <p class="mb-0">Copyright <script>document.write(new Date().getFullYear())</script> &copy; Sistem Informasi Rumah Sakit</p>
		  </footer>

		  <!-- Control Sidebar -->
		  <aside class="control-sidebar control-sidebar-dark">
		    <!-- Control sidebar content goes here -->
		  </aside>
		  <!-- /.control-sidebar -->
		</div>
		<!-- ./wrapper -->

		<!-- jQuery -->
		<script src="assets/AdminLTE/plugins/jquery/jquery.min.js"></script>
		<!-- jQuery UI 1.11.4 -->
		<script src="assets/AdminLTE/plugins/jquery-ui/jquery-ui.min.js"></script>
		<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
		<script>
		  $.widget.bridge('uibutton', $.ui.button)
		</script>
		<!-- Bootstrap 4 -->
		<script src="assets/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
		<!-- ChartJS -->
		<script src="assets/AdminLTE/plugins/chart.js/Chart.min.js"></script>
		<!-- Sparkline -->
		<script src="assets/AdminLTE/plugins/sparklines/sparkline.js"></script>
		<!-- JQVMap -->
		<script src="assets/AdminLTE/plugins/jqvmap/jquery.vmap.min.js"></script>
		<script src="assets/AdminLTE/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
		<!-- jQuery Knob Chart -->
		<script src="assets/AdminLTE/plugins/jquery-knob/jquery.knob.min.js"></script>
		<!-- daterangepicker -->
		<script src="assets/AdminLTE/plugins/moment/moment.min.js"></script>
		<script src="assets/AdminLTE/plugins/daterangepicker/daterangepicker.js"></script>
		<!-- Tempusdominus Bootstrap 4 -->
		<script src="assets/AdminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
		<!-- Summernote -->
		<script src="assets/AdminLTE/plugins/summernote/summernote-bs4.min.js"></script>
		<!-- overlayScrollbars -->
		<script src="assets/AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
		<!-- AdminLTE App -->
		<script src="assets/AdminLTE/dist/js/adminlte.js"></script>
		<script src="assets/AdminLTE/plugins/select2/js/select2.full.min.js"></script>
		<script type="text/javascript">
	    $('.select2').select2()
		</script>
		<!-- AdminLTE for demo purposes -->
		<!-- <script src="assets/AdminLTE/dist/js/demo.js"></script> -->
		<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
		<!-- <script src="assets/AdminLTE/dist/js/pages/dashboard.js"></script> -->
		</body>
		</html>

	<?php
}else{
	header("Location:login.php");
	exit();
}
