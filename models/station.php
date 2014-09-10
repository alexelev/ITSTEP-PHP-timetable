<?php

	class Station {
		private $id;
		public $city;
		public $name;

		public function __get($key){
			switch $key{
				case 'id':
					return $this->id;
					break;
				// case ''
			}
		}

		public function save($value='')
		{
			if ($this->id) {
				$query = "UPDATE `Stations` SET `city` = {$this->city}, `name` = {$this->name} 
							WHERE `id` = {$this->id}";
				$result = mysql_query($query) or mysql_error();
			} else {
				$query = "INSERT INTO `Stations` (`city`, `name`) VALUES ('{$this->city}', '{$this->name}')";
				$result = mysql_query($query) or mysql_error();
				$this->id = mysql_insert_id();
			}
		}

		public function __construct($id = null){
			if ($id){
				$query = "SELECT * FROM `Stations` WHERE `id` = {$id}";
				$result = mysql_fetch_assoc(mysql_query($query));
				$this->id = $result['id'];
				$this->city = $result['city'];
				$this->name = $result['name'];
			}
		}

		public function getID(){
			return $id;
		}

	}