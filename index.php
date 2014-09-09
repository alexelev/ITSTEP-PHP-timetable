<?php
	include 'init.php';
	
	$query = "SELECT * FROM Stations ORDER BY `city`, `name`";
	$r = mysql_query($query) or die(mysql_error());
	$template['list'] = array();
	while($row = mysql_fetch_assoc($r)){
		$template['list'][] = $row;
	}

     echo('<pre>');
     print_r($_POST);
     echo('</pre>');

//    die(1);

    if(isset($_POST['stationFrom']) && !empty($_POST['stationFrom']) &&
        isset($_POST['stationTo']) && !empty($_POST['stationTo'])){

        $template['date'] = (isset($_POST['date']) ? $_POST['date'] : date("d.m.Y"));
    	$prices = array();
    	$query = "SELECT `price` FROM `cars` ORDER BY `id`";
	    $result = mysql_query($query) or die(mysql_error());
	    $price[1] = current(mysql_fetch_assoc($result));
	    $price[2] = current(mysql_fetch_assoc($result));

	    $query = "SELECT `r`.*, `rp1`.`id` as `id_rp1`, `rp2`.`id` as `id_rp2`,
                  concat(
                    concat(`from`.`city`, ' - ', `from`.`name`),
                    ' => ',
                    concat(`to`.`city`, ' - ', `to`.`name`)
                  ) as `title`
				FROM `routes` AS `r`

				LEFT JOIN `Stations` as `from` ON `from`.`id` = `r`.`stFrom`
				LEFT JOIN `Stations` as `to` ON `to`.`id` = `r`.`stTo`

				LEFT JOIN `routes_parts` AS `rp1` ON `rp1`.`id_route` = `r`.`id`
				LEFT JOIN `parts` AS `p1` ON `p1`.`id` = `rp1`.`id_part`

				LEFT JOIN `routes_parts` AS `rp2` ON `rp2`.`id_route` = `r`.`id`
				LEFT JOIN `parts` AS `p2` ON `p2`.`id` = `rp2`.`id_part`
				WHERE `p1`.`station1` = {$_POST['stationFrom']} AND `p2`.`station2` = {$_POST['stationTo']} 
				AND `rp1`.`id` <= `rp2`.`id`";

//		 echo $query.'<br/>';
		
		$result = mysql_query($query) or die(mysql_error());

		$template['r'] = array();

		while($row = mysql_fetch_assoc($result)){

//            echo('<pre>');
//            print_r($row);
//			echo('</pre>');

            $id1 = $row['id_rp1'];
			$id2 = $row['id_rp2'];
			$id_r = $row['id'];
			$query = "SELECT SUM(`p`.`length`) FROM `routes_parts` as `rp` 
						LEFT JOIN `parts` as `p` ON `p`.`id` = `rp`.`id_part`
						WHERE `rp`.`id_route` = {$id_r} AND (`rp`.`id` BETWEEN {$id1} AND {$id2})";
			// echo $query.'<br/>';
			$r = mysql_query($query) or die(mysql_error());
			$row['length'] = current(mysql_fetch_assoc($r));
			$row['typeCar1exist'] = (strpos($row['cars'], '1') !== false ? true : false);
			$row['typeCar2exist'] = (strpos($row['cars'], '2') !== false ? true : false);
			if ($row['typeCar1exist']){
				$row['costCar1'] = $row['length'] * $price[1];
			}
			if ($row['typeCar2exist']){
				$row['costCar2'] = $row['length'] * $price[2];
			}

			$template['r'][] = $row;
		}
    } else if (!empty($_GET)){
       	$query = "SELECT `car`, `place` FROM `orders` WHERE `id_route` = {$_GET['id_route']} ORDER BY `car`, `place`";
       	$result = mysql_query($query) or die(mysql_error());
       	$orderedPlaces = array();
       	while($row = mysql_fetch_assoc($result)){
       		if(!isset($orderedPlaces[$row['car']])){
       			$orderedPlaces[$row['car']] = array();
       		}
       		$orderedPlaces[$row['car']][] = $row['place'];
       	}
       	$query = "SELECT `price` FROM `cars` WHERE `id` = {$_GET['typeCar']}";
       	$result = mysql_query($query) or die(mysql_error());
       	$price = current(mysql_fetch_assoc($result));

       	$query = "SELECT `places` FROM `cars` WHERE `id` = {$_GET['typeCar']}";
       	$result = mysql_query($query) or die(mysql_error());
       	$places = current(mysql_fetch_assoc($result));

       	$query = "SELECT `cars` FROM `routes` WHERE `id` = {$_GET['id_route']}";
       	$result = mysql_query($query) or die(mysql_error());
       	$cars = explode(',', current(mysql_fetch_assoc($result)));

       	$template['train'] = array();
       	foreach ($cars as $key => $car) {
       		if($car == $_GET['typeCar']){
       			$template['train'][$key + 1] = array();
       			for ($i=1; $i <= $places; $i++) { 
       				//true усли место свободно, false усли место занято
       				$template['train'][$key + 1][$i] = !(isset($orderedPlaces[$key + 1]) && in_array($i, $orderedPlaces[$key]));
       			}
       		}
       	}


    }

	// echo('<pre>');
 //    var_dump($template['train']);
 //    echo('</pre>');
	include ABSPATH.'/views/index.php';