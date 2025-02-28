<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

// This is the page for an individual post.
include_once("./src/header.php");

if (!isset($_GET['id']))
{
    echo "<p>Error: No post ID provided.</p>";
    exit;
}

$db = CONFIG::get_db();

$id = $_GET['id'];

$post = PostObj::load($db, $id);

if (!$post)
{
    echo "<p>Error: Post not found.</p>";
    exit;
}
?>

<section class="content-section">
  <h1><?= htmlspecialchars($post->header) ?></h1>
  <h2><?= htmlspecialchars($post->subheader) ?></h2>
  <img src="./img/<?= htmlspecialchars($post->previewimage) ?>" alt="Preview Image" class="post-image">
  <p><?= $post->content ?></p>
  <small>Published on: <?= date('Y-m-d H:i:s', $post->createdat) ?></small><br>
  <small>Updated on: <?= date('Y-m-d H:i:s', $post->updatedat) ?></small>
</section>

<?php
include_once("./src/footer.php");
?>