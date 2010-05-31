<?php

require_once("inc/global.php");
require_once("inc/db.php");
require_once("inc/config.php");

$q = sqlfix($_GET['q']);

$where = " WHERE `longname` LIKE '%$q%' OR `desc` LIKE '%$q%' OR `keywords` LIKE '%$q%' ";
$limit = " LIMIT 0, $gamesperpage ";
if(isset($_GET['page']) AND is_numeric($_GET['page'])) {
	$limit = "LIMIT ".($gamesperpage * ($_GET['page']-1)).", $gamesperpage ";
}
$order = " ORDER BY `longname` ASC ";

$query = "SELECT * FROM `games` $where $order $limit";
$result = mysql_query($query);
$num = mysql_numrows($result);

if($num < 1) {
	template("No Games Found","No games to display.  :(");
}

$content = "<table>";
for($i=0;$i<$num;$i++) {
	$content .= "<tr><td><a href=\"$baseurl/play/game/".mysql_result($result,$i,"shortname")."\"><img src=\"$baseurl".mysql_result($result,$i,"thumbnailsmall")."\" alt=\"".mysql_result($result,$i,"longname")."\" /></a></td>";
	$content .= "<td><a href=\"$baseurl/play/game/".mysql_result($result,$i,"shortname")."\">".mysql_result($result,$i,"longname")."</a>";
	$content .= "<br />".mysql_result($result,$i,"desc")."";
	
	$content .= "</td></tr>";
}

$content .= "</table>";

$url = "$baseurl/search/$q";


$totalcount = mysql_result(mysql_query("SELECT COUNT(*) AS `count` FROM `games` $where"),0,"count");
$content .= "<br /><center>".pagination($totalcount,$_GET['page'],$url)."</center>";
$pagename = "browse";
template("Search results for: $q",$content);

?>

