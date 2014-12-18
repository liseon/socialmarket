<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 10.12.2014
 * Time: 19:15
 */

class Cli_Controller_Vk_Find extends Cli_Controller_Abstract
{
    public function actionDefault(Cli_Request $request) {
        echo "Heyy \n";
        $keys = ['продам', 'продаю', 'пробег'];
        Vk_Api::getInstance()->setToken('58a8078f96e9408da84c5add7dea0c3c3d0210ef2ebdba7be82ed8c6900565da2ad90a8a761e47b29d971');
        $friends = Vk_Api::getInstance()->friendsGet(20992);
        $count = $friends->count();
        $i = 0;
        $result = new Vk_PostsCollection();
        while ($friends->getNext()) {
            echo "Start friend: {$friends->getId()} \n";
            $friends2 = Vk_Api::getInstance()->friendsGet($friends->getId(), $friends);
            $count += $friends2->count();
            $i++;
            $searcher = new Posts_Searcher(Vk_Api::getInstance()->wallGet($friends->getId(), 30));
            $result->joinCollection($searcher->findPosts($keys, 30, false));
        }

        echo "Result:: {$count} \n";

        while ($result->getNext()) {
            echo iconv('utf-8','cp866', $result->getPostText()) . "\n";
        }
    }
}