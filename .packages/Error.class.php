<?php
/**
 * Created by PhpStorm.
 * User: Игорь
 * Date: 27.11.2014
 * Time: 0:29
 */

class Error
{
    const CLASS_NOT_FOUND = 404;

    const MEMCACHE_CONN_FAIL = 101;

    const MONGO_CONN_FAIL = 201;

    const API_FATAL_TEXT = "Fatal error!";

    private static $errors = array(
        self::CLASS_NOT_FOUND => "Not Found!",
    );

    public static function getErrorTextByCode($code) {
        return isset(self::$errors[$code]) ? self::$errors[$code] : false;
    }

    /**
     * @param $comment
     * @param $code
     */
    public static function fatal($comment, $code) {
        trigger_error("{$comment} ErrorCode: {$code}");
        $response = Response::getInstance();
        $response->setError(self::getErrorTextByCode($code), $code);

        $response->output();
    }
}