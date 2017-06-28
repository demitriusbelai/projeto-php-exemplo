<?php

class Input {

    private static $values = array();

    public static function get($name) {
        if (array_key_exists($name, Input::$values)) {
            return Input::$values[$name];
        } else if (array_key_exists($name, $_REQUEST)) {
            return $_REQUEST[$name];
        }
        return null;
    }

    public static function set($name, $value) {
        Input::$values[$name] = $value;
    }

}
