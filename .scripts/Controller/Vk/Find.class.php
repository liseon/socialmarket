<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 10.12.2014
 * Time: 19:15
 */

class Cli_Controller_Vk_Find extends Cli_Controller_Abstract
{
    public function actionDefault(Request $request) {
        echo "Heyy \n";
        $keys = ['продам', 'продаю', 'пробег'];
        Vk_Api::getInstance()->setToken('832d159d010b4e5db27fa58becaaeff8f827d55d35584f2b814a1bf5e8d059ba7e183d6f73fb5efe73124');
        $friends = Vk_Api::getInstance()->friendsGet(20992);
        $result = new Vk_PostsCollection();
        $postsCount = 0;
        $block = [];
        do {
            echo "Start friend: {$friends->getId()} \n";
            $block[] = $friends->getId();
            //$friends2 = Vk_Api::getInstance()->friendsGet($friends->getId(), $friends);
            //$count += $friends2->count();
            if (count($block) == Vk_Api::EXECUTE_LIMIT) {
                $posts = Vk_Api::getInstance()->executeWallGet($block, 30);
                $postsCount += $posts->count();
                echo "------------> Have got:: {$posts->count()} posts\n";
                $searcher = new Posts_Searcher($posts);
                $result->joinCollection($searcher->findPosts($keys, 30, false));
                $block = [];
            }
        } while ($friends->getNext());

        echo "Count (friends):: {$friends->count()} \n";
        echo "Count (posts): " . $postsCount . "\n";
        echo "Count (result): " . $result->count() . "\n";

        do {
            echo iconv('utf-8','cp866', $result->getPostText()) . "\n";
        } while ($result->getNext());
    }

    public function actionTest(Cli_Request $request) {
        echo "Start! \n";
        $keys = ['продам', 'продаю', 'пробег'];
        Vk_Api::getInstance()->setToken('832d159d010b4e5db27fa58becaaeff8f827d55d35584f2b814a1bf5e8d059ba7e183d6f73fb5efe73124');
        $friends = Vk_Api::getInstance()->friendsGet(20992);

        for ($i = 0; $i <= 17; $i++) {
            $fr[] = $friends->getId();
            $friends->getNext();
        }

        $result = new Vk_PostsCollection();
        $posts = Vk_Api::getInstance()->executeWallGet($fr, 30);
        $searcher = new Posts_Searcher($posts);
        $result->joinCollection($searcher->findPosts($keys, 30, false));
        echo "Count (posts): " . $posts->count() . "\n";
        echo "Count (result): " . $result->count() . "\n";
        do {
            echo iconv('utf-8','cp866', $result->getPostText()) . "\n";
        } while ($result->getNext());
    }
}