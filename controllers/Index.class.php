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
      //  return $this->formAuth();

        $keys = ['продам', 'продаю', 'пробег'];
        $friends = Vk_Api::getInstance()->friendsGet(20992);
        $result = new Vk_PostsCollection();
        while ($friends->getNext()) {
            $searcher = new Posts_Searcher(Vk_Api::getInstance()->wallGet($friends->getId(), 30));
            $result->joinCollection($searcher->findPosts($keys, 30, false));
        }

        while ($result->getNext()) {
            echo $result->getPostText() . "\r\n";
        }

    }

    public function actionCallback() {
        echo "Успех!!";
    }

    private function formAuth() {
        Redirect::go(Vk_Api::getAuthUrl());

        return true;
    }
}