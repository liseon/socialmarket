<?php
/**
 * Created by PhpStorm.
 * User: Игорь
 * Date: 29.11.2014
 * Time: 13:46
 */

class Request
{
    private static $methods = [
        'post',
        'get',
        'cookie',
    ];

    public static function isPost() {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    public static function getOrPost($name) {
        return self::get($name, ['get', 'post']);
    }

    public static function getCookie($name) {
        return self::get($name, ['cookie']);
    }

    public static function getGet($name) {
        return self::get($name, ['get']);
    }

    public static function get($name, $methods = null, $default = false) {
        is_null($methods) && $methods = self::$methods;
        !is_array($methods) && $methods = [$methods];

        foreach (self::$methods as $method) {
            if (in_array($method, $methods)) {
                switch ($method) {
                    case "get":
                        if (isset($_GET[$name])) {
                            return $_GET[$name];
                        }
                        break;
                    case "post":
                        if (isset($_POST[$name])) {
                            return $_POST[$name];
                        }
                        break;
                    case "cookie":
                        if (isset($_COOKIE[$name])) {
                            return $_COOKIE[$name];
                        }
                        break;
                }
            }
        }

        return $default;
    }

}