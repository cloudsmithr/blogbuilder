<section class="content-section">
  <h1> <?= htmlspecialchars($post['header']) ?></h1>
  <h2> <?= htmlspecialchars($post['subheader']) ?></h2>
  <img src="./img/<?= htmlspecialchars($post['previewimage']) ?>" alt="Preview Image" class="post-image">
  <p> <?= $post['content'] ?></p>
  <small>Published on: <?= date('Y-m-d H:i:s', $post['createdat']) ?></small><br>
  <small>Updated on: <?= date('Y-m-d H:i:s', $post['updatedat']) ?></small>
  <a href="/blog">Back to Blog</a>
</section>