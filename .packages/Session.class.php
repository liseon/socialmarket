<?php
/**
 * Created by PhpStorm.
 * User: Игорь
 * Date: 29.11.2014
 * Time: 1:37
 */

class Session extends Patterns_Singleton
{
    public static function start() {
        session_start();
    }

    public static function getProperty($name) {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : false;
    }

    public static function setProperty($name, $value) {
        $_SESSION[$name] = $value;
    }
}