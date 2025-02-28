<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../src/core/autoload.php'; // auto-loads classes

use src\controllers\maincontroller;

// Normalize request URI
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// Remove trailing slash if present
$uri = rtrim($uri, '/');

$controller = new maincontroller();

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
    default:
        http_response_code(404);
        echo "404 - Not found";
}

