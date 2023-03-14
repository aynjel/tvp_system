<?php

class Increment extends Model{
    protected $table = 'increments';
    protected $fillable = [
        'user_id',
        'increment_amount'
    ];

    public function __construct(){
        parent::__construct($this->table);
    }
}