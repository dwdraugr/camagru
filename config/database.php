<?php
$db_host = '172.17.0.4';
$db   = 'bigdb';
$db_user = 'root';
$db_pass = 'qwerty';
$db_charset = 'utf8';

$dsn = "mysql:host=$db_host;charset=$db_charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$ftp_host = '172.17.0.3';
$ftp_user = 'qwe';
$ftp_pass = 'rty';
