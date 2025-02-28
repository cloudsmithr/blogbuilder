<?php

spl_autoload_register(function ($class) {
    $baseDir = realpath(__DIR__ . '/../../') . '/'; // Correctly resolves absolute path

    // Convert namespace into a file path
    $file = $baseDir . str_replace('\\', '/', $class) . '.php';

    if (file_exists($file))
    {
        require_once $file;
    }
    else
    {
        die("Autoload Error: Class file not found: $file");
    }
});
