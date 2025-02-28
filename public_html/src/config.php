<?php

class CONFIG
{
    public static function init_db()
    {
        $dbPath = __DIR__ . "/../data/articles.db";
        $dbDir = dirname($dbPath);
        
        if (!is_dir($dbDir)) {
            mkdir($dbDir, 0755, true);
        }

        $db = new SQLite3($dbPath);
        chmod($dbPath, 0660);

        return $db;
    }
}