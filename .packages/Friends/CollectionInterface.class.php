<?php
/**
 * Created by PhpStorm.
 * User: Игорь
 * Date: 28.11.2014
 * Time: 23:17
 */

interface Friends_CollectionInterface
{
    public function getId();

    public function getName();

    public function getMutualFriendId();
}