<?php

//todo: create database, move settings into settings.php, and create a few rooms

require('settings.php');

$con=mysqli_connect($sql_server,$sql_username,$sql_password) or die("Connect failed: %s\n", mysqli_connect_error());

// Create database
$sql="CREATE DATABASE IF NOT EXISTS rpi-wayfinding";
mysqli_query($con,$sql) or die ("Error creating database: " . mysqli_error($con));

//create tables for the rooms
$sql2 = "CREATE TABLE IF NOT EXISTS events
(
PID INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(PID),
EventName TEXT,
Start DATETIME,
End DATETIME,
Room TEXT,
Group TEXT
)";

// Execute query
mysqli_query($con,$sql2) or die("Error creating table: " . mysqli_error($con));



  
?> 
