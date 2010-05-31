<?php
include("config.php");

if($_COOKIE['game_username'] == $user AND ( $_COOKIE['game_hash'] == md5($pass) OR $_COOKIE['game_hash'] == $md5)) { 
	$loggedin = true;
}
else {
	include("../inc/config.php");
	header("Location: $baseurl/a/login.php");
	exit;
}

?>