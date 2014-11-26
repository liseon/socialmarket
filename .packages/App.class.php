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

    public static function run($controller) {
        $actionName = self::PREF_ACTION . ucfirst(self::ACTION_DEFAULT);
        $controller->$actionName();
    }
}