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

    const CAR_BREND_POINT = 60;


    public function actionDefault(Cli_Request $request) {
        echo "Heyy \n";
        $criteria = new Posts_SearcherCriteria($this->keys, 30, 110);
        $criteria->addGroup(ConfigHelper::getInfo('carBrands'), self::CAR_BREND_POINT);

        //echo iconv('utf-8','cp866', Strings::normalize('❤❤❤ @ Живописная, 2 http://instagram.com/p/sU9m0eooyR/')) . "\n";
        //die();

        Vk_Api::getInstance()->setToken('eedb295301d168f73471f35ada8a9422044696bdf48721fee494a4d75690ece6470f3464644a691934390');
        $friends = Vk_Api::getInstance()->friendsGet(22189);
        $result = new Vk_PostsCollection();
        $postsCount = 0;
        $block = [];
        do {
            $block[] = $friends->getId();
            //$friends2 = Vk_Api::getInstance()->friendsGet($friends->getId(), $friends);
            //$count += $friends2->count();
            if (count($block) == Vk_Api::EXECUTE_LIMIT) {
                $posts = Vk_Api::getInstance()->executeWallGet($block, 30);
                $postsCount += $posts->count();
                $searcher = new Posts_Searcher($posts);
                $result->joinCollection($searcher->findPosts($criteria));
                $block = [];
            }
        } while ($friends->getNext());

        echo "Count (friends):: {$friends->count()} \n";
        echo "Count (posts): " . $postsCount . "\n";
        echo "Count (result): " . $result->count() . "\n";

        do {
            echo iconv('utf-8','cp866', $result->getPostText()) . "\n";
            echo "id: {$result->getPostId()}  owner_id: {$result->getOwnerId()} \n";
        } while ($result->getNext());
    }
}