<?php
class Model_Main extends Model
{
	private static $sql_get_articles = "SELECT articles.id as aid, users.id as uid, users.nickname, users.password, articles.`likes` , articles.description 
                FROM articles, users 
                WHERE users.id = articles.id_user AND articles.id_user = :uid
                ORDER BY articles.publication_date DESC ";

	private static $sql_is_user = "SELECT * FROM users where id = :uid";

    public function get_feed()
    {
        include 'config/database.php';
        try
		{
			$pdo = new PDO($dsn, $db_user, $db_pass, $opt);
			$pdo->exec("USE $db");
			$src = 'SELECT articles.id as aid, users.id as uid, users.nickname, articles.`likes` , articles.description 
                FROM articles, users 
                WHERE users.id = articles.id_user 
                ORDER BY articles.publication_date DESC ';
			$data = $pdo->query($src);
			return $data;
		}
		catch (PDOException $ex)
		{
			return Model::DB_ERROR;
		}
    }

    public function get_profile($id)
    {
        include 'config/database.php';
        try
		{
			$pdo = new PDO($dsn, $db_user, $db_pass, $opt);
			$pdo->exec("USE $db");
			$stmt = $pdo->prepare(Model_Main::$sql_get_articles);
			$stmt->execute(array('uid' => $id));
			$data = $stmt->fetchAll();
			return $data;
		}
		catch (PDOException $ex)
		{
			return Model::DB_ERROR;
		}
    }
}