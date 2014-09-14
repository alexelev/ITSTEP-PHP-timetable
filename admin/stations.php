<?php

	include '../init.php';
	include ABSPATH.'/models/stations.php';

	if(isset($_POST['action'])){
		switch($_POST['action']){
			case 'add': 
				if(!empty($_POST['city']) && !empty($_POST['name'])){
					$station = new Station();
					$station->city = $_POST['city'];
					$station->name = $_POST['name'];
					$station->save();
					// $query = "INSERT INTO `Stations` (`city`, `name`)
					// 			VALUES ('{$_POST['city']}', '{$_POST['name']}')";

					// $result = mysql_query($query);
				} else {
					$_GET['action'] = 'add';
					$template['error'] = 'Пустое поле';
				}
				
				break;
			case 'edit': 
				if(!empty($_POST['city']) && !empty($_POST['name'])){
					$station = new Station($_POST['id']);
					$station->city = $_POST['city'];
					$station->name = $_POST['name'];
					$station->save();
						// $query = "UPDATE `Stations` SET `city` = '{$_POST['city']}', `name` = '{$_POST['name']}'
						// 			WHERE `id` = '{$_POST['id']}'";

						// $result = mysql_query($query);
					} else {
						$_GET['action'] = 'edit';
						$template['error'] = 'Пустое поле';
					}

				break;
		}
	}

	if (isset($_GET['action'])) {
		switch($_GET['action']){
			case 'add': 
				$template['show_form'] = true;
				$template['formAction'] = 'add';
				break;
			case 'edit': 
				$template['show_form'] = true;
				$template['formAction'] = 'edit';
				if(isset($_GET['id'])){
					// $station = new Station($_GET['id']);
					//TODO:переделать в шаблоне!!!1
					$template['formStation'] = new Station($_GET['id']);
					// $query = "SELECT `city`, `name` FROM `Stations` WHERE `id` = '{$_GET['id']}'";
					// $result = mysql_query($query) or die(mysql_error());
					// $row = mysql_fetch_assoc($result);
					// $template['formCity'] = $row['city'];
					// $template['formName'] = $row['name'];
					 $template['formId'] = $_GET['id'];

				}
				break;
			case 'delete': 
				$template['showForm'] = false;
				// $query = "DELETE FROM `Stations` WHERE `id` = '{$_GET['id']}'";
				// $result = mysql_query($query) or die(mysql_error());
				Station::delete($_GET['id']);
				header("Location: /admin/stations.php");

			break;
		}
	} else {
		$template['show_form'] = false;

		// $query = "SELECT * FROM Stations ORDER BY `city`, `name`";
		// $result = mysql_query($query);
		// $template['list'] = array();
		// while($row = mysql_fetch_assoc($result)){
		// 	$template['list'][] = $row;
		// }
		$template['list'] = Station::getList();
	}

	include ABSPATH.'/admin/views/stations.php';