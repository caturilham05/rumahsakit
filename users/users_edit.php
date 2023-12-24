<?php
  if (!isset($_SESSION['username'])) {
    header("Location:../login.php");
    exit();
  }
  require_once('config/connection.php');
  $id        = $_GET['id'] ?? 0;
  $name      = $_GET['name'] ?? '';
  $user      = mysqli_query($connection, 'SELECT `id`, `name`, `username`, `password` FROM `users` WHERE `id` = '.intval($id).' LIMIT 1') or die(mysqli_error($connection));
  $user_data = [];
  $msg       = '';
  if (!empty(mysqli_num_rows($user)))
  {
    $user_data = mysqli_fetch_assoc($user);
  }

  if (!empty($_POST))
  {
    if ($_POST['password'] != $_POST['password_conf'] )
    {
      $msg = "<div class='alert alert-danger alert-dismissable'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <b>Password not match with Password Confirmation</b>
      </div>";
    }
    else
    {
      $name     = trim(mysqli_real_escape_string($connection, $_POST['name']));
      $username = trim(mysqli_real_escape_string($connection, $_POST['username']));
      $password = md5(trim(mysqli_real_escape_string($connection, $_POST['password'])));
      $updated = mysqli_query($connection, 'UPDATE `users` SET `name` = "'.addslashes($name).'", `username` = "'.addslashes($username).'", `password` = "'.addslashes($password).'" WHERE `id` = '.intval($id)) or die (mysqli_error($connection));
      if (empty($updated))
      {
        $msg = "<div class='alert alert-danger alert-dismissable'>
          <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
          <b>".sprintf('%s Failed updated', $name)."</b>
        </div>";
      }
      else
      {
        echo "<meta http-equiv='refresh' content='0; url=index?page=users'>";
        $msg = "<div class='alert alert-success alert-dismissable'>
          <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
          <b>".sprintf('%s successfully updated', $name)."</b>
        </div>";
      }
    }
  }
?>

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Users Edit</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Users Edit</a></li>
          <li class="breadcrumb-item active">Users Edit</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<?php
  if (empty($user_data))
  {
    ?>
      <center>
        <h4>User with name <b><?php echo $name?></b> not found</h4>
      </center>
    <?php
  }
  else
  {
    ?>
      <section class="section">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users Edit</h3>
              </div>
              <div class="card-body">
                <?php echo $msg?>
                <form action="" method="POST">
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Name</label>
                      <input type="text" class="form-control" aria-describedby="emailHelp" name="name" placeholder="Name" value="<?php echo $user_data['name']?>" required>
                    </div>

                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Username</label>
                      <input type="text" class="form-control" aria-describedby="emailHelp" name="username" placeholder="Username" value="<?php echo $user_data['username']?>" required>
                    </div>

                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Password</label>
                      <input type="password" class="form-control" aria-describedby="emailHelp" name="password" placeholder="Password" required>
                    </div>

                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Password Confirmation</label>
                      <input type="password" class="form-control" aria-describedby="emailHelp" name="password_conf" placeholder="Password Confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Edit</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
    <?php
  }
?>