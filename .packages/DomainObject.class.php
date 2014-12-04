<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 04.12.2014
 * Time: 14:25
 *
 * @todo
 */

abstract class DomainObjects
{
    private $properties = [];

    public function __construct($properties) {
        $properties = $this->initProperties();
        array_merge($this->properties, $properties);
    }

    abstract protected function initProperties();


}