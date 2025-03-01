<?php
// Get the protocol (http or https)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
// Get the current host (e.g., localhost, admin.local, rsmith.local)
$host = $_SERVER['HTTP_HOST'];
// Get the directory where this script is running
$scriptdir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
// Ensure the base URL does not include '/views'
$baseurl = rtrim($scriptdir, '/views');
// Full base URL
$baseurl = "{$protocol}://{$host}{$baseurl}";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ryan A. Smith | Fullstack Software Engineer</title>
    <link rel="stylesheet" href="<?= $baseurl; ?>/css/style.css">
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.setAttribute('data-theme', 'dark');
        }
    </script>    
</head>
<body>
    <header class="header">
        <div class="container">
            <a href="<?= $baseurl; ?>">
                <div class="logo">
                    <img src="<?= $baseurl; ?>/img/logo.png" alt="Logo">
                    <span>rsmith.cloud</span>
                </div>
            </a>
            <div class="menu">
                <a href="/">Home</a>
                <a href="/about">About</a>
                <a href="/blog">Blog</a>
            </div>
        </div>
    </header>
    <button id="theme-toggle" class="theme-toggle">
        <span class="toggle-icon">🌞</span>
    </button>    
    <section class="highlight">
            <h3>Building Scalable Solutions with .NET, Microservices, and Domain-Driven Design</h3>
    </section>
    <div class="content">
       