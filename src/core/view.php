<?php

namespace src\core;

class view
{
    public static function render(string $view, array $data = [])
    {
        $viewPath = __DIR__ . '/../views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            die("View not found: $viewPath");
        }

        // Extract variables for use in the view
        extract($data);

        include __DIR__ . '/../views/header.php';
        include $viewPath;
        include __DIR__ . '/../views/footer.php';
    }
}