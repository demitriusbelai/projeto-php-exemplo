<?php

class Config {
    private static $config;
    static function init($dir_root) {
        Config::$config['root-dir'] = $dir_root;
        include 'config/config.php';
        foreach ($config as $key => $value) {
            Config::$config[$key] = $value;
        }
    }
    static function get($conf) {
        return Config::$config[$conf];
    }
}
