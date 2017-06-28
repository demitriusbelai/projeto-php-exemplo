<?php

$handle = opendir('lib');
while (false !== ($file = readdir($handle))) {
    if (preg_match('/.*\.php$/', $file)) {
        include_once 'lib/'.$file;
    }
}

$handle = opendir('model');
while (false !== ($file = readdir($handle))) {
    if (preg_match('/.*\.php$/', $file)) {
        include_once 'model/'.$file;
    }
}

$handle = opendir('action');
while (false !== ($file = readdir($handle))) {
    if (preg_match('/.*\.php$/', $file)) {
        include_once 'action/'.$file;
    }
}

Config::init(__DIR__);
Database::init();

if (array_key_exists('q', $_GET)) {
    $q = $_GET['q'];
} else {
    $q = '/';
}

Controller::execute($q);
