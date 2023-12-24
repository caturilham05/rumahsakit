<?php
  if (!isset($_SESSION['username'])) {
    header("Location:../login.php");
    exit();
  }
  require_once('config/connection.php');
  $invoice = '#'.date('dmY').'/'.rand();
  $user    = mysqli_query($connection, 'SELECT `id` FROM `users` WHERE `username` = "'.addslashes($_SESSION['username']).'" LIMIT 1') or die(mysqli_error($connection));
  $user_id = [];
  if (!empty(mysqli_num_rows($user)))
  {
    $user_id = mysqli_fetch_assoc($user);
  }

  $order_q = 'SELECT `id`, `invoice`, `created` FROM `orders` WHERE `user_id` = '.intval($user_id['id']).' AND `status` = 0 LIMIT 1';
  $order      = mysqli_query($connection, $order_q) or die(mysqli_error($connection));
  $order_data = [];
  if (!empty(mysqli_num_rows($order)))
  {
    $order_data = mysqli_fetch_assoc($order);
  }
  else
  {
    mysqli_query($connection, 'INSERT INTO `orders` (`invoice`, `user_id`) values ("'.addslashes($invoice).'", '.intval($user_id['id']).')') or die (mysqli_error($connection));
    echo "<meta http-equiv='refresh' content='0; url=index?page=orders_add'>";
  }

  $order_product_q = 'SELECT
                            `op`.*,
                            `o`.`invoice`,
                            `o`.`qty`   AS `qty_total`,
                            `o`.`price` AS `price_total`,
                            `c`.`name`  AS `name_category`,
                            `p`.`name`  AS `name_product`
                      FROM `orders_products` AS `op`
                      LEFT JOIN `orders` AS `o`
                      ON `o`.`id` = `op`.`order_id`
                      LEFT JOIN `products` AS `p`
                      ON `p`.`id` = `op`.`product_id`
                      LEFT JOIN `category` AS `c`
                      ON `c`.`id` = `op`.`category_id`
                      WHERE `o`.`user_id` = '.intval($user_id['id']).' AND `op`.`status` = 0 ORDER BY `op`.`id` DESC';
  $order_product      = mysqli_query($connection, $order_product_q) or die(mysqli_error($connection));
  $order_product_data = [];
  if (!empty(mysqli_num_rows($order_product)))
  {
    $order_product_data = mysqli_fetch_all($order_product, MYSQLI_ASSOC);
  }

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

  if (!empty($_POST))
  {
    switch ($_POST['button'])
    {
      case 1:
        $product_id       = $_POST['product_id'] ?? 0;
        $qty              = $_POST['qty'] ?? 0;
        $price            = $_POST['price'] ?? 0;
        $category_id      = mysqli_query($connection, 'SELECT `category_id` FROM `products` WHERE `id` = '.intval($product_id).' LIMIT 1') or die(mysqli_error($connection));
        $category_id_data = [];
        if (!empty(mysqli_num_rows($category_id)))
        {
          $category_id_data = mysqli_fetch_assoc($category_id);
        }

        mysqli_query($connection, 'INSERT INTO `orders_products` (`order_id`, `product_id`, `category_id`, `qty`, `price`) values ('.intval($order_data['id']).', '.intval($product_id).', '.intval($category_id_data['category_id']).', '.intval($qty).', '.floatval($price).')') or die (mysqli_error($connection));
        echo "<meta http-equiv='refresh' content='0; url=index?page=orders_add'>";
        break;

      case 2:
        $qty_total   = 0;
        $price_total = 0;
        foreach ($order_product_data as $key => $value)
        {
          $qty_total   += $value['qty'];
          $price_total += $value['price'];
        }

        $updated               = mysqli_query($connection, 'UPDATE `orders` SET `qty` = '.intval($qty_total).', `price` = '.floatval($price_total).', `status` = 1 WHERE `id` = '.intval($order_data['id'])) or die (mysqli_error($connection));
        $updated_order_product = mysqli_query($connection, 'UPDATE `orders_products` SET `status` = 1 WHERE `order_id` = '.intval($order_data['id'])) or die (mysqli_error($connection)); 
        echo "<meta http-equiv='refresh' content='0; url=index?page=orders'>";
        break;

      case 3:
        $order_product_id      = $_POST['order_product_id'] ?? 0;
        $qty                   = $_POST['qty'] ?? 0;
        $price                 = $_POST['price'] ?? 0;
        $updated_order_product = mysqli_query($connection, 'UPDATE `orders_products` SET `qty` = '.intval($qty).', `price` = '.floatval($price).' WHERE `id` = '.intval($order_product_id)) or die (mysqli_error($connection)); 
        echo "<meta http-equiv='refresh' content='0; url=index?page=orders_add'>";
        break;

      case 4:
        $order_product_id      = $_POST['order_product_id'] ?? 0;
        $updated_order_product = mysqli_query($connection, 'DELETE FROM `orders_products` WHERE `id` = '.intval($order_product_id)) or die (mysqli_error($connection)); 
        echo "<meta http-equiv='refresh' content='0; url=index?page=orders_add'>";
        break;

      default:
        // code...
        break;
    }
    // $name = trim(mysqli_real_escape_string($connection, $_POST['name']));
    // mysqli_query($connection, 'INSERT INTO `orders` (`name`) values ("'.addslashes($name).'")') or die (mysqli_error($connection));
    // echo "<meta http-equiv='refresh' content='0; url=index?page=orders'>";
    // echo "<center><div class='alert alert-success alert-dismissable'>
    //   <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
    //   <b>".sprintf('add user %s succesfully', $name)."</b>
    // </div><center>";
  }
  // echo "<pre>";
  // print_r([$products_data, $_POST, $user_id, $order_product_data, $order_data]);
  // echo "</pre>";

