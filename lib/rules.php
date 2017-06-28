<?php

require_once "validator.php";

class RequiredRule extends Rule {

    public function __contruct($name, $msg) {
        parent::__construct($name, null);
        $this->setMessage($msg);
    }

    public function validate() {
        return array_key_exists($this->getName(), $this->getArray()) && $this->getValue() != '';
    }

}

class NumberRule extends Rule {

    public function __contruct($name, $msg) {
        parent::__construct($name, null);
        $this->setMessage($msg);
    }

    public function validate() {
        if (!array_key_exists($this->getName(), $this->getArray()) || $this->getValue() == '')
            return true;
        $number = $this->getValue();
        if (!preg_match("/^[0-9]+$/", $number))
            return false;
        return true;
    }

}

class MoneyRule extends Rule {

    private $decimal;

    public function __construct($name, $msg, $decimal) {
        parent::__construct($name, null);
        $this->setMessage($msg);
        $this->decimal = $decimal;
    }

    public function validate() {
        if (!array_key_exists($this->getName(), $this->getArray()) || $this->getValue() == '')
            return true;
        $number = $this->getValue();
        if (!preg_match("/^[0-9,.]+$/", $number))
            return false;
        $number = preg_replace('/[^'.$this->decimal.'0-9]/', '', $number);
        $number = str_replace($this->decimal, '.', $number);
        Input::set($this->getName().'_number', $number);
        return true;
    }

}
