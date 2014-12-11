<?php
/**
 * Created by PhpStorm.
 * User: Игорь
 * Date: 27.11.2014
 * Time: 0:48
 */

class App extends Patterns_Singleton
{
    public static function run(Controller_Abstract $controller) {
        $controller->run(Front_Request::getInstance());
    }

    public static function runCli() {
        $className = Cli_Request::getInstance()->getClassName();
        if (!(($controller = new $className(Cli_Request::getInstance()->getMethodName())) instanceof
            Cli_Controller_Abstract)
        ) {
            trigger_error("Error! {$className} should be instance of Cli_Controller_Abstract!");

            return false;
        }

        /** @var $controller Cli_Controller_Abstract */
        $controller->run(Cli_Request::getInstance());
    }
}