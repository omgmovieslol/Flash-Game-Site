<?php

$dbhost = "localhost";
$dbname = "database";
$dbuser = "username";
$dbpass = "password";


mysql_connect($dbhost,$dbuser,$dbpass) or die("MySQL Connection error");
@mysql_select_db($dbname) or die("Unable to select database");


?>
