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
        //return $this->formModels();

        return $this->formAuth();

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