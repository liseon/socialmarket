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
        Vk_Api::getInstance()->setToken('9f7fd127b0271edb73d0c5fda3499579cd6a013003384af3144e12bac762d10931cc2cefd6167456d534f');
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