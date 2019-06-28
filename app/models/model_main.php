<?php
class Model_Main extends Model
{
    public function get_feed()
    {
        include 'config/database.php';
        $pdo = new PDO($dsn, $db_user, $db_pass, $opt);
        $pdo->exec("USE $db");
        $src = 'SELECT articles.id as aid, users.id as uid, users.nickname, articles.`likes` , articles.description 
                FROM articles, users 
                WHERE users.id = articles.id_user 
                ORDER BY articles.publication_date DESC ';
        $data = $pdo->query($src);
        return $data;
    }

    public function get_profile()
    {
        $uid = $_SESSION['uid'];
        include 'config/database.php';
        $pdo = new PDO($dsn, $db_user, $db_pass, $opt);
        $pdo->exec("USE $db");
        $src = "SELECT articles.id as aid, users.id as uid, users.nickname, articles.`likes` , articles.description 
                FROM articles, users 
                WHERE users.id = articles.id_user AND articles.id_user = $uid
                ORDER BY articles.publication_date DESC ";
        $data = $pdo->query($src);
        return $data;
    }
}