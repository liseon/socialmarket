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
    const URL_API = "https://api.vk.com/method/";

    const URL_OAUTH = "https://oauth.vk.com/authorize?client_id=%d&scope=%s&redirect_uri=%s&response_type=code&v=5.27";

    const PERMISSIONS = 8194;

    private $token = 'd9d3410c8e2caa33937ba660562c17688fafe061bb463727ee9b740589cd2932355e9134a815a82c2c4e4';

    public static function getAuthUrl() {
        $appId = Config::get('vk', 'app_id');
        $domain = Config::get('domain');
        $callback = $domain['full'] . $domain['callback'];
        return sprintf(self::URL_OAUTH, $appId, self::PERMISSIONS, $callback);
    }

    /**
     * @param $id
     * @return Vk_FriendsCollection
     */
    public function friendsGet($id){
        return new Vk_FriendsCollection(
            $this->request(
                'friends.get',
                [
                    'user_id' => $id,
                    'access_token' => $this->token,
                ]
            )
        );
    }

    /**
     * @param $id
     * @param $limit
     * @return Vk_PostsCollection
     */
    public function wallGet($id, $limit){
        return new Vk_PostsCollection(
            $this->request(
                'wall.get',
                [
                    'owner_id' => $id,
                    'count' => $limit,
                    'filter' => 'all',
                    'access_token' => $this->token,
                ]
            )
        );
    }

    private function request($method, $params){
        $url = self::URL_API . $method . "?" . http_build_query($params);
        $result = file_get_contents($url);
        $json = json_decode($result, true);

        if (isset($json['error'])) {
            echo "Error {$result} \r\n";
            print_r($params);
        }

        return isset($json['response']) ? $json['response'] : false;
    }
}