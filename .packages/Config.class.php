<?php
/**
 * Created by PhpStorm.
 * User: Игорь
 * Date: 29.11.2014
 * Time: 2:18
 */

class Config
{
    public static function get($configName, $value = null){
        $type = Core::isDev() ? 'devel' : 'production';
        $path = __DIR__ . "/../.configuration/{$type}/{$configName}.config.php";
        if (!file_exists($path)) {
            return false;
        }
        $config = include_once $path;

        return $value && isset($config[$value]) ? $config[$value] : $config;
    }
}