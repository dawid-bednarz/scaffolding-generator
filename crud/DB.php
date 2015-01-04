<?php

namespace daweb\crud;

/**
 * service PDO object
 *
 * @author daweb
 */
class DB {

    public static $pdo;


    public static function initConnection(array $settings) {

        if (empty(self::$pdo)) {
            self::$pdo = new \PDO($settings['dsn'], $settings['username'], $settings['password']);
        }
    }

}
