<?php

abstract class Controller_Abstract
{
    private $action = false;

    const PREF_ACTION = 'action';

    final public function __construct($action = false) {
        $this->action = $action;
    }

    /**
     * @param Request $request
     */
    final public function run($request) {
        $this->preAction($request);
        if ($this->action) {
            $action = self::PREF_ACTION . ucfirst($this->action);
            return $this->$action($request);
        }

        $this->actionDefault($request);
    }

    final public function getActionName() {
        return $this->action;
    }

    public function preAction() {
    }

    public function actionDefault(Request $request){
    }
}