<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Only For Cool Guys</title>
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
                    <span>admin.local</span>
                </div>
            </a>
        </div>
    </header>
    <button id="theme-toggle" class="theme-toggle">
        <span class="toggle-icon">🌞</span>
    </button>    
    <section class="highlight">
            <h3>Let's write some stuff!</h3>
    </section>
    <div class="content">
       