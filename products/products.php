<?php
  if (!isset($_SESSION['username'])) {
    header("Location:../login.php");
    exit();
  }
  require_once('config/connection.php');
  $query = 'SELECT
                  `p`.`id` AS `product_id`,
                  `p`.`category_id`,
                  `p`.`name` AS `name_product`,
                  `c`.`name` AS `name_category`
            FROM `products` AS `p`
            LEFT JOIN `category` AS `c`
            ON `c`.`id` = `p`.`category_id`
            WHERE 1 ORDER BY `p`.`id` DESC';

  $products      = mysqli_query($connection, $query) or die(mysqli_error($connection));
  $products_data = [];
  if (!empty(mysqli_num_rows($products)))
  {
    $products_data = mysqli_fetch_all($products, MYSQLI_ASSOC);
  }
  // echo "<pre>";
  // print_r($products_data);
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
            <h3 class="card-title">Products</h3>
          </div>
          <div class="card-body">
            <a href="index?page=products_add" class="btn btn btn-primary mb-3" style="cursor: pointer">Add Products</a>
            <?php
              if (empty($products_data))
              {
                ?>
                  <center>
                    <h3>Products not found</h3>
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
                        <th>Category Name</th>
                        <th>Product Name</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        foreach ($products_data as $key => $value)
                        {
                          ?>
                            <tr>
                              <td><?php echo $key+1?></td>
                              <td><?php echo $value['name_category']?></td>
                              <td><?php echo $value['name_product']?></td>
                              <td>
                                <a href="index?page=products_edit&id=<?php echo $value['product_id']?>&name=<?php echo $value['name_product']?> " class="btn btn-sm btn-warning" style="cursor: pointer; margin-left: 0.5rem;">Edit</a>
                                <a href="index?page=products_delete&id=<?php echo $value['product_id']?>&name=<?php echo $value['name_product']?>" class="btn btn-sm btn-danger" style="cursor: pointer; margin-left: 0.5rem;">Delete</a>
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
