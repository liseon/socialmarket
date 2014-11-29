<?php
/**
 * Created by PhpStorm.
 * User: Игорь
 * Date: 28.11.2014
 * Time: 23:25
 */

class Vk_FriendsCollection extends Collection implements Friends_CollectionInterface
{
    /**
     * @param array|false $rows
     */
    public function __construct($rows) {
        if (!is_array($rows)) {
            return;
        }
        foreach ($rows as $row) {
            $this->add([
                    'id' => $row,
                    'name' => null,
                    'mutual_friend' => null,
                ]);
        }
    }

    public function getId() {

        return $this->getProperty('id');
    }

    public function getName(){

    }

    public function getMutualFriendId(){

    }
}