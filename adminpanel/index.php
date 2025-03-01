<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../src/core/autoload.php';

use src\models\post;

$postModel = new post();
$posts = $postModel->getAllPosts();

include __DIR__ . '/../src/adminviews/adminheader.php';
?>
<section class="content-section">

    <h1>Admin Dashboard</h1>
    <div class="createbutton">
        <a href="postcreate.php">Create New Post</a>
    </div>
    <table border="1">
        <tr>
            <th>Title</th>
            <th>Subheader</th>
            <th>Content</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($posts as $post): ?>
            <tr>
                <td><?= htmlspecialchars($post['title']) ?></td>
                <td><?= htmlspecialchars($post['subheader']) ?></td>
                <td><?= htmlspecialchars($post['content']) ?></td>
                <td>
                    <a href="postedit.php?id=<?= $post['id'] ?>">Edit</a><br><br>
                    <a href="postdelete.php?id=<?= $post['id'] ?>" onclick="return confirm('Delete this post?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>
<?php include __DIR__ . '/../src/adminviews/adminfooter.php'; ?>
