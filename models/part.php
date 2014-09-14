<?php

	include_once ABSPATH.'/models/station.php';

	class Part{
		private $id;
		private $stationFrom;
		private $stationTo;
		private $title;

		public $length;
		public $id_stationFrom;
		public $id_stationTo;

		public function __construct($id = null, $load = false) {
			if ($id) {
				if ($load) {					
					$query = "SELECT *
								FROM `parts` AS `p`
								WHERE `p`.`id` = $id";
					$result = mysql_query($query) or mysql_error();
					$row = mysql_fetch_assoc($result);
					$this->id = $row['id'];
					$this->id_stationFrom = $row['station1'];
					$this->id_stationTo = $row['station2'];
					$this->length = $row['length'];
					$this->stationFrom = new Station($this->id_stationFrom);
					$this->stationTo = new Station($this->id_stationTo);
					$this->title = $this->stationFrom->city.' -> '.$this->stationFrom->name.' => '.$this->stationTo->city.' -> '.$this->stationTo->name;
				} else {
					$query = "SELECT `p`.*, concat(concat(`from`.`city`, ' -> ', `from`.`name`), ' => ', concat(`to`.`city`, ' -> ', `to`.`name`)) AS `title`
								FROM `parts` AS `p`	
								LEFT JOIN `Stations` AS `from` ON `from`.`id` = `p`.`station1`
								LEFT JOIN `Stations` AS `to` ON `to`.`id` = `p`.`station2`							
								WHERE `p`.`id` = $id";
					$result = mysql_query($query) or mysql_error();
					$row = mysql_fetch_assoc($result);
					$this->id = $row['id'];
					$this->id_stationFrom = $row['station1'];
					$this->id_stationTo = $row['station2'];
					$this->length = $row['length'];
					$this->title = $row['title'];
				}
		    };
        }

		public function getStationFrom()
		{
			if ($this->stationFrom) {
				return $this->stationFrom;
			}
			return new Station($this->id_stationFrom);
		}

		public function getTitle()
		{
			return $this->title;
		}

		public function getStationTo()
		{
			if ($this->stationTo) {
				return $this->stationTo;
			}
			return new Station($this->id_stationTo);
		}

		public function setStationFrom($station)
		{
			$this->id_stationFrom = $station->getID();
			$this->stationFrom = $station;
		}

		public function getID()
		{
			return $this->id;
		}

		public function save()
		{
			if ($this->id) {
				$query = "UPDATE `parts` SET `station1` = {$this->id_stationFrom}, `station2` = {$this->id_stationTo}, `length` = {$this->length}
							WHERE `id` = {$this->id}";
				$result = mysql_query($query) or mysql_error();
			} else {
				$query = "INSERT INTO `parts` (`station1`, `station2`, `length`)
                          VALUES ({$this->id_stationFrom}, {$this->id_stationTo}, {$this->length})
						  WHERE `id` = {$this->id}";
				$result = mysql_query($query) or mysql_error();
			}
		}

		public static function getList()
		{
			$query = "SELECT `p`.*, concat(concat(`from`.`city`, ' -> ', `from`.`name`), ' => ', concat(`to`.`city`, ' -> ', `to`.`name`)) AS `title`
						FROM `parts` AS `p`
						LEFT JOIN `Stations` AS `from` ON `from`.`id` = `p`.`station1`
						LEFT JOIN `Stations` AS `to` ON `to`.`id` = `p`.`station2`
						ORDER BY `from`.`city`, `from`.`name`,`to`.`city`, `to`.`name`";
			$result = mysql_query($query) or mysql_error();
			$array = array();
			while ( $row = mysql_fetch_assoc($result)) {
				$part = new self();
				$part->id = $row['id'];
				$part->stationFrom = $row['station1'];
				$part->stationTo = $row['station2'];
				$part->length = $row['length'];
				$part->title = $row['title'];
				$array[] = $part;
			}
			return $array;
		}

		public static function delete($id)
		{
			$query = "DELETE FROM `parts` WHERE `id` = '{$_GET['id']}'";
			$result = mysql_query($query) or die(mysql_error());
		}
	}