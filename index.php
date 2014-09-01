<?php
	include 'init.php';
	
	$query = "SELECT /*`id`, concat(`city`, ' -> ', `name`)*/ * FROM Stations ORDER BY `city`, `name`";
	$r = mysql_query($query) or die(mysql_error());
	$template['list'] = array();
	while($row = mysql_fetch_assoc($r)){
		$template['list'][] = $row;
	}


	include ABSPATH.'/views/index.php';