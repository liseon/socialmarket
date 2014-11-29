<?php

abstract class Controller_Abstract
{
    private $action = null;

    public function __construct($action = null) {
        $this->action = $action;
    }

    public function getActionName() {
        return $this->action;
    }

    public function preAction() {
    }

    abstract public function actionDefault();
}