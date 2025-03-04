<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../src/core/autoload.php';

use src\models\post;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $postmodel = new post();
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $autosavecontent = $_POST['content'] ?? '';

    if (empty($autosavecontent)) {
        http_response_code(400);
        die("Invalid request: Content is empty");
    }

    // Check if the post exists
    $post = $id ? $postmodel->getpostbyid($id, true) : null;

    if (!$post) {
        // Post doesn't exist, create a temporary draft entry
        $id = $postmodel->createpost("Untitled", "", "temp-" . time(), "", $autosavecontent, "", 0);
        if (!$id) {
            http_response_code(500);
            die("Failed to create draft post");
        }
    }

    // Save autosave content (DO NOT overwrite main content)
    if ($postmodel->autosavecontent($id, $autosavecontent)) {
        echo json_encode(["status" => "success", "id" => $id, "message" => "Autosaved at " . date("H:i:s")]);
    } else {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Autosave failed"]);
    }
}
