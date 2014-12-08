<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 04.12.2014
 * Time: 21:24
 */

class Cli_Request extends Patterns_Singleton
{
    private $args = [];

    private $className;

    private $methodName;

    const ARGUMENT_PREF = '--';

    public function __construct() {
        $this->className = $_SERVER['argv'][1];
        $this->methodName = $_SERVER['argv'][2];
        for ($i = 3; $i < count($_SERVER['argv']); $i++) {
            if (strpos($_SERVER['argv'][$i], self::ARGUMENT_PREF) !== false) {
                $this->args[str_replace(self::ARGUMENT_PREF, '', $_SERVER['argv'][$i])] =
                    isset($_SERVER['argv'][$i + 1]) ? $_SERVER['argv'][$i + 1] : false;
            }
        }
    }

    /**
     * @return mixed
     */
    public function getClassName() {
        return $this->className;
    }

    /**
     * @return mixed
     */
    public function getMethodName() {
        return $this->methodName;
    }

    /**
     * @return mixed
     */
    public function getArg($name) {
        return isset($this->args[$name]) ? $this->args[$name] : false;
    }

    public function isSetArg($name) {

    }


}