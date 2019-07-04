<?php
class Model
{
    const SUCCESS				= 0;
    const DB_ERROR				= 1;
    const USER_EXIST			= 2;
    const INCOMPLETE_DATA		= 3;
    const BAD_EMAIL				= 4;
    const INCORRECT_NICK_PASS	= 5;
    const SID_NOT_FOUND			= 6;
    const WEAK_PASSWORD			= 7;

    const REASON_CREATE			= 100;
    const REASON_FORGOTTEN		= 101;

    private $sql_read = "SELECT * FROM users WHERE nickname = :nickname AND id = :uid AND password = :password";

    protected function _auth()
	{
		if (!(isset($_SESSION['nickname']) and isset($_SESSION['uid']) and isset($_SESSION['password'])))
			return Model::INCOMPLETE_DATA;
		include "config/database.php";
		try
		{
			$pdo = new PDO($dsn, $db_user, $db_pass, $opt);
			$stmt = $pdo->prepare($this->sql_read);
			$stmt->execute(array(
				'nickname' => $_SESSION['nickname'],
				'uid' => $_SESSION['uid'],
				'password' => $_SESSION['password']
			));
			$data = $stmt->fetch();
			if (!$data)
				return Model::INCORRECT_NICK_PASS;
			else
				return Model::SUCCESS;
		}
		catch (PDOException $ex)
		{
			return Model::DB_ERROR;
		}
	}
}
