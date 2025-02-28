<?php

namespace src\core;

use SQLite3;

class database
{
    private static ?SQLite3 $instance = null;

    public static function getInstance(): SQLite3
    {
        if (self::$instance === null) {
            $config = require __DIR__ . '/../config/config.php';
            self::$instance = new SQLite3($config['db']['path']);
        }
        return self::$instance;
    }
}