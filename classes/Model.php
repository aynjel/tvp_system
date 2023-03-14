<?php

class Model{
    protected $db, $table, $fillable = [], $data, $error = false, $count = 0;

    public function __construct($table){
        $this->db = Database::getInstance();
        $this->table = $table;
    }

    public function create($fields = []){
        $this->db->insert($this->table, $fields);
        return $this->db->lastInsertId();
    }

    public function update($id, $fields = []){
        $this->db->update($this->table, $id, $fields);
        return $this->db->count();
    }

    public function delete($id){
        $this->db->delete($this->table, $id);
        return $this->db->count();
    }

    public function findBy($field, $value){
        $data = $this->db->get($this->table, [$field, '=', $value]);
        return $data->first();
    }

    public function findAll($conds = ''){
        $data = $this->db->query("SELECT * FROM {$this->table} {$conds}");
        return $data->results();
    }

    public function where($where = []){
        $data = $this->db->get($this->table, $where);
        return $data->results();
    }

    public function find($id){
        $data = $this->db->get($this->table, ['id', '=', $id]);
        return $data->first();
    }

    public function get_columns(){
        return $this->db->get_columns($this->table);
    }

    public function query($sql, $params = []){
        return $this->db->query($sql, $params);
    }

    public function count(){
        return $this->db->count();
    }

    public function error(){
        return $this->db->error();
    }

    public function lastId(){
        return $this->db->lastInsertId();
    }

    public function results(){
        return $this->db->results();
    }

    public function first(){
        return $this->db->first();
    }

    public function deleteAll(){
        $this->db->deleteAll($this->table);
        return $this->db->count();
    }

    public function exists(){
        return (!empty($this->data)) ? true : false;
    }

    public function data(){
        return $this->data;
    }

    public function lastInsertId(){
        return $this->db->lastInsertId();
    }
}