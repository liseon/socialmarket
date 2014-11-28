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

    private $i;

    /**
     * @param array $rows
     */
    public function __construct($rows = []) {
        $this->rows = $rows;
    }

    public function add($row) {
        if (is_array($row)) {
            $this->rows[] = $row;
        }
    }

    public function getRows() {
        return $this->rows;
    }

    public function getNext() {
        if (isset($this->rows[$this->i + 1])) {
            $this->i++;

            return $this->rows[$this->i];
        }

        return false;
    }

    public function getCurrent(){
        return isset($this->rows[$this->i]) ? $this->rows[$this->i] : false;
    }

    /**
     * @param int $i
     * @return $this
     */
    public function setIndex($i) {
        $this->i = (int)$i;

        return $this;
    }

    public function reset() {
        return $this->setIndex(0);
    }

    public function unsetCurrent() {
        if (isset($this->rows[$this->i])) {
            unset($this->rows[$this->i]);
            $this->i--;

            return true;
        }

        return false;
    }

    public function getProperty($name) {
        return isset($this->getCurrent()[$name]) ? $this->getCurrent()[$name] : false;
    }



    abstract function getPostTime();

    abstract function getPostText();
}