<?php

class Admin extends Model{
    protected $table = 'admins';
    protected $fillable = [
        'username',
        'password'
    ];

    public function __construct(){
        parent::__construct($this->table);
    }

    public function isLoggedIn(){
        return Session::exists(Config::get('session/admin'));
    }

    public function logout(){
        Session::delete(Config::get('session/admin'));
    }
    
    public function login($username, $password){
        $user = $this->findBy('username', $username);
        $pass = $this->findBy('password', $password);

        if($user && $pass){
            Session::put(Config::get('session/admin'), $user->id);
            return true;
        }

        return false;
    }
}