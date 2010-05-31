<?php
if($_POST['do'] == "login") {
	setcookie("game_username",$_POST['username']);
	setcookie("game_hash",md5($_POST['password']));
	include("../inc/config.php");
	header("Location: $baseurl/a/index.php");
	exit;
}
?>
<html>
<head>
<title>Admin Login</title>
</head>
<body>
<form action="login.php" method="post">
<center><br /><br /><br />
Username<br />
<input type="text" name="username" /><br />
Password<br />
<input type="password" name="password" /><br />
<input type="hidden" name="do" value="login" />
<br /><input type="submit" value="Log In" />
</center>
</form>
</body>
</html>