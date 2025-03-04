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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $subheader = $_POST['subheader'];
    $slug = $_POST['slug'];
    $previewimage = $_POST['previewimage'];
    $content = $_POST['content'];
    $tags = $_POST['tags'];

    if ($postmodel->updatepost($id, $title, $subheader, $slug, $previewimage, $content, $tags)) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Failed to update post!";
    }
}

$content = !empty($post['autosavecontent']) ? $post['autosavecontent'] : $post['content'];
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
        <label>Content:<br> <textarea id="contentfield" name="content" required><?= htmlspecialchars($post['content']) ?></textarea></label><br>
        <label>
        Publish: 
        <input type="checkbox" name="published" value="1" <?= $post['published'] ? 'checked' : '' ?>>
        </label><br>        
        <button type="submit">Update Post</button>
    </form>
    <p id="autosavestatus">Autosave Status: Not saved</p>
</section>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const contentfield = document.getElementById("contentfield");
    let postid = <?= (int)$id ?>;

    function autosave() {
        let content = contentfield.value;

        if (content)
        {
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
    }

    setInterval(autosave, 5000); // Auto-save every 5 seconds
});
</script>


<?php include __DIR__ . '/../src/adminviews/adminfooter.php'; ?>