<?php
class Model_Settings extends Model
{
	private static $sql_update_send_email = "UPDATE users SET send_email = ? WHERE id = ?";
	private static $sql_search_nickname = "SELECT nickname FROM users WHERE nickname = :nickname";
	private static $sql_update_nickname = "UPDATE users SET nickname=:nickname WHERE id=:uid";

	public function sending_mail()
	{
		if (($result = $this->_auth()) !== Model::SUCCESS)
			return $result;
		include "config/database.php";
		try
		{

			$pdo = new PDO($dsn, $db_user, $db_pass, $opt);
			$pdo->exec("USE $db");
			$stmt = $pdo->prepare(Model_Settings::$sql_update_send_email);
			if ($_POST['send_email'] === "Enable")
				$stmt->execute(array(1, $_SESSION['uid']));
			else
				$stmt->execute(array(0, $_SESSION['uid']));
			return Model::SUCCESS;
		}
		catch (PDOException $ex)
		{
			return Model::DB_ERROR;
		}
	}

	public function change_nickname()
	{
		if (($result = $this->_auth()) !== Model::SUCCESS)
			return $result;
		include "config/database.php";
		try
		{
			$pdo = new PDO($dsn, $db_user, $db_pass, $opt);
			$pdo->exec("USE $db");
			$stmt = $pdo->prepare(Model_Settings::$sql_search_nickname);
			$stmt->execute(array('nickname' => $_POST['new_nick']));
			$data = $stmt->fetch();
			if ($data)
				return Model::USER_EXIST;
			$stmt = $pdo->prepare(Model_Settings::$sql_update_nickname);
			$stmt->execute(array(
				'nickname' => $_POST['new_nick'],
				'uid' => $_SESSION['uid']
			));
			$_SESSION['nickname'] = $_POST['new_nick'];
			return Model::SUCCESS;
		}
		catch (PDOException $ex)
		{
			return Model::DB_ERROR;
		}
	}
}