<?php

	define('ABSPATH', dirname(__FILE__));
	$csr = '123';

	$connect = mysql_connect('localhost', 'root', '');
	$db = mysql_select_db('trains', $connect);
	mysql_set_charset('utf8', $connect);
	$template = array();

    include_once ABSPATH.'/models/stations.php';
//    include_once ABSPATH.'/models/parts.php';
    include_once ABSPATH.'/models/part.php';
    include_once ABSPATH.'/models/orders.php';
    include_once ABSPATH.'/models/routes.php';