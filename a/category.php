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

if(isset($_GET['remove'])) {
	if(isset($_GET['confirm']) AND $_GET['confirm'] == "yes") {
		if(isset($_GET['updategames']) AND $_GET['updategames'] == "on") {
			if($_GET['moveto'] == "") {
				errorproc("Need to set new category name for games to be moved into");
			}
			else {
				mysql_query("UPDATE `games` SET `cat` = '".$_GET['moveto']."' WHERE `cat` = '".$_GET['remove']."'") or die("MySQL Error: ".mysql_error());
			}
		}
		mysql_query("DELETE FROM `categories` WHERE `name` = '".$_GET['remove']."' LIMIT 1") or die("MySQL Error: ".mysql_error());
		echo "Successfully deleted... <a href=\"category.php\">Back To Cateory Management</a>";
		exit;
	}
	
	
	echo "<html><head><title>Confirm Deletion</title></head><body>";
	echo "<br />Are you sure you want to remove category '".$_GET['remove']."'?<br /><br />";
	echo "<form action=\"category.php\" method=\"get\"><input type=\"hidden\" name=\"remove\" value=\"".$_GET['remove']."\" /><input type=\"hidden\" name=\"confirm\" value=\"yes\" /><input type=\"checkbox\" name=\"updategames\" />
	Move games from old category to <select name=\"moveto\">";
	$result = mysql_query("SELECT * FROM `categories` WHERE `name` != '".$_GET['remove']."' ORDER BY `name` ASC");
	for($i=0;$i<mysql_numrows($result);$i++) {
		echo "<option value=\"".mysql_result($result,$i,"name")."\">".mysql_result($result,$i,"name")."</option>";
	}
	echo "</select>?<br /><br />
	<input type=\"submit\" value=\"Confirm\" /> <input type=\"button\" value=\"Cancel\" onclick=\"history.go(-1)\" /></form>
	</body></html>";
	exit;
	
}

if(isset($_GET['edit'])) {
	if(isset($_GET['confirm']) AND $_GET['confirm'] == "yes") {
		if($_GET['newname'] == "") errorproc("You need to put a new name for the category");
		if(isset($_GET['updategames']) AND $_GET['updategames'] == "on") {
			mysql_query("UPDATE `games` SET `cat` = '".$_GET['newname']."' WHERE `cat` = '".$_GET['edit']."'") or die("MySQL Error: ".mysql_error());
		}
		mysql_query("UPDATE `categories` SET `name` = '".$_GET['newname']."' WHERE `name` = '".$_GET['edit']."' LIMIT 1") or die("MySQL Error: ".mysql_error());
		echo "Successfully changed....<a href=\"category.php\">Go Back To Category Management</a>";
		exit;
	}
	
	echo "<html><head><title>Edit Category</title></head><body>
	<form action=\"category.php\" method=\"get\">
	<input type=\"hidden\" name=\"edit\" value=\"".$_GET['edit']."\" />
	<input type=\"hidden\" name=\"confirm\" value=\"yes\" />
	New Name: <input type=\"text\" name=\"newname\" /><br />
	<input type=\"checkbox\" name=\"updategames\" checked=\"checked\" /> Update Games?<br /><br />
	<input type=\"submit\" value=\"Confirm\" /> <input type=\"button\" value=\"Cancel\" onclick=\"history.go(-1)\" /></form>
	</body></html>";
	exit;
}

if(isset($_GET['category'])) {
	mysql_query("INSERT INTO `categories` VALUES(NULL, '".$_GET['category']."', 'Games', '', '', 0)")or die("MySQL Error: ".mysql_error());
	echo "Added ".$_GET['category']."...<a href=\"category.php\">Go Back To Category Management</a>";
	exit;
}

$result = mysql_query("SELECT * FROM `categories` ORDER BY `name` ASC");

echo "<html><head><title>Category Management</title></head><body>";
echo "<table><thead><th>Category</th><th>Num Games</th><th>Remove</th><th>Edit</th></thead>";
for($i=0;$i<mysql_numrows($result);$i++) {
	$category = mysql_result($result,$i,"name");
	echo "<tr><td>$category</td><td style=\"text-align: center;\">".mysql_result(mysql_query("SELECT COUNT(*) AS `count` FROM `games` WHERE `cat` = '$category'"),0,"count")."</td><td><a href=\"category.php?remove=$category\" rel=\"nofollow\">Remove</a></td><td><a href=\"category.php?edit=$category\">Edit</a></tr>";
}
echo "</table>";
?>
<br /><br />
<form action="category.php" method="get">
<input type="text" name="category" /><input type="submit" value="Add New" />
</form>
</body></html>