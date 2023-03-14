<?php

class H{
    public static function dnd($data, $die = false){
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        if($die){
            die();
        }
    }
    
    public static function sanitize($dirty){
        return htmlentities($dirty, ENT_QUOTES, 'UTF-8');
    }
}