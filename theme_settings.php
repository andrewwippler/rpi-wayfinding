<?php

// set the theme
$theme = "default";

//custom date range example
if (date("w") == "0") {
$theme = "default";
}

//load the config of the theme
include( __DIR__ . "/theme/{$theme}/config.php");
