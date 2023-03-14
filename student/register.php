<?php

require('../autoload.php');

$student = new Student();

$id_number = Input::get('id_number');
$password = Input::get('password');
$email = Input::get('email');
$first_name = Input::get('first_name');
$last_name = Input::get('last_name');

if(Input::exists('get')){
    $validate = new Validate();
    $validation = $validate->check($_GET, [
        'id_number' => [
            'display' => 'ID Number',
            'required' => true,
            'min' => 8,
            'unique' => 'students'
        ],
        'password' => [
            'display' => 'Password',
            'required' => true,
            'min' => 6
        ],
        'confirm_password' => [
            'display' => 'Confirm Password',
            'required' => true,
            'matches' => 'password'
        ],
        'email' => [
            'display' => 'Email',
            'required' => true,
            'email' => true,
            'unique' => 'students'
        ],
        'first_name' => [
            'display' => 'First Name',
            'required' => true,
            'min' => 2,
            'max' => 50
        ],
        'last_name' => [
            'display' => 'Last Name',
            'required' => true,
            'min' => 2,
            'max' => 50
        ]
    ]);
    
    if($validation->passed()){
        try{
            $res = $student->register([
                'id_number' => $id_number,
                'password' => $password,
                'email' => $email,
                'first_name' => $first_name,
                'last_name' => $last_name
            ]);
            
            if($res){
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Registration successful',
                    'data_id' => $res
                ]);
            }else{
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Registration failed'
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