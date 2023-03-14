<?php

class Enrollment extends Model{
    protected $table = 'enrollments';
    protected $fillable = [
        'user_id',
        'school_year',
        'session',
        'tuition'
    ];

    public function __construct(){
        parent::__construct($this->table);
    }
}