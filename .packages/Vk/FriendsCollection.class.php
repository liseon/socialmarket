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
     * @param Vk_FriendsCollection|null $clean
     */
    public function __construct($rows, $clean = null) {
        if (!is_array($rows)) {
            return;
        }
        //Очистим от друзей, которые итак уже являются моими
        if ($clean instanceof Vk_FriendsCollection) {
            $clean = $clean->getRows();
            $rows = array_filter($rows, function($value) use($clean) {
                   return !in_array($value, $clean);
                });
        }
        $this->rows = $rows;
    }

    public function getId() {

        return $this->getCurrent();
    }

    public function getName(){
    }

    public function getMutualFriendId(){
    }
}