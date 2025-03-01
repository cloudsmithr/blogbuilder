<?php
require_once __DIR__ . '/../src/core/autoload.php';

use src\models\post;

$postModel = new post();
$id = $_GET['id'] ?? null;

if (!$id) {
    die("Invalid post ID");
}

$post = $postModel->getpostbyid((int)$id);

if (!$post) {
    die("Post not found");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $subheader = $_POST['subheader'];
    $slug = $_POST['slug'];
    $previewimage = $_POST['previewimage'];
    $content = $_POST['content'];
    $tags = $_POST['tags'];

    if ($postModel->updatepost($id, $title, $subheader, $slug, $previewimage, $content, $tags)) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Failed to update post!";
    }
}

include __DIR__ . '/../src/adminviews/adminheader.php';
?>

<section class="content-section">

    <h1>Edit Post</h1>
    <form method="POST">
        <label>Title: <br><input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required></label><br>
        <label>Subheader: <br><input type="text" name="subheader" value="<?= htmlspecialchars($post['subheader']) ?>"></label><br>
        <label>Slug: <br><input type="text" name="slug" value="<?= htmlspecialchars($post['slug']) ?>" required></label><br>
        <label>Preview Image URL (only filename needed, if put in img folder): <br><input type="text" name="previewimage" value="<?= htmlspecialchars($post['previewimage']) ?>"></label><br>
        <label>Tags: <br><input type="text" name="tags" value="<?= htmlspecialchars($post['tags']) ?>"></label><br>
        <label>Content:<br> <textarea name="content" required><?= htmlspecialchars($post['content']) ?></textarea></label><br>
        <button type="submit">Update Post</button>
    </form>

</section>
<?php include __DIR__ . '/../src/adminviews/adminfooter.php'; ?>