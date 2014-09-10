<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>stations</title>
</head>
<body>
<?php if($template['show_form']){ ?>
	<?php if(isset($template['error'])){ ?>
		<p><?= $template['error']?></p>
	<?php } ?>

	<form action="/admin/stations.php" method="POST">
		<input type="hidden" name="action" value="<?=$template['formAction'] ?>"/>
		
		<?php if($template['formAction'] === 'edit'){?>
			<input type="hidden" name="id" value="<?=$template['formId']?>">
		<? } ?>
		
		ГОРОД: <input type="text" name="city"  
				value="<?= ($template['formAction'] === 'edit') ? $template['formCity'] : ''?>" />
		СТАНЦИЯ: <input type="text" name="name" 
				value="<?= ($template['formAction'] === 'edit') ? $template['formName'] : ''?>"/>
		<input type="submit" value="CREATE">
	</form>
<?php } else {?>
<a href="/admin/stations.php?action=add">ADD STATION</a>
	<table>
		<thead>
			<tr>
				<th>id</th>
				<th>Город</th>
				<th>Станция</th>
				<th colspan="2"></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($template['list'] as $item){ ?>
				<tr>
					<td><?=$item->getID()?></td>
					<td><?=$item->city?></td>
					<td><?=$item->name?></td>
					<td><a href="/admin/stations.php?action=edit&id=<?=$item->getID()?>">edit</a></td>
					<td><a href="/admin/stations.php?action=delete&id=<?=$item->getID()?>">delete</a></td>
				</tr>
			<?} ?>
		</tbody>		
	</table>
<?php } ?>	
</body>
</html>