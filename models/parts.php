<?php
/**
 * Created by PhpStorm.
 * User: Алексей
 * Date: 14.09.14
 * Time: 20:15
 */

class Part{
    private $id = null;
    public $stFrom = null;
    public $stTo = null;
    public $length = 0;

    public function __construct($id = null){
        if($id){
            $query = "SELECT * FROM `parts` WHERE `id` = {$id}";
            $result = mysql_query($query) or mysql_error();
            $data = mysql_fetch_assoc($result);
            $this->id = $data['id'];
            $this->stFrom = $data['station1'];
            $this->stTo = $data['station2'];
            $this->length = $data['length'];
        }
    }

    public function save(){
        if($this->id){
            $query = "UPDATE `parts`
                      SET `station1` = '{$this->stFrom}', `station2` = '{$this->stTo}', `length` = {$this->length}
                      WHERE `id` = {$this->id}";
            mysql_query($query) or mysql_error();
        } else {
            $query = "INSERT INTO `parts` (`station1`, `station2`, `length`)
                      VALUES ('{$this->stFrom}', '{$this->stTo}', {$this->length})";
            mysql_query($query) or mysql_error();
            $this->id = mysql_insert_id();
        }
    }

    public function getId(){
        return $this->id;
    }

    public function getList(){
        $array = array();
        $query = "SELECT * FROM `parts`";
        $result = mysql_query($query) or mysql_error();
        while ($row = mysql_fetch_assoc($result)){
            $part = new self();
            $part->id = $row['id'];
            $part->stFrom = $row['station1'];
            $part->stTo = $row['station2'];
            $part->length = $row['length'];
            $array[] = $part;
        }
    }

    public function delete($id){
        $query = "DELETE FROM `parts` WHERE `id` = {$id}";
        $result = mysql_query($query) or mysql_error();
    }
}