<?php

// We're saving text, not HTML, so we gotta do some formatting.
// This also helps keep things like image URLS dynamic. If we 
// Wanna move the image folder later we'll only have to change
// It here, not edit all the blog posts.
function formatContent(string $content, string $baseurl)
{
  $content = nl2br($content);
  $content = preg_replace_callback('/\[img:(.*?)\]/',
    function ($matches) use ($baseurl)
    {
      $imageFile = htmlspecialchars($matches[1]); // Extract filename safely
      return "<img src='$baseurl/img/$imageFile' alt='$imageFile'>";
    }, $content);

  return $content;
}
?>

<section class="content-section">
  <h1> <?= htmlspecialchars($post['title']) ?></h1>
  <h2> <?= htmlspecialchars($post['subheader']) ?></h2>
  <small>Published on: <?= date('M d, Y', $post['createdat']) ?></small><br>
  <small>Updated on: <?= date('M d, Y', $post['updatedat']) ?></small>
  <img src="<?= $baseurl ?>/img/<?= htmlspecialchars($post['previewimage']) ?>" alt="Preview Image" class="previewimage">
  <p> <?= formatContent(htmlspecialchars($post['content']), $baseurl) ?></p>
</section>



