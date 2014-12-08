<?php
/**
 * Created by PhpStorm.
 * User: Игорь
 * Date: 27.11.2014
 * Time: 0:48
 */

class App extends Patterns_Singleton
{
    const PREF_ACTION = 'action';

    const ACTION_DEFAULT = 'default';

    public static function run(Controller_Abstract $controller) {
        $actionDef = self::PREF_ACTION . ucfirst(self::ACTION_DEFAULT);
        $actionRun = self::PREF_ACTION . ucfirst($controller->getActionName());
        if (method_exists($controller, $actionRun)) {
            $controller->$actionRun();
        } else {
            $controller->$actionDef();
        }
    }

    public static function runCli() {
        print_r('Run cli');
        print_r($_SERVER['argv']);
    }
}