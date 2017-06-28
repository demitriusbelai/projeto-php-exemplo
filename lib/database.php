<?php

class Database {

    private static $dbh;

    public static function init() {
        try {
            $conf = Config::get('database');
            Database::$dbh = new PDO($conf['dsn'], $conf['user'], $conf['password']);
            Database::$dbh->query("SET NAMES 'utf8'");
            Database::$dbh->query("SET CHARACTER SET 'utf8'");
        } catch (PDOException $e) {
            echo 'Falha de conexão: ' . $e->getMessage();
            echo '<br/>';
            echo 'Necessário habilitar "extension=php_pdo_mysql.dll" no php.ini';
            exit();
        }
    }

    public static function get() {
        return Database::$dbh;
    }

}
