<?php
  if (!isset($_SESSION['username'])) {
    header("Location:../login.php");
    exit();
  }
  require_once('config/connection.php');
  if (!empty($_POST))
  {
    $name = trim(mysqli_real_escape_string($connection, $_POST['name']));
    mysqli_query($connection, 'INSERT INTO `category` (`name`) values ("'.addslashes($name).'")') or die (mysqli_error($connection));
    echo "<meta http-equiv='refresh' content='0; url=index?page=category'>";
    echo "<center><div class='alert alert-success alert-dismissable'>
      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
      <b>".sprintf('add user %s succesfully', $name)."</b>
    </div><center>";
  }
?>

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Category Add</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Category Add</a></li>
          <li class="breadcrumb-item active">Category Add</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<section class="section">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Category Add</h3>
        </div>
        <div class="card-body">
          <form action="" method="POST">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Name</label>
                <input type="text" class="form-control" aria-describedby="emailHelp" name="name" placeholder="Name" required>
              </div>
              <button type="submit" class="btn btn-primary btn-block">Add</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

