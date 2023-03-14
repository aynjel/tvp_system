<?php

class Post extends Model{
    protected $table = 'posts';
    protected $fillable = ['title', 'description'];

    public function __construct(){
        parent::__construct($this->table);
    }
}