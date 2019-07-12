<?php
class Model_Settings extends Model
{
	private static $sql_update_send_email = "UPDATE users SET send_email = ? WHERE id = ?";
	private static $sql_search_nickname = "SELECT nickname FROM users WHERE nickname = :nickname";
	private static $sql_update_nickname = "UPDATE users SET nickname=:nickname WHERE id=:uid";
	private static $sql_search_email = "SELECT email FROM users WHERE email = :email";
	private static $sql_update_email = "UPDATE users SET email=:email WHERE id=:uid";
	private static $sql_update_password = "UPDATE users SET password=:password WHERE id=:uid";

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

	public function change_email()
	{
		if (($result = $this->_auth()) !== Model::SUCCESS)
			return $result;
		include "config/database.php";
		try
		{
			$pdo = new PDO($dsn, $db_user, $db_pass, $opt);
			$pdo->exec("USE $db");
			$stmt = $pdo->prepare(Model_Settings::$sql_search_email);
			$stmt->execute(array('email' => $_POST['new_email']));
			$data = $stmt->fetch();
			if ($data)
				return Model::USER_EXIST;
			$stmt = $pdo->prepare(Model_Settings::$sql_update_email);
			$stmt->execute(array(
				'email' => $_POST['new_email'],
				'uid' => $_SESSION['uid']
			));
			return Model::SUCCESS;
		}
		catch (PDOException $ex)
		{
			return Model::DB_ERROR;
		}
	}

	public function change_password()
	{
		if (($result = $this->_auth()) !== Model::SUCCESS)
			return $result;
		if ($_SESSION['password'] != hash('whirlpool', $_POST['old_password']))
			return Model::INCORRECT_NICK_PASS;
		if ($_POST['confirm_password'] != $_POST['new_password'])
			return FALSE;
		if ($_POST['new_password'] === strtolower($_POST['new_password']) or strlen($_POST['new_password']) < 6)
			return Model::WEAK_PASSWORD;
		include "config/database.php";
		try
		{
			$pdo = new PDO($dsn, $db_user, $db_pass, $opt);
			$pdo->exec("USE $db");
			$stmt = $pdo->prepare(Model_Settings::$sql_update_password);
			$stmt->execute(array(
				'password' => hash('whirlpool', $_POST['new_password']),
				'uid' => $_SESSION['uid']
			));
			return Model::SUCCESS;
		}
		catch (PDOException $ex)
		{
			return Model::DB_ERROR;
		}
	}
}