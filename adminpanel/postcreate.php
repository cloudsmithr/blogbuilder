<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../src/core/autoload.php';

use src\models\post;

$postmodel = new post();
$id = $_GET['id'] ?? 0;
$post = null;

// If this is a new post, create a draft
if ($id == 0)
{
    $id = $postmodel->createpost("Untitled", "", "temp-" . time(), "", "", "", 0);
    if (!$id) {
        die("Failed to create draft post");
    }

    // Redirect to the new post URL so future autosaves use the correct ID
    header("Location: postcreate.php?id=$id");
    exit;
}
else
{
    $post = $postmodel->getpostbyid((int)$id, true);
    if (!$post) {
        die("Post not found");
    }
}

$content = !empty($post['autosavecontent']) ? $post['autosavecontent'] : $post['content'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $subheader = $_POST['subheader'];
    $slug = $_POST['slug'];
    $previewimage = $_POST['previewimage'];
    $content = $_POST['content'];
    $tags = $_POST['tags'];

    // ✅ Use autosaved content if available
    if (!empty($post['autosavecontent'])) {
        $content = $post['autosavecontent'];
    }

    // ✅ Update post with final content
    $postmodel->updatepost($id, $title, $subheader, $slug, $previewimage, $content, $tags, 0);

    // ✅ Clear autosavecontent
    $postmodel->clearautosavecontent($id);

    // ✅ Redirect to admin dashboard
    header("Location: index.php");
    exit;
}

include __DIR__ . '/../src/adminviews/adminheader.php';
?>

<section class="content-section">
    <h1>Create New Post</h1>
    <form method="POST" id="postform">
        <label>Title: <br><input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required></label><br>
        <label>Subheader: <br><input type="text" name="subheader" value="<?= htmlspecialchars($post['subheader']) ?>"></label><br>
        <label>Slug: <br><input type="text" name="slug" value="<?= htmlspecialchars($post['slug']) ?>" required></label><br>
        <label>Preview Image URL (only filename needed, if put in img folder): <br><input type="text" name="previewimage" value="<?= htmlspecialchars($post['previewimage']) ?>"></label><br>
        <label>Tags: <br><input type="text" name="tags" value="<?= htmlspecialchars($post['tags']) ?>"></label><br>
        <label>Content:<br> <textarea name="content" id="contentfield" required><?= htmlspecialchars($content) ?></textarea></label><br>
        <button type="submit" name="save">Create Post</button>
    </form>
    <p id="autosavestatus">Autosave Status: Not saved</p>    
</section>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const contentfield = document.getElementById("contentfield");
    let postid = <?= (int)$id ?>;

    function autosave() {
        let content = contentfield.value;

        fetch("postautosave.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "id=" + postid + "&content=" + encodeURIComponent(content)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                let localTime = new Date().toLocaleTimeString();
                document.getElementById("autosavestatus").innerText = "Autosaved at " + localTime;
            }
        })
        .catch(error => console.error("Autosave failed:", error));
    }

    setInterval(autosave, 5000); // Auto-save every 5 seconds
});
</script>

<?php include __DIR__ . '/../src/adminviews/adminfooter.php'; ?>
