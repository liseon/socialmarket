<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 27.11.2014
 * Time: 21:02
 */

class Vk_PostsCollection extends Collection implements Posts_CollectionInterface
{
    public function getPostTime() {

        return $this->getProperty('created');
    }

    public function getPostText() {

        return $this->getProperty('text') . $this->getProperty('copy_text');
    }

    public function getPostId() {

        return $this->getProperty('id');
    }

    public function getOwnerId() {

        return $this->getProperty('to_id');
    }
}