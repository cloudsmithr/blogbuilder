<?php
include_once("./src/config.php");

class DBMANAGER
{
    public static function get_db()
    {
        $db = CONFIG::init_db();

        // Create table if it doesn't exist
        $db->exec("CREATE TABLE IF NOT EXISTS articles (
            id TEXT PRIMARY KEY,
            header TEXT,
            subheader TEXT,
            previewimage TEXT,
            content TEXT,
            createdat INTEGER,
            updatedat INTEGER
        )");

        return $db;
    }
}


?>