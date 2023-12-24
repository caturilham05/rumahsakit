<?php
  if (!isset($_SESSION['username'])) {
    header("Location:../login.php");
    exit();
  }
  require_once('config/connection.php');
  $category_q    = mysqli_query($connection, 'SELECT `id`, `name` FROM `category` WHERE 1') or die(mysqli_error($connection));
  $category_data = [];
  if (!empty(mysqli_num_rows($category_q)))
  {
    $category_data = mysqli_fetch_all($category_q, MYSQLI_ASSOC);
  }

  if (!empty($_POST))
  {
    $category_id = $_POST['category_id'] ?? 0;
    $name        = trim(mysqli_real_escape_string($connection, $_POST['name']));
    mysqli_query($connection, 'INSERT INTO `products` (`category_id`, `name`) values ('.intval($category_id).', "'.addslashes($name).'")') or die (mysqli_error($connection));
    echo "<meta http-equiv='refresh' content='2; url=index?page=products'>";
    echo "<div class='alert alert-success alert-dismissable'>
      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
      <b>".sprintf('add product %s succesfully', $name)."</b>
    </div>";
  }

  // echo "<pre>";
  // print_r($category_data);
  // echo "</pre>";

?>

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Products Add</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Products Add</a></li>
          <li class="breadcrumb-item active">Products Add</li>
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
          <h3 class="card-title">Products Add</h3>
        </div>
        <div class="card-body">
          <form action="" method="POST">
            <div class="mb-3">
							<label for="category_id">Category</label>
							<select name="category_id" class="form-control" required>
                <option value="">-- Category --</option>
                <?php
                	foreach ($category_data as $value)
                	{
                		?>
			                <option value="<?php echo $value['id']?>"><?php echo $value['name']?></option>
                		<?php
                	}
                ?>
              </select>
            </div>

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

