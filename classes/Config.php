<?php

class Config{
    private static $config = [
        'mysql' => [
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'db' => 'tvp_db'
        ],
        'email' => [
            'host' => 'smtp.gmail.com',
            'username' => 'sample@gmail.com',
            'password' => 'sample',
            'port' => 587,
            'secure' => 'tls'
        ],
        'url' => [
            'base' => 'http://localhost/tvp/',
            'admin' => 'http://localhost/tvp/admin/',
            'student' => 'http://localhost/tvp/student/',
            'assets' => 'http://localhost/tvp/assets/'
        ],
        'session' => [
            'admin' => 'admin_id',
            'student' => 'student_id'
        ],
        'remember' => [
            'admin' => 'admin',
            'student' => 'student'
        ],
        'website' => [
            'name' => 'TVP',
            'title' => 'TVP - Tuition Viewing Portal',
            'description' => 'TVP - Tuition Viewing Portal',
            'keywords' => 'TVP, Tuition Viewing Portal, TVP - Tuition Viewing Portal',
            'author' => 'TVP'
        ],
        'admin' => [
            'username' => 'admin',
            'password' => 'admin'
        ]
    ];
    
    public static function get($path = null){
        if($path){
            $config = self::$config;
            $path = explode('/', $path);
            
            foreach($path as $bit){
                if(isset($config[$bit])){
                    $config = $config[$bit];
                }
            }
            
            return $config;
        }
        
        return false;
    }
}