<?php

class Fee extends Model{
    protected $table = 'fees';
    protected $fillable = [
        'transaction_id',
        'user_id',
        'increment_id',
        'balance'
    ];

    public function __construct(){
        parent::__construct($this->table);
    }

    public function deductBalance($amount, $id){
        $sql = "UPDATE {$this->table} SET balance = balance - {$amount} WHERE id = {$id}";
        $this->query($sql);
    }
}