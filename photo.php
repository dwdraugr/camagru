<?php
header("Content-type: image/jpeg");
$photo = $_GET['photo'];
$user = $_GET['user'];
echo file_get_contents("ftp://qwe:rty@192.168.99.100/photo/$user/$photo");