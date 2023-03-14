<?php

class Transaction extends Model{
    protected $table = 'transactions';
    protected $fillable = [
        'user_id',
        'amount',
        'status',
        'date'
    ];

    public function __construct(){
        parent::__construct($this->table);
    }

    public function totalAmountPaid($id){
        $sql = "SELECT SUM(amount) AS total_paid FROM {$this->table} WHERE enrollment_id = {$id}";
        $result = $this->query($sql)->first();
        return $result->total_paid;
    }

    public function getBalance($id){
        $enrollment = new Enrollment();
        $enroll = $enrollment->find($id);
        $total_paid = $this->totalAmountPaid($id);
        return $enroll->tuition - $total_paid;
    }
}