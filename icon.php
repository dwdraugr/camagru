<?php
header("Content-type: image/jpeg");
$ic = $_GET['icon'];
echo file_get_contents("ftp://qwe:rty@192.168.99.100/icons/$ic.jpg");
