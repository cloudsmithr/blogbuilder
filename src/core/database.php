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
            $dbPath = $config['db']['path'];

            // Create or open the SQLite database
            self::$instance = new SQLite3($dbPath);

            // Ensure tables exist
            self::initializedatabase(self::$instance);
            
        }
        return self::$instance;
    }

    private static function initializeDatabase(SQLite3 $db)
    {
        $db->exec("
            CREATE TABLE IF NOT EXISTS posts (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                subheader Text,
                slug TEXT UNIQUE NOT NULL,
                previewimage TEXT,
                content TEXT NOT NULL,
                autosavecontent TEXT,
                tags TEXT,
                published INTEGER NOT NULL DEFAULT 0,
                createdat INTEGER NOT NULL,
                updatedat INTEGER NOT NULL
            )
        ");
    }
}