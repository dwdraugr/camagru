<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Camagru</title>
    <link rel="stylesheet" href="/css/font.css">
    <link rel="stylesheet" href="/css/index.css">
</head>
<body>
<header>
    <img id="logo" src="/images/camera.svg">
    <span>Camagru</span>
    <nav>
        <a href="#feed"><div class="navi">Feed</div></a>
        <a href="#profile"><div class="navi">Profile</div></a>
        <a href="#add"><div class="navi">Add</div></a>
    </nav>
</header>
<br>
<main>
    <?php include 'app/views/'.$content_view; ?>
</main>
</body>
</html>