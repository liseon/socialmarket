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
        return $this->formAuth();

        $keys = ['продам', 'продаю', 'пробег'];
        Vk_Api::getInstance()->setToken('58a8078f96e9408da84c5add7dea0c3c3d0210ef2ebdba7be82ed8c6900565da2ad90a8a761e47b29d971');
        $friends = Vk_Api::getInstance()->friendsGet(4916443);
        $result = new Vk_PostsCollection();
        $count = $friends->count();
        $i = 0;
        while ($friends->getNext()) {
            $friends2 = Vk_Api::getInstance()->friendsGet($friends->getId(), $friends);
            $count += $friends2->count();
            $i++;
           // $searcher = new Posts_Searcher(Vk_Api::getInstance()->wallGet($friends->getId(), 30));
           // $result->joinCollection($searcher->findPosts($keys, 30, false));
        }

        echo "<br>***************<br>Result:: {$count}<br>";

       /* while ($result->getNext()) {
            echo $result->getPostText() . "\r\n";
        }*/

    }

    public function actionCallback() {
        $result = Vk_Api::getInstance()->getNewAccessToken(Front_Request::getGet(Vk_Api::PARAM_CODE));
        print_r($result);
    }

    private function formAuth() {
        Redirect::go(Vk_Api::getAuthUrl());

        return true;
    }
}