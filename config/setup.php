<?php
include "database.php";
$pdo = new PDO($dsn, $db_user, $db_pass, $opt);

$users_tab = "CREATE TABLE IF NOT EXISTS users(
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
nickname VARCHAR(30) NOT NULL,
password VARCHAR(4096) NOT NULL,
email VARCHAR(255) NOT NULL
)";

$article_tab = "CREATE TABLE IF NOT EXISTS articles(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_user INT UNSIGNED NOT NULL,
    photo VARCHAR(50) NOT NULL,
    description VARCHAR(250) NOT NULL,
    publication_date DATE NOT NULL,
    likes INT UNSIGNED NOT NULL
)";

$comments_tab = "CREATE TABLE IF NOT EXISTS comments(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_user INT UNSIGNED NOT NULL,
    id_post INT UNSIGNED NOT NULL,
    comment_date DATE NOT NULL,
    content VARCHAR(250) NOT NULL
)";
$pdo->exec($users_tab);
$pdo->exec($article_tab);
$pdo->exec($comments_tab);
$pdo = null;