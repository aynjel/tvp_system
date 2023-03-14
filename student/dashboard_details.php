<?php

require('../autoload.php');

$user = new Student();
$enrollment = new Enrollment();
$transaction = new Transaction();

$user_id = Input::get('id');

if(!isset($user_id) || empty($user_id) || is_numeric($user_id) == false){
    echo json_encode([
        'status' => 'error',
        'message' => 'Error: User ID not set'
    ]);
}else{
    $user_data = $user->findBy('id', $user_id);
    $enrollment_data = $enrollment->findAll('WHERE student_id = ' . $user_id . ' ORDER BY created_at DESC');

    // format enrollment data
    foreach($enrollment_data as $enrollment){
        // format date
        $enrollment->created_at = date('l, F j, Y h:i A', strtotime($enrollment->created_at));
        // format tuition
        $enrollment->tuition = number_format($enrollment->tuition, 2);
        // get balance
        $enrollment->balance = number_format($transaction->getBalance($enrollment->id), 2);
    }
    
    echo json_encode([
        'status' => 'success',
        'message' => 'Data retrieved successfully',
        'user_data' => $user_data,
        'enrollment_data' => $enrollment_data
    ]);
}