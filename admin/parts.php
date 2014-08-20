<?php

	include '../init.php';

	if(isset($_POST['action'])){
		switch($_POST['action']){
			case 'add': 
				if(!empty($_POST['from']) && !empty($_POST['to']) && !empty($_POST['length'])){
					$query = "INSERT INTO `parts` (`station1`, `station2`, `length`)
							VALUES ('{$_POST['from']}', '{$_POST['to']}', '{$_POST['length']}')";

					$result = mysql_query($query);
				} else {
					$_GET['action'] = 'add';
					$template['error'] = 'Пустое поле';
				}
				
				break;
			case 'edit': 
				if(!empty($_POST['from']) && !empty($_POST['to']) && !empty($_POST['length'])){
						$query = "UPDATE `parts` SET `station1` = '{$_POST['from']}', `station2` = '{$_POST['to']}', `length` = '{$_POST['length']}'
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
				$query = "SELECT id, CONCAT(`city`,' - ', `name`) as `station` FROM `Stations` ORDER BY `city`, `name`";
				$result = mysql_query($query) or die(mysql_error());
				$template['formStations'] = array();
				while ($row = mysql_fetch_assoc($result)) {
					$template['formStations'][] = $row;
				}
				break;
			case 'edit': 
				$template['show_form'] = true;
				$template['formAction'] = 'edit';
				$query = "SELECT id, CONCAT(`city`,' - ', `name`) as `station` FROM `Stations` ORDER BY `city`, `name`";
				$result = mysql_query($query) or die(mysql_error());
				$template['formStations'] = array();
				while ($row = mysql_fetch_assoc($result)) {
					$template['formStations'][] = $row;
				}
				if(isset($_GET['id'])){
					$query = "SELECT `station1`, `station2`, `length` FROM `parts` WHERE `id` = '{$_GET['id']}'";
					$result = mysql_query($query) or die(mysql_error());
					$row = mysql_fetch_assoc($result);
					$template['formFrom'] = $row['station1'];
					$template['formTo'] = $row['station2'];
					$template['formLength'] = $row['length'];
					$template['formId'] = $_GET['id'];
				}
				break;
			case 'delete': 
				$template['showForm'] = false;
				$query = "DELETE FROM `parts` WHERE `id` = '{$_GET['id']}'";
				$result = mysql_query($query) or die(mysql_error());
				header("Location: /admin/parts.php");

			break;
		}
	} else {
		$template['show_form'] = false;
		$query = "SELECT `p`.`id`, concat(`from`.`city`,' - ',`from`.`name`) AS `from`, 
					concat(`to`.`city`,' - ',`to`.`name`) AS `to`, `p`.`length` AS `length`	
					FROM `parts` as `p` 
					LEFT JOIN `Stations` as `from` ON `from`.`id` = `p`.`station1` 
					LEFT JOIN  `Stations` as `to` ON `to`.`id` = `p`.station2";
		$result = mysql_query($query);
		$template['list'] = array();
		while($row = mysql_fetch_assoc($result)){
			$template['list'][] = $row;
		}
	}

	include ABSPATH.'/admin/views/parts.php';