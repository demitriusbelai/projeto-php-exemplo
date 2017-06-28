<?php

class Util {
    public static function random_salt() {
        $salt_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
        $ret = '$6$';
        for ($i = 0; $i < 8; $i++) {
            $ret .= $salt_chars[rand(0, strlen($salt_chars) - 1)];
        }
        return $ret;
    }
}
