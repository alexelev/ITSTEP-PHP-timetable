<?php

	include '../init.php';

    echo('<pre>');
    print_r($template['routeParts']);
    echo('</pre>');

	//подготовка данных отрезков и вагонов из БД
    //для заполнения $template['formParts'], $template['formCars']
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

    //подготовка данных из POST для заполнения
    //$template['routeParts'], $template['routeCars'], $template['routeTimeFrom'],
    //$template['routeTimeTo'], $template['formMtssage'], $template['formDate']
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
        $template['routeTimeFrom'] = array();
        foreach ($_POST['timeFrom'] as $item){
            $template['routeTimeFrom'][] = $item;
        }
        $template['routeTimeTo'] = array();
        foreach ($_POST['timeTo'] as $item){
            $template['routeTimeTo'][] = $item;
        }
		$template['formMessage'] = $_POST['message'];
		$template['formDate'] = $_POST['date'];
	}

    //для поиска данных $template['formParts'] по id
	function findPart($id){
		global $template;
		foreach ($template['formParts'] as $item) {
			if ($item['id'] === $id)
				return $item;
		}
		return null;
	}

    //для поиска данных $template['formCars'] по id
	function findCar($id){
		global $template;
		foreach ($template['formCars'] as $item) {
			if ($item['id'] === $id)
				return $item;
		}
		return null;	
	}

    //для заполнения $template['list'] из БД
	function prepareList(){
		global $template;
		$query = "SELECT * FROM Stations ORDER BY `city`, `name`";
		$result = mysql_query($query);
		$template['list'] = array();
		while($row = mysql_fetch_assoc($result)){
			$template['list'][] = $row;
		}
	}

    //для заполнения $template['routesList'] из БД
	function prepareRoutesList(){
		global $template;
		$query = "SELECT `routes`.`id`, concat(concat(`from`.`city`, ' - ', `from`.`name`), ' => ', concat(`to`.`city`, ' - ', `to`.`name`)) as `title`, `date`
			FROM `routes`
			LEFT JOIN `Stations` as `from` ON `from`.`id` = `routes`.`stFrom`
			LEFT JOIN `Stations` as `to` ON `to`.`id` = `routes`.`stTo`";
		$result = mysql_query($query);
		$template['routesList'] = array();
		while ($row = mysql_fetch_assoc($result)) {
			$template['routesList'][] = $row;
		}
	}

    //получение данных из БД для заполнения формы при редактировании маршрута
	function prepareRouteFromDB($id){
		global $template;
		$template['formId'] = $id;
		$query = "SELECT `message`, `date`, `cars` 
					FROM `routes`
					WHERE `routes`.`id` = $id";
		$result = mysql_query($query) or die(mysql_error());
		$row = mysql_fetch_assoc($result);
		$template['formMessage'] = $row['message'];
		$template['formDate'] = $row['date'];
		$template['routeCars'] = array();
		$tmpCars = explode(',', $row['cars']);
		foreach ($tmpCars as $item) {
			$template['routeCars'][] = findCar($item);
		}
		$template['routeTimeFrom'] = array();
		$template['routeTimeTo'] = array();
		$template['routeParts'] = array();
		$query = "SELECT `id_part`, `timeFrom`, `timeTo`
					FROM `routes_parts`
					WHERE `id_route` = $id";
		$result = mysql_query($query) or die(mysql_error());
		while($row = mysql_fetch_assoc($result)){
			$template['routeTimeFrom'][] = $row['timeFrom'];
			$template['routeTimeTo'][] = $row['timeTo'];
			$template['routeParts'][] = findPart($row['id_part']);
		}	
	// echo '<pre>';
	 // var_dump($template, $_POST);
	// print_r($template['routeParts']);
	// echo '</pre>';			
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
				if (isset($_GET['id'])){
					prepareValues();
					prepareRouteFromDB($_GET['id']);
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
                } elseif (isset($_POST['delete'])){
                    $template['show_form'] = true;
                    $template['formAction'] = 'edit';

//                    echo('<br/><pre>');
//                    print_r($_POST['parts']);
//                    echo('</pre><br/>');

                    unset($_POST['parts'][$_POST['delete']]);
                    array_values($_POST['parts']);

//                    echo('<pre>');
//                    print_r($_POST['parts']);
//                    echo('</pre>');

                    prepareValues();
                    prepareRoute();
				} else {
					$template['show_form'] = false;
					prepareRoutesList();
					$query = 'SELECT `station1` FROM `parts`
					            WHERE `id` = '.$_POST['parts'][0];
					$result = mysql_query($query) or die(mysql_error());
					$station1 = current(mysql_fetch_assoc($result));
					
					$query = "SELECT `station1` FROM `parts`
					            WHERE `id` = ".$_POST['parts'][count($_POST['parts']) - 1];
					$result = mysql_query($query) or die(mysql_error());
					$station2 = current(mysql_fetch_assoc($result));

					$timeFrom = $_POST['timeFrom'][0];
					$timeTo = $_POST['timeTo'][count($_POST['timeTo']) - 1];
					$date = $_POST['date'];
					$message = $_POST['message'];
					$cars = implode(',', $_POST['cars']);

					$query = "INSERT INTO `routes` (`stFrom`, `stTo`, `message`,
					            `cars`, `timeFrom`, `timeTo`, `date`)
					            VALUES ($station1, $station2, '$message', '$cars',
					            CAST('$timeFrom' AS TIME), CAST('$timeTo' AS TIME),
					             CAST('$date' AS DATE))";
//						 echo $query;
//						 die();
					$result = mysql_query($query) or die(mysql_error());

                    $routeID = mysql_insert_id();
                    foreach (/*$template['routeParts']*/ $_POST['parts'] as $key => $part) {
                        $id = $part;
                        $timeFrom = $_POST['timeFrom'][$key];
                        $timeTo = $_POST['timeTo'][$key];
                        // $timeFrom = $template[routeTimeFrom][$key];
                        // $timeTo = $template[routeTimeTo][$key];
                        $query = "INSERT INTO `routes_parts` (`id_route`, `id_part`, `timeFrom`, `timeTo`)
                                    VALUES ($routeID, $id,
                                    CAST('$timeFrom' AS TIME),
                                    CAST('$timeTo' AS TIME))";
						// echo $query.'<br/>';
						// die();
                        $result = mysql_query($query) or die(mysql_error());
                    }
                    
                    // die();

                }
				break;
			case 'edit':
				if (isset($_POST['addPart'])){
					$template['show_form'] = true;
					$template['formAction'] = 'edit';
					prepareValues();
					prepareRoute();
					$template['formId'] = $_POST['id'];
					$template['addPart'] = true;
				} else if (isset($_POST['addCar'])){
					$template['show_form'] = true;
					$template['formAction'] = 'edit';
					prepareValues();
					prepareRoute();
					$template['formId'] = $_POST['id'];
					$template['addCar'] = true;
                }elseif (isset($_POST['delete'])){
                    $template['show_form'] = true;
                    $template['formAction'] = 'edit';

                   // echo('<br/><pre>');
                   // print_r($_POST['parts']);
                   // echo(count($_POST['parts']));
                   // echo('</pre><br/>');

                    unset($_POST['parts'][$_POST['delete']]);
                    array_values($_POST['parts']);

                   // echo('<pre>');
                   // echo(count($_POST['parts']));
                   // print_r($_POST['parts']);
                   // echo('</pre>');

                    prepareValues();
                    prepareRoute();
                    $template['formId'] = $_POST['id'];
				} else {
					$template['show_form'] = false;
					prepareRoutesList();
					$query = 'SELECT `station1` FROM `parts`
					            WHERE `id` = '.$_POST['parts'][0];
					$result = mysql_query($query) or die(mysql_error());

					$station1 = current(mysql_fetch_assoc($result));
					
					$query = "SELECT `station1` FROM `parts`
					            WHERE `id` = ".$_POST['parts'][count($_POST['parts']) - 1];
					$result = mysql_query($query) or die(mysql_error());

					$station2 = current(mysql_fetch_assoc($result));

					$timeFrom = $_POST['timeFrom'][0];
					$timeTo = $_POST['timeTo'][count($_POST['timeTo']) - 1];
					$date = $_POST['date'];
					$message = $_POST['message'];
					$cars = implode(',', $_POST['cars']);

//                    die('1');
					$query = "UPDATE `routes`
								SET `stFrom` = $station1, `stTo` = $station2, `timeFrom` = CAST('$timeFrom' AS TIME),
								    `timeTo` = CAST('$timeTo' AS TIME), `message` = '$message',
								    `date` = CAST('$date' AS DATE), `cars` = '$cars'
								WHERE `id` = {$_POST['id']}";
								// echo "$query";
					$result = mysql_query($query) or die(mysql_error());
//					 die('1');
					$query = "DELETE FROM `routes_parts` WHERE `id_route` = {$_POST['id']}";
					$result = mysql_query($query) or die(mysql_error());
					foreach ($_POST['parts'] as $key => $part) {
                        $id = $part;
                        $timeFrom = $_POST['timeFrom'][$key];
                        $timeTo = $_POST['timeTo'][$key];
                        $query = "INSERT INTO `routes_parts` (`id_route`, `id_part`, `timeFrom`, `timeTo`)
                                    VALUES ({$_POST['id']}, $id,
                                    CAST('$timeFrom' AS TIME),
                                    CAST('$timeTo' AS TIME))";
						// echo $query.'<br/>';
						// die();
                        $result = mysql_query($query) or die(mysql_error());
                    }
                }
				break;
			}
		} else {
			$template['show_form'] = false;
			prepareRoutesList();
		}

		
	}

	// echo '<pre>';
	 // var_dump($template, $_POST);
	// print_r($template);
	// echo '</pre>';

	include ABSPATH.'/admin/views/routes.php';