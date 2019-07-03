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
        $pdo = new PDO($dsn, $db_user, $db_pass, $opt);
        $pdo->exec("USE $db");
        $sql = "SELECT * FROM users WHERE nickname = ? AND password = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute(array($login, $hash_passwd))) {
            $data = $stmt->fetchAll();
            return $data;
        }
        else
            return null;
    }

    public function confirm_account($sid)
    {
        include "config/database.php";
        $pdo = new PDO($dsn, $db_user, $db_pass, $opt);
        $pdo->exec("USE $db");
        $stmt = $pdo->prepare(Model_Auth::$sql_search);
        $stmt->execute(array($sid));
        $result = $stmt->fetch();
        if ($result['sid'] == $sid)
        {
            $stmt = $pdo->prepare(Model_Auth::$sql_update);
            $stmt->execute(array($result['id_user']));
            $stmt = $pdo->prepare(Model_Auth::$sql_remove);
            $stmt->execute(array($result['id_user']));
            return TRUE;
        }
        else
            return FALSE;
    }
}