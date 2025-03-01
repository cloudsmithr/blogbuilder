<?php
require_once __DIR__ . '/../src/core/autoload.php'; // auto-loads classes

use src\controllers\maincontroller;
use src\controllers\blogcontroller;

// Normalize request URI
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// Remove trailing slash if present
$uri = rtrim($uri, '/');

$controller = new maincontroller();
$blogcontroller = new blogcontroller();

switch ($uri)
{
    case '':
        $controller->index();
        break;
    case 'home':
        $controller->index();
        break;
    case 'about':
        $controller->about();
        break;
    case 'blog':
        $blogcontroller->index();
        break;
    case preg_match('/^blog\/(.+)$/', $uri, $matches) ? true : false:
        $blogcontroller->show($matches[1]);
        break;
    default:
        http_response_code(404);
        echo "404 - Not found";
}

