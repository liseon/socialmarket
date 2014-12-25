<?php
/**
 * Created by PhpStorm.
 * User: Игорь
 * Date: 27.11.2014
 * Time: 0:55
 */

class Controller_Index extends Front_Controller
{
    public function actionDefault() {
        return $this->formModels();

        return $this->formAuth();

        $keys = ['продам', 'продаю', 'пробег'];
        Vk_Api::getInstance()->setToken('01fb1b10b3e28928b8ae48d781290f2b09ebdc50dc0f41a25cda0dc64e731b278e59a198ed4597fdb2601');
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

    private function formModels() {
        $models = ConfigHelper::getInfo('carModels');
        foreach ($models as $model) {
            echo "'" . $model['title'] . "', <br>";
        }

    }
}