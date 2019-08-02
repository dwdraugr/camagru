<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Camagru</title>
    <link rel="stylesheet" href="/css/font.css">
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/auth.css">
    <link rel="stylesheet" href="/css/add.css">
    <link rel="icon" href="/images/icon.ico" type="image/x-icon">
</head>
<body>
<header>
    <img id="logo" src="/images/camera.svg">
    <span>Camagru</span>
    <nav>
        <a href="/main/feed"><div class="navi">Feed</div></a>
        <?php
        if (!isset($_SESSION['nickname']) and !isset($_SESSION['password']))
            {
                echo "<a href='/auth'><div class='navi'>Sign In</div></a>";
                echo "<a href='/signup'><div class='navi'>Sign Up</div></a>";
            }
        else {
			echo "<a href='/add'><div class='navi'>Add</div></a>";
            echo "<a href='/main/profile/{$_SESSION['uid']}'><div id='user' class='navi'>{$_SESSION['nickname']}</div></a>";
            echo "<a href='/settings'><div class='navi'>Settings</div></a>";
            echo "<a href='/auth/signout'><div class='navi'>Sign Out</div></a>";
        }
        ?>
<!--    </nav>-->
</header>
<br>
<main>
    <?php include 'app/views/'.$content_view; ?>
</main>
</body>
</html>