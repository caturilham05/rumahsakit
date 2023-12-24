<?php
	require_once('config/connection.php');
	if (isset($_SESSION['username']))
	{
		header('Location: index');
    exit();
	}

	if (isset($_POST['username']) && isset($_POST['password']))
	{
    $username = trim(mysqli_real_escape_string($connection, $_POST['username']));
    $password = md5(trim(mysqli_real_escape_string($connection, $_POST['password'])));

    $login = mysqli_query($connection, "select * from users where username = '$username' and password = '$password'") or die(mysqli_error($connection));
    if (!empty(mysqli_num_rows($login)))
    {
		  session_start();
    	$_SESSION['username'] = $username;
			header("Location:index");
      exit();
    }
		else
		{
			?>
	      <div class="col-lg-offset-3">
	        <div class="alert alert-danger alert-dismissable" role="danger">
	          <a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
	          <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	          <strong>Login Gagal</strong>&nbsp;Username atau Password Salah!
	        </div>
	      </div>
			<?php
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Admin RS</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/AdminLTE/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets/AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/AdminLTE/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Admin</b> Rumah Sakit</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Username" name="username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="assets/AdminLTE/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="assets/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/AdminLTE/dist/js/adminlte.min.js"></script>
</body>
</html>
