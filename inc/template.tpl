<?php
global $pubid, $channelright, $channeltop, $channelleft;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<?php
if(isset($_GET['do']) AND $_GET['do'] == "reload") {
	echo "<META NAME=\"ROBOTS\" content=\"NOINDEX,FOLLOW\" />";
}
?>
<script type="text/javascript">
function highlight(field) 
{
	field.focus();
	field.select();
}
</script>
<style type="text/css">
/*---- Layout ----*/
div
{
	padding: 0;
	margin: 0;
}
body
{
	padding: 20px;
	margin: 0;
}
#oldbrowser
{
	text-align: center;
}
#masthead h1
{
	display: inline;
}
#leftcolumn
{
	margin-right: -200px;	/* IE 4 fix */
}
#leftColumn
{
	float: left;
	width: 150px;
	/*/*/ /*/margin: 0 0 0 2px; /* Silly Netscape hack to get the borders to line up */
}
#rightColumn
{
	float: right;
	width: 160px;
}
#contentColumn
{
	width: auto;
	margin-left: 149px;
}
#masthead, #innerLeftColumn, #innerContentColumn, #innerRightColumn, #innerFooter
{
	padding: 10px;
}
#footer
{
	clear: both;
}
#innerFooter
{
	text-align: center;
}
#innerContentColumn
{
	overflow: visible;
	height: 100%;	/* fix the Win32 IE float bug */
	margin-right: 160px;
	/*/*/ /*/margin: 0 0 0 2px; /* Silly Netscape hack to get the borders to line up */
}
#contentColumn>#innerContentColumn
{
	height: auto;	/* fix Opera 5 which breaks with the above IE fix */
}
#innercontentcolumn
{
	height: 100%;	/* fix IE 5.0 which parse the Opera fix, note the selector is all lower case */
}
#masthead, #footer
{
	z-index: 10;
}

/*---- Borders ----*/
#pageFrame
{
	border: solid 1px #000;
}
#footer, #masthead, #innerLeftColumn, #contentColumn, #innerContentColumn
{
	border: solid 0px #000;
}
#footer
{
	border-top-width: 1px;
	font-size: 75%;
}
#masthead
{
	border-bottom-width: 1px;
}
#innerLeftColumn, #innerContentColumn
{
	border-right-width: 1px;
}
#contentColumn
{
	border-left-width: 1px;
}

/*---- Visual Elements ----*/
body
{
	background-color: #222222;
	color: #2B2B2B;
	padding: 20px;
	margin: 0;
}
a:link, a:visited {

	color:#1a81e0;

}

a:hover, a:active {

	text-decoration:none;

	color:#FFFFFF;

	background-color:#1a81e0;

}
#pageFrame
{
	background-color:#fff;
	background-image:url(<?php echo $baseurl; ?>/images/bg-content.gif);
	background-repeat:repeat-x;
	background-position:top center;
	color: #2B2B2B;
	min-width: 500px;
	font-family:Arial, sans-serif;
}

div#oldbrowser
{
	display: none;
}

a img
{
	border-width: 0;
}
#innerLeftColumn img
{
	display: block;
	margin: 0 auto;
	text-align: center;	/* IE 5 centering hack */
}
#innerRightColumn
{
	border-left: solid 1px #000;
	margin-left: -1px;
}

.vnav ul, .vnav ul li
{
	margin: 0;
	padding: 0;
	list-style-type: none;
	display: block;
}
.vnav ul
{
	border: solid 1px #000;
	border-bottom-width: 0;
}
.vnav ul li
{
	border-bottom: solid 1px #000;
}
.vnav ul li a
{
	display: block;
	text-decoration: none;
	padding: 2px 10px;
	color: #1a81e0;
	background-color: #fff;
	font-size: 80%;
	font-weight: bold;
}
.vnav ul li a:hover
{
	background-color: #1a81e0;
	color: #fff;
}

.vnav
{
	margin-bottom: 1em;
}


#masthead a:link, #masthead a:visited
{
	color: #2B2B2B;
	text-decoration: none;
}
#masthead a:hover, #masthead a:active
{
	color: #00348F;
}

