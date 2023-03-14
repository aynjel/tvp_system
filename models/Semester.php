<?php
 
class Semester extends Model{
    protected $table = 'semesters';
    protected $fillable = [
        'semester',
        'school_year'
    ];
 
    public function __construct(){
        parent::__construct($this->table);
    }
}