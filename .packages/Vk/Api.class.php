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
    private $token = '';

    private $lock;

    private $startTime;

    private $timeForRequest = 0;

    const URL_API = "https://api.vk.com/method/";

    const URL_OAUTH = "https://oauth.vk.com/authorize?client_id=%d&scope=%s&redirect_uri=%s&response_type=code&v=5.27";

    const URL_ACCESS_TOKEN = "https://oauth.vk.com/access_token?client_id=%d&client_secret=%s&code=%s&redirect_uri=%s";

    const PERMISSIONS = 4194304;

//    const PERMISSIONS = 2; //Друзья

    const PARAM_CODE = 'code';

    const REQUESTS_LIMIT = 3;

    /** сколько ждать при ошибки по лимиту запросов */
    const ERROR_WAIT_MS = 1000000;


    /**
     * @param string $token
     */
    public function setToken($token) {
        $this->token = $token;
    }

    public static function getAuthUrl() {
        $appId = ConfigHelper::get('vk', 'app_id');
        $domain = ConfigHelper::get('domain');
        $callback = $domain['full'] . $domain['callback'];
        return sprintf(self::URL_OAUTH, $appId, self::PERMISSIONS, $callback);
    }

    /**
     * Получим от Контакта access_token
     *
     * @param $code
     * @return bool|mixed
     */
    public function getNewAccessToken($code) {
        $vkConf = ConfigHelper::get('vk');
        $appId = $vkConf['app_id'];
        $secret = $vkConf['secret'];
        $domain = ConfigHelper::get('domain');
        $callback = $domain['full'] . $domain['callback'];
        $url = sprintf(self::URL_ACCESS_TOKEN, $appId, $secret, $code, $callback);

        $result = $this->requestHttp($url);
        $json = json_decode($result, true);
        if (isset($json['error'])) {
            echo "Error {$result} \r\n";

            return false;
        }

        return $json;
    }

    /**
     * @param $id
     * @param Vk_FriendsCollection|null $clean
     * @return Vk_FriendsCollection
     */
    public function friendsGet($id, $clean = null) {
        if (!$this->startTime) {
            $this->startTime = time();
        }
        return new Vk_FriendsCollection(
            $this->requestApi(
                'friends.get',
                [
                    'user_id' => $id,
                    'access_token' => $this->token,
                ]
            ),
            $clean
        );
    }

    /**
     * @param $id
     * @param $limit
     * @return Vk_PostsCollection
     */
    public function wallGet($id, $limit){
        return new Vk_PostsCollection(
            $this->requestApi(
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

    private function requestApi($method, $params){
        $url = self::URL_API . $method . "?" . http_build_query($params);
        $repeat = false;
        do {
            $result = $this->requestHttp($url);
            $json = json_decode($result, true);
            if (isset($json['error']['error_code']) && $json['error']['error_code'] == 6) {
                $repeat = true;
                $sec = time() - $this->startTime;
                echo "<br>Error in {$sec}  seconds! <br> {$result} <br>";

                return false;
                usleep(self::ERROR_WAIT_MS);
            }
        } while ($repeat);

        return isset($json['response']) ? $json['response'] : false;
    }

    /**
     * Ждем пока снова можно будет совершать запрос!
     *
     * @return bool
     */
    private function waitLock() {
        $time = microtime(true);
        if(!$this->lock) {
            $this->timeForRequest = 1 / self::REQUESTS_LIMIT;
        } elseif ($time <= $this->lock + $this->timeForRequest) {
            $sleepTime = ceil(($this->lock + $this->timeForRequest - $time) * 1000000);
            usleep($sleepTime);
        }

        $this->lock = microtime(true);

        return true;
    }

    private function requestHttp($url){
        if (!$this->waitLock()) {
            return false;
        }

        return file_get_contents($url);
    }
}