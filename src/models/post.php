<?php

namespace src\models;

use SQLite3;
use src\core\database;

class post
{
    private SQLite3 $db;

    public function __construct()
    {
        $this->db = database::getInstance();
    }

    public function getallposts(): array
    {
        $result = $this->db->query("SELECT * FROM posts ORDER BY created_at DESC");
        $posts = [];

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $posts[] = $row;
        }

        return $posts;
    }

    public function getpostbyslug(string $slug): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE slug = :slug LIMIT 1");
        $stmt->bindValue(':slug', $slug, SQLITE3_TEXT);
        $result = $stmt->execute();

        return $result->fetchArray(SQLITE3_ASSOC) ?: null;
    }

    public function getpostbyid(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE id = :id LIMIT 1");
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        $result = $stmt->execute();

        return $result->fetchArray(SQLITE3_ASSOC) ?: null;
    }

    public function createpost(string $title, string $subheader, string $slug, string $previewimage, string $content, string $tags): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO posts (title, subheader, slug, previewimage, content, tags, created_at, updated_at)
            VALUES (:title, :subheader, :slug, :previewimage, :content, :tags, :created_at, :updated_at)
        ");

        $stmt->bindValue(':title', $title, SQLITE3_TEXT);
        $stmt->bindValue(':subheader', $subheader, SQLITE3_TEXT);
        $stmt->bindValue(':slug', $slug, SQLITE3_TEXT);
        $stmt->bindValue(':previewimage', $previewimage, SQLITE3_TEXT);
        $stmt->bindValue(':content', $content, SQLITE3_TEXT);
        $stmt->bindValue(':tags', $tags, SQLITE3_TEXT);
        $stmt->bindValue(':created_at', time(), SQLITE3_INTEGER);
        $stmt->bindValue(':updated_at', time(), SQLITE3_INTEGER);

        return $stmt->execute() !== false;
    }

    public function updatepost(int $id, string $title, string $subheader, string $slug, string $previewimage, string $content, string $tags): bool
    {
        $stmt = $this->db->prepare("
            UPDATE posts
            SET title = :title, subheader = :subheader, slug = :slug, previewimage = :previewimage, content = :content, tags = :tags, updated_at = :updated_at
            WHERE id = :id
        ");

        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        $stmt->bindValue(':title', $title, SQLITE3_TEXT);
        $stmt->bindValue(':subheader', $subheader, SQLITE3_TEXT);
        $stmt->bindValue(':slug', $slug, SQLITE3_TEXT);
        $stmt->bindValue(':previewimage', $previewimage, SQLITE3_TEXT);
        $stmt->bindValue(':content', $content, SQLITE3_TEXT);
        $stmt->bindValue(':tags', $tags, SQLITE3_TEXT);
        $stmt->bindValue(':updated_at', time(), SQLITE3_INTEGER);

        return $stmt->execute() !== false;
    }

    public function deletepost(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM posts WHERE id = :id");
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);

        return $stmt->execute() !== false;
    }
}