input, textarea
{
	background-color: #fff;
	background-image:url(<?php echo $baseurl; ?>/images/bg-content.gif);
	background-repeat:repeat-x;
	background-position:top center;
}
.smallfont
{
	font-size: 75%;
}

</style>
<?php
	global $sitename,$baseurl;
	echo "<title>$title - $sitename</title>\n";
?>
</head><body>
<div id="pageFrame"><div id="masthead">
<span style="float:right;"><form action="<?php echo $baseurl; ?>/search.php" method="get"><input type="text" name="q" value="<?php global $q; echo $q; ?>" />
<input type="submit" value="Search" /></form></span>
<h1><a href="<?php echo $baseurl."/"; ?>"><?php echo $sitename; ?></a></h1>
</div>
<div id="leftColumn">
<div id="innerLeftColumn">
	<div class="vnav">
	<ul>
		<li><a href="<?php echo $baseurl; ?>/">Home</a></li>
		<li><a href="<?php echo $baseurl; ?>/browse-games">Browse Games</a></li>
		<li><a href="<?php echo $baseurl; ?>/recently-added">Recently Added</a></li>
		<li><a href="<?php echo $baseurl; ?>/most-played">Most Played</a></li>
	</ul>
	<br />
	<span style="font-size: 75%; font-weight: bold;">Categories</span>
	<ul>
		<?php
		$result = mysql_query("SELECT * FROM `categories` WHERE `type` = 'Games' ORDER BY `name` ASC");
		for($i=0;$i<mysql_numrows($result);$i++) {
			echo "<li><a href=\"$baseurl/category/".strtolower(mysql_result($result,$i,"name"))."\">".mysql_result($result,$i,"name")."</a></li>";
		}
		?>
	</ul>
	</div>
	<script type="text/javascript"><!--
	google_ad_client = "<?php echo $pubid; ?>";
	google_ad_width = 120;
	google_ad_height = 240;
	google_ad_format = "120x240_as";
	google_ad_type = "text_image";
	//2007-03-03: freeflashgames-top
	google_ad_channel = "<?php echo $channelleft; ?>";
	google_color_border = "FFFFFF";
	google_color_bg = "FFFFFF";
	google_color_link = "1a81e0";
	google_color_text = "2B2B2B";
	google_color_url = "1a81e0";
	//--></script>
	<script type="text/javascript"
	  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script>
	
</div>
</div>
<div id="contentColumn">
<div id="rightColumn"><div id="innerRightColumn">

<?php
	global $pagename;
	if($pagename == "game") {
		global $views,$keywords;
		echo "Views: $views<br />";
		echo $keywords;
	}
	if($pagename == "browse" OR $pagename == "search") {
		global $num, $totalcount;
		echo "Showing <strong>$num</strong> Out Of <strong>$totalcount</strong><br />";
	}

?>
	<br /><br />
	<script type="text/javascript">
	google_ad_client = "<?php echo $pubid; ?>";
	google_ad_width = 120;
	google_ad_height = 600;
	google_ad_format = "120x600_as";
	google_ad_type = "text_image";
	//2007-03-03: freeflashgames-right
	google_ad_channel = "<?php echo $channelright; ?>";
	google_color_border = "FFFFFF";
	google_color_bg = "FFFFFF";
	google_color_link = "1a81e0";
	google_color_text = "2B2B2B";
	google_color_url = "1a81e0";
	</script>
	<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
</div></div>

<div id="innerContentColumn">
<center><script type="text/javascript">
google_ad_client = "<?php echo $pubid; ?>";
google_ad_width = 468;
google_ad_height = 60;
google_ad_format = "468x60_as";
google_ad_type = "text_image";
//2007-03-03: freeflashgames-top
google_ad_channel = "<?php echo $channeltop; ?>";
google_color_border = "FFFFFF";
google_color_bg = "FFFFFF";
google_color_link = "1a81e0";
google_color_text = "2B2B2B";
google_color_url = "1a81e0";
</script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></center><br />

<?php echo $content; ?></div>
</div>

<div id="footer">
<div id="innerFooter">&copy; <?php echo date("Y")." ".$sitename; ?><!--<br /><a href="http://nothingoutoftheordinary.com/gamescript/">Gamescript v 1.0</a>--></div>
</div>

</div>

</body></html>