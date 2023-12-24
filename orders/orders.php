<?php
  if (!isset($_SESSION['username'])) {
    header("Location:../login.php");
    exit();
  }
  require_once('config/connection.php');
  $q = 'SELECT
  						`op`.`id`,
  						`op`.`order_id`,
  						`o`.`invoice`,
  						`o`.`status`,
  						`o`.`created`,
  						`op`.`qty`,
  						`op`.`price`,
  						`p`.`name` AS `product_name`,
  						`c`.`name` AS `category_name`
  			FROM `orders_products` AS `op`
  			LEFT JOIN `orders` AS `o`
  			ON `o`.`id` = `op`.`order_id`
  			LEFT JOIN `products` AS `p`
  			ON `p`.`id` = `op`.`product_id`
  			LEFT JOIN  `category` AS `c`
  			ON `c`.`id` = `op`.`category_id`
  			WHERE 1 ORDER BY `op`.`id` DESC';
  $orders      = mysqli_query($connection, $q) or die(mysqli_error($connection));
  $orders_data = [];
  if (!empty(mysqli_num_rows($orders)))
  {
    $orders_data = mysqli_fetch_all($orders, MYSQLI_ASSOC);
  }
  // echo "<pre>";
  // print_r($orders_data);
  // echo "</pre>";
?>
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><?php echo @$_GET['page']?></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#"><?php echo @$_GET['page']?></a></li>
          <li class="breadcrumb-item active"><?php echo @$_GET['page']?></li>
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
            <h3 class="card-title">Orders</h3>
          </div>
          <div class="card-body">
            <a href="index?page=orders_add" class="btn btn btn-primary mb-3" style="cursor: pointer">Add Orders</a>
            <?php
              if (empty($orders_data))
              {
                ?>
                  <center>
                    <h3>Orders not found</h3>
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
                        <th>Invoice</th>
                        <th>Product Name</th>
                        <th>Category Name</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Created</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        foreach ($orders_data as $key => $value)
                        {
                          ?>
                            <tr>
                              <td><?php echo $key+1?></td>
                              <td><?php echo $value['invoice']?></td>
                              <td><?php echo $value['product_name']?></td>
                              <td><?php echo $value['category_name']?></td>
                              <td><?php echo $value['qty']?></td>
                              <td><?php echo $value['price']?></td>
                              <td><?php echo empty($value['status']) ? 'Proses' : 'Selesai'?></td>
                              <td><?php echo date('d F Y H:i:s', strtotime($value['created']))?></td>
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

