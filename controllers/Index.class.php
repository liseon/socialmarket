<?php
/**
 * Created by PhpStorm.
 * User: Игорь
 * Date: 27.11.2014
 * Time: 0:55
 */

class Controller_Index extends Controller_Abstract
{
    public function actionDefault() {
        //$friends = Vk_Api::getInstance()->friendsGet(20992);
        /*foreach ($friends as $friend) {
            echo $friend;
            break;
        }*/

        $wall = Vk_Api::getInstance()->wallGet(20992, 30);
//        var_dump($wall);
        $searcher = new Content_Searcher(new Vk_PostsCollection($wall));
        var_dump($searcher->findPosts(['сочи']));

    }
}