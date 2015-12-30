<?php
function writeSetting($handle,$setting,$value) {
  if (fwrite($handle,$setting.' = \''.$value.'\';\n') === FALSE) {
        echo "Could not write ".$setting."\n";
        exit;
    }
}

//initial settings
$form = $_POST['s'];
$continue = TRUE;

//check to see if form has been submitted
if ($form == 1) {

  if ( ! is_writable(__DIR__)) {
    die("Error: %s\n",__DIR__ . ' is not writeable by your webserver. Please ensure the user running the web server is the owner of the directory and has write permissions. On Raspbian is is done by doing: chown www-data ' . __DIR__ . ' and then chmod 0744 ' . __DIR__);
    $continue = FALSE;
  }

  //If all checks look good, proceed
  if ($continue) {
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


    //make the settings.php file
    $handle = fopen(__DIR__ . 'settings.php', 'w');

    fwrite($handle,'<?php\nrequire("rooms.php");\n');
    writeSetting($handle,"$start_time",$start);
    writeSetting($handle,"$end_time",$end);
    writeSetting($handle,"$mailserver",$mail_srv);
    writeSetting($handle,"$sql_server",$sql_server);
    writeSetting($handle,"$sql_username",$sql_username);
    writeSetting($handle,"$sql_password",$sql_password);
    writeSetting($handle,"$passcode",$force_sync);
    fwrite($handle,'$force = FALSE;\n');
    fwrite($handle,'include("theme_settings.php");\n');

    fclose($handle);

  }
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
<label for="start_time">Turn of signs at</label><input type="text" name="start_time" value="04:59" /><br />
<label for="end_time">Turn on signs at</label><input type="text" name="end_time" value="23:59" /><br />
<br />

<label for="force_sync">Force sync passcode</label><input type="text" name="force_sync" /><br />
<br />
<input type="submit" value="create" />



</form>

</body>
</html>
