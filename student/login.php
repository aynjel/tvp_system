<?php

require('../autoload.php');

$user = new Student();

$id_number = Input::get('id_number');
$password = Input::get('password');

if(Input::exists('get')){
    $validate = new Validate();
    $validation = $validate->check($_GET, [
        'id_number' => [
            'display' => 'ID Number',
            'required' => true,
            'is_numeric' => true,
        ],
        'password' => [
            'display' => 'Password',
            'required' => true,
        ]
    ]);

    if($validation->passed()){
        try{
            $res = $user->login($id_number, $password);
            if($res){
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Login successful',
                    'data_id' => $res->id
                ]);
            }else{
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Login failed'
                ]);
            }
        }catch(Exception $e){
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }else{
        echo json_encode([
            'status' => 'error',
            'message' => $validation->errors()[0]
        ]);
    }
}else{
    echo json_encode([
        'status' => 'error',
        'message' => 'No data received'
    ]);
}