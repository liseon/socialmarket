<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 27.11.2014
 * Time: 21:02
 */

class Vk_PostsCollection extends Collection
{
    public function getPostTime() {

        return $this->getProperty('created');
    }

    public function getPostText() {
        echo ($this->getProperty('text') . "<br>");

        return $this->getProperty('text');
    }
}