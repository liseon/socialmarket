<?php

abstract class Controller_Abstract
{
    public function preAction() {
    }

    abstract public function actionDefault();
}