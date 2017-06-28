<?php

class Controller {

    private static $action;

    public static function execute($path) {
        $map = Path::find($path);
        if ($map == null) {
            $map = 'ERROR_404';
        }
        Controller::$action = Path::getMap($map);
        $filters = Path::filters($path);
        foreach($filters as $filter) {
            $f = new $filter();
            $f->filter();
        }
        Template::restoreState();
        $a = new Controller::$action();
        $args = str_replace($map.'/', '', $path);
        if ($args != '' && $args != $path) {
            $args = explode('/', $args);
            if (method_exists($a, $args[0])) {
                call_user_func_array(Array($a, $args[0]), array_slice($args, 1));
            } else {
                call_user_func_array(Array($a, 'execute'), $args);
            }
        } else {
            $a->execute();
        }
    }

    public static function redirect($path) {
        Template::saveState();
        header('Location: '.Controller::url($path));
        exit();
    }

    public static function url($path) {
        $path = '/'.$path;
        $path = str_replace('//', '/', $path);
        $path = str_replace('//', '/', $path);
        if (Config::get('clean-urls')) {
            return Config::get('base-path').$path;
        } else {
            return '/'.Config::get('base-path').'?q='.$path;
        }
    }

    public static function getAction() {
        return Controller::$action;
    }

    public static function page($page) {
        Template::body($page);
        Template::execute();
    }

}
