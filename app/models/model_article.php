<?php
class Model_Article extends Model
{
	private $sql_get_post = "SELECT articles.id as aid, users.id as uid, users.nickname, articles.`likes`, articles.description 
                FROM articles, users, comments
                WHERE articles.id = :aid AND users.id = articles.id_user
                ORDER BY articles.publication_date DESC";
	private $sql_get_comment = "SELECT comments.id as cid, users.id as uid, users.nickname as nickname, content
								FROM comments, users
								WHERE id_post = :aid AND users.id = comments.id_user ORDER BY comment_date ASC";
	private $sql_put_comment = "INSERT INTO comments VALUES (NULL, :uid, :aid, NOW(), :content)";

	public function get_data($aid)
	{
		include "config/database.php";
		try
		{
			$pdo = new PDO($dsn, $db_user, $db_pass, $opt);
			$pdo->exec("USE $db");
			$stmt = $pdo->prepare($this->sql_get_post);
			$stmt->execute(array('aid' => $aid));
			$data[] = $stmt->fetch();
			if (!$data)
				return Model::ARTICLE_NOT_FOUND;
			$stmt = $pdo->prepare($this->sql_get_comment);
			$stmt->execute(array('aid' => $aid));
			$data[] = $stmt->fetchAll();
			return $data;
		}
		catch (PDOException $ex)
		{
			return Model::DB_ERROR;
		}
	}

	public function put_comment($aid)
	{
		$result = $this->_auth();
		if ( $result !== Model::SUCCESS)
			return $result;
		if (!isset($_POST['comment']) or mb_strlen($_POST['comment']) === 0)
			return Model::INCOMPLETE_DATA;
		include "config/database.php";
		try
		{
			$pdo = new PDO($dsn, $db_user, $db_pass, $opt);
			$pdo->exec("USE $db");
			$stmt = $pdo->prepare($this->sql_put_comment);
			$stmt->execute(array(
				'uid' => $_SESSION['uid'],
				'aid' => $aid,
				'content' => $_POST['comment']
			));
			return Model::SUCCESS;
		}
		catch (PDOException $ex)
		{
			return Model::DB_ERROR;
		}
	}
}