<?php
/**
 * Created by PhpStorm.
 * User: Игорь
 * Date: 29.11.2014
 * Time: 2:57
 */

header("Content-Type: text/html; charset=utf-8");

include_once '../init.php';

App::run(new Controller_Index('callback'));