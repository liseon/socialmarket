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
        Vk_Api::getInstance()->setToken('01fb1b10b3e28928b8ae48d781290f2b09ebdc50dc0f41a25cda0dc64e731b278e59a198ed4597fdb2601');
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