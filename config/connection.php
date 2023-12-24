<?php
  session_start();
  $host = "localhost";
  $user = "root";
  $password = "";
  $nama_db = "rumahsakit";

  $connection = mysqli_connect($host, $user, $password, $nama_db);
  
  //!check connection
  if(mysqli_connect_errno())
  {
      echo "connection database gagal : " . mysqli_connect_error();
  }

ini_set('display_errors', 1);