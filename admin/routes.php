<?php

	include '../init.php';

	//подготовка данных отрезков и вагонов из БД
	function prepareValues(){
		global $template;
		$query = "SELECT `p`.`id`, concat(concat(`from`.`city`,' - ',`from`.`name`), ' => ', concat(`to`.`city`,' - ',`to`.`name`)) as `title`
			FROM `parts` as `p` 
			LEFT JOIN `Stations` as `from` ON `from`.`id` = `p`.`station1` 
			LEFT JOIN  `Stations` as `to` ON `to`.`id` = `p`.station2";
		$result = mysql_query($query);
		$template['formParts'] = array();
		while($row = mysql_fetch_assoc($result)){
			$template['formParts'][] = $row;
		}

		$query = "SELECT `id`, `name` FROM `cars` ORDER BY `name`";
		$result = mysql_query($query);
		$template['formCars'] = array();
		while($row = mysql_fetch_assoc($result)){
			$template['formCars'][] = $row;
		}
	}

	function prepareRoute(){
		global $template;
		$template['routeParts'] = array();
		foreach ($_POST['parts'] as $part) {			
			$template['routeParts'][] = findPart($part);
		}
		$template['routeCars'] = array();
		foreach ($_POST['cars'] as $car) {
			$template['routeCars'][] = $car;
		}
		
	}

	function findPart($id){
		global $template;
		foreach ($template['formParts'] as $item) {
			if ($item['id'] === $id)
				return $item;
		}
		return null;
	}

	function prepareList(){
		global $template;
		$query = "SELECT * FROM Stations ORDER BY `city`, `name`";
		$result = mysql_query($query);
		$template['list'] = array();
		while($row = mysql_fetch_assoc($result)){
			$template['list'][] = $row;
		}
	}
	

	if (isset($_GET['action'])) {
		switch($_GET['action']){
			case 'add': 
				$template['show_form'] = true;
				$template['formAction'] = 'add';
				prepareValues();
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
		if(isset($_POST['action'])){
		switch($_POST['action']){
			case 'add': 
				if (isset($_POST['addPart'])){
					$template['show_form'] = true;
					$template['formAction'] = 'add';
					prepareValues();
					prepareRoute();
					$template['addPart'] = true;
				} else if (isset($_POST['addCar'])){
					$template['show_form'] = true;
					$template['formAction'] = 'add';
					prepareValues();
					prepareRoute();
				} else {
					$template['show_form'] = false;
					prepareList();
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
		} else {
			$template['show_form'] = false;
			prepareList();
		}

		
	}

	include ABSPATH.'/admin/views/routes.php';