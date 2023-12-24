<?php
  if (!isset($_SESSION['username'])) {
    header("Location:../login.php");
    exit();
  }
  require_once('config/connection.php');
  $id            = $_GET['id'] ?? 0;
  $name          = $_GET['name'] ?? '';
  $category_q    = mysqli_query($connection, 'SELECT `id`, `name` FROM `category` WHERE 1') or die(mysqli_error($connection));
  $product_q     = mysqli_query($connection, 'SELECT `id`, `category_id`, `name` FROM `products` WHERE `id` = '.intval($id).' LIMIT 1') or die(mysqli_error($connection));
  $category_data = [];
  $product_data  = [];
  if (!empty(mysqli_num_rows($category_q)))
  {
    $category_data = mysqli_fetch_all($category_q, MYSQLI_ASSOC);
  }

  if (!empty(mysqli_num_rows($product_q)))
  {
  	$product_data = mysqli_fetch_assoc($product_q);
  }

  if (!empty($_POST))
  {
    $category_id = $_POST['category_id'] ?? 0;
    $name        = trim(mysqli_real_escape_string($connection, $_POST['name']));
    $updated     = mysqli_query($connection, 'UPDATE `products` SET `category_id` = '.intval($category_id).', `name` = "'.addslashes($name).'"WHERE `id` = '.intval($id)) or die (mysqli_error($connection));

    if (empty($updated))
    {
      echo "<div class='alert alert-danger alert-dismissable'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <b>".sprintf('%s Failed updated', $name)."</b>
      </div>";
    }
    else
    {
      echo "<meta http-equiv='refresh' content='2; url=index?page=products'>";
      echo "<div class='alert alert-success alert-dismissable'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <b>".sprintf('%s successfully updated', $name)."</b>
      </div>";
    }
  }

  // echo "<pre>";
  // print_r($product_data);
  // echo "</pre>";

?>

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Products Edit</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Products Edit</a></li>
          <li class="breadcrumb-item active">Products Edit</li>
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
          <h3 class="card-title">Products Edit</h3>
        </div>
        <div class="card-body">
          <form action="" method="POST">
            <div class="mb-3">
							<label for="category_id">Category</label>
							<select name="category_id" class="form-control" required>
                <?php
                	foreach ($category_data as $value)
                	{
                		?>
				              <option value="<?php echo $value['id']?>" <?php echo $value['id'] == @$product_data['category_id'] ? 'selected' : ''?>><?php echo $value['name']?></option>
                		<?php
                	}
                ?>
              </select>
            </div>

            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Name</label>
              <input type="text" class="form-control" aria-describedby="emailHelp" name="name" placeholder="Name" value="<?php echo $product_data['name']?>" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Edit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

