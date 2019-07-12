<?php
class Model_Signup extends Model
{
    private static $sql_check = "SELECT * FROM users WHERE email = :email OR nickname = :nickname";
    private static $sql_write_db = "INSERT INTO `users` (`id`, `nickname`, `password`, `email`, `confirmed`)
                    VALUES (NULL, :nickname, :password, :email, 0)";
    private static $sql_add_to_change = "INSERT INTO `change_table` (`id`, `id_user`, `reason`, `sid`)
                    VALUES (NULL, :id, :reason, :sid)";
    private static $sql_get_id = "SELECT id FROM users WHERE email = :email AND nickname = :nickname
                                    AND password = :password";


    public function create_account($nickname, $passwd, $email)
    {
        include "config/database.php";
        if ($passwd === strtolower($passwd) or strlen($passwd) < 6)
        	return Model::WEAK_PASSWORD;
        try
		{
			$pdo = new PDO($dsn, $db_user, $db_pass, $opt);
			$pdo->exec("USE $db");
			$arr = array('nickname' => $nickname, 'password' => hash("whirlpool", $passwd), 'email' => $email);
			if ($this->_check($pdo, $arr))
				return self::USER_EXIST;
			switch ($this->_check($pdo, $arr))
			{
				case Model::DB_ERROR:
					return Model::DB_ERROR;
				case Model::USER_EXIST:
					return Model::USER_EXIST;
				case Model::SUCCESS:
			}
			if ($this->_write_to_db($pdo, Model_Signup::$sql_write_db, $arr) === Model::SUCCESS
				and $this->_add_to_change($arr, $pdo) === Model::SUCCESS)
				return Model::SUCCESS;
			else
				return Model::DB_ERROR;
		}
		catch (PDOException $ex)
		{
			return Model::DB_ERROR;
		}
    }

    private function _check($pdo, $arr)
    {
        unset($arr['password']);
        try
		{
			$stmt = $pdo->prepare(self::$sql_check);
			$stmt->execute($arr);
			$result = $stmt->fetchAll();
			foreach ($result as $r)
			{
				if ($r['email'] == $arr['email'] or $r['nickname'] == $arr['nickname'])
					return Model::USER_EXIST;
			}
			return Model::SUCCESS;
		}
		catch (PDOException $ex)
		{
			Model::DB_ERROR;
		}
    }

    private function _add_to_change($arr, $pdo) {
    	try
		{
			$stmt = $pdo->prepare(self::$sql_get_id);
			$stmt->execute($arr);
			$id = $stmt->fetch();
			$stmt = $pdo->prepare(self::$sql_add_to_change);
			$fd = fopen("/dev/urandom", "r");
			$salt = fread($fd, 30);
			fclose($fd);
			$sid = hash("whirlpool", $arr['email'] . $salt);
			$arr2 = array('id' => $id['id'], 'reason' => Model::REASON_CREATE, 'sid' => $sid);
			$stmt->execute($arr2);
			$this->_send_mail($arr['email'], $sid);
			return Model::SUCCESS;
		}
        catch (PDOException $ex)
		{
			return Model::DB_ERROR;
		}
    }

    private function _write_to_db($pdo, $sql, $arr)
    {
    	try
		{
			$stmt = $pdo->prepare($sql);
			$stmt->execute($arr);
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
        $subject = "Welcome to Camagru, buddy";
        $main = "Thank you for registering on our site. To confirm your entry, follow this link: http://".
            $email_host."/auth/confirm/".$sid;
        $main = wordwrap($main, 60, "\r\n");
        $headers = 'From: kostya.marinenkov@gmail.com'."\r\n".
                    "Reply-To: kostya.marinenkov@gmail.com"."\r\n".
                    "X-Mailer: PHP/".phpversion();
        mail($email, $subject, $main, $headers);
    }
}