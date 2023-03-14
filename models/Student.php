<?php

class Student extends Model{
    protected $table = 'students';
    protected $fillable = [
        'id_number',
        'password',
        'email',
        'first_name',
        'last_name'
    ];

    public function __construct(){
        parent::__construct($this->table);
    }

    public function register($fields = []){
        $this->db->insert($this->table, $fields);
        return $this->db->lastInsertId();
    }

    public function login($id_number, $password){
        $data = $this->db->get($this->table, ['id_number', '=', $id_number, 'AND', 'password', '=', $password]);
        if($data->count()){
            return $data->first();
        }

        return false;
    }

    public function get($id){
        $data = $this->db->get($this->table, ['id', '=', $id]);
        if($data->count()){
            return $data;
        }

        return false;
    }
}