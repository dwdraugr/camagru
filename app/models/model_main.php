<?php
class Model_Main extends Model
{
	private static $sql_get_articles = "SELECT articles.id as aid, users.id as uid, users.nickname , articles.description 
                FROM articles, users 
                WHERE users.id = articles.id_user 
                ORDER BY articles.publication_date DESC ";
	private static $sql_get_likes = "SELECT COUNT(*) as likes FROM likes_table WHERE id_article = :aid";

    public function get_feed()
    {
        include 'config/database.php';
        try
		{
			$pdo = new PDO($dsn, $db_user, $db_pass, $opt);
			$pdo->exec("USE $db");
			$stmt= $pdo->prepare(Model_Main::$sql_get_articles);
			$stmt->execute();
			$data = $stmt->fetchAll();
			$stmt = $pdo->prepare(Model_Main::$sql_get_likes);
			for ($i = 0; $i < count($data); $i++)
			{
				$stmt->execute(array('aid' => $data[$i]['aid']));
				$likes = $stmt->fetch();
				$data[$i]['likes'] = $likes['likes'];
			}
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