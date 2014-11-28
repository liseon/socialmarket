<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 27.11.2014
 * Time: 20:29
 */

class Content_Searcher
{
    /** @var Collection  */
    private $collection;

    /**
     * @param Collection $collection
     */
    public function __construct(Collection $collection) {
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
                echo "Time!!! <br><br>";
                continue;
            }
            $found = 0;
            $text = self::normalize($this->collection->getPostText());
            foreach ($keys as $key) {
                if (!mb_strpos($text, $key) === false) {
                    $found++;
                } else {
                    echo "************************************<br>Text :: {$text} <br> KEY:: {$key} <br>*******************************<br>";
                }
            }
            //Результат не найден, если вообще нет совпадений, либо если поиск жесткий и совпадений недостаточно.
            if (!$found || ($isHard && count($found) < count($keys))) {
                echo "Found (( {$found} <br><br>";
                continue;
            }

            $result->add($this->collection->getCurrent());
        }
    }

    private static function normalize($text) {

//        return $text;

        return strtolower($text);

        return str_replace([' ', ',', '.', '!', '?', '&', '_', '~'], '', mb_strtolower($text));
    }
}