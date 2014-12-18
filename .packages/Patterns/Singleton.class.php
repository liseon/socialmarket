<?php
/**
 * Created by PhpStorm.
 * User: Игорь
 * Date: 27.11.2014
 * Time: 0:30
 */

abstract class Patterns_Singleton {

    private static $instances;

    private function __construct(){
    }

    private final function __clone() {
    }

    /**
     * @return static
     */
    public static function getInstance() {
        $class = get_called_class();
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new $class();
        }

        return self::$instances[$class];
    }

}