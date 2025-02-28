<?php

// This is the header for every page.
include_once("./src/postobj.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ryan A. Smith | Fullstack Software Engineer</title>
    <link rel="stylesheet" href="./css/style.css">
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.setAttribute('data-theme', 'dark');
        }
    </script>    
</head>
<body>
    <header class="header">
        <div class="container">
            <a href="/">
                <div class="logo">
                    <img src="./img/logo.png" alt="Logo">
                    <span>rsmith.cloud</span>
                </div>
            </a>
            <div class="menu">
                <a href="./index.php">Home</a>
                <a href="./about.php">About</a>
                <a href="./blog.php">Blog</a>
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
       