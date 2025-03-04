<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../src/core/autoload.php';

use src\models\post;

$postmodel = new post();
$id = $_GET['id'] ?? null;

if (!$id) {
    die("Invalid post ID");
}

$post = $postmodel->getpostbyid((int)$id, true);
if (!$post) {
    die("Post not found");
}

// Toggle the published status
$newStatus = $post['published'] ? 0 : 1;
$postmodel->updatepublishedstatus((int)$id, $newStatus);

header("Location: index.php");
exit;
