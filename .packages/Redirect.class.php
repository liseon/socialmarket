<?php
/**
 * Created by PhpStorm.
 * User: Игорь
 * Date: 29.11.2014
 * Time: 2:34
 */

class Redirect
{
    public static function go($url){
        header("Location: {$url}");
    }
}