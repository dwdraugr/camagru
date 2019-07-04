<?php
class Model_Auth extends Model
{
    private static $sql_search = "SELECT * FROM change_table WHERE sid = ?";
    private static $sql_update = "UPDATE users SET confirmed = 1 WHERE id = ?";
    private static $sql_remove = "DELETE FROM change_table WHERE id_user = ?";

    public function get_data($login, $password)
    {
        include "config/database.php";
        $hash_passwd = hash("whirlpool", $password);
        try
		{
			$pdo = new PDO($dsn, $db_user, $db_pass, $opt);
			$pdo->exec("USE $db");
			$sql = "SELECT * FROM users WHERE nickname = ? AND password = ?";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(array($login, $hash_passwd));
			$data = $stmt->fetch();
			if ($data)
			{
				$_SESSION['nickname'] = $data['nickname'];
				$_SESSION['password'] = $data['password'];
				$_SESSION['uid'] = $data['id'];
				return Model::SUCCESS;
			}
			else
				return Model::INCORRECT_NICK_PASS;
		}
		catch (PDOException $ex)
		{
			return Model::DB_ERROR;
		}
    }

    public function confirm_account($sid)
    {
        include "config/database.php";
        try
		{
			$pdo = new PDO($dsn, $db_user, $db_pass, $opt);
			$pdo->exec("USE $db");
			$stmt = $pdo->prepare(Model_Auth::$sql_search);
			$stmt->execute(array($sid));
			$result = $stmt->fetch();
			if ($result)
			{
				$stmt = $pdo->prepare(Model_Auth::$sql_update);
				$stmt->execute(array($result['id_user']));
				$stmt = $pdo->prepare(Model_Auth::$sql_remove);
				$stmt->execute(array($result['id_user']));
				return Model::SUCCESS;
			}
			else
				return Model::SID_NOT_FOUND;
		}
		catch (PDOException $ex)
		{
			return Model::DB_ERROR;
		}
    }
}