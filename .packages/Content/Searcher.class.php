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

    public function findPosts($keys) {
        //$result = n
    }
}