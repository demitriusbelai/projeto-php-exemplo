<?php

class Path {

    private static $map = array();
    private static $classMap = array();
    private static $filter = array();

    static function map($path, $class) {
        Path::$map[$path] = $class;
        Path::$classMap[$class] = $path;
    }

    static function filter($path, $class) {
        if (array_key_exists($path, Path::$filter)) {
            if (!is_array(Path::$filter[$path])) {
                Path::$filter[$path] = array(Path::$filter[$path]);
            }
            Path::$filter[$path][] = $class;
        } else
            Path::$filter[$path] = $class;
    }

    static function getClassMap($class) {
        if (!array_key_exists($class, Path::$classMap))
            return null;
        return Path::$classMap[$class];
    }

    static function find($path) {
        $paths = explode('/', $path);
        for ($i = count($paths); $i > 0; $i--) {
            $key = implode('/', array_slice($paths, 0, $i));
            if (array_key_exists($key, Path::$map)) {
                return $key;
            }
        }
    }

    static function filters($path) {
        $filters = array();
        foreach (Path::$filter as $key => $action) {
            $p = '/^'.str_replace('/', '\/', $key).'/';
            if (preg_match($p, $path)) {
                if (is_array($action)) {
                    foreach($action as $a)
                        $filters[] = $a;
                } else
                    $filters[] = $action;
            }
        }
        return $filters;
    }

    static function getMap($key) {
        if (array_key_exists($key, Path::$map))
            return Path::$map[$key];
        else
            return null;
    }

}
