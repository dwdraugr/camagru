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
        $pdo = new PDO($dsn, $db_user, $db_pass, $opt);
        $pdo->exec("USE $db");
        $arr = array(
            'nickname' => $nickname,
            'password' =>  hash("whirlpool", $passwd),
            'email' => $email
        );
        if ($this->_check($pdo, $arr, $email))
            return self::EMAIL_EXIST;
        if ($this->_write_to_db($pdo, Model_Signup::$sql_write_db, $arr) and $this->_add_to_change($arr, $pdo))
            return self::SUCCESS;
        else
            return self::DB_ERROR;
    }

    private function _check($pdo, $arr, $email)
    {
        unset($arr['password']);
        $stmt = $pdo->prepare(self::$sql_check);
        if (!$stmt->execute($arr))
            return FALSE; //TODO: Возвращение "существования" аккаунта при ошибке бд - это говно
        $result = $stmt->fetchAll();
        foreach ($result as $r)
        {
            if ($r['email'] == $arr['email'] or $r['nickname'] == $arr['nickname'])
                return TRUE;
        }
        return FALSE;
    }

    private function _add_to_change($arr, $pdo) {
        $stmt = $pdo->prepare(self::$sql_get_id);
        $stmt->execute($arr);
        $id = $stmt->fetch();
        $stmt = $pdo->prepare(self::$sql_add_to_change);
        $fd = fopen("/dev/urandom", "r");
        $salt = fread($fd, 30);
        fclose($fd);
        $sid = hash("whirlpool", $arr['email'].$salt);
        $arr2 = array(
            'id' => $id['id'],
            'reason' => Model::REASON_CREATE,
            'sid' => $sid
        );
        if ($stmt->execute($arr2)) {
            $this->_send_mail($arr['email'], $sid);
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
        $subject = "Welcome to Camagru, buddy";
        $main = "Thank you for registering on our site. To confirm your entry, follow this link: http://".
            $_SERVER['HTTP_HOST']."/auth/confirm/".$sid;
        $main = wordwrap($main, 60, "\r\n");
        $headers = 'From: kostya.marinenkov@gmail.com'."\r\n".
                    "Reply-To: kostya.marinenkov@gmail.com"."\r\n".
                    "X-Mailer: PHP/".phpversion();
        mail($email, $subject, $main, $headers);
    }


}