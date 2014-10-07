<?php

	class Station {
		private $id;
		public $city;
		public $name;

		public function __get($key){
			switch ($key){
				case 'id':
					return $this->id;
					break;
				// case ''
			}
		}

		public function save($value='')
		{
			if ($this->id) {
				$query = "UPDATE `Stations`
                          SET `city` = '{$this->city}', `name` = '{$this->name}'
						  WHERE `id` = {$this->id}";
				$result = mysql_query($query) or mysql_error();
			} else {
				$query = "INSERT INTO `Stations` (`city`, `name`)
				          VALUES ('{$this->city}', '{$this->name}')";
				$result = mysql_query($query) or mysql_error();
				$this->id = mysql_insert_id();
			}
		}

		public function __construct($id = null){
			if ($id){
				$query = "SELECT * FROM `Stations` WHERE `id` = {$id}";
                $result = mysql_query($query) or mysql_error();
                $data = mysql_fetch_assoc($result);
				$this->id = $data['id'];
				$this->city = $data['city'];
				$this->name = $data['name'];
			}
		}

		public function getID(){
			return $this->id;
		}

		public static function getList()
		{
			$query = "SELECT * FROM `Stations` ORDER BY `city`, `name`";
			$result = mysql_query($query) or mysql_error();
			$array = array();
			while ( $row = mysql_fetch_assoc($result)) {
				$station = new self();
				$station->id = $row['id'];
				$station->city = $row['city'];
				$station->name = $row['name'];
				$array[] = $station;
			}
			return $array;
		}

        public static function getListFormatNames(){
            $query = "SELECT id, CONCAT(`city`,' - ', `name`) as `station` FROM `Stations` ORDER BY `city`, `name`";
            $result = mysql_query($query) or mysql_error();
            $array = array();
            while ( $row = mysql_fetch_assoc($result)) {
                $station = new self();
                $station->id = $row['id'];
                $station->city = $row['city'];
                $station->name = $row['name'];
                $array[] = $station;
            }
            return $array;
        }

		public static function delete($id)
		{
			$query = "DELETE FROM `Stations` WHERE `id` = {$id}";
			$result = mysql_query($query) or mysql_error();
		}
	}