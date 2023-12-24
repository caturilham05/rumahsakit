<?php
if (!isset($_SESSION['username'])) {
	header("Location:login.php");
	exit();
}
$page =  isset($_GET['page']) ? $_GET['page'] : 'dashboard';
switch ($page)
{
	case 'orders':
		include 'orders/orders.php';
		break;
	case 'orders_add':
		include 'orders/orders_add.php';
		break;

	case 'category':
		include 'category/category.php';
		break;
	case 'category_add':
		include 'category/category_add.php';
		break;
	case 'category_edit':
		include 'category/category_edit.php';
		break;
	case 'category_delete':
		include 'category/category_delete.php';
		break;

	case 'products':
		include 'products/products.php';
		break;
	case 'products_add':
		include 'products/products_add.php';
		break;
	case 'products_edit':
		include 'products/products_edit.php';
		break;
	case 'products_delete':
		include 'products/products_delete.php';
		break;

	case 'users':
		include 'users/users.php';
		break;
	case 'users_add':
		include 'users/users_add.php';
		break;
	case 'users_edit':
		include 'users/users_edit.php';
		break;
	case 'users_delete':
		include 'users/users_delete.php';
		break;

	default:
		include 'dashboard.php';
		break;
}