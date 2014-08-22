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
			$template['routeCars'][] = findCar($car);
		}
		$template['formMessage'] = $_POST['message'];
		$template['formDate'] = $_POST['date'];
	}

	function findPart($id){
		global $template;
		foreach ($template['formParts'] as $item) {
			if ($item['id'] === $id)
				return $item;
		}
		return null;
	}

	function findCar($id){
		global $template;
		foreach ($template['formCars'] as $item) {
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
					$template['addCar'] = true;
				} else {
					$template['show_form'] = false;
					prepareList();
					$query = 'SELECT `station1` FROM `parts` WHERE `id` = '.$_POST['parts'][0];
					$result = mysql_query($query) or die(mysql_error());
					$station1 = current(mysql_fetch_assoc($result));
					
					$query = 'SELECT `station1` FROM `parts` WHERE `id` = '.$_POST['parts'][count($_POST['parts']) - 1];
					$result = mysql_query($query) or die(mysql_error());
					$station2 = current(mysql_fetch_assoc($result));

					$timeFrom = $_POST['timeFrom'][0];
					$timeTo = $_POST['timeTo'][count($_POST['timeTo']) - 1];
					$date = $_POST['date'];
					$message = $_POST['message'];
					$cars = implode(',', $_POST['cars']);

					$query = "INSERT INTO `routes` (`stFrom`, `stTo`, `message`, `cars`, `timeFrom`, `timeTo`, `date`) VALUES ($station1, $station2, '$message', '$cars', CAST('$timeFrom' AS TIME), CAST('$timeTo' AS TIME), CAST('$date' AS DATE))";
						// echo $query;
						// die();
					$result = mysql_query($query) or die(mysql_error());

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

	// echo '<pre>';
	// var_dump($template, $_POST);
	// print_r($template);
	// echo '</pre>';

	include ABSPATH.'/admin/views/routes.php';


	//TODO: запоминать время отрезков в $_POST, заполнить таблицу route_parts
	//mysql_insert_id()