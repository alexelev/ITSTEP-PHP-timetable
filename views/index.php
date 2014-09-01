<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Order</title>
</head>
<body>
	<form action="" method="POST">
		<select name="stationsFrom" id="">
			<option value="-1">Choose the station</option>
			<?php foreach ($template['list'] as $key => $station) { ?>
				<option value="<?=$station['id']?>"><?=$station['city'].' -> '.$station['name']?></option>
			<?php } ?>
		</select>
		<select name="stationTo" id="">
			<option value="-1">Choose the station</option>
			<?php foreach ($template['list'] as $key => $station) { ?>
				<option value="<?=$station['id']?>"><?=$station['city'].' -> '.$station['name']?></option>
			<?php } ?>
		</select>
		<input type="submit" value="NEXT">
	</form>
</body>
</html>