<?php
class Model_Main extends Model
{
	private static $sql_get_articles = "SELECT articles.id as aid, users.id as uid, users.nickname , articles.description 
                FROM articles, users 
                WHERE users.id = articles.id_user 
                ORDER BY articles.publication_date DESC LIMIT 5 OFFSET ?";
	private static $sql_get_profile = "SELECT articles.id as aid, users.id as uid, users.nickname , articles.description 
                FROM articles, users 
                WHERE users.id = articles.id_user AND articles.id_user = :uid
                ORDER BY articles.publication_date DESC LIMIT 5 OFFSET :page";
	private static $sql_get_likes = "SELECT COUNT(*) as likes FROM likes_table WHERE id_article = :aid";
	private static $sql_num_page = "SELECT COUNT(*) as num FROM articles WHERE id_user=?";

    public function get_feed()
    {
        include 'config/database.php';
        try
		{
			$pdo = new PDO($dsn, $db_user, $db_pass, $opt);
			$pdo->exec("USE $db");
			$stmt= $pdo->prepare(Model_Main::$sql_get_articles);
			if (!isset($_GET['page']) or $_GET['page'] < 2)
			{
				$stmt->execute(array(0));
				$_SERVER['first'] = true;
			}
			else
				$stmt->execute(array(($_GET['page'] - 1) * 5));
			$data = $stmt->fetchAll();
			if (count($data) < 5)
				$_SERVER['last'] = true;
			$stmt = $pdo->prepare(Model_Main::$sql_get_likes);
			for ($i = 0; $i < count($data); $i++)
			{
				$stmt->execute(array('aid' => $data[$i]['aid']));
				$likes = $stmt->fetch();
				$data[$i]['likes'] = $likes['likes'];
			}
			$_SERVER['type'] = 'feed';
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
			$stmt = $pdo->prepare(Model_Main::$sql_get_profile);
			if (!isset($_GET['page']) or $_GET['page'] < 2)
			{
				$stmt->execute(array('uid' => $id, 'page' => 0));
				$_SERVER['first'] = true;
			}
			else
				$stmt->execute(array('uid' => $id, 'page' => ($_GET['page'] - 1) * 5));
			$data = $stmt->fetchAll();
			$num = count($data);
			if ($num < 5)
				$_SERVER['last'] = true;
			if ($num === 0)
				return Model::EMPTY_PROFILE;
			$stmt = $pdo->prepare(self::$sql_num_page);
			$stmt->execute(array($id));
			$num = $stmt->fetch();
			if ($num['num'] == 5)
				$_SERVER['last'] = true;

			$stmt = $pdo->prepare(Model_Main::$sql_get_likes);
			for ($i = 0; $i < count($data); $i++)
			{
				$stmt->execute(array('aid' => $data[$i]['aid']));
				$likes = $stmt->fetch();
				$data[$i]['likes'] = $likes['likes'];
			}
			$_SERVER['type'] = 'profile';
			return $data;
		}
		catch (PDOException $ex)
		{
			return Model::DB_ERROR;
		}
    }
}