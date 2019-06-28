<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Camagru</title>
    <link rel="stylesheet" href="/css/font.css">
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/auth.css">
</head>
<body>
<header>
    <img id="logo" src="/images/camera.svg">
    <span>Camagru</span>
    <nav>
        <a href="/main/feed"><div class="navi">Feed</div></a>
        <a href="/main/profile"><div class="navi">Profile</div></a>
        <a href="#add"><div class="navi">Add</div></a>
        <?php
        if (!isset($_SESSION['nickname']) and !isset($_SESSION['password']))
            echo "<a href='/auth'><div class='navi'>Sign In</div></a>";
        else
            echo "<a href='/auth/signout'><div class='navi'>Sign Out</div></a>";
        ?>
    </nav>
</header>
<br>
<main>
    <?php include 'app/views/'.$content_view; ?>
</main>
</body>
</html>