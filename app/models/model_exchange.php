<?php
class Model_Exchange extends Model
{
    public function get_photo($param)
    {
        $img = file_get_contents("ftp://qwe:rty@172.17.0.3/photos/$param.jpg");
        return $img;


    }

    public function get_icon($param)
    {
        $img = file_get_contents("ftp://qwe:rty@172.17.0.3/icons/$param.jpg");
        return $img;
    }
}