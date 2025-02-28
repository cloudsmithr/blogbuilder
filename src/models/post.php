<?php

namespace src\models;

use SQLite3;
use src\core\database

class post
{
    private SQLite3 $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAllPosts(): array
    {
        
    }
}