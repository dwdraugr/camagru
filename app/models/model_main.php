<?php
class Model_Main extends Model
{
    public function get_data($param = null)
    {
        include 'config/database.php';
        $pdo = new PDO($dsn, $user, $pass, $opt);
        $data = $pdo->query('SELECT * FROM testtab');
        return $data;
    }
}