<?php
include_once "config/database.php";
class Model_Exchange extends Model
{
    public function get_photo($param)
    {
        include "config/database.php";
        $img = file_get_contents("ftp://$ftp_user:$ftp_pass@$ftp_host/photos/$param.jpg");
        return $img;


    }

    public function get_icon($param)
    {
        include "config/database.php";
        $img = file_get_contents("ftp://$ftp_user:$ftp_pass@$ftp_host/icons/$param.jpg");
        return $img;
    }
}