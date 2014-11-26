<?php
/**
 * Created by PhpStorm.
 * User: Игорь
 * Date: 27.11.2014
 * Time: 0:30
 */

abstract class Patterns_Singleton {

    private static $instances;

    private final function __construct(){
    }

    private final function __clone() {
    }

    /**
     * @return mixed
     */
    public static function getInstance() {
        $class = get_called_class();
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new $class();
        }

        return self::$instances[$class];
    }

}