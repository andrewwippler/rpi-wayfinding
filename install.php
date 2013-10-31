<?php

//todo: create database, move settings into settings.php, and create a few rooms

require('settings.php');

$con=mysqli_connect($sql_server,$sql_username,$sql_password) or die("Connect failed: %s\n", mysqli_connect_error());

// Create database
$sql="CREATE DATABASE IF NOT EXISTS rpi-wayfinding";
if (mysqli_query($con,$sql))
  {
  echo "Database my_db created successfully";
  }
else
  {
  echo "Error creating database: " . mysqli_error($con);
  }
  

  
?> 
