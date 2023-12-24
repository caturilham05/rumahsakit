<?php
  if (!isset($_SESSION['username'])) {
    header("Location:../login.php");
    exit();
  }
  require_once('config/connection.php');
  $users      = mysqli_query($connection, 'SELECT `id`, `name`, `username` FROM `users` WHERE 1') or die(mysqli_error($connection));
  $users_data = [];
  if (!empty(mysqli_num_rows($users)))
  {
    $users_data = mysqli_fetch_all($users, MYSQLI_ASSOC);
  }
  // echo "<pre>";
  // print_r($users_data);
  // echo "</pre>";

?>
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><?php echo $_GET['page']?></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#"><?php echo $_GET['page']?></a></li>
          <li class="breadcrumb-item active"><?php echo $_GET['page']?></li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Users</h3>
          </div>
          <div class="card-body">
            <a href="index?page=users_add" class="btn btn btn-primary mb-3" style="cursor: pointer">Add Users</a>
            <?php
              if (empty($users_data))
              {
                ?>
                  <center>
                    <h3>Users not found</h3>
                  </center>
                <?php
              }
              else
              {
                ?>
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        foreach ($users_data as $key => $value)
                        {
                          ?>
                            <tr>
                              <td><?php echo $key+1?></td>
                              <td><?php echo $value['name']?></td>
                              <td><?php echo $value['username']?></td>
                              <td>
                                <a href="index?page=users_edit&id=<?php echo $value['id']?>&name=<?php echo $value['name']?> " class="btn btn-sm btn-warning" style="cursor: pointer; margin-left: 0.5rem;">Edit</a>
                                <a href="index?page=users_delete&id=<?php echo $value['id']?>&name=<?php echo $value['name']?>" class="btn btn-sm btn-danger" style="cursor: pointer; margin-left: 0.5rem;">Delete</a>
                              </td>
                            </tr>
                          <?php
                        }
                      ?>
                    </tbody>
                  </table>
                <?php
              }
            ?>
          </div>
        </div>
      </div>
    </div>

  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
