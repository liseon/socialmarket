<?php
/**
 * Created by PhpStorm.
 * User: Игорь
 * Date: 27.11.2014
 * Time: 0:29
 *
 */

class Response extends Patterns_Singleton
{
    /**
     * @var array
     */
    private $args = array();

    public function setArg($name, $value) {
        $this->args[$name] = $value;
    }

    public function setArgs($args) {
        $this->args = array_merge($this->args, $args);
    }

    public function unsetArg($name) {
        unset($this->args[$name]);
    }

    public function issetArg($name) {
        return isset($this->args[$name]);
    }

    public function setError($errorText, $errorCode) {
        $this->setArgs(array(
            ));
    }

    public function serialize() {

        return json_encode($this->args);
    }

    public function output() {
        die($this->serialize());
    }
}