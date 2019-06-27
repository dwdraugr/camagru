<?php
class Model_Main extends Model
{
    public function get_data($param = null)
    {
        include 'config/database.php';
        $pdo = new PDO($dsn, $db_user, $db_pass, $opt);
        $pdo->exec("USE $db");
        $data = $pdo->query('SELECT articles.id as aid, users.id as uid, users.nickname, articles.`likes` , articles.description FROM articles, users WHERE users.id = articles.id_user ORDER BY articles.publication_date, articles.publication_time ASC ');
        return $data;
    }
}