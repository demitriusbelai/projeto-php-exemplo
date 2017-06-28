<?php

class ObjectPool {

    private static $array = array();

    public static function get($class, $val) {
        if (array_key_exists($class, ObjectPool::$array) && array_key_exists($val, ObjectPool::$array[$class])) {
            return ObjectPool::$array[$class][$val];
        }
        return null;
    }

    public static function put($class, $val, $bean) {
        if (!array_key_exists($class, ObjectPool::$array)) {
            ObjectPool::$array[$class] = array();
        }
        ObjectPool::$array[$class][$val] = $bean;
    }

}
