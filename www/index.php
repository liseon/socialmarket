<?php
/**
 * Created by PhpStorm.
 * User: Игорь
 * Date: 27.11.2014
 * Time: 0:00
 */

header("Content-Type: text/html; charset=utf-8");

include_once '../init.php';

App::run(new Controller_Index());