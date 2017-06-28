<?php

abstract class Rule {

    private $name;
    private $array;
    private $msg;

    public function __construct($name, $msg) {
        $this->name = $name;
        $this->msg = $msg;
    }

    abstract public function validate();

    public function setArray($array) {
        $this->array = $array;
    }

    public function getValue() {
        return $this->array[$this->name];
    }

    public function setValue($value) {
        $this->array[$this->name] = $value;
    }

    public function getName() {
        return $this->name;
    }

    public function getArray() {
        return $this->array;
    }

    public function getMessage() {
        return $this->msg;
    }

    public function setMessage($msg) {
        $this->msg = $msg;
    }

}

class FunctionRule extends Rule {

    private $func = null;

    public function __construct($name, $func) {
        parent::__construct($name);
        $this->func = $func;
    }

    public function validate() {
        return call_user_func_array($this->func, func_get_args());
    }

}

class Validator {

    private $array;
    private $rules = array();
    private $errors = array();

    public function __construct($array) {
        $this->array = $array;
    }

    public function addRule($rule) {
        if (!array_key_exists($rule->getName(), $this->rules)) {
            $this->rules[$rule->getName()] = array();
        }
        $this->rules[$rule->getName()][] = $rule;
    }

    public function validate() {
        foreach($this->rules as $list) {
            foreach($list as $r) {
                $r->setArray($this->array);
                if (!$r->validate()) {
                    $this->errors[$r->getName()] = $r->getMessage();
                    break;
                }
            }
        }
        return count($this->errors) == 0;
    }

    public function getErrors() {
        return $this->errors;
    }

}
