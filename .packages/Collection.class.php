<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 27.11.2014
 * Time: 20:46
 */

abstract class Collection
{

    /** @var array */
    protected $rows = [];

    /**
     * @param $rows
     */
    public function __construct($rows) {
        $this->rows = $rows;
    }

    protected function getRows() {
        return $this->rows;
    }

    abstract function getGetPostTime();

    abstract function getPostText();
}