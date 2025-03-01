<?php
require_once __DIR__ . '/../src/core/autoload.php';

use src\models\post;

$id = $_GET['id'] ?? null;
if (!$id) {
    die("Invalid post ID");
}

$postModel = new post();
if ($postModel->deletepost((int)$id)) {
    header("Location: index.php");
    exit;
} else {
    die("Failed to delete post");
}
