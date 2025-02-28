<?php 

// This is the blog page.

include_once("./src/header.php");
?>

<?php
$db = new SQLite3('articles.db');

// Pagination settings
$limit = 5;  // Number of posts per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Get total number of posts
$totalQuery = $db->querySingle("SELECT COUNT(*) as count FROM articles");
$totalPages = ceil($totalQuery / $limit);

// Fetch posts for current page
$stmt = $db->prepare("SELECT * FROM articles ORDER BY updatedat DESC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $limit, SQLITE3_INTEGER);
$stmt->bindValue(':offset', $offset, SQLITE3_INTEGER);
$result = $stmt->execute();

// Display posts

echo "<section class='content-section blog-section'>";
echo "<h1>My Blog</h1>";
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    echo '<a href="./post.php?id=' . htmlspecialchars($row['id']) . '">';
    echo '<div class="post-item">';
    echo '<div class="article-item">';
    echo '<img src="./img/' . htmlspecialchars($row['previewimage']) . '" alt="Preview Image" class="preview-image">';
    echo '<div class="article-content">';
    echo '<h2>' . htmlspecialchars($row['header']) . '</h2>';
    echo '<h3>' . htmlspecialchars($row['subheader']) . '</h3>';
    echo '<p>' . htmlspecialchars(substr($row['content'], 0, 92)) . '...</p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</a>';
}
echo "</section>";

// Pagination controls
echo '<section class="pagination-section"><div class="pagination-holder">';

    // The previous buttons
    echo '<div class="prevBtns">';

    if ($page > 1) {
        echo '<a href="?page=1">First</a> ';
        echo '<a href="?page=' . ($page - 1) . '">Previous</a> ';
    }
    else{
        echo '<a disabled>First</a> ';
        echo '<a disabled>Previous</a> ';
    }

    echo '</div>';

    // The page number buttons

    echo '<div class="pageBtns">';
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $page) {
            echo '<strong><a disabled>' . $i . '</a></strong> ';
        } else {
            echo '<a href="?page=' . $i . '">' . $i . '</a> ';
        }
    }
    echo '</div>';

    // The next buttons

    echo '<div class="nextBtns">';

    if ($page < $totalPages) {
        echo '<a href="?page=' . ($page + 1) . '">Next</a> ';
        echo '<a href="?page=' . $totalPages . '">Last</a>';
    }
    else{
        echo '<a disabled>Next</a> ';
        echo '<a disabled>Last</a> ';
    }
    echo '</div>';

echo '</div></section">';
?>

<?php
include_once("./src/footer.php");
?>