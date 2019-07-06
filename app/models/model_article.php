<?php
class Model_Article extends Model
{
	private $sql_get_post = "SELECT articles.id as aid, users.id as uid, users.nickname, articles.`likes` , articles.description 
                FROM articles, users 
                WHERE articles.id = :aid AND users.id = articles.id_user
                ORDER BY articles.publication_date DESC";
	public function get_data($aid)
	{
		include "config/database.php";
		try
		{
			$pdo = new PDO($dsn, $db_user, $db_pass, $opt);
			$pdo->exec("USE $db");
			$stmt = $pdo->prepare($this->sql_get_post);
			$stmt->execute(array('aid' => $aid));
			$data = $stmt->fetch();
			if ($data)
				return $data;
			else
				return Model::ARTICLE_NOT_FOUND;
		}
		catch (PDOException $ex)
		{
			return Model::DB_ERROR;
		}
	}
}