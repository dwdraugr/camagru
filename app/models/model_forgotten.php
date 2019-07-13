<?php
class Model_Forgotten extends Model
{
	private static $sql_check_email = 'SELECT * FROM users WHERE email=:email';
	private static $sql_add_to_change = "INSERT INTO `change_table` (`id`, `id_user`, `reason`, `sid`)
                    VALUES (NULL, :id, :reason, :sid)";
	private static $sql_check_sid = 'SELECT * FROM change_table WHERE sid=:sid and reason=:reason';
	private static $sql_update_password = 'UPDATE users SET password=:password WHERE id=:uid';
	private static $sql_remove = "DELETE FROM change_table WHERE sid=:sid";


	public function new_password($sid)
	{
		$data = $this->_check_sid($sid);
		$result = gettype($data);
		if ("array" != $result)
			return $data;
		if ($_POST['confirm_password'] != $_POST['new_password'])
			return FALSE;
		if ($_POST['new_password'] === strtolower($_POST['new_password']) or strlen($_POST['new_password']) < 6)
			return Model::WEAK_PASSWORD;
		$uid = $data['uid'];
		$password = hash('whirlpool', $_POST['new_password']);
		include "config/database.php";
		try
		{
			$pdo = new PDO($dsn, $db_user, $db_pass, $opt);
			$pdo->exec("USE $db");
			$stmt = $pdo->prepare(self::$sql_update_password);
			$stmt->execute(array('uid' => $uid, 'password' => $password));
			if ($this->_del_sid($sid) === Model::SUCCESS)
				return Model::SUCCESS;
			else
				return Model::DB_ERROR;
		}
		catch (PDOException $ex)
		{
			return Model::DB_ERROR;
		}
	}

	private function _del_sid($sid)
	{
		include "config/database.php";
		try
		{
			$pdo = new PDO($dsn, $db_user, $db_pass, $opt);
			$pdo->exec("USE $db");
			$stmt = $pdo->prepare(self::$sql_remove);
			$stmt->execute(array($sid));
			return Model::SUCCESS;
		}
		catch (PDOException $ex)
		{
			Model::SID_NOT_FOUND;
		}
	}

	private function _check_sid($sid)
	{
		include "config/database.php";
		try
		{
			$pdo = new PDO($dsn, $db_user, $db_pass, $opt);
			$pdo->exec("USE $db");
			$stmt = $pdo->prepare(self::$sql_check_sid);
			$arr = array('sid' => $sid, 'reason' => Model::REASON_FORGOTTEN);
			$stmt->execute($arr);
			$data = $stmt->fetch();
			if (!$data)
				return Model::SID_NOT_FOUND;
			$arr = array('uid' => $data['id_user'], 'res' => Model::SUCCESS);
			return $arr;
		}
		catch (PDOException $ex)
		{
			return Model::DB_ERROR;
		}
	}

	public function check_email()
	{
		include 'config/database.php';
		try
		{
			$pdo = new PDO($dsn, $db_user, $db_pass, $opt);
			$pdo->exec("USE $db");
			$stmt = $pdo->prepare(self::$sql_check_email);
			$stmt->execute(array('email' => $_POST['email']));
			$data = $stmt->fetch();
			if (!$data)
				return Model::BAD_EMAIL;
			$arr = array('email' => $data['email'], 'uid' => $data['id']);
			$result = $this->_add_to_change($arr, $pdo);
			return $result;
		}
		catch (PDOException $ex)
		{
			Model::DB_ERROR;
		}
	}

	private function _add_to_change($arr, $pdo) {
		try
		{
			$stmt = $pdo->prepare(self::$sql_add_to_change);
			$fd = fopen("/dev/urandom", "r");
			$salt = fread($fd, 30);
			fclose($fd);
			$sid = hash("whirlpool", $arr['email'] . $salt);
			$arr2 = array('id' => $arr['uid'], 'reason' => Model::REASON_FORGOTTEN, 'sid' => $sid);
			$stmt->execute($arr2);
			$this->_send_mail($arr['email'], $sid);
			return Model::SUCCESS;
		}
		catch (PDOException $ex)
		{
			return Model::DB_ERROR;
		}
	}

	private function _send_mail($email, $sid)
	{
		include 'config/database.php';
		$subject = "Password recovery in Camagru";
		$main = "You, or not good dude trying recovery password. If is you, click here: http://".
			$email_host."/forgotten/recovery/".$sid;
		$main = wordwrap($main, 60, "\r\n");
		$headers = 'From: kostya.marinenkov@gmail.com'."\r\n".
			"Reply-To: kostya.marinenkov@gmail.com"."\r\n".
			"X-Mailer: PHP/".phpversion();
		mail($email, $subject, $main, $headers);
	}
}