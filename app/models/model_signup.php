<?php
class Model_Signup extends Model
{
    private static $sql_check = "SELECT * FROM users WHERE email = ?";
    private static $sql_write_db = "INSERT INTO `users` (`id`, `nickname`, `password`, `email`, `confirmed`)
                    VALUES (NULL, :nickname, :password, :email, 0)";
    private static $sql_add_to_change = "INSERT INTO `change_table` (`id`, `reason`, `sid`)
                    VALUES (NULL, :reason, :sid)";


    public function create_account($nickname, $passwd, $email)
    {
        include "config/database.php";
        $pdo = new PDO($dsn, $db_user, $db_pass, $opt);
        $pdo->exec("USE $db");
        $arr = array(
            'nickname' => $nickname,
            'password' =>  hash("whirlpool", $passwd),
            'email' => $email
        );
        if ($this->_check($pdo, $arr, $email))
            return self::EMAIL_EXIST;
        if ($this->_write_to_db($pdo, Model_Signup::$sql_write_db, $arr) and $this->_add_to_change($email, $pdo))
            return self::SUCCESS;
        else
            return self::DB_ERROR;
    }

    private function _check($pdo, $arr, $email)
    {
        $stmt = $pdo->prepare(self::$sql_check);
        if (!$stmt->execute(array($email)))
            return FALSE; //TODO: Возвращение "существования" аккаунта при ошибке бд - это говно
        $result = $stmt->fetchAll();
        foreach ($result as $r)
        {
            if ($r[3] == $email)
                return TRUE;
        }
        return FALSE;
    }

    private function _add_to_change($email, $pdo) {
        $stmt = $pdo->prepare(self::$sql_add_to_change);
        $fd = fopen("/dev/urandom", "r");
        $salt = fread($fd, 30);
        fclose($fd);
        $sid = hash("whirlpool", $email.$salt);
        $arr = array(
            'reason' => Model::REASON_CREATE,
            'sid' => $sid
        );
        if ($stmt->execute($arr)) {
            $this->_send_mail($email, $sid);
            return TRUE;
        }
        RETURN FALSE;
    }

    private function _write_to_db($pdo, $sql, $arr)
    {
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute($arr)) {
            return TRUE;
        }
        else
            return FALSE;
    }

    private function _send_mail($email, $sid)
    {
        $subject = "Welcome to Camagru";
        $main = "Thank you for registering on our site. To confirm your entry, follow this link:".
            $_SERVER['SERVER_NAME']."/auth/confirm/?".$sid;
        $main = wordwrap($main, 70, "\r\n");
        mail($email, $subject, $main);
    }


}