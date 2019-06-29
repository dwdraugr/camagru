<?php
class Model_Auth extends Model
{
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
}