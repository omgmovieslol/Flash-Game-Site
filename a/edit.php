<?php require_once("loggedin.php"); 
require_once("../inc/db.php");
error_reporting(E_ALL);

function errorproc($content) {
	echo "<html><head><title>Error!</title>
	<script type=\"text/javascript\">
	function goback() {
		history.go(-1);
		return false;
	}
	</script>
	</head><body>
	There was an error processing your information.<br /><br />
	Error: $content<br /><br />
	<a href=\"".$_SERVER['HTTP_REFERER']."\" onclick=\"return goback()\">Go Back</a>
	</body></html>";
	exit;
}

function details($mysql) {
	echo "<html><head><title>Edit Game</title></head><body>";
	echo "<form action=\"edit.php\" method=\"post\">
	<input type=\"hidden\" name=\"id\" value=\"".mysql_result($mysql,0,"id")."\" />
	<input type=\"hidden\" name=\"confirm\" value=\"yes\" />";
	?>
	Name: <input type="text" name="longname" value="<?php echo mysql_result($mysql,0,"longname"); ?>" /><br />
	Short name (url name): <input type="text" name="shortname" value="<?php echo mysql_result($mysql,0,"shortname"); ?>" /><br />

	Category: <select name="category">
	<?php include("../inc/db.php"); 
	$result = mysql_query("SELECT * FROM `categories` WHERE `type` = 'Games' ORDER BY `name`");
	$num = mysql_numrows($result);

	for($i=0;$i<$num;$i++) {
		echo "<option value=\"".mysql_result($result,$i,"name")."\"";
		if(mysql_result($result,$i,"name") == mysql_result($mysql,0,"cat")) {
			echo " selected=\"selected\" ";
		}
		echo ">".mysql_result($result,$i,"name")."</option>\n";
	}
	?>
	</select><br />
	Description: <br /><textarea name="desc" rows="5" cols="25"><?php echo htmlentities(mysql_result($mysql,0,"desc")) ?></textarea><br />
	Description (short, optional):<br /> <textarea name="descsmall" rows="3" cols="25"><?php echo htmlentities(mysql_result($mysql,0,"shortdesc")) ?></textarea><br />

	<br />

	Type: <select name="type"><option value="SWF">SWF</option><option value="extlink">External Link</option><option value="CustomCode">Custom Code</option></select><br />
	SWF: <input type="text" name="swf" value="<?php echo mysql_result($mysql,0,"swf"); ?>"/><br />
	Thumbnail Large: <input type="text" name="thumbnail1" value="<?php echo mysql_result($mysql,0,"thumbnailsmall"); ?>" /><br />
	Thumbnail Small (optional): <input type="text" name="thumbnail2" value="<?php echo mysql_result($mysql,0,"thumbnaillarge"); ?>"/><br />
	<br />
	Width: <input type="text" name="width" value="<?php echo mysql_result($mysql,0,"width"); ?>" /><br />
	Height: <input type="text" name="height" value="<?php echo mysql_result($mysql,0,"height"); ?>"/><br />
	<br />
	Keywords: <input type="text" name="keywords" value="<?php echo mysql_result($mysql,0,"keywords"); ?>" /><br />
	Views: <input type="text" name="views" value="<?php echo mysql_result($mysql,0,"views"); ?>" /><br />

	<br /><br />
	<input type="checkbox" name="deletegame" /> Delete Game? (Cannot be undone)<br />
	<input type="checkbox" name="deleteall" /> Also delete swf and thumbs?<br /><br />
	
	<input type="submit" value="Edit Game" />
	</form>
	</body></html>
	<?php
	exit;

}

$where = "";
if(isset($_GET['q'])) {
	$q = $_GET['q'];
	$where = " WHERE `longname` LIKE '%$q%' OR `desc` LIKE '%$q%' OR `keywords` LIKE '%$q%' ";
}
if(isset($_GET['q']) OR isset($_GET['show'])) {
	$result = mysql_query("SELECT * FROM `games` $where ORDER BY `longname`");
	$num = mysql_numrows($result);
	if($num < 1) errorproc("No games found.");
	if($num == 1) details($result);
	echo "<html><head><title>Select Game</title></head><body>";
	for($i=0;$i<$num;$i++) {
		echo "<a href=\"edit.php?id=".mysql_result($result,$i,"id")."\">".mysql_result($result,$i,"longname")."</a><br />";
	}
	echo "</body></html>";
	exit;
}
if(isset($_GET['id']) AND is_numeric($_GET['id'])) {
	details(mysql_query("SELECT * FROM `games` WHERE `id` = ".$_GET['id']." LIMIT 1"));
}
if(isset($_POST['id']) AND is_numeric($_POST['id'])) {
	if(isset($_POST['confirm']) AND $_POST['confirm'] == "yes") {
		if(isset($_POST['deletegame']) AND $_POST['deletegame'] == "on") {
			if(isset($_POST['deleteall']) AND $_POST['deleteall'] == "on") {
				@unlink("..".$_POST['swf']);
				@unlink("..".$_POST['thumbnail1']);
				@unlink("..".$_POST['thumbnail2']);
			}
			mysql_query("DELETE FROM `games` WHERE `id` = ".$_POST['id']." LIMIT 1") or die("MySQL Error: ".mysql_error());
			echo "Game Successfully Deleted...<a href=\"edit.php\">Go Back To Edit Game Page</a>";
			exit;
		}
		mysql_query("UPDATE	`games` SET `shortname` = '".$_POST['shortname']."', 
		`longname` = '".$_POST['longname']."',
		`cat` = '".$_POST['category']."',
		`desc` = '".$_POST['desc']."',
		`shortdesc` = '".$_POST['descsmall']."',
		`type` = '".$_POST['type']."', 
		`swf` = '".$_POST['swf']."',
		`thumbnailsmall` = '".$_POST['thumbnail1']."', 
		`thumbnaillarge` = '".$_POST['thumbnail2']."',
		`width` = '".$_POST['width']."', 
		`height` = '".$_POST['height']."',
		`keywords` = '".$_POST['keywords']."', 
		`views` = '".$_POST['views']."' 
		WHERE `id` = ".$_POST['id']." LIMIT 1") or die("MySQL Error: ".mysql_error());
		echo "Successfully Editted. <a href=\"edit.php\">Go Back To Edit Games Page</a>";
		exit;
	}
}

?>
<html>
<head><title>Edit Game</title></head>
<body>
Find Game: <form action="edit.php" method="get"><input type="text" name="q" /> <input type="submit" value="Search" />
<br /><br />
<a href="edit.php?show=all">Show All</a>
</body></html>