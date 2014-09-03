<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Order</title>
</head>
    <body>
        <form action="" method="POST">
            <select name="stationFrom" id="">
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
	    <table>
			<thead>
				<tr>
					<th>id</th>
					<th>stFrom</th>
					<th>stTo</th>
					<th>message</th>
					<th>timeFrom</th>
					<th>timeTo</th>
					<th>Length</th>
					<th colspan="2"></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($template['r'] as $item){ ?>
					<tr>
						<td><?= $item['id'] ?></td>
						<td><?= $item['stFrom'] ?></td>
						<td><?= $item['stTo'] ?></td>
						<td><?= $item['message'] ?></td>
						<td><?= $item['timeFrom'] ?></td>
						<td><?= $item['timeTo'] ?></td>
						<td><?= $item['length'] ?></td>
						<td><a href="/admin/stations.php?action=edit&id=<?=$item['id']?>">edit</a></td>
						<td><a href="/admin/stations.php?action=delete&id=<?=$item['id']?>">delete</a></td>
					</tr>
				<?} ?>
			</tbody>		
		</table>
    </body>
</html>