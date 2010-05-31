<?php

require_once("inc/global.php");
require_once("inc/db.php");

if(sqlcheck($_GET['name'])) {
	$name = $_GET['name'];
}
else $name = "";

$result = mysql_query("SELECT * FROM `games` WHERE `shortname` = '$name' LIMIT 0, 1");

if(mysql_numrows($result) < 1) {
	template("Game Not Found","The game you request was not found.");
}
if(!isset($_GET['do']) AND $_GET['do'] != "reload") {
	if(!checkbot()) {
		@mysql_query('UPDATE `games` SET `views` = \''.(mysql_result($result,0,"views")+1).'\' WHERE `games`.`id` = '.mysql_result($result,0,"id").' LIMIT 1;');
	}
}
	
include("inc/config.php");

$content = "";

$content .= "<center><h3>".mysql_result($result,0,"longname")."</h3><br />\n\n";

$embed = "<embed allowScriptAccess=\"never\" src=\"$baseurl".mysql_result($result,0,"swf")."\" width=".mysql_result($result,0,"width")." height=".mysql_result($result,0,"height")." align=\"center\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\"></embed>";
$content .= $embed."<br />";

$content .= "<br /><a href=\"$baseurl/play/game/".mysql_result($result,0,"shortname")."/reload\" rel=\"nofollow\">Retry</a><br />";

$content .= "<a href=\"$baseurl".mysql_result($result,0,"swf")."\">View Game In Fullscreen</a><br />";

$content .= "<br /><span class=\"smallfont\">Add this to your MySpace Profile<br /><textarea cols=60 rows=4 readonly onclick=\"focus();select();\" style=\"width: 97%; height: 75px; font-size: 12px;\">".htmlentities("<b><a href=\"$baseurl/play/game/".mysql_result($result,0,"shortname")."\">".mysql_result($result,0,"longname")."</a><br>".$embed."<b><center><a href=\"$baseurl\">Get more games at $sitename</a></center></b>")."</textarea><br />Just Copy and Paste the Above Code</span><br />";

if(mysql_result($result,0,"keywords") != "") {
	$keywords = "Keywords:<br />".keywordparse(mysql_result($result,0,"keywords"))."";
}

$content .= "</center>";
$pagename = "game";
$views = mysql_result($result,0,"views")+1;
template(mysql_result($result,0,"longname"),$content);

?>

