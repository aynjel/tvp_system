<?php

require('../autoload.php');

$transaction = new Transaction();

$id = Input::get('id');

if(!isset($id) || empty($id) || is_numeric($id) == false || $transaction->findBy('enrollment_id', $id) == false){
    echo json_encode([
        'status' => 'error',
        'message' => 'Error: Enrollment ID not set'
    ]);
}else{
    $transaction_data = $transaction->findAll('WHERE enrollment_id = ' . $id . ' ORDER BY created_at DESC');

    // calculate total paid
    $total_paid = 0;
    foreach($transaction_data as $trans){
        $total_paid += $trans->amount;
        // format date
        $trans->created_at = date('l, F j, Y h:i A', strtotime($trans->created_at));
        // format amount
        $trans->amount = number_format($trans->amount, 2);
    }
    
    echo json_encode([
        'status' => 'success',
        'message' => 'Data retrieved successfully',
        'total_paid' => number_format($total_paid, 2),
        'balance' => number_format($transaction->getBalance($id), 2),
        'transaction_data' => $transaction_data
    ]);
}