?>

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Orders Add</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Orders Add</a></li>
          <li class="breadcrumb-item active">Orders Add</li>
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
          <h3 class="card-title">Orders Add</h3>
        </div>
        <div class="card-body">
          <form action="" method="POST">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Invoice</label>
                <h3><?php echo @$order_data['invoice']?></h3>
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Order Date</label>
                <h5><?php echo @date('d F Y H:i', strtotime($order_data['created']))?></h5>
              </div>
              <?php
                if (!empty($order_product_data))
                {
                  ?>
                    <button type="submit" class="btn btn-primary btn-block" name="button" value="2">Create Order</button>
                  <?php
                }
              ?>
          </form>
          <?php
            if (!empty($order_product_data))
            {
              ?>
                <hr>
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Category Name</th>
                      <th>Product Name</th>
                      <th>Qty</th>
                      <th>Price</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      foreach ($order_product_data as $key => $order)
                      {
                        ?>
                          <tr>
                            <td><?php echo $key + 1?></td>
                            <td><?php echo $order['name_category']?></td>
                            <td><?php echo $order['name_product']?></td>
                            <form action="" method="POST">
                              <input type="hidden" class="form-control" aria-describedby="emailHelp" name="order_product_id" value="<?php echo $order['id']?>">
                              <td>
                                <div class="mb-3">
                                  <input type="text" class="form-control" aria-describedby="emailHelp" name="qty" placeholder="Qty" value="<?php echo $order['qty']?>">
                                </div>
                              </td>
                              <td>
                                <div class="mb-3">
                                  <input type="text" class="form-control" aria-describedby="emailHelp" name="price" placeholder="Price" value="<?php echo $order['price']?>">
                                </div>
                              </td>
                              <td>
                                <button type="submit" class="btn btn-warning btn-sm" name="button" value="3">Edit</button>
                                <button type="submit" class="btn btn-danger btn-sm" name="button" value="4">Delete</button>
                              </td>
                            </form>
                          </tr>
                        <?php
                      }
                    ?>
                  </tbody>
                </table>
              <?php
            }
          ?>
          <hr>
          <form action="" method="POST">
              <div class="mb-3">
                <label>Products</label>
                <select class="select2" style="width: 100%;" name="product_id">
                  <?php
                    foreach ($products_data as $key => $value)
                    {
                      ?>
                        <option value="<?php echo $value['product_id']?>"><?php echo $value['name_product']?></option>
                      <?php
                    }
                  ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Qty</label>
                <input type="number" min="1" class="form-control" aria-describedby="emailHelp" name="qty" placeholder="Qty" required>
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Price</label>
                <input type="number" min="1000" class="form-control" aria-describedby="emailHelp" name="price" placeholder="Price" required>
              </div>
              <button type="submit" class="btn btn-primary btn-block" name="button" value="1">Add Order Products</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

