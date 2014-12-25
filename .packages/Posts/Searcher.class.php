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
     * @param Posts_SearcherCriteria $criteria
     * @return Vk_PostsCollection $result
     *
     */
    public function findPosts(Posts_SearcherCriteria $criteria) {
        $result = new Vk_PostsCollection();
        $this->collection->reset();
        $period = (int)$criteria->getDays() * Constants::DAY;
        $extremeTime = time() - $period;

        do {
            if ($extremeTime < $this->collection->getPostTime()) {
                //Цикл не прерываем, т.к. мы точно не можем быть уверены в верной сортировке по дате.
                continue;
            }
            if ($criteria->analizeText($this->collection->getPostText())) {
                $result->add($this->collection->getCurrent());
            }
        } while ($this->collection->getNext());

        return $result;
    }

}