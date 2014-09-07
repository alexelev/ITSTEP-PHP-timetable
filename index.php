<?php
	include 'init.php';
	
	$query = "SELECT /*`id`, concat(`city`, ' -> ', `name`)*/ * FROM Stations ORDER BY `city`, `name`";
	$r = mysql_query($query) or die(mysql_error());
	$template['list'] = array();
	while($row = mysql_fetch_assoc($r)){
		$template['list'][] = $row;
	}

    echo('<pre>');
    print_r($_POST);
    echo('</pre>');

    if(isset($_POST['stationFrom']) && isset($_POST['stationTo'])){
	    $query = "SELECT `r`.*, `rp1`.`id` as `id_rp1`, `rp2`.`id` as `id_rp2`
				FROM `routes` AS `r`

				LEFT JOIN `routes_parts` AS `rp1` ON `rp1`.`id_route` = `r`.`id`
				LEFT JOIN `parts` AS `p1` ON `p1`.`id` = `rp1`.`id_part`

				LEFT JOIN `routes_parts` AS `rp2` ON `rp2`.`id_route` = `r`.`id`
				LEFT JOIN `parts` AS `p2` ON `p2`.`id` = `rp2`.`id_part`
				WHERE `p1`.`station1` = {$_POST['stationFrom']} AND `p2`.`station2` = {$_POST['stationTo']} 
				AND `rp1`.`id` <= `rp2`.`id`";

		echo $query.'<br/>';
		
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
			echo $query.'<br/>';
			$r = mysql_query($query) or die(mysql_error());
			$row['length'] = current(mysql_fetch_assoc($r));
			$row['typeCar1exist'] = (strpos($row['cars'], '1') !== false ? true : false);
			$row['typeCar2exist'] = (strpos($row['cars'], '2') !== false ? true : false);
			$template['r'][] = $row;
		}

        $prices = array();
        $query = "SELECT `price` FROM `cars` ORDER BY `id`";
        $result = mysql_query($query) or die(mysql_error());
        $price[1] = current(mysql_fetch_assoc($result));
        $price[2] = current(mysql_fetch_assoc($result));

        foreach ($template['r'] as $route){
            $route['costCar1'] = $route['length'] * $price[1];
            $route['costCar2'] = $route['length'] * $price[2];
        }

    }

	echo('<pre>');
    var_dump($template['r']);
    echo('</pre>');

	include ABSPATH.'/views/index.php';