<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
    <title>Заказ билетов онлайн</title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
</head>
    <body>
        <header>
            <h1>Заказ билетов</h1>
        </header>
        <form action="" method="POST">
            <div>
                <label for="stationFrom">Откуда :</label>
                <select name="stationFrom" id="station1">
                    <option value="-1">Выберите станцию отправления</option>
                    <?php foreach ($template['list'] as $key => $station) { ?>
                        <option value="<?=$station['id']?>"><?=$station['city'].' -> '.$station['name']?></option>
                    <?php } ?>
                </select>

                <label for="stationTo">Куда :</label>
                <select name="stationTo" id="station2">
                    <option value="">Выберите станцию прбытия</option>
                    <?php foreach ($template['list'] as $key => $station) { ?>
                        <option value="<?=$station['id']?>"><?=$station['city'].' -> '.$station['name']?></option>
                    <?php } ?>
                </select>
                <br/>
                <label for="date">Когда :</label>
                <input type="date" name="date"/>
            </div>

            <div class="submit">
                <input type="submit" name="search" value="Поиск поездов на <?/*= date("d.m.Y") */?>" />
            </div>

<!--            <select name="stationFrom" id="">-->
<!--                <option value="-1">Choose the station</option>-->
<!--                --><?php //foreach ($template['list'] as $key => $station) { ?>
<!--                    <option value="--><?//=$station['id']?><!--">--><?//=$station['city'].' -> '.$station['name']?><!--</option>-->
<!--                --><?php //} ?>
<!--            </select>-->
<!--            <select name="stationTo" id="">-->
<!--                <option value="-1">Choose the station</option>-->
<!--                --><?php //foreach ($template['list'] as $key => $station) { ?>
<!--                    <option value="--><?//=$station['id']?><!--">--><?//=$station['city'].' -> '.$station['name']?><!--</option>-->
<!--                --><?php //} ?>
<!--            </select>-->
<!--            <input type="submit" value="NEXT">-->

        </form>

        <?php if (isset($template['r'])) { ?>

        <table>
            <thead>
            <th>Маршрут</th>
            <th>Дата</th>
            <th>Плацкарт</th>
            <th>Купе</th>
            </thead>
            <tbody>
            <?php foreach($template['r'] as $item) { ?>
            <tr>
                <td><?= $item['title'] ?></td>
                <td><?= $template['date'] ?></td>
                <td><?= ($item['typeCar1exist'] ? ($item['costCar1'].' грн.'.'<br/><a href="?stFrom='.$item['stFrom'].'&stTo='.$item['stTo'].'&id_route='.$item['id'].'&typeCar=1&price='.$item['costCar1'].'">заказать</a>') : '-') ?></td>
                <td><?= ($item['typeCar2exist'] ? ($item['costCar2'].' грн.'.'<br/><a href="?stFrom='.$item['stFrom'].'&stTo='.$item['stTo'].'&id_route='.$item['id'].'&typeCar=2&price='.$item['costCar2'].'">заказать</a>') : '-') ?></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>

        <?php }
        if (!empty($template['train'])){ ?>
        <form action="" method="get">
            <div>
                <label for="fio">ФИО :</label>
                <input type="text" name="fio" id="fio" value="" />
            </div>

            <div>
                <label for="car">Вагон :</label>
                <select name="car" id="cars">
                    <option value="">Выберите номер вагона</option>
                    <?php foreach ($template['train'] as $key => $train) { ?>
        				<option value="<?= $key ?>">Car № <?= $key ?></option>
					<? } ?>
                </select>

                <label for="place">Место :</label>
                <select name="place" id="places">
                    <option value="">Выберите место</option>

                </select>
            </div>

            <div>
                <input type="submit" name="order" value="Заказать билет" />
            </div>
        </form>
        <?php } ?>
        <!--	    <table>-->
<!--			<thead>-->
<!--				<tr>-->
<!--					<th>id</th>-->
<!--					<th>stFrom</th>-->
<!--					<th>stTo</th>-->
<!--					<th>message</th>-->
<!--					<th>timeFrom</th>-->
<!--					<th>timeTo</th>-->
<!--					<th>Length</th>-->
<!--                    <th>цена в плацкарте</th>-->
<!--                    <th>цена в купе</th>-->
<!--					<th colspan="2"></th>-->
<!--				</tr>-->
<!--			</thead>-->
<!--			<tbody>-->
<!--				--><?php //if(isset($template['r'])){
//                    foreach($template['r'] as $item){ ?>
<!--                        <tr>-->
<!--                            <td>--><?//= $item['id'] ?><!--</td>-->
<!--                            <td>--><?//= $item['stFrom'] ?><!--</td>-->
<!--                            <td>--><?//= $item['stTo'] ?><!--</td>-->
<!--                            <td>--><?//= $item['message'] ?><!--</td>-->
<!--                            <td>--><?//= $item['timeFrom'] ?><!--</td>-->
<!--                            <td>--><?//= $item['timeTo'] ?><!--</td>-->
<!--                            <td>--><?//= $item['length'] ?><!--</td>-->
<!--                            <td>-->
<!--                                --><?//= ($item['typeCar1exist'] ? ($item['costCar1'].'<br/><a href="?stFrom='.$item['stFrom'].'&stTo='.$item['stTo'].'&id_route='.$item['id'].'&typeCar=1&price='.$item['costCar1'].'">заказать</a>') : '-') ?>
<!--                            </td>-->
<!--                            <td>-->
<!--                                --><?//= ($item['typeCar2exist'] ? ($item['costCar2'].'<br/><a href="?stFrom='.$item['stFrom'].'&stTo='.$item['stTo'].'&id_route='.$item['id'].'&typeCar=2&price='.$item['costCar2'].'">заказать</a>') : '-') ?>
<!--                            </td>-->
<!--                        </tr>-->
<!--                    --><?// }
//                } if (!empty($template['train'])){ ?>
<!---->
<!--					<form action="" method="POST">-->
<!--						<input type="hidden" name="price">-->
<!--						<select name="cars" id="cars">-->
<!--							<option value="">Choose the car</option>-->
<!--							--><?php //foreach ($template['train'] as $key => $train) { ?>
<!--								<option value="--><?//= $key ?><!--">Car № --><?//= $key ?><!--</option>-->
<!--							--><?// } ?>
<!--						</select>-->
<!--						<select name="places" id="places">-->
<!--							<option value="">Choose the place</option>-->
<!--						</select>-->
<!--					</form>-->
					<script type="text/javascript">
						var train = <?= json_encode($template['train']) ?>;
						var selectedCar = document.getElementById('cars'),
							places = document.getElementById('places');
						selectedCar.addEventListener('change', function(){
							var car = selectedCar.value;
							places.innerHTML = '';
                            var firstOption = document.createElement('option');
                            firstOption.innerText = "Choose the place";
                            places.appendChild(firstOption);
							for (var i in train[car]) {
								if(train[car][i]){
									var option = document.createElement('option');
									option.value = i;
									option.innerText = i;
									places.appendChild(option);
								}
							};
						});
					</script>
<!--				--><?// } ?>
<!--			</tbody>		-->
<!--		</table>-->
    </body>
</html>