<?php
include "database.php";
$pdo = new PDO($dsn, $db_user, $db_pass, $opt);
$pdo->exec("CREATE DATABASE IF NOT EXISTS $db CHARACTER SET utf8 COLLATE utf8_general_ci");
$pdo->exec("USE $db");

$users_tab = "CREATE TABLE IF NOT EXISTS users(
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
nickname VARCHAR(30) NOT NULL,
password VARCHAR(4096) NOT NULL,
email VARCHAR(255) NOT NULL,
confirmed BOOL NOT NULL DEFAULT 0
)";

$article_tab = "CREATE TABLE IF NOT EXISTS articles(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_user INT UNSIGNED NOT NULL,
    description VARCHAR(250) NOT NULL,
    publication_date DATETIME NOT NULL,
    likes INT UNSIGNED NOT NULL
)";

$comments_tab = "CREATE TABLE IF NOT EXISTS comments(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_user INT UNSIGNED NOT NULL,
    id_post INT UNSIGNED NOT NULL,
    comment_date DATETIME NOT NULL,
    content VARCHAR(250) NOT NULL
)";

$change_tab = "CREATE TABLE IF NOT EXISTS change_table(
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_user INT UNSIGNED NOT NULL,
    reason INT UNSIGNED NOT NULL,
    sid VARCHAR(150) NOT NULL
)";

$likes_tab = "CREATE TABLE IF NOT EXISTS likes_table(
	id_article INT UNSIGNED NOT NULL,
	id_user INT UNSIGNED NOT NULL
)";
$pdo->exec($users_tab);
$pdo->exec($article_tab);
$pdo->exec($comments_tab);
$pdo->exec($change_tab);
$pdo->exec($likes_tab);
$data = $pdo->query('SELECT articles.id as aid, users.id as uid, users.nickname, articles.`likes` , articles.description FROM articles, users WHERE users.id = articles.id_user ORDER BY articles.publication_date ASC ');
foreach ($data as $datum) {
    echo "<br>";
    var_dump($datum);
}
$pdo = null;