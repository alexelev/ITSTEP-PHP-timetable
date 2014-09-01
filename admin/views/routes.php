<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>routes</title>
</head>
<body>
<?php if($template['show_form']){ ?>
	<?php if(isset($template['error'])){ ?>
		<p><?= $template['error']?></p>
	<?php } ?>

	<form action="/admin/routes.php" method="POST">
		<input type="hidden" name="action" value="<?=$template['formAction'] ?>"/>
		<?php if($template['formAction'] === 'edit'){?>
			<input type="hidden" name="id" value="<?=$template['formId']?>">
		<? } ?>

		<?php if(!empty($template['routeParts'])){ ?>
			<?php foreach ($template['routeParts'] as $key => $item) { ?>
				<select name="parts[]" id="">
				<option value="">Choose the part</option>
				<?php foreach ($template['formParts'] as $item1) { ?>
					<option value="<?=$item1['id']?>"
					<?= ($item['id'] == $item1['id']) ? 'selected' : '' ?>
					><?=$item1['title']?></option>

				<?php } ?>
				</select>

				Время отправления: <input type="time" name="timeFrom[]" value="<?= $template['routeTimeFrom'][$key] ?>"/>
				Время прибытия: <input type="time" name="timeTo[]" value="<?= $template['routeTimeTo'][$key] ?>"/>

              
                <button name="delete" value="<?= $key ?>"> - </button>

                <br/>
			<? } 
			if ($template['addPart']){ ?>
				<select name="parts[]" id="">
					<option value="">Choose the part</option>
					<?php foreach ($template['formParts'] as $item) { ?>
					<option value="<?=$item['id']?>"><?=$item['title']?></option>
					<?php } ?>
				</select>
				Время отправления: <input type="time" name="timeFrom[]" value="00:00">
				Время прибытия: <input type="time" name="timeTo[]" value="00:00">
				<br/>
			<? } ?>

		<? } else { ?>
		<select name="parts[]" id="">
			<option value="">Choose the part</option>
			<?php foreach ($template['formParts'] as $item) { ?>
			<option value="<?=$item['id']?>"><?=$item['title']?></option>
			<?php } ?>
		</select>
		Время отправления: <input type="time" name="timeFrom[]" value="00:00">
		Время прибытия: <input type="time" name="timeTo[]" value="00:00">
		<br/>
		<? } ?>
		
		<input type="submit" name="addPart" value="ADD PART">
		<br/>
		
		<?php if (!empty($template['routeCars'])) { ?>
		
			<?php foreach($template['routeCars'] as $car) { ?>
				
				<select name="cars[]" id="">
					<option>Choose the cars</option>
					<?php foreach ($template['formCars'] as $item) { ?>
					<option value="<?=$item['id'] ?>"
					<?= ($item['id'] === $car['id']) ? 'selected' : '' ?>><?=$item['name']?></option>
					<?php } ?>
				</select>
				<br/>
			<?php } 

			if($template['addCar']) { ?>
				<select name="cars[]" id="">
					<option>Choose the cars</option>
					<?php foreach ($template['formCars'] as $item) { ?>
					<option value="<?=$item['id'] ?>"><?=$item['name']?></option>
					<?php } ?>
				</select>
				<br/>
			<?php } ?>
			
		<?php } else { ?>
		<select name="cars[]" id="">
			<option>Choose the cars</option>
			<?php foreach ($template['formCars'] as $item) { ?>
			<option value="<?=$item['id'] ?>"><?=$item['name']?></option>
			<?php } ?>
		</select>
		
		<?php } ?>
		<br/>		
		<input type="submit" name="addCar" value="ADD CAR">
		<br/>
		
		MESSAGE: <br/>
		<textarea name="message" cols="100" rows="20" resize="none"><?= $template['formMessage'] ?></textarea>
		<br/>
		DATE: 
		<input type="date" name="date" value="<?= $template['formDate'] ?>">
		<br/>

		<input type="submit" value="SAVE">
	</form>
<?php } else {?>
<a href="/admin/routes.php?action=add">ADD ROUTE</a>
	<table>
		<thead>
			<tr>
				<th>id</th>
				<th>Маршрут</th>
				<th>Дата</th>
				<th colspan="2"></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($template['routesList'] as $item){ ?>
				<tr>
					<td><?=$item['id']?></td>
					<td><?=$item['title']?></td>
					<td><?=$item['date']?></td>
					<td><a href="/admin/routes.php?action=edit&id=<?=$item['id']?>">edit</a></td>
					<td><a href="/admin/routes.php?action=delete&id=<?=$item['id']?>">delete</a></td>
				</tr>
			<?} ?>
		</tbody>		
	</table>
<?php } ?>	
</body>
</html>