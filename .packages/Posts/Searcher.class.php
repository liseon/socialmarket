<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 27.11.2014
 * Time: 20:29
 */

class Posts_Searcher
{
    /** @var Collection  */
    private $collection;

    /**
     * @param Vk_PostsCollection $collection
     */
    public function __construct(Vk_PostsCollection $collection) {
        $this->collection = $collection;
    }

    /**
     * Вернет коллекцию постов, которые удовлетворяют условиям:
     * 1) Были опубликованы не позже, чем $period дней назад.
     * 2) Создержат в посте вхождение всех требуемых подстрок, если параметр $isHard включен!
     * Или хотя бы одной строки, если $isHard == false
     * Перед поиском текст и ключи нормализуется!
     *
     * @param array $keys
     * @param int $period
     * @param bool $isHard
     * @return Vk_PostsCollection $result
     *
     */
    public function findPosts(array $keys, $period = 30, $isHard = false) {
        $result = new Vk_PostsCollection();
        $this->collection->reset();
        $period = (int)$period * Constants::DAY;
        $extremeTime = time() - $period;
        //нормализуем ключи поиска
        $keys = array_map(function ($val) {
                return self::normalize($val);
            }, $keys);

        while ($this->collection->getNext()) {
            if ($extremeTime < $this->collection->getPostTime()) {
                //Цикл не прерываем, т.к. мы точно не можем быть уверены в верной сортировке по дате.
                continue;
            }
            $found = 0;
            $text = self::normalize($this->collection->getPostText());
            foreach ($keys as $key) {
                if (!mb_strpos($text, $key) === false) {
                    $found++;
                }
            }
            //Результат не найден, если вообще нет совпадений, либо если поиск жесткий и совпадений недостаточно.
            if (!$found || ($isHard && count($found) < count($keys))) {
                continue;
            }

            $result->add($this->collection->getCurrent());
        }

        return $result;
    }

    private static function normalize($text) {

        return str_replace([' ', ',', '.', '!', '?', '&', '_', '~'], '', mb_strtolower($text, 'UTF-8'));
    }
}