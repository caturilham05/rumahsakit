<?php
$id   = $_GET['id'] ?? 0;
$name = $_GET['name'] ?? '';

if (empty($id) || empty($name))
{
	echo 'category not found';
}

$delete = mysqli_query($connection, 'DELETE FROM `category` WHERE `id` = '.intval($id)) or die (mysqli_error($connection));
if (empty($delete))
{
	echo 'failed';
}
else
{
  echo "<meta http-equiv='refresh' content='2; url=index?page=category'>";
  echo "<div class='alert alert-success alert-dismissable'>
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
    <b>".sprintf('%s successfully delete', $name)."</b>
  </div>";
}


