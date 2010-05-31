<?php require_once("loggedin.php"); 
require_once("../inc/db.php");
error_reporting(E_ALL);
//print_r($_FILES);

//exit;

if($_POST['do'] == "add") {
	$v3arcade = false;
	if(is_uploaded_file($_FILES['varcade']['tmp_name'])) {
		$file = file_get_contents($_FILES['varcade']['tmp_name']);
		$start = strpos($file,"## EDIT HERE ##");
		$stop = strpos($file,"## NO MORE EDITS BELOW THIS LINE ##");
		$eval = "//".substr($file,$start,$stop-$start);
		eval($eval);
		if(isset($title) && isset($shortname) && isset($description) && isset($game_width) && isset($game_height)) {
			$v3arcade = true;
		}
	}
	
	if($_POST['type'] == "SWF"){
		if(is_uploaded_file($_FILES['swf']['tmp_name'])) {
			$targetpath = "../swf/".basename($_FILES['swf']['name']);
			//$targetpath = basename($_FILES['swf']['name']);
			//echo $targetpath;
			if(move_uploaded_file($_FILES['swf']['tmp_name'],$targetpath)) {
				$swf = str_replace("..","",$targetpath);
			} 
			else echo "error 2";
		} 
		else echo "error 1"; 
	} 
	else {
		$swf = $_POST['url'];
	}
	if(is_uploaded_file($_FILES['thumbnail1']['tmp_name'])) {
		$targetpath = "../thumbs/".basename($_FILES['thumbnail1']['name']);
		if(move_uploaded_file($_FILES['thumbnail1']['tmp_name'],$targetpath)) {
			$image1 = str_replace("..","",$targetpath);
		}
	}
	if(is_uploaded_file($_FILES['thumbnail2']['tmp_name'])) {
		$targetpath = "../thumbs/".basename($_FILES['thumbnail2']['name']);
		if(move_uploaded_file($_FILES['thumbnail2']['tmp_name'],$targetpath)) {
			$image2 = str_replace("..","",$targetpath);
		}
	}
	if(!$v3arcade) {
		$query = "INSERT INTO `games` VALUES (NULL, 
			'".$_POST['shortname']."', 
			'".$_POST['longname']."', 
			'".$image1."', 
			'".$image2."', 
			'".$swf."', 
			'".$_POST['desc']."', 
			'".$_POST['descsmall']."', 
			'".$_POST['width']."', '".$_POST['height']."', 
			'".$_POST['category']."', 
			'".$_POST['type']."', 
			'".$_POST['keywords']."', 
			0, 
			'Yes')";
	}
	else {
		$query = "INSERT INTO `games` VALUES (NULL, 
			'".$shortname."', 
			'".$title."', 
			'".$image1."', 
			'".$image2."', 
			'".$swf."', 
			'".$description."', 
			'".$_POST['descsmall']."', 
			'".$game_width."', '".$game_height."', 
			'".$_POST['category']."', 
			'".$_POST['type']."', 
			'".$_POST['keywords']."', 
			0,
			'Yes')";
	}
	
	@mysql_query($query) or die("<b>MySQL ERROR</b><br /><br />".mysql_error());
	
	echo "<html><head><title>Added Successfully</title></head><body><center><br /><br />Game Added Successfully<br /><br /><br /><a href=\"add.php\">Add Another</a><br /><a href=\"index.php?pane=right\">Return to Admin Index</a></body></html>";
	exit;
}
else {

?>
<html><head>
<title>Add Game</title>
<style type="text/css">
body 
{
 line-height: 2.0em;
}
</style>
</head>
<body>
<form action="add.php" method="post" enctype="multipart/form-data">
<h1>Add Game</h1>

<input type="hidden" name="do" value="add" />
v3Arcade Install File: <input type="file" name="varcade" /><br /><br />

Name: <input type="text" name="longname" /><br />
Short name (url name): <input type="text" name="shortname" /><br />

Category: <select name="category">
<?php include("../inc/db.php"); 
$result = mysql_query("SELECT * FROM `categories` WHERE `type` = 'Games' ORDER BY `name`");
$num = mysql_numrows($result);

for($i=0;$i<$num;$i++) {
	echo "<option value=\"".mysql_result($result,$i,"name")."\">".mysql_result($result,$i,"name")."</option>\n";
}
?>
</select><br />
Description: <br /><textarea name="desc" rows="5" cols="25"></textarea><br />
Description (short, optional):<br /> <textarea name="descsmall" rows="3" cols="25"></textarea><br />

<br />

Type: <select name="type"><option value="SWF">SWF</option><option value="extlink">External Link</option><option value="CustomCode">Custom Code</option></select><br />
SWF: <input type="file" name="swf" /><br />
Thumbnail Large: <input type="file" name="thumbnail1" /><br />
Thumbnail Small (optional): <input type="file" name="thumbnail2" /><br />
<br />
Width: <input type="text" name="width" /><br />
Height: <input type="text" name="height" /><br />
<br />
Keywords: <input type="text" name="keywords" />

<br /><br />
<input type="submit" value="Add Game" />



</form>
<?php
}
?>
</body></html>
