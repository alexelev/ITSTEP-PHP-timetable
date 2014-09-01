<?php

	include '../init.php';

	if(isset($_POST['action'])){
		switch($_POST['action']){
			case 'add': 
				if(!empty($_POST['city']) && !empty($_POST['name'])){
					$query = "INSERT INTO `Stations` (`city`, `name`)
								VALUES ('{$_POST['city']}', '{$_POST['name']}')";

					$result = mysql_query($query);
				} else {
					$_GET['action'] = 'add';
					$template['error'] = 'Пустое поле';
				}
				
				break;
			case 'edit': 
				if(!empty($_POST['city']) && !empty($_POST['name'])){
						$query = "UPDATE `Stations` SET `city` = '{$_POST['city']}', `name` = '{$_POST['name']}'
									WHERE `id` = '{$_POST['id']}'";

						$result = mysql_query($query);
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
					$query = "SELECT `city`, `name` FROM `Stations` WHERE `id` = '{$_GET['id']}'";
					$result = mysql_query($query) or die(mysql_error());
					$row = mysql_fetch_assoc($result);
					$template['formCity'] = $row['city'];
					$template['formName'] = $row['name'];
					$template['formId'] = $_GET['id'];
				}
				break;
			case 'delete': 
				$template['showForm'] = false;
				$query = "DELETE FROM `Stations` WHERE `id` = '{$_GET['id']}'";
				$result = mysql_query($query) or die(mysql_error());
				header("Location: /admin/stations.php");

			break;
		}
	} else {
		$template['show_form'] = false;
		$query = "SELECT 
					`o`.`id`,
					concat(concat(`rfrom`.`city`,' - ',`rfrom`.`name`), ' => ', concat(`rto`.`city`,' - ',`rto`.`name`)) as `route`,
					concat(concat(`ofrom`.`city`,' - ',`ofrom`.`name`), ' => ', concat(`oto`.`city`,' - ',`oto`.`name`)) as `path`,
					`o`.`car`, `o`.`place`, `o`.`name`, `o`.`date`, `o`.`price`
					FROM `orders` AS `o`
					LEFT JOIN `routes` AS `r` ON `o`.`id_route` = `r`.`id`
					LEFT JOIN `Stations` AS `ofrom` ON `o`.`id_stationFrom` = `ofrom`.`id`
					LEFT JOIN `Stations` AS `oto` ON `o`.`id_stationTo` = `oto`.`id`
					LEFT JOIN `Stations` AS `rfrom` ON `r`.`stFrom` = `rfrom`.`id`
					LEFT JOIN `Stations` AS `rto` ON `r`.`stTo` = `rto`.`id`
					";
		$result = mysql_query($query);
		$template['list'] = array();
		while($row = mysql_fetch_assoc($result)){
			$template['list'][] = $row;
		}
	}

	include ABSPATH.'/admin/views/orders.php';