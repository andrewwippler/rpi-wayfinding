<?php

//todo: create database, move settings into settings.php, and create a few rooms

if ($_POST['s'] == 1) {

$sql_server = $_POST["DB_srv"];
$sql_username = $_POST["DB_usr"];
$sql_password = $_POST["DB_pw"];
$mail_srv = $_POST["mail_srv"];
$start = $_POST["start_time"];
$end = $_POST["end_time"];
$force_sync = $_POST["force_sync"];

$con=mysqli_connect($sql_server,$sql_username,$sql_password) or die("Connect failed: %s\n". mysqli_connect_error());

// Create database
$sql="CREATE DATABASE IF NOT EXISTS rpiwayfinding";
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
Grp TEXT,
Bldg TEXT
)";

// Execute query
mysqli_query($con,$sql2) or die("Error creating table: " . mysqli_error($con));
 
}

  
?> 

<html>
<head>
<title>RPi - Wayfinding installer</title>
</head>

<body>

<form action="install.php" method="post">
	<input type="hidden" name="s" value="1" />
<label for="DB_srv">Database Server</label><input type="text" name="DB_srv" value="localhost" /><br />
<label for="DB_usr">Database User</label><input type="text" name="DB_usr" /><br />
<label for="DB_pw">Database Password</label><input type="text" name="DB_pw" /><br />


<br />
<label for="mail_srv">Exchange Server (optional)</label><input type="text" name="mail_srv" /><br />
<br />
<label for="start_time">Turn of signs at</label><input type="text" name="start_time" /><br />
<label for="end_time">Turn on signs at</label><input type="text" name="end_time" /><br />
<br />

<label for="force_sync">Force sync passcode</label><input type="text" name="force_sync" /><br />
<br />
<input type="submit" value="create" />



</form>

</body>
</html>
