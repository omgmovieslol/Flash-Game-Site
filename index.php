<?php

require_once("inc/global.php");
require_once("inc/db.php");
require_once("inc/config.php");

$content = "";


// Get the 5 mot popular
$result = mysql_query("SELECT * FROM `games` ORDER BY `views` DESC LIMIT 0, 5");

$num = mysql_numrows($result);

$content .= "<strong>Most popular Games</strong><table>";
for($i=0;$i<$num;$i++) {
	$content .= "<tr><td><a href=\"$baseurl/play/game/".mysql_result($result,$i,"shortname")."\"><img src=\"$baseurl".mysql_result($result,$i,"thumbnailsmall")."\" alt=\"".mysql_result($result,$i,"longname")."\" /></a></td>";
	$content .= "<td><a href=\"$baseurl/play/game/".mysql_result($result,$i,"shortname")."\">".mysql_result($result,$i,"longname")."</a>";
	$content .= "<br />".mysql_result($result,$i,"desc")."";
	
	$content .= "</td></tr>";
}
$content .= "</table>";

$content .= "<br />";

// Get the last 5 submitted games
$result = mysql_query("SELECT * FROM `games` ORDER BY `id` DESC LIMIT 0, 5");

$num = mysql_numrows($result);

$content .= "<strong>Recently Added Games</strong><table>";
for($i=0;$i<$num;$i++) {
	$content .= "<tr><td><a href=\"$baseurl/play/game/".mysql_result($result,$i,"shortname")."\"><img src=\"$baseurl".mysql_result($result,$i,"thumbnailsmall")."\" alt=\"".mysql_result($result,$i,"longname")."\" /></a></td>";
	$content .= "<td><a href=\"$baseurl/play/game/".mysql_result($result,$i,"shortname")."\">".mysql_result($result,$i,"longname")."</a>";
	$content .= "<br />".mysql_result($result,$i,"desc")."";
	
	$content .= "</td></tr>";
}
$content .= "</table>";

template($sitename,$content);

?>