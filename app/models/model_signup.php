<?php
class Model_Signup extends Model
{
    const NICKNAME_EXIST = 1;
    const EMAIL_EXIST = 2;

    public function create_account($nickname, $passwd, $email)
    {
        include "config/database.php";
        $pdo = new PDO($dsn, $db_user, $db_pass, $opt);
        $pdo->exec("USE $db");
        if (!$this->_check($pdo, "SELECT nickname FROM users WHERE nickname = ?", array($nickname)))
            return self::NICKNAME_EXIST;
        if (!$this->_check($pdo, "SELECT email FROM users WHERE email = ?", array($nickname)))
            return self::EMAIL_EXIST;

    }

    private function _check($pdo, $sql, $arr)
    {
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute($arr))
            return TRUE;
        else
            return FALSE;
    }
}