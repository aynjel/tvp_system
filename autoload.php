<?php

function myAutoloader($className){
    if(file_exists('classes/'.$className.'.php')){
        require_once('classes/'.$className.'.php');
    }elseif(file_exists('../classes/'.$className.'.php')){
        require_once('../classes/'.$className.'.php');
    }elseif(file_exists('../models/'.$className.'.php')){
        require_once('../models/'.$className.'.php');
    }elseif(file_exists('models/'.$className.'.php')){
        require_once('models/'.$className.'.php');
    }else{
        die('Class '.$className.' not found.');
    }
}

spl_autoload_register('myAutoloader');

session_start();