<?php
/**
 * Created by PhpStorm.
 * User: Игорь
 * Date: 27.11.2014
 * Time: 0:13
 */

function includeFile($file) {
    if (file_exists($file)) {
        include_once $file;

        return true;
    }

    return false;
}

spl_autoload_register(
    function ($className) {
        $path = __DIR__ . "/.packages/" . str_replace("_", "/", $className) . ".class.php";
        if (includeFile($path)) {

            return;
        }

        $expl = explode("_", $className);
        $type = $expl[0];
        unset($expl[0]);
        switch ($type) {
            case 'Controller':
                $path = __DIR__ . "/controllers/" . implode("/", $expl) . ".class.php";
                break;
        }

        if (!includeFile($path)) {
            Error::fatal("Class {$className} not found!", Error::CLASS_NOT_FOUND);
        }
    }
);

if (!Core::isCli()) {
    Session::start();
}