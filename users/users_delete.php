<?php
$id   = $_GET['id'] ?? 0;
$name = $_GET['name'] ?? '';

if (empty($id) || empty($name))
{
	echo 'user not found';
}

$delete = mysqli_query($connection, 'DELETE FROM `users` WHERE `id` = '.intval($id)) or die (mysqli_error($connection));
if (empty($delete))
{
	echo 'failed';
}
else
{
  echo "<meta http-equiv='refresh' content='0; url=index?page=users'>";
}


