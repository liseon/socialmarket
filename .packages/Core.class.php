<?php
/**
 * Created by PhpStorm.
 * User: Игорь
 * Date: 29.11.2014
 * Time: 1:52
 */

class Core
{

    public static function isCli() {
        return php_sapi_name() == 'cli';
    }

    public static function isDev() {
        return true;
    }
}