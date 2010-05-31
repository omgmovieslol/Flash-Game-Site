<?php

function sqlcheck($string) {
	return preg_match("/[a-zA-z0-9]/ix",$string);
}

function sqlfix($string) {
	return preg_replace("/[^a-zA-Z0-9_-\s]*/ix","",$string);
}

function checkbot() {
	$agent = $_SERVER['HTTP_USER_AGENT'];
	$bots = array('Googlebot', 'Mediapartners', 'ia_archiver', 'Gigabot', 'grub-client', 'Yahoo! Slurp', 'inktomi', 'msnbot', 'W3C_Validator', 'Jigsaw', 'Ask Jeeves', 'gsa-crawler');
	$isbot = false;
	foreach($bots as $bot) {
		if(strpos($agent, $bot) !== FALSE) {
			$isbot = true;
			break;
		}
	}
	return $isbot;	
}


function pagination($total,$page,$url) {
	global $gamesperpage;
	$content = "";
	
	if($page == "") {
		$page = 1;
	}
	
	$numpages = ceil($total/$gamesperpage);
	if($page > 1) {
		$content .= "<a href=\"$url/page/1\">&lt;&lt;</a> ";
	}
	if($page > 1) {
		$content .= "<a href=\"$url/page/".($page-1)."\">Previous</a> ";
	}
	if($page > 4) {
		$content .= "... ";
	}
	$curpage = $page - 3;
	if($curpage < 1) {
		$curpage = 1;
	}
	for($i=0;$i<6 && $curpage<=$numpages; $i++) {
		if($curpage != $page) {
			$content .= "<a href=\"$url/page/$curpage\">$curpage</a> ";
		}
		else {
			$content .= "$curpage ";
		}
		$curpage++;
	}
	if($curpage < $numpages) {
		$content .= "... ";
	}
	if($page < $numpages) {
		$content .= "<a href=\"$url/page/".($page+1)."\">Next</a> ";
		$content .= "<a href=\"$url/page/$numpages\">&gt;&gt;</a>";
	}
	
	return $content;
}

function keywordparse($keywords) {
	global $baseurl;
	$keywords = explode(", ",$keywords);
	$return = "";
	foreach($keywords as $keyword) {
		if($return != "")
			$return .= ", ";
		$return .= "<a href=\"$baseurl/keyword/".spacetodash($keyword)."\">$keyword</a>";
	}
	return $return;
}

function spacetodash($string) {
	return str_replace(" ","-",$string);
}

function dashtospace($string) {
	return str_replace("-"," ",$string);
}

function template($title,$content) {
	global $baseurl;
	include("template.tpl");
	exit;
}



?>

