<?php
/**
 * Created by PhpStorm.
 * User: Игорь
 * Date: 27.11.2014
 * Time: 1:16
 *
 *
 */

class Vk_Api extends Patterns_Singleton
{
    const URL = "https://api.vk.com/method/";

    public function friendsGet($id){
        return $this->request('friends.get', [
                'user_id' => $id,
            ]);
    }

    public function wallGet($id, $limit){
        return $this->request('wall.get', [
                'owner_id' => $id,
                'count' => $limit,
                'filter' => 'all',
            ]);
    }

    private function request($method, $params){
        $url = self::URL . $method . "?" . http_build_query($params);
        $result = file_get_contents($url);
        $json = json_decode($result, true);

        return $json['response'];
    }
}