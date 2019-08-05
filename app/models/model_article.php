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
	private $sql_send_email = "SELECT email, send_email FROM users INNER JOIN articles
								ON users.id = articles.id_user AND articles.id = :aid";
	private static $sql_get_likes = "SELECT COUNT(*) as likes FROM likes_table WHERE id_article = :aid";
	private static $sql_del_post = "DELETE FROM articles WHERE id = :aid AND id_user = :uid";
	private static $sql_del_comment = "DELETE FROM comments WHERE id = :cid AND id_user = :uid";


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
			if (!$data[0])
				return Model::ARTICLE_NOT_FOUND;
			$stmt = $pdo->prepare($this->sql_get_comment);
			$stmt->execute(array('aid' => $aid));
			$data[] = $stmt->fetchAll();
			$stmt = $pdo->prepare(Model_Article::$sql_get_likes);
			$stmt->execute(array('aid' => $data[0]['aid']));
			$likes = $stmt->fetch();
			$data[0]['likes'] = $likes['likes'];
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
			$stmt = $pdo->prepare($this->sql_send_email);
			$stmt->execute(array('aid' => $aid));
			$data = $stmt->fetch();
			$this->_send_mail($data['email'], $_SESSION['nickname'], $aid, $data['send_email']);
			return Model::SUCCESS;
		}
		catch (PDOException $ex)
		{
			return Model::DB_ERROR;
		}
	}

	private function _send_mail($email, $nickname, $aid, $confirmed)
	{
		include 'config/database.php';
		if ($confirmed === 0)
			return;
		$subject = "You have comments, sweetie";
		$main = "Hello, $nickname! Under your post left a comment! Rather check it out! http://".
			$email_host."/article/index/".$aid;
		$main = wordwrap($main, 65, "\r\n");
		$headers = 'From: kostya.marinenkov@gmail.com'."\r\n".
			"Reply-To: kostya.marinenkov@gmail.com"."\r\n".
			"X-Mailer: PHP/".phpversion();
		mail($email, $subject, $main, $headers);
	}

	public function delete_post($aid)
	{
		$result = $this->_auth();
		if ( $result !== Model::SUCCESS)
			return $result;
		include "config/database.php";
		try
		{
			$pdo = new PDO($dsn, $db_user, $db_pass, $opt);
			$pdo->exec("USE $db");
			$stmt = $pdo->prepare(self::$sql_del_post);
			$stmt->execute(array('aid' => $aid, 'uid' => $_SESSION['uid']));
			if (!$stmt->rowCount())
				return Model::ARTICLE_NOT_FOUND;
			return Model::SUCCESS;
		}
		catch (PDOException $ex)
		{
			return Model::DB_ERROR;
		}
	}

	public function delete_comment($cid)
	{
		$result = $this->_auth();
		if ( $result !== Model::SUCCESS)
			return $result;
		if (!strstr($cid, ';'))
			return Model::ARTICLE_NOT_FOUND;
		$arr = explode(';', $cid);
		include "config/database.php";
		try
		{
			$pdo = new PDO($dsn, $db_user, $db_pass, $opt);
			$pdo->exec("USE $db");
			$stmt = $pdo->prepare(self::$sql_del_comment);
			$stmt->execute(array('cid' => $arr[0], 'uid' => $_SESSION['uid']));
			if (!$stmt->rowCount())
				return Model::ARTICLE_NOT_FOUND;
			return Model::SUCCESS;
		}
		catch (PDOException $ex)
		{
			return Model::DB_ERROR;
		}
	}
}