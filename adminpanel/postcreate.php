<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../src/core/autoload.php';

use src\models\post;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $subheader = $_POST['subheader'];
    $slug = $_POST['slug'];
    $previewimage = $_POST['previewimage'];
    $content = $_POST['content'];
    $tags = $_POST['tags'];

    $postModel = new post();
    if ($postModel->createpost($title, $subheader, $slug, $previewimage, $content, $tags)) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Failed to create post!";
    }
}

include __DIR__ . '/../src/adminviews/adminheader.php';
?>

<section class="content-section">
    <h1>Create New Post</h1>
    <form method="POST">
        <label>Title: <br><input type="text" name="title" required></label><br>
        <label>Subheader: <br><input type="text" name="subheader"></label><br>
        <label>Slug: <br><input type="text" name="slug" required></label><br>
        <label>Preview Image URL (only filename needed, if put in img folder): <br><input type="text" name="previewimage"></label><br>
        <label>Tags: <br><input type="text" name="tags"></label><br>
        <label>Content:<br> <textarea name="content" required></textarea></label><br>
        <button type="submit">Create Post</button>
    </form>
</section>

<?php include __DIR__ . '/../src/adminviews/adminfooter.php'; ?>
