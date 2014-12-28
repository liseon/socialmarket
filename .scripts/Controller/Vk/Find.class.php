<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 10.12.2014
 * Time: 19:15
 */

class Cli_Controller_Vk_Find extends Cli_Controller
{
    private $keys = [
        'прода' => 40,
        'пробег' => 30,
        'л.с' => 30,
        'км' => 10,
        'скучен' => 50,
        'ксенон' => 70,
        'акпп' => 60,
        //'ат' => 10,
        'механика' => 10,
        'аварий' => 20,
        'салон' => 20,
    ];

    private $criteria;

    const CAR_BREND_POINT = 60;


    public function actionDefault(Cli_Request $request) {
        echo "Heyy \n";


        //echo iconv('utf-8','cp866', Strings::normalize('❤❤❤ @ Живописная, 2 http://instagram.com/p/sU9m0eooyR/')) . "\n";
        //die();

        Vk_Api::getInstance()->setToken('b6eed00259626530c8c4594bc557f5fd71a9e2ed8bddbed5a342f61cbb6d4225e46ce6c6ffebdd9144f60');
        $friends = Vk_Api::getInstance()->friendsGet(20992);
        $result = new Vk_PostsCollection();
        $postsCount = 0;
        $friendsCount = $friends->count();
        //Первый круг друзей
        $this->fetchPostsForUsers($friends, $result, $postsCount);
        //Второй круг друзей
        $friends->reset();
        do {
            $friends2 = Vk_Api::getInstance()->friendsGet($friends->getId(), $friends);
            $friendsCount += $friends2->count();
            $this->fetchPostsForUsers($friends2, $result, $postsCount);
        } while ($friends->getNext());

        echo "Count (friends):: {$friends->count()} \n";
        echo "Count (posts): " . $postsCount . "\n";
        echo "Count (result): " . $result->count() . "\n";

        do {
            echo iconv('utf-8','cp866', $result->getPostText()) . "\n";
            echo "id: {$result->getPostId()}  owner_id: {$result->getOwnerId()} \n";
        } while ($result->getNext());
    }

    private function fetchPostsForUsers(Vk_FriendsCollection $friends, Vk_PostsCollection &$result, &$postsCount) {
        $block = [];
        do {
            $block[] = $friends->getId();
            if (count($block) == Vk_Api::EXECUTE_LIMIT) {
                $posts = Vk_Api::getInstance()->executeWallGet($block, 30);
                $postsCount += $posts->count();
                $searcher = new Posts_Searcher($posts);
                $result->joinCollection($searcher->findPosts($this->getCriteria()));
                $block = [];
            }
        } while ($friends->getNext());
    }

    private function getCriteria() {
        if (!$this->criteria) {
            $this->criteria = new Posts_SearcherCriteria($this->keys, 30, 110);
            $this->criteria->addGroup(ConfigHelper::getInfo('carBrands'), self::CAR_BREND_POINT);
        }

        return $this->criteria;
    }
}