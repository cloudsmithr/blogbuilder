<section class='content-section blog-section'>
    <h1>Blog</h1>
    <?php foreach ($posts as $post): ?>
        <a href="<?= $baseurl ?>/blog/<?= htmlspecialchars($post['slug']) ?>">
            <div class="post-item">
                <div class="article-item">

                    <?php if(htmlspecialchars($post['previewimage'])) { ?>
                        <img src="<?= $baseurl ?>/img/<?= htmlspecialchars($post['previewimage']) ?>" alt="Preview Image" class="preview-image">
                    <?php } ?>
                    
                    <div class="article-content">
                        <h2> <?= htmlspecialchars($post['title']) ?></h2>
                        <h3> <?= htmlspecialchars($post['subheader']) ?></h3>
                        <p> <?= substr(htmlspecialchars($post['content']), 0, 92) ?>...</p>
                        <small>Published on: <?= date('M d, Y', $post['createdat']) ?></small><br>
                        <small>Updated on: <?= date('M d, Y', $post['updatedat']) ?></small>
                    </div>
                </div>
            </div>
        </a>
    <?php endforeach; ?>
</section>