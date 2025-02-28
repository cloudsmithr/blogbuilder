<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once("./src/postobj.php");
include_once("./src/.php");

echo "beginning scan<br>";

$dir = 'articles';
$db = CONFIG::get_db();

date_default_timezone_set('UTC');

// Scan the directory, we only want files and directories
$files = array_diff(scandir($dir), array('.', '..'));
// Track the files we have so we can see which rows don't have file matches later
$currentFiles = [];

foreach ($files as $file)
{
    $post = PostObj::buildfromfile($db, $file, $dir);
    if ($post)
    {
        $post->save();
    }
}

echo "Scan complete.";


// Delete entries from DB that no longer have corresponding files
/*$result = $db->query("SELECT id FROM articles");

while ($row = $result->fetchArray(SQLITE3_ASSOC))
{
    $id = $row['id'];
    if (!in_array($id, $currentFiles))
    {
        $db->exec("DELETE FROM articles WHERE id = '$id'");
        echo "Deleted: $id (no corresponding file)<br>";
    }
}*/

?>
