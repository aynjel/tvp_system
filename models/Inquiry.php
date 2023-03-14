<?php

class Inquiry extends Model{
    protected $table = 'inquiries';
    protected $fillable = [
        'user_id',
        'balance'
    ];

    public function __construct(){
        parent::__construct($this->table);
    }
}