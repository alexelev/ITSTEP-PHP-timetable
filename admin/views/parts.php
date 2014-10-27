<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>parts</title>
</head>
<body>
<?php if($template['show_form']){ ?>
	<?php if(isset($template['error'])){ ?>
		<p><?= $template['error']?></p>
	<?php } ?>

	<form action="/admin/parts.php" method="POST">
		<input type="hidden" name="action" value="<?=$template['formAction'] ?>"/>
		
		<?php if($template['formAction'] === 'edit'){?>
			<input type="hidden" name="id" value="<?=$template['formId']?>">
		<? } ?>
		
		StationFROM: 
		<select name="from" id="">
			<option>Choose the station</option>
			<?php foreach ($template['formStations'] as $item){ ?>
			<option value="<?=$item->id ?>" <?= ($template['formAction'] === 'edit' &&
				$template['formFrom'] === $item->id) ? 'selected' : '' ?>><?=$item->station?></option>
			<?php } ?>
		</select>
		StationTO:
		<select name="to" id="">
			<option>Choose the station</option>
			<?php foreach ($template['formStations'] as $item){ ?>
			<option value="<?=$item->id ?>" <?= ($template['formAction'] === 'edit' &&
				$template['formTo'] === $item->id) ? 'selected' : '' ?>><?=$item->station?></option>
			<?php } ?>
		</select>
		
		<input type="text" name="length" value="<?= $template['formLength'] ?>" placeholder="Length">

		<input type="submit" value="CREATE">
	</form>
<?php } else {?>
<a href="/admin/parts.php?action=add">ADD PART</a>
	<table>
		<thead>
			<tr>
				<th>id</th>
				<th>FROM</th>
				<th>TO</th>
				<th>LENGTH</th>
				<th colspan="2"></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($template['list'] as $item){ ?>
				<tr>
					<td><?=$item['id']?></td>
					<td><?=$item['from']?></td>
					<td><?=$item['to']?></td>
					<td><?=$item['length']?> km</td>
					<td><a href="/admin/parts.php?action=edit&id=<?=$item['id']?>">edit</a></td>
					<td><a href="/admin/parts.php?action=delete&id=<?=$item['id']?>">delete</a></td>
				</tr>
			<?} ?>
		</tbody>		
	</table>
<?php } ?>	
</body>
</html>