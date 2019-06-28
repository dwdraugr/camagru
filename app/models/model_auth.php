<?php
class Model_Auth extends Model
{
    public function get_data($login, $password)
    {
        include "config/database.php";
        $pdo = new PDO($dsn, $db_user, $db_pass, $opt);
        $pdo->exec("USE $db");
        $sql = "SELECT * FROM users WHERE nickname = :nickname AND password = :password";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute(array($login, $password))) {
            $data = $stmt->fetchAll();
            return $data;
        }
        else
            return null;
    }
}