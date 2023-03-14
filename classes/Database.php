<?php

class Database{
    protected static $instance = null;
    protected $dbh, $query, $results, $lastInsertId = null, $count = 0, $error = false;

    private function __construct(){
        try{
            $this->dbh = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
        }catch(PDOException $e){
            die('Could not connect to database.' . $e->getMessage());
        }
    }

    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function query($sql, $params = []){
        $this->error = false;

        if($this->query = $this->dbh->prepare($sql)){
            $x = 1;
            if(count($params)){
                foreach($params as $param){
                    $this->query->bindValue($x, $param);
                    $x++;
                }
            }

            if($this->query->execute()){
                $this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
                $this->count = $this->query->rowCount();
                $this->lastInsertId = $this->dbh->lastInsertId();
            }else{
                $this->error = true;
            }
        }

        return $this;
    }

    public function get($table, $where = []){
        return $this->query("SELECT * FROM {$table} WHERE {$where[0]} {$where[1]} ?", [$where[2]]);
    }

    public function getAll($table){
        return $this->query("SELECT * FROM {$table}");
    }

    public function insert($table, $fields = []){
        $fieldString = '';
        $valueString = '';
        $values = [];

        foreach($fields as $field => $value){
            $fieldString .= '`'.$field.'`, ';
            $valueString .= '?, ';
            $values[] = $value;
        }

        $fieldString = rtrim($fieldString, ', ');
        $valueString = rtrim($valueString, ', ');

        $sql = "INSERT INTO {$table} ({$fieldString}) VALUES ({$valueString})";

        if(!$this->query($sql, $values)->error()){
            return true;
        }

        return false;
    }

    public function update($table, $id, $fields = []){
        $fieldString = '';
        $values = [];

        foreach($fields as $field => $value){
            $fieldString .= ' '.$field.' = ?,';
            $values[] = $value;
        }

        $fieldString = trim($fieldString);
        $fieldString = rtrim($fieldString, ',');

        $sql = "UPDATE {$table} SET {$fieldString} WHERE id = {$id}";

        if(!$this->query($sql, $values)->error()){
            return true;
        }

        return false;
    }

    public function delete($table, $id){
        $sql = "DELETE FROM {$table} WHERE id = {$id}";

        if(!$this->query($sql)->error()){
            return true;
        }

        return false;
    }

    public function deleteAll($table){
        $sql = "DELETE FROM {$table}";

        if(!$this->query($sql)->error()){
            return true;
        }

        return false;
    }

    public function results(){
        return $this->results;
    }

    public function first(){
        if($this->count){
            return $this->results()[0];
        }
    }

    public function error(){
        return $this->error;
    }

    public function count(){
        return $this->count;
    }

    public function lastInsertId(){
        return $this->lastInsertId;
    }

    public function get_columns($table){
        return $this->query("SHOW COLUMNS FROM {$table}")->results();
    }
}